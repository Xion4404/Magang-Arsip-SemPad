<?php

namespace App\Imports;

use App\Models\Arsip;
use App\Models\MasterKlasifikasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class ArsipImport implements ToModel, \Maatwebsite\Excel\Concerns\WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) 
    {
        // 1. Skip Empty Rows or "Uraian" Subheaders
        // Check if important columns are empty (e.g., no_berkas or nama_berkas)
        // Adjust logic: sometimes NoBerkas is blank but it's a valid row? 
        // User said: "Data dimulai dari Baris 6 (karena baris 5 berisi sub-keterangan 'Uraian' dari merged cells)."
        // DEBUG: Log Raw Row
        // \Illuminate\Support\Facades\Log::info("Raw Row Index Map: " . json_encode($row));

        // MAPPING BY INDEX (Based on Screenshot/User Info)
        // 0: No Berkas
        // 1: Kode Klasifikasi
        // 2: Nama Berkas
        // 3: Tahun
        // 4: Isi Berkas
        // 5: Tanggal
        // 6: Jumlah
        // 7: Asli/Copy
        // 8: Jenis Arsip
        // 9: Masa Simpan
        // 10: Permanen/Musnah (Tindakan)
        // 11: Hak Akses 
        // 12: No Boks
        // 13: Lokasi
        // 14: Unit Kerja
        // 15: Rak
        // 16: Tingkat

        // 1. Basic Validation
        $kodeKlasifikasi = trim($row[1] ?? '');
        $namaBerkas = trim($row[2] ?? '');

        // Skip completely empty rows
        if ($kodeKlasifikasi === '' && $namaBerkas === '') {
            return null;
        }
        
        // Double check we are not reading a header line (just in case startRow is wrong or file shifted)
        if (strtolower($namaBerkas) == 'nama berkas' || strtolower($namaBerkas) == 'uraian') {
            return null;
        }

        // 2. Resolve Klasifikasi
        $klasifikasiId = null;
        if ($kodeKlasifikasi) {
            $klasifikasi = MasterKlasifikasi::where('kode_klasifikasi', $kodeKlasifikasi)->first();
            if ($klasifikasi) {
                $klasifikasiId = $klasifikasi->id;
            } else {
                 \Illuminate\Support\Facades\Log::warning("Klasifikasi not found: " . $kodeKlasifikasi);
                 return null; // Skip row if classification is invalid to prevent SQL error
            }
        }

        // 3. Defaults
        $user = \App\Models\User::first();
        $userId = $user ? $user->id : 1;

        // 4. Create Model
        return new Arsip([
            'no_berkas'     => $row[0] ?? null,
            'klasifikasi_id'=> $klasifikasiId,
            'nama_berkas'   => $namaBerkas,
            'tahun'         => $row[3] ?? date('Y'),
            'isi'           => $row[4] ?? null,
            'tanggal_masuk' => $this->parseDate($row[5] ?? null),
            'jumlah'        => is_numeric($row[6] ?? null) ? $row[6] : 1, // Default 1 if invalid
            'asli_copy'     => $row[7] ?? null,
            'jenis_media'   => $row[8] ?? null,
            'masa_simpan'   => $row[9] ?? null,
            'tindakan_akhir'=> $row[10] ?? null, 
            'hak_akses'     => $row[11] ?? 'Biasa',
            'no_box'        => $row[12] ?? null,
            'lokasi'        => $row[13] ?? null,
            'unit_pengolah' => $row[14] ?? null,
            'rak'           => $row[15] ?? null,
            'tingkat'       => $row[16] ?? null,
            'user_id'       => $userId
        ]);
    }

    public function startRow(): int
    {
        return 6; // Data starts at Row 6 in the Excel file
    }

    private function parseDate($value) {
        if (!$value) return null;
        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            }
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
