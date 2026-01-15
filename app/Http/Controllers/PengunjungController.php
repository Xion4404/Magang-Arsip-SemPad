<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;

class PengunjungController extends Controller
{
    // =================================================================
    // 1. TAMPILKAN DAFTAR PENGUNJUNG (Dinding Tamu)
    // =================================================================
    public function index()
    {
        // Ambil data terbaru paling atas
        $pengunjung = Pengunjung::latest()->get();
        return view('pengunjung.index', compact('pengunjung'));
    }

    // =================================================================
    // 2. TAMPILKAN FORM ISI BUKU TAMU
    // =================================================================
    public function create()
    {
        return view('pengunjung.create');
    }

    // =================================================================
    // 3. PROSES SIMPAN DATA
    // =================================================================
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama' => 'required|max:255',
            'asal_instansi' => 'required|max:255', // Sekolah/Kampus/Umum
            'no_hp' => 'required|numeric',
            'pesan_kesan' => 'required',
        ]);

        // Simpan ke Database
        Pengunjung::create([
            'nama' => $request->nama,
            'asal_instansi' => $request->asal_instansi,
            'no_hp' => $request->no_hp,
            'pesan_kesan' => $request->pesan_kesan
        ]);

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect('/pengunjung')->with('success', 'Terima kasih! Pesan Anda telah ditempel di dinding tamu.');
    }

    // =================================================================
    // 4. HAPUS DATA (DESTROY)
    // =================================================================
    public function destroy($id)
    {
        // Cari data berdasarkan ID, kalau ga ketemu error 404
        $tamu = Pengunjung::findOrFail($id);
        
        // Hapus data
        $tamu->delete();

        // Kembali ke halaman index dengan notifikasi
        return redirect('/pengunjung')->with('success', 'Data pengunjung berhasil dilepas dari dinding.');
    }
}