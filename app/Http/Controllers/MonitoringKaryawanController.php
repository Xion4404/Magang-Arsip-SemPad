<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;

class MonitoringKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $monitoring = LogAktivitas::with('user')->latest()->get();
        $total = LogAktivitas::count();
        $bulanIni = LogAktivitas::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $selesai = LogAktivitas::where('status_kerja', 'Selesai')->count();

        return view('monitoring.index', compact('monitoring', 'total', 'bulanIni', 'selesai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('monitoring.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nba' => 'required|string|max:255',
            'tahapan' => 'required|string|max:255',
            'jumlah_box' => 'required|integer',
            'tanggal_berkas_masuk' => 'required|date',
            'unit_kerja' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        LogAktivitas::create([
            'user_id' => $request->user_id,
            'nba' => $request->nba,
            'tahapan' => $request->tahapan,
            'jumlah_box' => $request->jumlah_box,
            'tanggal_berkas_masuk' => $request->tanggal_berkas_masuk,
            'unit_kerja' => $request->unit_kerja,
            'keterangan' => $request->keterangan,
            'status_kerja' => 'Proses', // Default status
        ]);

        return redirect()->route('monitoring.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MonitoringKaryawan $monitoringKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonitoringKaryawan $monitoringKaryawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MonitoringKaryawan $monitoringKaryawan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonitoringKaryawan $monitoringKaryawan)
    {
        //
    }
}
