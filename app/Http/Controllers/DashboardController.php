<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\DetailPeminjaman; 
use App\Models\LogAktivitas;
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

        $pemilahan = $applyFilters(LogAktivitas::where('tahapan', 'Pemilahan'))->count();
        $pendataan = $applyFilters(LogAktivitas::where('tahapan', 'Pendataan'))->count();
        $pelabelan = $applyFilters(LogAktivitas::where('tahapan', 'Pelabelan'))->count();
        
        // Recent Activities for Table (Add this too as it was missing from the view's data)
        $monitoringLogs = $applyFilters(LogAktivitas::with('user'))->orderBy('id', 'desc')->take(10)->get();
        // Calculate userStats for generic usage if needed, though pemilahanStats covers top table
        $userStats = \App\Models\LogAktivitas::with('user')
            ->selectRaw('user_id, SUM(jumlah_box) as total_target, SUM(jumlah_box_selesai) as total_selesai')
            ->groupBy('user_id')
            ->get()
            ->map(function($stat) {
                $stat->persentase = $stat->total_target > 0 
                    ? round(($stat->total_selesai / $stat->total_target) * 100) 
                    : 0;
                return $stat;
            });
        
        // A. Top Table & Chart Data
        $pemilahanStatsQuery = LogAktivitas::with('user')->where('tahapan', 'Pemilahan');
        $pemilahanStats = $applyFilters($pemilahanStatsQuery)
            ->selectRaw('user_id, SUM(jumlah_box) as total_target, SUM(jumlah_box_selesai) as total_selesai')
            ->groupBy('user_id')
            ->get()
            ->map(function($stat) {
                $stat->persentase = $stat->total_target > 0 
                    ? round(($stat->total_selesai / $stat->total_target) * 100) 
                    : 0;
                return $stat;
            });

        // For the Chart: "Rata-rata Aktivitas PIC" (Overall Progress All Stages)
        $chartStatsQuery = LogAktivitas::with('user');
        $chartStats = $applyFilters($chartStatsQuery)
            ->selectRaw('user_id, SUM(jumlah_box) as total_target, SUM(jumlah_box_selesai) as total_selesai')
            ->groupBy('user_id')
            ->get()
            ->map(function($stat) {
                $stat->persentase = $stat->total_target > 0 
                    ? round(($stat->total_selesai / $stat->total_target) * 100) 
                    : 0;
                return $stat;
            })
            ->sortByDesc('persentase')
            ->values();

        // --- NEW CHARTS DATA FOR "ARSIP" TAB ---

        // 1. CHART TAHAPAN PENGARSIPAN (Horizontal Bar)
        // We already have $pemilahan, $pendataan, $pelabelan, $inputEArsip counts from filters above.
        // We just need to pack them for the view.
        // Note: These respect the selected filters (which makes sense).
        $tahapanChartData = [
            'labels' => ['Pemilahan', 'Pendataan', 'Pelabelan', 'Input E-Arsip'],
            'data' => [$pemilahan, $pendataan, $pelabelan, $inputEArsip]
        ];

        // 2. CHART ARSIP MASUK PER BULAN (Line Chart)
        // This should probably be "General" stats, or filtered? 
        // Usually trend charts ignore month/week filters but respect Unit/PIC if applicable.
        // Let's make it respect Unit filter if present, but ignore Month/Week filter to show the trend.
        
        $arsipTrendQuery = \App\Models\ArsipMasuk::query();
        // Apply Unit Filter if exists (Manually, since ArsipMasuk structure is different from LogAktivitas)
        if ($request->has('unit_kerja') && $request->unit_kerja != '') {
            $arsipTrendQuery->where('unit_asal', $request->unit_kerja);
        }
        
        $arsipTrendData = $arsipTrendQuery->selectRaw('MONTH(tanggal_terima) as bulan, COUNT(*) as total')
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

        // 3. CHART ARSIP PER UNIT KERJA (Donut Chart)
        // Top 5 Units + others? Or just all? Let's try Top 5 for neatness.
        $arsipUnitQuery = \App\Models\ArsipMasuk::query();
        if ($request->has('bulan') && $request->bulan != '') {
            $arsipUnitQuery->whereMonth('tanggal_terima', $request->bulan);
        }
        // Unit filter doesn't make sense for a "Per Unit" chart (would just be 100% one slice), 
        // unless we want to drill down? valid. But usually we want to see comparison.
        // Let's keep it unfiltered by unit to show distribution, but respect time filters.

        $arsipUnitDataRaw = $arsipUnitQuery->selectRaw('unit_asal, COUNT(*) as total')
            ->groupBy('unit_asal')
            ->orderByDesc('total')
            ->take(10) // Limit to top 10 to avoid overcrowding
            ->get();
            
        $arsipUnitChart = [
            'labels' => $arsipUnitDataRaw->pluck('unit_asal'),
            'data' => $arsipUnitDataRaw->pluck('total')
        ];

        // B. Detailed Matrix (Bottom Table)
        $stages = ['Pemilahan', 'Pendataan', 'Pelabelan', 'Input E-Arsip'];
        $matrixData = [];

        // 1. Get distinct User + Unit Kerja pairs matching filters
        $combinationsQuery = LogAktivitas::select('user_id', 'unit_kerja')
            ->distinct()
            ->whereNotNull('user_id')
            ->whereNotNull('unit_kerja')
            ->with('user');
        
        $combinations = $applyFilters($combinationsQuery)->get();

        foreach ($combinations as $combo) {
            $user = $combo->user;
            if (!$user) continue;

            $row = [
                'user' => $user,
                'unit_kerja' => $combo->unit_kerja
            ];

            $hasActivity = false;

            foreach ($stages as $stage) {
                $statsQuery = LogAktivitas::where('user_id', $user->id)
                    ->where('unit_kerja', $combo->unit_kerja)
                    ->where('tahapan', $stage);
                
                if ($request->has('bulan') && $request->bulan != '') {
                    $statsQuery->whereMonth('tanggal_kerja', $request->bulan);
                }
                if ($request->has('minggu') && $request->minggu != '') {
                     $statsQuery->whereRaw('FLOOR((Day(tanggal_kerja) - 1) / 7) + 1 = ?', [$request->minggu]);
                }

                $stats = $statsQuery->selectRaw('SUM(jumlah_box) as target, SUM(jumlah_box_selesai) as selesai')
                    ->first();

                // If no record, use 0
                $target = $stats->target ?? 0;
                $selesai = $stats->selesai ?? 0;
                $progress = $target > 0 ? round(($selesai / $target) * 100) : 0;

                if ($target > 0) $hasActivity = true;

                $row[$stage] = [
                    'target' => $target,
                    'selesai' => $selesai,
                    'progress' => $progress
                ];
            }
            
            if($hasActivity) {
                $matrixData[] = $row;
            }
        }
        
        // Sort by User Name for better readability
        usort($matrixData, function($a, $b) {
            return strcmp($a['user']->nama, $b['user']->nama);
        });

        // ==========================================
        // 4. (BARU) PROPORSI MEDIA (Pie Chart)
        // ==========================================
        // Menggantikan Jabatan yang tidak penting
        $mediaHardfile = DetailPeminjaman::where('jenis_arsip', 'Hardfile')->count();
        $mediaSoftfile = DetailPeminjaman::where('jenis_arsip', 'Softfile')->count();

        // Kirim semua variabel ke View
        return view('beranda', compact(
            'dipinjam', 'kembali', 'dataDipinjam', 'dataKembali',
            'pemilahanStats', 'chartStats', 'matrixData', 'stages',
            'totalArsip', 'totalBox', 'inputEArsip', 'bulanIniArsip', 
            'pemilahan', 'pendataan', 'pelabelan', 'monitoringLogs', 'userStats',
            'allPics', 'allUnits',
            'tahapanChartData', 'arsipBulananData', 'arsipUnitChart',
            'mediaHardfile', 'mediaSoftfile'
        ));
    }
}