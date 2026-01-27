use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ArsipImport implements ToCollection, WithStartRow, WithCalculatedFormulas
{
    public function startRow(): int
    {
        return 5; // Start reading data from Row 5 (Indices are 0-based for columns)
    }

    public function collection(Collection $rows)
    {
        $lastNoBerkas = null;
        $lastKodeKlasifikasi = null;
        $lastNamaBerkas = null; // Uraian (Col C / Index 2)
        $lastTahun = null;
        $lastUnit = null;

        // Cache klasifikasi ID
        $klasifikasiMap = MasterKlasifikasi::pluck('id', 'kode_klasifikasi')->toArray();
        $fallbackKlasifikasiId = MasterKlasifikasi::first()->id ?? 1;

        foreach ($rows as $row) {
            // Index Mapping based on Image:
            // 0: No Berkas
            // 1: Kode Klasifikasi
            // 2: Nama Berkas (Uraian Header)
            // 3: Tahun
            // 4: Isi Berkas (Uraian Sub-Header)
            // 5: Tanggal
            // 6: Jumlah
            // 7: Asli/Copy
            // 8: Jenis Arsip
            // 9: Masa Simpan
            // 10: Tindakan (Permanen/Musnah)
            // 11: Hak Akses
            // 12: No Boks
            // 13: Lokasi
            // 14: Unit Kerja
            
            // FILL DOWN LOGIC
            // If cell is not empty, update "last" variable. If empty, use "last".
            
            // No Berkas
            if (isset($row[0]) && trim($row[0]) !== '') {
                $lastNoBerkas = trim($row[0]);
            }
            // Kode Klasifikasi
            if (isset($row[1]) && trim($row[1]) !== '') {
                $lastKodeKlasifikasi = trim($row[1]);
            }
            // Nama Berkas
            if (isset($row[2]) && trim($row[2]) !== '') {
                $lastNamaBerkas = trim($row[2]);
            }
            // Tahun
            if (isset($row[3]) && trim($row[3]) !== '') {
                $lastTahun = trim($row[3]);
            }
            // Unit Kerja (Col 14) - Fill down often applies here too
             if (isset($row[14]) && trim($row[14]) !== '') {
                $lastUnit = trim($row[14]);
            }

            // FILTER: We only import if we have specific content (Isi Berkas) typical of a detail row?
            // Or do we import every row? 
            // In the image, 'Isi Berkas' (Col 4) contains the item details.
            // If 'Isi Berkas' is empty, it might be a spacer row or just a header continuation.
            // Let's assume valid rows must have 'Isi Berkas' (Col 4) OR be the start of a new group.
            // Actually, sometimes 'Isi Berkas' is purely descriptive.
            // Let's require at least 'Nama Berkas' and 'No Berkas' to be resolved.
            
            if (!$lastNoBerkas || !$lastNamaBerkas) {
                continue; // Can't import without grouping info
            }
            
            // Skip rows that look like headers (if logic fails) -> "Uraian" in Isiberkas
            $isiBerkas = isset($row[4]) ? trim($row[4]) : '';
            if (strtolower($isiBerkas) === 'uraian') continue;
            if ($isiBerkas === '') $isiBerkas = '-'; // Default if empty? or maybe skip? Let's keep it.

            // Check duplicate? We are importing.
            // We trust the import.
            
            // Resolve Klasifikasi
            $klasifikasiId = $klasifikasiMap[$lastKodeKlasifikasi] ?? $fallbackKlasifikasiId;
            
            // Date formatting
            $tanggal = isset($row[5]) ? $row[5] : null;
             if (is_numeric($tanggal)) {
                $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal)->format('Y-m-d');
            } elseif ($tanggal) {
                // Try parse or leave string (DB requires date?) 
                // DB is `date` type. If invalid format, might fail.
                // Let's try simple parse if string
                try {
                    $tanggal = date('Y-m-d', strtotime($tanggal));
                } catch (\Exception $e) { $tanggal = null; }
            }
            
            $jumlah = isset($row[6]) ? (int)$row[6] : 1;
            // Col 7 Asli/Copy ignored?
            $jenis = isset($row[8]) ? trim($row[8]) : 'Kertas';
            $masaSimpan = isset($row[9]) ? trim($row[9]) : null;
            $tindakan = isset($row[10]) ? trim($row[10]) : 'Musnah';
            $hakAkses = isset($row[11]) ? trim($row[11]) : 'Biasa';
            $noBox = isset($row[12]) ? trim($row[12]) : null;
            
            Arsip::create([
                'user_id' => auth()->id() ?? 1,
                'no_berkas' => $lastNoBerkas, // DIRECT USE
                'nama_berkas' => $lastNamaBerkas,
                'klasifikasi_id' => $klasifikasiId,
                'unit_pengolah' => $lastUnit ?? '-',
                'isi' => $isiBerkas,
                'tahun' => $lastTahun ?? date('Y'),
                'tanggal_masuk' => $tanggal,
                'jumlah' => $jumlah,
                'no_box' => $noBox,
                'hak_akses' => $hakAkses,
                'jenis_media' => $jenis,
                'masa_simpan' => $masaSimpan,
                'tindakan_akhir' => $tindakan,
            ]);
        }
    }
}
