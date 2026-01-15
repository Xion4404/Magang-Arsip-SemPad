<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Arsip;

// IMPORT UNTUK EXCEL
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanController extends Controller
{
    // =================================================================
    // 1. TAMPILKAN DATA (INDEX)
    // =================================================================
    public function index(Request $request)
    {
        // --- A. HITUNG STATISTIK ---
        $totalPeminjaman = Peminjaman::count();
        $masihDipinjam = Peminjaman::where('status', 'Sedang Dipinjam')->count();
        // Menghitung status 'Sudah' atau 'Telah' (jaga-jaga support keduanya)
        $sudahDikembalikan = Peminjaman::whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan'])->count();

        // --- B. QUERY DATA UTAMA ---
        $query = Peminjaman::with('arsip');

        // 1. Filter Search (Nama Peminjam, NIP, Unit, Nama Arsip, No Berkas)
        if ($request->has('search') && $request->search != null) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_peminjam', 'LIKE', "%$keyword%")
                  ->orWhere('nip', 'LIKE', "%$keyword%")
                  ->orWhere('unit_peminjam', 'LIKE', "%$keyword%")
                  ->orWhereHas('arsip', function($qArsip) use ($keyword) {
                      $qArsip->where('nama_berkas', 'LIKE', "%$keyword%")
                             ->orWhere('no_berkas', 'LIKE', "%$keyword%");
                  });
            });
        }

        // 2. Filter Status (Dari Modal Sort)
        if ($request->has('status') && $request->status != 'All') {
            if ($request->status == 'Sudah Dikembalikan' || $request->status == 'Telah Dikembalikan') {
                $query->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // 3. Filter Jenis Dokumen (Digital/Fisik)
        if ($request->has('jenis_dokumen') && $request->jenis_dokumen != 'All') {
            $query->where('jenis_dokumen', $request->jenis_dokumen);
        }

        // 4. Filter Tanggal (Dari Modal Sort)
        if ($request->start_date) {
            $query->whereDate('tanggal_pinjam', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('tanggal_pinjam', '<=', $request->end_date);
        }

        // Ambil data urut dari yang terbaru
        $peminjaman = $query->orderBy('id', 'desc')->get();

        return view('peminjaman.index', compact('peminjaman', 'totalPeminjaman', 'masihDipinjam', 'sudahDikembalikan'));
    }

    // =================================================================
    // 2. FORM TAMBAH (CREATE)
    // =================================================================
    public function create()
    {
        // LOGIKA BLACKLIST:
        // 1. Cari daftar ID Arsip yang statusnya masih 'Sedang Dipinjam'
        $idSedangDipinjam = Peminjaman::where('status', 'Sedang Dipinjam')
                                      ->pluck('arsip_id') 
                                      ->toArray();

        // 2. Ambil Arsip yang ID-nya TIDAK ADA di dalam daftar terlarang
        $daftarArsip = Arsip::whereNotIn('id', $idSedangDipinjam)
                            ->select('id', 'nama_berkas', 'no_berkas')
                            ->get();
        
        return view('peminjaman.create', compact('daftarArsip'));
    }

    // =================================================================
    // 3. PROSES SIMPAN (STORE)
    // =================================================================
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal' => 'required|date',
            'nama_peminjam' => 'required',
            'nip' => 'required|numeric',     // NIP harus angka
            'unit' => 'required',            // Input Manual Text
            'jenis_dokumen' => 'required',   // Digital/Fisik
            'bukti_pinjam' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib Upload Gambar (Max 2MB)
            'arsip_id' => 'required|array'
        ]);

        // 2. Proses Upload Gambar
        $pathBukti = null;
        if ($request->hasFile('bukti_pinjam')) {
            $file = $request->file('bukti_pinjam');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_pinjam'), $namaFile); 
            $pathBukti = 'bukti_pinjam/' . $namaFile;
        }

        // 3. Simpan Data per Arsip yang Dipilih
        foreach ($request->arsip_id as $idArsip) {
            // DOUBLE CHECK: Pastikan arsip ini benar-benar tidak dipinjam
            $sedangDipinjam = Peminjaman::where('arsip_id', $idArsip)
                                        ->where('status', 'Sedang Dipinjam')
                                        ->exists();

            if ($sedangDipinjam) {
                return back()->withErrors(['msg' => 'Gagal! Salah satu arsip yang dipilih sedang dipinjam orang lain.']);
            }

            // Simpan Data
            Peminjaman::create([
                'tanggal_pinjam' => $request->tanggal,
                'nama_peminjam' => $request->nama_peminjam,
                'nip' => $request->nip,              
                'unit_peminjam' => $request->unit,   
                'jenis_dokumen' => $request->jenis_dokumen, 
                'bukti_peminjaman' => $pathBukti,    
                'arsip_id' => $idArsip, 
                'status' => 'Sedang Dipinjam'
            ]);
        }

        return redirect('/peminjaman');
    }

    // =================================================================
    // 4. UBAH STATUS JADI KEMBALI (COMPLETE)
    // =================================================================
    public function complete($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        
        // Pastikan Database kamu kolom 'status' sudah diubah (bukan ENUM kaku)
        // atau ENUM-nya sudah ditambahkan 'Telah Dikembalikan'
        $pinjam->update(['status' => 'Telah Dikembalikan']);

        return redirect('/peminjaman');
    }

    // =================================================================
    // 5. FORM EDIT
    // =================================================================
    public function edit($id)
    {
        $editData = Peminjaman::with('arsip')->findOrFail($id);
        
        // LOGIKA BLACKLIST UNTUK EDIT:
        $idDipinjamOrangLain = Peminjaman::where('status', 'Sedang Dipinjam')
                                         ->where('id', '!=', $id) // Abaikan diri sendiri
                                         ->pluck('arsip_id')
                                         ->toArray();

        $daftarArsip = Arsip::whereNotIn('id', $idDipinjamOrangLain)
                            ->select('id', 'nama_berkas', 'no_berkas')
                            ->get();

        return view('peminjaman.edit', compact('editData', 'id', 'daftarArsip'));
    }

    // =================================================================
    // 6. PROSES UPDATE
    // =================================================================
    public function update(Request $request, $id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'nama_peminjam' => 'required',
            'nip' => 'required|numeric',
            'unit' => 'required',
            'jenis_dokumen' => 'required',
            // Gambar tidak required saat update (boleh kosong)
            'bukti_pinjam' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $dataUpdate = [
            'tanggal_pinjam' => $request->tanggal,
            'nama_peminjam' => $request->nama_peminjam,
            'nip' => $request->nip,
            'unit_peminjam' => $request->unit,
            'jenis_dokumen' => $request->jenis_dokumen,
        ];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('bukti_pinjam')) {
            // Hapus gambar lama jika ada
            if ($pinjam->bukti_peminjaman && file_exists(public_path($pinjam->bukti_peminjaman))) {
                unlink(public_path($pinjam->bukti_peminjaman));
            }

            // Upload gambar baru
            $file = $request->file('bukti_pinjam');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_pinjam'), $namaFile);
            $dataUpdate['bukti_peminjaman'] = 'bukti_pinjam/' . $namaFile;
        }

        // Jika user mengganti Arsip
        if ($request->has('arsip_id') && !empty($request->arsip_id)) {
            $newArsipId = $request->arsip_id[0];
            
            // Cek apakah arsip pengganti sedang dipinjam orang lain?
            $sedangDipinjam = Peminjaman::where('arsip_id', $newArsipId)
                                        ->where('status', 'Sedang Dipinjam')
                                        ->where('id', '!=', $id) 
                                        ->exists();
            
            if($sedangDipinjam) {
                 return back()->withErrors(['msg' => 'Gagal update! Arsip pengganti sedang dipinjam orang lain.']);
            }

            $dataUpdate['arsip_id'] = $newArsipId;
        }

        $pinjam->update($dataUpdate);

        return redirect('/peminjaman');
    }

    // =================================================================
    // 7. HAPUS DATA (DESTROY)
    // =================================================================
    public function destroy($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        
        // Hapus file gambar bukti jika ada
        if ($pinjam->bukti_peminjaman && file_exists(public_path($pinjam->bukti_peminjaman))) {
            unlink(public_path($pinjam->bukti_peminjaman));
        }

        $pinjam->delete();

        return redirect('/peminjaman');
    }

    // =================================================================
    // 8. EXPORT KE EXCEL (.xlsx)
    // =================================================================
    public function export(Request $request)
    {
        // Kita kirim seluruh data request (filter) ke class Export
        // Nama filenya dinamis ada tanggal & jam
        $namaFile = 'Laporan_Peminjaman_' . date('d-m-Y_H-i') . '.xlsx';

        return Excel::download(new PeminjamanExport($request->all()), $namaFile);
    }
}