<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\MasterKlasifikasi;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::with(['klasifikasi', 'isiArsip']);

        // Search logic
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_berkas', 'like', "%{$search}%")
                  ->orWhere('no_berkas', 'like', "%{$search}%")
                  ->orWhereHas('isiArsip', function($q2) use ($search) {
                      $q2->where('isi', 'like', "%{$search}%");
                  })
                  ->orWhereHas('klasifikasi', function($q3) use ($search) {
                      $q3->where('kode_klasifikasi', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting logic
        switch ($request->input('sort')) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'year_desc':
                $query->orderBy('tahun', 'desc');
                break;
            case 'year_asc':
                $query->orderBy('tahun', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $arsips = $query->paginate(10); // Use paginate instead of take(10) for better lists
        
        if ($request->ajax()) {
            return view('arsip.partials.table', compact('arsips'));
        }

        return view('arsip.arsip', compact('arsips'));
    }

    public function create()
    {
        $klasifikasis = MasterKlasifikasi::all();
        return view('arsip.input-arsip', compact('klasifikasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'no_berkas' => 'nullable|string', // We will generate this if empty or validate uniqueness
            'klasifikasi_id' => 'required|exists:master_klasifikasi,id',
            'nama_berkas' => 'required|string',
            'unit_pengolah' => 'required|string',
            'hak_akses' => 'required|string',
            // 'isi_berkas' => 'nullable|string', // Removed single string validation
            'isi_berkas' => 'required|array|min:1', // Must have at least one content
            'isi_berkas.*.isi' => 'required|string',
            'isi_berkas.*.tahun' => 'nullable|integer',
            'isi_berkas.*.tanggal' => 'nullable|date',
            'isi_berkas.*.jumlah' => 'nullable|integer',
            'isi_berkas.*.no_box' => 'nullable|string',
            'isi_berkas.*.hak_akses' => 'nullable|string',
            'isi_berkas.*.jenis_media' => 'nullable|string',
            'isi_berkas.*.masa_simpan' => 'nullable|string',
            'isi_berkas.*.tindakan_akhir' => 'nullable|string',
        ]);

        // Derive Parent Data from First/All Items
        $firstItem = $validated['isi_berkas'][0];
        $year = $firstItem['tahun'] ?? date('Y');
        $tanggalMasuk = $firstItem['tanggal'] ?? date('Y-m-d');
        
        // Parent Metadata Defaults (using first item as representative)
        $mainHakAkses = $firstItem['hak_akses'] ?? '-';
        $mainNoBox = $firstItem['no_box'] ?? '-';
        $mainMedia = $firstItem['jenis_media'] ?? 'Kertas';
        
        // Jumlah: Sum of all items' jumlah
        $totalJumlah = 0;
        foreach ($validated['isi_berkas'] as $item) {
            $totalJumlah += ($item['jumlah'] ?? 1);
        }

        // Auto Generate No Berkas
        // Format: ARS-{YEAR}-{XXX}
        $lastArsip = Arsip::where('no_berkas', 'like', "ARS-{$year}-%")->orderBy('id', 'desc')->first();
        
        if ($lastArsip) {
            $lastNo = substr($lastArsip->no_berkas, -3); // Get last 3 digits
            $nextNo = intval($lastNo) + 1;
        } else {
            $nextNo = 1;
        }
        $no_berkas = sprintf("ARS-%s-%03d", $year, $nextNo);

        // Ensure user exists
        $user = \App\Models\User::first();
        if (!$user) {
            $user = \App\Models\User::create([
                'nama' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);
        }

        $arsip = Arsip::create([
            'no_berkas' => $no_berkas,
            'klasifikasi_id' => $validated['klasifikasi_id'],
            'nama_berkas' => $validated['nama_berkas'],
            'unit_pengolah' => $validated['unit_pengolah'],
            'hak_akses' => $mainHakAkses, // Saved parent value for reference
            'jenis_media' => $mainMedia,
            'tahun' => $year,
            'tanggal_masuk' => $tanggalMasuk,
            'jumlah' => $totalJumlah,
            'no_box' => $mainNoBox,
            'user_id' => $user->id,
        ]);

        // Save Isi Berkas (Multiple with Details)
        foreach ($validated['isi_berkas'] as $item) {
            \App\Models\IsiArsip::create([
                'arsip_id' => $arsip->id,
                'isi' => $item['isi'],
                'tahun' => $item['tahun'] ?? null,
                'tanggal' => $item['tanggal'] ?? null,
                'jumlah' => $item['jumlah'] ?? 1,
                'hak_akses' => $item['hak_akses'] ?? null,
                'no_box' => $item['no_box'] ?? null,
                'jenis_media' => $item['jenis_media'] ?? null,
                'masa_simpan' => $item['masa_simpan'] ?? null,
                'tindakan_akhir' => $item['tindakan_akhir'] ?? null,
            ]);
        }

        return redirect('/arsip')->with('success', "Data arsip berhasil ditambahkan! Nomor Berkas: $no_berkas");
    }

    public function export(Request $request) 
    {
        $type = $request->input('type');
        $ids = json_decode($request->input('ids'), true);
        $search = $request->input('search');
        $sort = $request->input('sort');

        // Prepare query for PDF (Excel uses Export class)
        // Ideally, we reuse logic. Let's extract query logic or use the Export class query.
        $export = new \App\Exports\ArsipExport($ids, $search, $sort);
        $filename = 'arsip-all-' . date('Y-m-d') . ($type === 'pdf' ? '.pdf' : '.xlsx');

        if ($type === 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
        }

        if ($type === 'pdf') {
            // Fetch data manually for the view
            $query = $export->query(); 
            $arsips = $query->with('isiArsip')->get(); // Eager load isiArsip
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('arsip.pdf', compact('arsips'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download($filename);
        }

        return redirect()->back();
    }
    public function getKlasifikasiOptions(Request $request)
    {
        $level = $request->input('level', 0); // Default to 0 now
        $parent = $request->input('parent');
        $jraType = $request->input('jra_type'); // New input

        // Level 0: Choose JRA Type
        if ($level == 0) {
            return response()->json([
                ['code' => 'Fasilitatif', 'label' => 'JRA Fasilitatif'],
                ['code' => 'Substantif', 'label' => 'JRA Substantif'],
            ]);
        }

        // Level 1: Pokok Masalah (filtered by JRA Type)
        if ($level == 1) {
            // Note: We removed 'jenis_jra' column from master_klasifikasi in revision, 
            // so filtering by 'jenis_jra' in DB might fail or needs adjustment if we rely on it.
            // But wait, the user said "gabung aja", so maybe we don't filter in DB?
            // "3. pilihan substantif dan fasilitatif digabung aja, jadi di database kolom jenis jra nya dihapus aja"
            // So we should NOT filter by jraType anymore in logic?
            // But the UI still starts with "Pilih Jenis JRA"? NO, user said "digabung aja".
            // If DB column is gone, I cannot filter.
            // I should assume the UI flow might change or simply show ALL at level 1?
            // The user revisions said "digabung aja".
            // So Level 0 (JRA Type selection) might be REDUNDANT now?
            // "3. pilihan substantif dan fasilitatif digabung aja"
            // Wait, if I keep the UI Step 0, it does nothing if I return same data?
            // Actually, I should probably Remove Step 0 in Frontend logic too if they are merged.
            // But for now, let's just make it return all codes regardless of type input.
            
            $query = MasterKlasifikasi::select('kode_klasifikasi');
            
            // if ($jraType) { $query->where('jenis_jra', $jraType); } // Column removed

            $codes = $query->get();
            $unique = $codes->map(function($item) {
                $parts = explode('.', $item->kode_klasifikasi);
                return isset($parts[0]) ? $parts[0] : null;
            })->unique()->filter()->values();
            
            $formatted = $unique->map(function($code) {
                return [
                    'code' => $code,
                    'label' => $this->getKategoriLabel($code)
                ];
            });

            return response()->json($formatted);
        }

        if ($level == 2 && $parent) {
            $codes = MasterKlasifikasi::where('kode_klasifikasi', 'like', $parent . '.%')->get();
            $unique = $codes->map(function($item) {
                $parts = explode('.', $item->kode_klasifikasi);
                return isset($parts[0], $parts[1]) ? $parts[0] . '.' . $parts[1] : null;
            })->unique()->filter()->values();

            $formatted = $unique->map(function($code) {
                return [
                    'code' => $code,
                    'label' => $this->getSubKategoriLabel($code)
                ];
            });

            return response()->json($formatted);
        }

        if ($level == 3 && $parent) {
            $items = MasterKlasifikasi::where('kode_klasifikasi', 'like', $parent . '.%')
                        ->select('id', 'kode_klasifikasi', 'jenis_arsip', 'masa_simpan', 'tindakan_akhir', 'hak_akses')
                        ->get();
            
            $formatted = $items->map(function($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->kode_klasifikasi,
                    'label' => $item->kode_klasifikasi . ' - ' . $item->jenis_arsip,
                    'masa_simpan' => $item->masa_simpan,
                    'tindakan_akhir' => $item->tindakan_akhir,
                    'hak_akses' => $item->hak_akses // Include hak_akses
                ];
            });

            return response()->json($formatted);
        }

        return response()->json([]);
    }

    private function getKategoriLabel($code)
    {
        $labels = [
            'HK' => 'HK - HUKUM',
            'HM' => 'HM - HUMAS',
            'KK' => 'KK - KESELAMATAN, KESEHATAN KERJA & LINGKUNGAN HIDUP',
            'KM' => 'KM - KEAMANAN',
            'KS' => 'KS - KESEKRETARIATAN',
            'KU' => 'KU - KEUANGAN',
            'PB' => 'PB - PERBEKALAN',
            'PW' => 'PW - PENGAWASAN & SISTEM MANAJEMEN',
            'SM' => 'SM - SUMBER DAYA MANUSIA',
            
            // JRA Substantif
            'BJ' => 'BJ - KEBIJAKAN',
            'DT' => 'DT - DISTRIBUSI DAN TRANSPORTASI',
            'LB' => 'LB - PENELITIAN & PENGEMBANGAN',
            'MR' => 'MR - MANAJEMEN GCG & RISIKO',
            'PR' => 'PR - PRODUKSI',
            'PS' => 'PS - PEMASARAN',
            'PM' => 'PM - PEMELIHARAAN',
        ];
        return $labels[$code] ?? $code;
    }

    private function getSubKategoriLabel($code)
    {
        $labels = [
            // HK
            'HK.00' => 'HK.00 - Peraturan',
            'HK.01' => 'HK.01 - Tanah / Bangunan',
            'HK.02' => 'HK.02 - Surat Berharga',
            'HK.03' => 'HK.03 - Dokumen Legal',
            
            // HM
            'HM.00' => 'HM.00 - Penerangan',
            'HM.01' => 'HM.01 - Protokoler',
            'HM.02' => 'HM.02 - Publikasi',
            'HM.03' => 'HM.03 - Rekanan',
            'HM.04' => 'HM.04 - Bantuan Bina Lingkungan',
            'HM.05' => 'HM.05 - Kemitraan',
            'HM.06' => 'HM.06 - Sarana dan Prasarana',

            // KK
            'KK.00' => 'KK.00 - Identifikasi',
            'KK.01' => 'KK.01 - Penilaian',
            'KK.02' => 'KK.02 - Pemantauan dan Pengendalian',

            // KM
            'KM.00' => 'KM.00 - Keamanan Lingkungan Intern',
            'KM.01' => 'KM.01 - Keamanan Lingkungan Ekstern',
            'KM.02' => 'KM.02 - Kerjasama dengan Aparat Hukum',
            'KM.03' => 'KM.03 - Koordinasi Keamanan Pemerintah',

            // KS
            'KS.00' => 'KS.00 - Surat Menyurat',
            'KS.01' => 'KS.01 - Laporan',
            'KS.02' => 'KS.02 - Kearsipan',
            'KS.03' => 'KS.03 - Supplies Kantor',
            
            // KU
            'KU.00' => 'KU.00 - Anggaran',
            'KU.01' => 'KU.01 - Perbendaharaan',
            'KU.02' => 'KU.02 - Akuntansi',

            // PB
            'PB.00' => 'PB.00 - Kinerja Suplier',
            'PB.01' => 'PB.01 - Pengadaan Barang',
            'PB.02' => 'PB.02 - Pengadaan Jasa',
            'PB.03' => 'PB.03 - Penerimaan Barang',
            'PB.04' => 'PB.04 - Pengeluaran Barang',

            // PW
            'PW.00' => 'PW.00 - Pemeriksaan Ekstern',
            'PW.01' => 'PW.01 - Pengawasan Intern',
            'PW.02' => 'PW.02 - Pengawasan Anak Perusahaan & Lembaga Penunjang',
            'PW.03' => 'PW.03 - Pengawasan Intercompany SMIG',

            // SM
            'SM.00' => 'SM.00 - Formasi',
            'SM.01' => 'SM.01 - Penerimaan Karyawan',
            'SM.02' => 'SM.02 - Penilaian',
            'SM.03' => 'SM.03 - Penggajian',
            'SM.04' => 'SM.04 - Kesejahteraan',
            'SM.05' => 'SM.05 - Pendidikan dan Pelatihan',
            'SM.06' => 'SM.06 - Pemberhentian Hubungan Kerja',
            'SM.07' => 'SM.07 - Administrasi Karyawan',
            'SM.08' => 'SM.08 - Evaluasi Organisasi',
            'SM.09' => 'SM.09 - Komitmen / Kesepakatan',
            'SM.10' => 'SM.10 - Personal File',
            'SM.10' => 'SM.10 - Personal File',
            
            // Substantif placeholders (to be expanded fully if needed, but for now fallback logic is fine or basic ones)
            'BJ.00' => 'BJ.00 - Penetapan Kebijakan',
            'DT.00' => 'DT.00 - Transportir',
            'DT.01' => 'DT.01 - Distribusi & Transportasi Laut',
            'DT.02' => 'DT.02 - Distribusi dan Transportasi',
            'LB.00' => 'LB.00 - Penelitian',
            'LB.01' => 'LB.01 - Rancang Bangun',
            'LB.02' => 'LB.02 - Pengembangan',
            'MR.00' => 'MR.00 - Manajemen GCG',
            'MR.01' => 'MR.01 - Manajemen Risiko',
            'MR.02' => 'MR.02 - Kajian Risiko',
            'MR.03' => 'MR.03',
            'PR.00' => 'PR.00 - Rencana Produksi Bahan Baku',
            'PR.01' => 'PR.01 - Realisasi Produksi Bahan Baku',
            'PR.02' => 'PR.02 - Mutu Produk & Bahan baku',
            'PR.03' => 'PR.03 - Evaluasi Kinerja Peralatan Produksi dan Mutu Bahan Baku',
            'PR.04' => 'PR.04 - Rencana Produksi Terak/Klinker',
            'PR.05' => 'PR.05 - Realisasi Produksi Terak/ Klinker',
            'PR.06' => 'PR.06 - Mutu Produk & Bahan Terak / klinker',
            'PR.07' => 'PR.07 - Evaluasi Kinerja Peralatan Produksi dan Mutu Produk Terak / Klinker',
            'PR.08' => 'PR.08 - Rencana Produksi Semen',
            'PR.09' => 'PR.09 - Realisasi Produksi Semen',
            'PR.10' => 'PR.10 - Mutu Produk & Bahan Produksi Semen',
            'PR.11' => 'PR.11 - Evaluasi Kinerja Peralatan Produksi dan Mutu Produk Semen',
            'PS.00' => 'PS.00 - Rencana pemasaran',
            'PS.01' => 'PS.01 - Distributor',
            'PS.02' => 'PS.02 - Kebutuhan Pasar',
            'PS.03' => 'PS.03 - Evaluasi Pemasaran',
            'PS.04' => 'PS.04 - Penjualan',
            'PS.05' => 'PS.05 - Promosi',
            'PM.00' => 'PM.00 - Peralatan Produksi',
            'PM.01' => 'PM.01 - Peralatan Penunjang Produksi',
            'PM.03' => 'PM.03 - Peralatan Uji Mutu',
            'PM.04' => 'PM.04 - Energi Listrik',
            'PM.05' => 'PM.05 - Sistem Informasi',

        ];
        return $labels[$code] ?? $code;
    }
}