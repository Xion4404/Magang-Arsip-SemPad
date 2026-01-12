<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; // Pastikan Import Model Ini
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. DATA RINGKAS (Untuk Widget Atas & Chart Donut)
        $dipinjam = Peminjaman::where('status', 'Sedang Dipinjam')->count();
        $kembali  = Peminjaman::whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan'])->count();

        // 2. DATA TREN BULANAN (Untuk Stacked Bar Chart)
        // Siapkan array kosong isi 0 untuk 12 bulan
        $dataDipinjam = array_fill(0, 12, 0); 
        $dataKembali  = array_fill(0, 12, 0);

        // Ambil data tahun ini saja biar relevan
        $tahunIni = date('Y');
        $transaksiTahunIni = Peminjaman::whereYear('tanggal_pinjam', $tahunIni)->get();

        // Looping data untuk dimasukkan ke bulan yang tepat
        foreach ($transaksiTahunIni as $item) {
            // Ambil angka bulan (01 - 12), kurangi 1 biar jadi index array (0 - 11)
            $bulanIndex = (int)date('m', strtotime($item->tanggal_pinjam)) - 1;

            if ($item->status == 'Sedang Dipinjam') {
                $dataDipinjam[$bulanIndex]++;
            } else {
                $dataKembali[$bulanIndex]++;
            }
        }

        // Kirim semua variabel ke View
        return view('beranda', compact('dipinjam', 'kembali', 'dataDipinjam', 'dataKembali'));
    }
}