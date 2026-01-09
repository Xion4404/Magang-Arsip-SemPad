<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Arsip;

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
        $sudahDikembalikan = Peminjaman::where('status', 'Sudah Dikembalikan')->count();

        // --- B. QUERY DATA UTAMA ---
        $query = Peminjaman::with('arsip');

        // 1. Filter Search (Nama Peminjam, Unit, Nama Arsip, No Berkas)
        if ($request->has('search') && $request->search != null) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_peminjam', 'LIKE', "%$keyword%")
                  ->orWhere('unit_peminjam', 'LIKE', "%$keyword%")
                  ->orWhereHas('arsip', function($qArsip) use ($keyword) {
                      $qArsip->where('nama_berkas', 'LIKE', "%$keyword%")
                             ->orWhere('no_berkas', 'LIKE', "%$keyword%");
                  });
            });
        }

        // 2. Filter Status (Dari Modal Sort)
        if ($request->has('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        // 3. Filter Tanggal (Dari Modal Sort)
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
                                      ->pluck('arsip_id') // Ambil ID-nya saja
                                      ->toArray();        // Ubah jadi array [1, 5, 10...]

        // 2. Ambil Arsip yang ID-nya TIDAK ADA di dalam daftar terlarang (blacklist) tadi
        // Kita juga select 'no_berkas' supaya fitur search dropdown di view tidak error
        $daftarArsip = Arsip::whereNotIn('id', $idSedangDipinjam)
                            ->select('id', 'nama_berkas', 'no_berkas')
                            ->get();
        
        $units = ['Unit Sistem Manajemen', 'Unit SDM & Umum', 'Unit K3', 'Unit Operasional', 'Unit Keuangan'];

        return view('peminjaman.create', compact('units', 'daftarArsip'));
    }

    // =================================================================
    // 3. PROSES SIMPAN (STORE)
    // =================================================================
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_peminjam' => 'required',
            'unit' => 'required',
            'arsip_id' => 'required|array'
        ]);

        foreach ($request->arsip_id as $idArsip) {
            // DOUBLE CHECK: Pastikan arsip ini benar-benar tidak dipinjam saat tombol diklik
            $sedangDipinjam = Peminjaman::where('arsip_id', $idArsip)
                                        ->where('status', 'Sedang Dipinjam')
                                        ->exists();

            if ($sedangDipinjam) {
                // Jika keduluan orang lain, kembalikan dengan pesan error
                return back()->withErrors(['msg' => 'Gagal! Salah satu arsip yang dipilih sedang dipinjam orang lain.']);
            }

            // Simpan Data
            Peminjaman::create([
                'tanggal_pinjam' => $request->tanggal,
                'nama_peminjam' => $request->nama_peminjam,
                'unit_peminjam' => $request->unit,
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
        
        // Update status jadi 'Sudah Dikembalikan'
        // (Otomatis arsip ini akan muncul lagi di dropdown create karena statusnya bukan 'Sedang Dipinjam' lagi)
        $pinjam->update(['status' => 'Sudah Dikembalikan']);

        return redirect('/peminjaman');
    }

    // =================================================================
    // 5. FORM EDIT
    // =================================================================
    public function edit($id)
    {
        $editData = Peminjaman::with('arsip')->findOrFail($id);
        $units = ['Unit Sistem Manajemen', 'Unit SDM & Umum', 'Unit K3', 'Unit Operasional', 'Unit Keuangan'];
        
        // LOGIKA BLACKLIST UNTUK EDIT:
        // 1. Cari ID arsip yang dipinjam orang lain (KECUALI transaksi yang sedang diedit ini)
        $idDipinjamOrangLain = Peminjaman::where('status', 'Sedang Dipinjam')
                                         ->where('id', '!=', $id) // Abaikan diri sendiri
                                         ->pluck('arsip_id')
                                         ->toArray();

        // 2. Ambil Arsip yang aman (tidak dipakai orang lain)
        $daftarArsip = Arsip::whereNotIn('id', $idDipinjamOrangLain)
                            ->select('id', 'nama_berkas', 'no_berkas')
                            ->get();

        return view('peminjaman.edit', compact('editData', 'id', 'units', 'daftarArsip'));
    }

    // =================================================================
    // 6. PROSES UPDATE
    // =================================================================
    public function update(Request $request, $id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $dataUpdate = [
            'tanggal_pinjam' => $request->tanggal,
            'nama_peminjam' => $request->nama_peminjam,
            'unit_peminjam' => $request->unit,
        ];

        // Jika user mengganti Arsip
        if ($request->has('arsip_id') && !empty($request->arsip_id)) {
            $newArsipId = $request->arsip_id[0];
            
            // Cek apakah arsip pengganti sedang dipinjam orang lain?
            $sedangDipinjam = Peminjaman::where('arsip_id', $newArsipId)
                                        ->where('status', 'Sedang Dipinjam')
                                        ->where('id', '!=', $id) // Kecuali diri sendiri
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
        $pinjam->delete();

        return redirect('/peminjaman');
    }
}