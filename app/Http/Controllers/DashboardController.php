<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // 1. DATA RINGKAS (Card Atas & Chart Donut)
        // ==========================================
        $dipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->where('status', 'Sedang Dipinjam');
        })->count();

        $kembali = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
        })->count();

        // ==========================================
        // 2. DATA TREN BULANAN (Bar Chart)
        // ==========================================
        $dataDipinjam = array_fill(0, 12, 0);
        $dataKembali = array_fill(0, 12, 0);

        $tahunIni = date('Y');

        // Ambil semua DETAIL Item tahun ini (berdasarkan tgl pinjam parent)
        $itemsTahunIni = DetailPeminjaman::with('peminjaman')
            ->whereHas('peminjaman', function ($q) use ($tahunIni) {
                $q->whereYear('tanggal_pinjam', $tahunIni);
            })->get();

        foreach ($itemsTahunIni as $item) {
            if (!$item->peminjaman)
                continue;

            $bulanIndex = (int) date('m', strtotime($item->peminjaman->tanggal_pinjam)) - 1;

            if ($item->peminjaman->status == 'Sedang Dipinjam') {
                $dataDipinjam[$bulanIndex]++;
            } else {
                $dataKembali[$bulanIndex]++;
            }
        }



        // ==========================================
        // 4. (BARU) PROPORSI MEDIA (Pie Chart)
        // ==========================================
        // Menggantikan Jabatan yang tidak penting
        $mediaHardfile = DetailPeminjaman::where('jenis_arsip', 'Hardfile')->count();
        $mediaSoftfile = DetailPeminjaman::where('jenis_arsip', 'Softfile')->count();

        return view('beranda', compact(
            'dipinjam',
            'kembali',
            'dataDipinjam',
            'dataKembali',

            'mediaHardfile',
            'mediaSoftfile' // Kirim data media
        ));
    }
}