<?php

namespace App\Http\Controllers;

use App\Models\ArsipMasuk;
use App\Models\BerkasArsipMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class ArsipMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = ArsipMasuk::orderBy('id', 'asc');

        // Filter by Search (General)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('unit_asal', 'like', "%{$search}%")
                  ->orWhere('nomor_berita_acara', 'like', "%{$search}%")
                  ->orWhereHas('penerima', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Unit Asal
        if ($request->has('unit_asal') && $request->unit_asal != '') {
            $query->where('unit_asal', $request->unit_asal);
        }

        // Filter by Penerima
        if ($request->has('penerima') && $request->penerima != '') {
            $query->where('user_penerima', $request->penerima);
        }

        $arsipMasuk = $query->get();
        
        // Get Options for Filters
        $unitAsalOptions = ArsipMasuk::select('unit_asal')->distinct()->pluck('unit_asal');
        $users = User::all();

        return view('arsip-masuk.index', compact('arsipMasuk', 'unitAsalOptions', 'users'));
    }

    public function show($id)
    {
        $arsipMasuk = ArsipMasuk::with(['berkas.klasifikasi', 'penerima'])->findOrFail($id);
        return view('arsip-masuk.show', compact('arsipMasuk'));
    }

    public function create()
    {
        $users = User::all();
        return view('arsip-masuk.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_asal' => 'required|string|max:255',
            'nomor_berita_acara' => 'required|string|max:100',
            'tanggal_terima' => 'required|date',
            'jumlah_box_masuk' => 'required|integer',
            'user_penerima' => 'required|exists:users,id',
        ]);

        $arsipMasuk = ArsipMasuk::create($request->all());

        return redirect()->route('arsip-masuk.berkas.create', $arsipMasuk->id)
            ->with('success', 'Data Arsip Masuk berhasil disimpan. Silakan input berkas per box.');
    }

    public function createBerkas($id)
    {
        $arsipMasuk = ArsipMasuk::with('berkas.klasifikasi')->findOrFail($id);
        $klasifikasi = \App\Models\MasterKlasifikasi::all();
        return view('arsip-masuk.add-berkas', compact('arsipMasuk', 'klasifikasi'));
    }

    public function storeBerkas(Request $request, $id)
    {
        $request->validate([
            'no_box' => 'required|string|max:50',
            'klasifikasi_id' => 'required|exists:master_klasifikasi,id',
            'nama_berkas' => 'required|string|max:255',
            'isi_berkas' => 'nullable|string',
            'tanggal_berkas' => 'nullable|date',
            'jumlah' => 'nullable|integer',
        ]);

        $arsipMasuk = ArsipMasuk::findOrFail($id);

        $arsipMasuk->berkas()->create([
            'no_box' => $request->no_box,
            'klasifikasi_id' => $request->klasifikasi_id,
            'nama_berkas' => $request->nama_berkas,
            'isi_berkas' => $request->isi_berkas,
            'tanggal_berkas' => $request->tanggal_berkas,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil ditambahkan!');
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

        // Level 1: Pokok Masalah (filtered by JRA Type)
        if ($level == 1) {
            $query = \App\Models\MasterKlasifikasi::select('kode_klasifikasi');
            
            if ($jraType) {
                // Assuming 'jenis_jra' column exists. If not, logic might utilize prefix or join. 
                // Using user provided logic:
                $query->where('jenis_jra', $jraType);
            }

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

        // Level 2: Sub Masalah (filtered by Parent Pokok Masalah)
        if ($level == 2 && $parent) {
            $codes = \App\Models\MasterKlasifikasi::where('kode_klasifikasi', 'like', $parent . '.%')->get();
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

        // Level 3: Specific Classification (filtered by Parent Sub Masalah)
        if ($level == 3 && $parent) {
            $items = \App\Models\MasterKlasifikasi::where('kode_klasifikasi', 'like', $parent . '.%')
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

    public function editBerkas($id, $berkasId)
    {
        $arsipMasuk = ArsipMasuk::findOrFail($id);
        $berkas = \App\Models\BerkasArsipMasuk::findOrFail($berkasId);
        
        // Ensure the berkas belongs to the arsipMasuk
        if($berkas->arsip_masuk_id != $id) {
            abort(404);
        }

        return view('arsip-masuk.add-berkas', compact('arsipMasuk', 'berkas'));
    }

    public function updateBerkas(Request $request, $id, $berkasId)
    {
        $berkas = \App\Models\BerkasArsipMasuk::findOrFail($berkasId);
        
        if($berkas->arsip_masuk_id != $id) {
            abort(404);
        }

        $request->validate([
            'no_box' => 'required',
            'klasifikasi_id' => 'required|exists:master_klasifikasi,id',
            'nama_berkas' => 'required',
            'tanggal_berkas' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $berkas->update([
            'no_box' => $request->no_box,
            'klasifikasi_id' => $request->klasifikasi_id,
            'nama_berkas' => $request->nama_berkas,
            'isi_berkas' => $request->isi_berkas,
            'tanggal_berkas' => $request->tanggal_berkas,
            'jumlah' => $request->jumlah
        ]);

        return redirect()->route('arsip-masuk.berkas.create', $id)->with('success', 'Berkas berhasil diperbarui!');
    }

    public function destroyBerkas($id, $berkasId)
    {
        $berkas = \App\Models\BerkasArsipMasuk::findOrFail($berkasId);
        
        if($berkas->arsip_masuk_id != $id) {
            abort(404);
        }

        $berkas->delete();

        return redirect()->route('arsip-masuk.berkas.create', $id)->with('success', 'Berkas berhasil dihapus!');
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
            
            // Substantif placeholders 
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
