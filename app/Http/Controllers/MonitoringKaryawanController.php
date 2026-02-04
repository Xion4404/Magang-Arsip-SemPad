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
        $query = LogAktivitas::with('user')->orderBy('id', 'desc');

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
        $inputEArsip = LogAktivitas::where('tahapan', 'Input E-Arsip')->count();
        
        return view('monitoring.index', compact('monitoring', 'total', 'bulanIni', 'pemilahan', 'pendataan', 'pelabelan', 'inputEArsip', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $arsipMasuk = ArsipMasuk::all(); // Get all ArsipMasuk for dropdown
        return view('monitoring.create', compact('users', 'arsipMasuk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'arsip_masuk_id' => 'required|exists:arsip_masuk,id',
            'tahapan' => 'required|string|in:Pemilahan,Pendataan,Pelabelan,Input E-Arsip',
            'jumlah_box_selesai' => 'nullable|integer',
            'tanggal_kerja' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $arsipMasuk = ArsipMasuk::findOrFail($request->arsip_masuk_id);

        LogAktivitas::create([
            'user_id' => $request->user_id,
            'arsip_masuk_id' => $arsipMasuk->id,
            'nba' => $arsipMasuk->nomor_berita_acara,
            'tahapan' => $request->tahapan,
            'jumlah_box' => $arsipMasuk->jumlah_box_masuk,
            'jumlah_box_selesai' => $request->jumlah_box_selesai ?? 0,
            'tanggal_kerja' => $request->tanggal_kerja,
            'unit_kerja' => $arsipMasuk->unit_asal,
            'keterangan' => $request->keterangan,
            'status_kerja' => 'Proses', // Default status
        ]);
        
        return redirect()->route('monitoring.index')->with('success', 'Data Monitoring berhasil ditambahkan!');
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
        $arsipMasuk = ArsipMasuk::all();
        return view('monitoring.edit', compact('monitoring', 'users', 'arsipMasuk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'arsip_masuk_id' => 'required|exists:arsip_masuk,id',
            'tahapan' => 'required|string|in:Pemilahan,Pendataan,Pelabelan,Input E-Arsip',
            'jumlah_box_selesai' => 'nullable|integer',
            'tanggal_kerja' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $logAktivitas = LogAktivitas::findOrFail($id);
        $arsipMasuk = ArsipMasuk::findOrFail($request->arsip_masuk_id);
    
        $logAktivitas->update([
            'user_id' => $request->user_id,
            'arsip_masuk_id' => $arsipMasuk->id,
            'nba' => $arsipMasuk->nomor_berita_acara,
            'tahapan' => $request->tahapan,
            'jumlah_box' => $arsipMasuk->jumlah_box_masuk,
            'jumlah_box_selesai' => $request->jumlah_box_selesai ?? 0,
            'tanggal_kerja' => $request->tanggal_kerja,
            'unit_kerja' => $arsipMasuk->unit_asal,
            'keterangan' => $request->keterangan,
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
        $stages = ['Pemilahan', 'Pendataan', 'Pelabelan', 'Input E-Arsip'];
        
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