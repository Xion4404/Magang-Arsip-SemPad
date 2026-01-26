<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipMasuk;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        // 1. Total Arsip Masuk
        $totalArsip = ArsipMasuk::count();

        // 2. Arsip Masuk Bulan Ini
        $bulanIniArsip = ArsipMasuk::whereMonth('tanggal_terima', now()->month)
            ->whereYear('tanggal_terima', now()->year)
            ->count();

        // 3. Tren Arsip Masuk (Tahun Ini) for Chart
        $arsipTrendData = ArsipMasuk::selectRaw('MONTH(tanggal_terima) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_terima', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();
        
        // Fill 1-12 months with 0 if missing
        $arsipBulananData = [];
        for($m=1; $m<=12; $m++) {
            $arsipBulananData[] = $arsipTrendData[$m] ?? 0;
        }

        return view('landing', compact('totalArsip', 'bulanIniArsip', 'arsipBulananData'));
    }
}
