<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\MasterKlasifikasi;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    // --- 1. FITUR UTAMA (INDEX & SEARCH - PUNYA TEMAN) ---
    public function index(Request $request)
    {
        $query = Arsip::with('klasifikasi');

        // Search logic
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_berkas', 'like', "%{$search}%")
                  ->orWhere('no_berkas', 'like', "%{$search}%")
                  ->orWhere('isi_berkas', 'like', "%{$search}%")
                  ->orWhereHas('klasifikasi', function($q2) use ($search) {
                      $q2->where('kode_klasifikasi', 'like', "%{$search}%");
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

        $arsips = $query->paginate(10); 
        
        if ($request->ajax()) {
            return view('arsip.partials.table', compact('arsips'));
        }

        // Pastikan nama view ini sesuai dengan file index teman kamu
        return view('arsip.arsip', compact('arsips'));
    }

    // --- 2. FITUR CREATE (GABUNGAN) ---
    public function create()
    {
        $klasifikasis = MasterKlasifikasi::all();
        // Menggunakan view 'input-arsip' punya teman kamu
        return view('arsip.input-arsip', compact('klasifikasis'));
    }

    // --- 3. FITUR STORE (GABUNGAN LENGKAP) ---
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            // Punya Teman
            'no_berkas' => 'required|string',
            'klasifikasi_id' => 'required|exists:master_klasifikasi,id',
            'nama_berkas' => 'required|string',
            'isi_berkas' => 'nullable|string',
            'tahun' => 'required|integer',
            'tanggal_masuk' => 'required|date', // Di form namanya 'tanggal_masuk', disesuaikan
            'jumlah' => 'required|integer|min:0',
            'no_box' => 'required|string',
            'jenis_media' => 'required',
            
            // Punya Peminjaman (Wajib)
            'klasifikasi_keamanan' => 'required',
            'unit_pengolah' => 'required',
            'lokasi_fisik' => 'required',
        ]);

        // Cek User Admin (Logika Teman)
        $user = \App\Models\User::first();
        if (!$user) {
            $user = \App\Models\User::create([
                'nama' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Simpan Data
        Arsip::create([
            'user_id' => $user->id,
            'no_berkas' => $request->no_berkas,
            'klasifikasi_id' => $request->klasifikasi_id,
            'nama_berkas' => $request->nama_berkas,
            'isi_berkas' => $request->isi_berkas,
            'jenis_media' => $request->jenis_media,
            'tahun' => $request->tahun,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah' => $request->jumlah,
            'no_box' => $request->no_box,
            
            // Data Tambahan Penting
            'klasifikasi_keamanan' => $request->klasifikasi_keamanan,
            'unit_pengolah' => $request->unit_pengolah,
            'lokasi_fisik' => $request->lokasi_fisik,
        ]);

        return redirect('/arsip')->with('success', 'Data arsip berhasil ditambahkan!');
    }

    // --- 4. FITUR EDIT (BARU DITAMBAHKAN) ---
    public function edit($id)
    {
        $arsip = Arsip::findOrFail($id);
        $klasifikasis = MasterKlasifikasi::all();
        // Menggunakan view edit baru
        return view('arsip.edit', compact('arsip', 'klasifikasis'));
    }

    // --- 5. FITUR UPDATE (BARU DITAMBAHKAN) ---
    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $request->validate([
            'no_berkas' => 'required|string',
            'klasifikasi_id' => 'required',
            'nama_berkas' => 'required|string',
            'isi_berkas' => 'nullable|string',
            'tahun' => 'required|integer',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer',
            'no_box' => 'required|string',
            'jenis_media' => 'required',
            'klasifikasi_keamanan' => 'required',
            'unit_pengolah' => 'required',
            'lokasi_fisik' => 'required',
        ]);

        $arsip->update([
            'no_berkas' => $request->no_berkas,
            'klasifikasi_id' => $request->klasifikasi_id,
            'nama_berkas' => $request->nama_berkas,
            'isi_berkas' => $request->isi_berkas,
            'jenis_media' => $request->jenis_media,
            'tahun' => $request->tahun,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah' => $request->jumlah,
            'no_box' => $request->no_box,
            'klasifikasi_keamanan' => $request->klasifikasi_keamanan,
            'unit_pengolah' => $request->unit_pengolah,
            'lokasi_fisik' => $request->lokasi_fisik,
        ]);

        return redirect('/arsip')->with('success', 'Data arsip berhasil diperbarui!');
    }

    // --- 6. FITUR DELETE (BARU DITAMBAHKAN) ---
    public function destroy($id)
    {
        $arsip = Arsip::findOrFail($id);
        
        // Safety Check: Jangan hapus kalau sedang dipinjam
        if ($arsip->peminjaman()->where('status', 'Sedang Dipinjam')->exists()) {
            return back()->with('error', 'Gagal! Arsip sedang dipinjam user lain.');
        }

        $arsip->delete();
        return redirect('/arsip')->with('success', 'Arsip berhasil dihapus.');
    }

    // --- 7. FITUR EXPORT & AJAX (PUNYA TEMAN - JANGAN DIUBAH) ---

    public function export(Request $request) 
    {
        $type = $request->input('type');
        $ids = json_decode($request->input('ids'), true);
        $search = $request->input('search');
        $sort = $request->input('sort');

        $export = new \App\Exports\ArsipExport($ids, $search, $sort);
        $filename = 'arsip-all-' . date('Y-m-d') . ($type === 'pdf' ? '.pdf' : '.xlsx');

        if ($type === 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
        }

        if ($type === 'pdf') {
            $query = $export->query(); 
            $arsips = $query->get();
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('arsip.pdf', compact('arsips'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download($filename);
        }

        return redirect()->back();
    }

    public function getKlasifikasiOptions(Request $request)
    {
        $level = $request->input('level', 0);
        $parent = $request->input('parent');
        $jraType = $request->input('jra_type');

        // Level 0: Choose JRA Type
        if ($level == 0) {
            return response()->json([
                ['code' => 'Fasilitatif', 'label' => 'JRA Fasilitatif'],
                ['code' => 'Substantif', 'label' => 'JRA Substantif'],
            ]);
        }

        // Level 1: Pokok Masalah
        if ($level == 1) {
            $query = MasterKlasifikasi::select('kode_klasifikasi');
            
            if ($jraType) {
                $query->where('jenis_jra', $jraType);
            }

            $codes = $query->get();
            $unique = $codes->map(function($item) {
                $parts = explode('.', $item->kode_klasifikasi);
                return isset($parts[0]) ? $parts[0] : null;
            })->unique()->filter()->values();
            
            $formatted = $unique->map(function($code) use ($jraType) {
                return [
                    'code' => $code,
                    'label' => $this->getKategoriLabel($code)
                ];
            });

            return response()->json($formatted);
        }

        // Level 2: Sub Masalah
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

        // Level 3: Detail Klasifikasi
        if ($level == 3 && $parent) {
            $items = MasterKlasifikasi::where('kode_klasifikasi', 'like', $parent . '.%')
                        ->select('id', 'kode_klasifikasi', 'jenis_arsip', 'masa_simpan', 'tindakan_akhir')
                        ->get();
            
            $formatted = $items->map(function($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->kode_klasifikasi,
                    'label' => $item->kode_klasifikasi . ' - ' . $item->jenis_arsip,
                    'masa_simpan' => $item->masa_simpan,
                    'tindakan_akhir' => $item->tindakan_akhir
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
            'HK.00' => 'HK.00 - Peraturan',
            'HK.01' => 'HK.01 - Tanah / Bangunan',
            'HK.02' => 'HK.02 - Surat Berharga',
            'HK.03' => 'HK.03 - Dokumen Legal',
            'HM.00' => 'HM.00 - Penerangan',
            'HM.01' => 'HM.01 - Protokoler',
            'HM.02' => 'HM.02 - Publikasi',
            'HM.03' => 'HM.03 - Rekanan',
            'HM.04' => 'HM.04 - Bantuan Bina Lingkungan',
            'HM.05' => 'HM.05 - Kemitraan',
            'HM.06' => 'HM.06 - Sarana dan Prasarana',
            'KK.00' => 'KK.00 - Identifikasi',
            'KK.01' => 'KK.01 - Penilaian',
            'KK.02' => 'KK.02 - Pemantauan dan Pengendalian',
            'KM.00' => 'KM.00 - Keamanan Lingkungan Intern',
            'KM.01' => 'KM.01 - Keamanan Lingkungan Ekstern',
            'KM.02' => 'KM.02 - Kerjasama dengan Aparat Hukum',
            'KM.03' => 'KM.03 - Koordinasi Keamanan Pemerintah',
            'KS.00' => 'KS.00 - Surat Menyurat',
            'KS.01' => 'KS.01 - Laporan',
            'KS.02' => 'KS.02 - Kearsipan',
            'KS.03' => 'KS.03 - Supplies Kantor',
            'KU.00' => 'KU.00 - Anggaran',
            'KU.01' => 'KU.01 - Perbendaharaan',
            'KU.02' => 'KU.02 - Akuntansi',
            'PB.00' => 'PB.00 - Kinerja Suplier',
            'PB.01' => 'PB.01 - Pengadaan Barang',
            'PB.02' => 'PB.02 - Pengadaan Jasa',
            'PB.03' => 'PB.03 - Penerimaan Barang',
            'PB.04' => 'PB.04 - Pengeluaran Barang',
            'PW.00' => 'PW.00 - Pemeriksaan Ekstern',
            'PW.01' => 'PW.01 - Pengawasan Intern',
            'PW.02' => 'PW.02 - Pengawasan Anak Perusahaan & Lembaga Penunjang',
            'PW.03' => 'PW.03 - Pengawasan Intercompany SMIG',
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