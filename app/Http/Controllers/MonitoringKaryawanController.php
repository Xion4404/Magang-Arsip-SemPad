<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use App\Models\ArsipMasuk;
use App\Models\BerkasArsipMasuk;
use Illuminate\Http\Request;

class MonitoringKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->orderBy('id', 'asc');

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('tahapan', 'like', "%{$search}%")
                ->orWhere('unit_kerja', 'like', "%{$search}%")
                ->orWhere('nba', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // PIC Filter
        if ($request->has('pic') && $request->pic != '') {
            $query->where('user_id', $request->pic);
        }

        // Tahapan Filter
        if ($request->has('tahapan') && $request->tahapan != '') {
            $query->where('tahapan', $request->tahapan);
        }

        $monitoring = $query->get();
        $users = User::all(); // Fetch users for dropdown
        
        // Cards Data
        $total = ArsipMasuk::count();
        $bulanIni = ArsipMasuk::whereMonth('tanggal_terima', now()->month)
            ->whereYear('tanggal_terima', now()->year)
            ->count();
            
        $pemilahan = LogAktivitas::where('tahapan', 'Pemilahan')->count();
        $pendataan = LogAktivitas::where('tahapan', 'Pendataan')->count();
        $pelabelan = LogAktivitas::where('tahapan', 'Pelabelan')->count();
        
        return view('monitoring.index', compact('monitoring', 'total', 'bulanIni', 'pemilahan', 'pendataan', 'pelabelan', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $allBerkas = BerkasArsipMasuk::with('arsipMasuk')->get();
        // Get unique ArsipMasuk for the NBA dropdown
        $arsipMasuk = ArsipMasuk::all();
        return view('monitoring.create', compact('users', 'allBerkas', 'arsipMasuk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'berkas_id' => 'required|exists:berkas_arsip_masuk,id',
            'tahapan' => 'required|string|in:Pemilahan,Pendataan,Pelabelan,Input E Arsip',
            'jumlah_box_selesai' => 'nullable|integer',
            'tanggal_kerja' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $berkas = BerkasArsipMasuk::with('arsipMasuk')->findOrFail($request->berkas_id);
        $arsipMasuk = $berkas->arsipMasuk;

        // Append box and file info to keterangan
        $keterangan = $request->keterangan;
        $boxInfo = " | Pengerjaan Box: " . $berkas->no_box;
        $fileInfo = " | Berkas: " . $berkas->nama_berkas;
        
        // Handle Box Info
        if (strpos($keterangan, "Pengerjaan Box:") === false) {
             $keterangan .= $boxInfo;
        }
        // Handle File Info
        if (strpos($keterangan, "Berkas:") === false) {
             $keterangan .= $fileInfo;
        }

        LogAktivitas::create([
            'user_id' => $request->user_id,
            'arsip_masuk_id' => $arsipMasuk->id,
            'nba' => $arsipMasuk->nomor_berita_acara,
            'tahapan' => $request->tahapan,
            'jumlah_box' => $arsipMasuk->jumlah_box_masuk,
            'jumlah_box_selesai' => $request->jumlah_box_selesai ?? 0,
            'tanggal_kerja' => $request->tanggal_kerja,
            'unit_kerja' => $arsipMasuk->unit_asal,
            'keterangan' => $keterangan,
            'status_kerja' => 'Proses', // Default status
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $monitoring = LogAktivitas::findOrFail($id);
        $users = User::all();
        $allBerkas = BerkasArsipMasuk::with('arsipMasuk')->get();
        return view('monitoring.edit', compact('monitoring', 'users', 'allBerkas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'berkas_id' => 'required|exists:berkas_arsip_masuk,id',
            'tahapan' => 'required|string|in:Pemilahan,Pendataan,Pelabelan,Input E Arsip',
            'jumlah_box_selesai' => 'nullable|integer',
            'tanggal_kerja' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $logAktivitas = LogAktivitas::findOrFail($id);
        $berkas = BerkasArsipMasuk::with('arsipMasuk')->findOrFail($request->berkas_id);
        $arsipMasuk = $berkas->arsipMasuk;
        
        // Append/Update box and file info in keterangan
        $keterangan = $request->keterangan;
        $boxInfo = " | Pengerjaan Box: " . $berkas->no_box;
        $fileInfo = " | Berkas: " . $berkas->nama_berkas;

        // Update Box Info
        if (preg_match('/ \| Pengerjaan Box: .*/', $keterangan)) {
            $keterangan = preg_replace('/ \| Pengerjaan Box: [^|]*/', $boxInfo, $keterangan);
        } else {
             $keterangan .= $boxInfo;
        }

        // Update File Info
        if (preg_match('/ \| Berkas: .*/', $keterangan)) {
            $keterangan = preg_replace('/ \| Berkas: .*/', $fileInfo, $keterangan);
        } else {
             $keterangan .= $fileInfo;
        }

        $logAktivitas->update([
            'user_id' => $request->user_id,
            'arsip_masuk_id' => $arsipMasuk->id,
            'nba' => $arsipMasuk->nomor_berita_acara,
            'tahapan' => $request->tahapan,
            'jumlah_box' => $arsipMasuk->jumlah_box_masuk,
            'jumlah_box_selesai' => $request->jumlah_box_selesai ?? 0,
            'tanggal_kerja' => $request->tanggal_kerja,
            'unit_kerja' => $arsipMasuk->unit_asal,
            'keterangan' => $keterangan,
        ]);

        return redirect()->route('monitoring.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $logAktivitas = LogAktivitas::findOrFail($id);
        $logAktivitas->delete();
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Advance the stage of the specified resource.
     */
    public function advanceStage($id)
    {
        $monitoring = LogAktivitas::findOrFail($id);
        $stages = ['Pemilahan', 'Pendataan', 'Pelabelan', 'Input E Arsip'];
        
        $currentStageIndex = array_search($monitoring->tahapan, $stages);
        
        if ($currentStageIndex !== false && $currentStageIndex < count($stages) - 1) {
            $nextStage = $stages[$currentStageIndex + 1];
            
            // Check if Input E Arsip is complete or just transition to it?
            // User request only mentioned button to continue to next stage.
            
            $monitoring->tahapan = $nextStage;
            $monitoring->save();
            
            return redirect()->back()->with('success', 'Tahapan berhasil dilanjutkan ke ' . $nextStage);
        }

        return redirect()->back()->with('info', 'Tahapan sudah mencapai batas atau tidak valid.');
    }
}