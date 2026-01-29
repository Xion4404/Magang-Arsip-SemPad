<?php

namespace App\Imports;

use App\Models\Arsip;
use App\Models\MasterKlasifikasi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ArsipImport implements ToCollection, WithStartRow, WithCalculatedFormulas
{
    public function startRow(): int
    {
        return 2; // Read from Row 2 to ensure we don't miss anything. Filters will handle headers.
    }

    public function collection(Collection $rows)
    {
        $lastNoBerkas = null;
        $lastNamaBerkas = null; 
        $lastKodeKlasifikasi = null;
        
        $lastTahun = null;
        $lastUnitKerja = null; 
        
        $klasifikasiMap = MasterKlasifikasi::select('id', 'kode_klasifikasi', 'hak_akses')
                            ->get()
                            ->keyBy('kode_klasifikasi')
                            ->toArray();
                            
        $fallbackKlasifikasiId = MasterKlasifikasi::first()->id ?? 1;

        Log::info('Starting Import. Total Rows: ' . $rows->count());

        foreach ($rows as $index => $row) {
            $rowIndex = $index + 2; // Offset based on startRow

            // DEBUG: Log first 5 rows raw data to verify column mapping
            if ($index < 5) {
                Log::info("Row $rowIndex RAW: " . json_encode($row));
            }

            // 1. READ RAW VALUES
            $rawNoBerkas = isset($row[0]) ? trim((string)$row[0]) : '';
            $rawKode     = isset($row[1]) ? trim((string)$row[1]) : '';
            $rawNama     = isset($row[2]) ? trim((string)$row[2]) : '';
            $rawTahun    = isset($row[3]) ? trim((string)$row[3]) : '';
            $rawIsi      = isset($row[4]) ? trim((string)$row[4]) : '-';
            $rawTanggal  = isset($row[5]) ? $row[5] : null;
            $rawJumlah   = isset($row[6]) ? (int)$row[6] : 1;
            // 7: Asli/Copy
            $rawJenis    = isset($row[8]) ? trim((string)$row[8]) : 'Kertas';
            $rawMasa     = isset($row[9]) ? trim((string)$row[9]) : '-';
            $rawTindakan = isset($row[10]) ? trim((string)$row[10]) : 'Musnah';
            $rawBox      = isset($row[12]) ? trim((string)$row[12]) : '-';
            $rawUnit     = isset($row[14]) ? trim((string)$row[14]) : '';

            // 2. FILL DOWN LOGIC
            if ($rawNoBerkas !== '') $lastNoBerkas = $rawNoBerkas;
            if ($rawNama !== '')     $lastNamaBerkas = $rawNama;
            if ($rawKode !== '')     $lastKodeKlasifikasi = $rawKode;
            if ($rawTahun !== '')    $lastTahun = $rawTahun;
            if ($rawUnit !== '')     $lastUnitKerja = $rawUnit;

            // 3. SKIP HEADER / INVALID ROWS
            // Robust check: If 'No Berkas' or 'Uraian' appears in identity columns, it's a header
            if (
                stripos($rawNoBerkas, 'no') === 0 || // Starts with 'No'
                stripos($rawNama, 'nama berkas') !== false ||
                stripos($rawNama, 'uraian') !== false ||
                stripos($rawIsi, 'uraian') !== false ||
                stripos($rawIsi, 'isi berkas') !== false
            ) {
                 // Log::info("Skipping Header Row $rowIndex");
                 continue;
            }

            // Must have a grouping (No Berkas + Nama) to proceed
            if (!$lastNoBerkas || !$lastNamaBerkas) {
                continue;
            }

            // 4. RESOLVE DATA
            $klasifikasiData = $klasifikasiMap[$lastKodeKlasifikasi] ?? null;
            $klasifikasiId = $klasifikasiData['id'] ?? $fallbackKlasifikasiId;
            $hakAkses = $klasifikasiData['hak_akses'] ?? 'Biasa'; 

            // Date Handling
            $finalTanggal = null;
            $finalTahun = $lastTahun ?? date('Y');

            if (!empty($rawTanggal)) {
                if (is_numeric($rawTanggal)) {
                    if ($rawTanggal > 1900 && $rawTanggal < 2100) {
                        $finalTahun = $rawTanggal; 
                        $finalTanggal = null; 
                    } else {
                        try {
                            $finalTanggal = Date::excelToDateTimeObject($rawTanggal)->format('Y-m-d');
                        } catch (\Exception $e) { $finalTanggal = null; }
                    }
                } else {
                    if (preg_match('/^\d{4}$/', trim((string)$rawTanggal))) {
                         $finalTahun = trim((string)$rawTanggal);
                         $finalTanggal = null;
                    } else {
                        try {
                            $ts = strtotime($rawTanggal);
                            if ($ts) $finalTanggal = date('Y-m-d', $ts);
                        } catch (\Exception $e) {}
                    }
                }
            }

            // 5. INSERT
            $dataToInsert = [
                'user_id' => auth()->id(), 
                'no_berkas' => $lastNoBerkas,
                'nama_berkas' => $lastNamaBerkas,
                'klasifikasi_id' => $klasifikasiId,
                'unit_pengolah' => $lastUnitKerja ?? '-',
                'isi' => $rawIsi,
                'tahun' => $finalTahun,
                'tanggal_masuk' => $finalTanggal,
                'jumlah' => $rawJumlah,
                'no_box' => $rawBox,
                'hak_akses' => $hakAkses,
                'jenis_media' => $rawJenis,
                'masa_simpan' => $rawMasa,
                'tindakan_akhir' => $rawTindakan,
            ];

            try {
                Arsip::create($dataToInsert);
            } catch (\Exception $e) {
                Log::error("Import Error Row $rowIndex: " . $e->getMessage());
            }
        }
        
        Log::info('Import Completed.');
    }
}
