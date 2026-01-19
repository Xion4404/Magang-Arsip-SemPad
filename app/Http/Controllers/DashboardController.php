<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // 1. DATA RINGKAS (Card Atas & Chart Donut)
        // ==========================================
        $dipinjam = Peminjaman::where('status', 'Sedang Dipinjam')->count();
        $kembali  = Peminjaman::whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan'])->count();

        // ==========================================
        // 2. DATA TREN BULANAN (Bar Chart)
        // ==========================================
        $dataDipinjam = array_fill(0, 12, 0); 
        $dataKembali  = array_fill(0, 12, 0);

        $tahunIni = date('Y');
        $transaksiTahunIni = Peminjaman::whereYear('tanggal_pinjam', $tahunIni)->get();

        foreach ($transaksiTahunIni as $item) {
            $bulanIndex = (int)date('m', strtotime($item->tanggal_pinjam)) - 1;

            if ($item->status == 'Sedang Dipinjam') {
                $dataDipinjam[$bulanIndex]++;
            } else {
                $dataKembali[$bulanIndex]++;
            }
        }

        // ==========================================
        // 3. TOP 5 UNIT PEMINJAM (Horizontal Bar)
        // ==========================================
        $topUnit = Peminjaman::select('unit_peminjam', DB::raw('count(*) as total'))
                    ->groupBy('unit_peminjam')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->get();

        $unitLabels = $topUnit->pluck('unit_peminjam');
        $unitData   = $topUnit->pluck('total');

        // ==========================================
        // 4. (BARU) PROPORSI MEDIA (Pie Chart)
        // ==========================================
        // Menggantikan Jabatan yang tidak penting
        $mediaHardfile = Peminjaman::where('jenis_dokumen', 'LIKE', '%Hardfile%')->count();
        $mediaSoftfile = Peminjaman::where('jenis_dokumen', 'LIKE', '%Softfile%')->count();

        return view('beranda', compact(
            'dipinjam', 'kembali', 
            'dataDipinjam', 'dataKembali',
            'unitLabels', 'unitData',
            'mediaHardfile', 'mediaSoftfile' // Kirim data media
        ));
    }
}