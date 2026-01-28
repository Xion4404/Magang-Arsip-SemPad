<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringKaryawanController extends Controller
{
    public function index(Request $request)
    {
        // Query Dasar
        $query = \App\Models\MonitoringKaryawan::with('user');

        // Filter Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nba', 'like', "%{$search}%")
                    ->orWhere('unit_kerja', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter PIC
        if ($request->has('pic') && $request->pic != '') {
            $query->where('user_id', $request->pic);
        }

        // Filter Tahapan
        if ($request->has('tahapan') && $request->tahapan != '') {
            $query->where('tahapan', $request->tahapan);
        }

        // Data Table (Paginate)
        $monitoring = $query->latest('tanggal_kerja')->paginate(10)->withQueryString();

        // Data Statistik (Card)
        // Hitung total keseluruhan tanpa filter paginate tapi tetap kena filter search/pic/tahapan jika diinginkan?
        // Biasanya card statistik itu TOTAL GLOBAL atau TOTAL TERFILTER. 
        // Berdasarkan UI, sepertinya Total Global (atau minimal mengikuti filter jika user mau).
        // Kita buat ikut filter activity agar dinamis.

        // Clone query untuk statistik agar tidak kena paginate
        $statsQuery = \App\Models\MonitoringKaryawan::query();

        $total = $statsQuery->count();
        $bulanIni = $statsQuery->clone()->whereMonth('tanggal_kerja', now()->month)
            ->whereYear('tanggal_kerja', now()->year)->count();
        $pemilahan = $statsQuery->clone()->where('tahapan', 'Pemilahan')->count();
        $pendataan = $statsQuery->clone()->where('tahapan', 'Pendataan')->count();
        $pelabelan = $statsQuery->clone()->where('tahapan', 'Pelabelan')->count();
        $inputEArsip = $statsQuery->clone()->where('tahapan', 'Input E-Arsip')->count();

        // List Users untuk Filter
        $users = \App\Models\User::where('role', 'karyawan')->get();

        return view('monitoring.index', compact(
            'monitoring',
            'total',
            'bulanIni',
            'pemilahan',
            'pendataan',
            'pelabelan',
            'inputEArsip',
            'users'
        ));
    }

    public function create()
    {
        return view('monitoring.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahapan' => 'required|in:Pemilahan,Pendataan,Pelabelan,Input E-Arsip',
            'tanggal_kerja' => 'required|date',
            'nba' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'jumlah_box_selesai' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        \App\Models\MonitoringKaryawan::create($validated);

        return redirect()->route('monitoring.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $monitoring = \App\Models\MonitoringKaryawan::findOrFail($id);
        return view('monitoring.edit', compact('monitoring'));
    }

    public function update(Request $request, $id)
    {
        $monitoring = \App\Models\MonitoringKaryawan::findOrFail($id);

        $validated = $request->validate([
            'tahapan' => 'required|in:Pemilahan,Pendataan,Pelabelan,Input E-Arsip',
            'tanggal_kerja' => 'required|date',
            'nba' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'jumlah_box_selesai' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $monitoring->update($validated);

        return redirect()->route('monitoring.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $monitoring = \App\Models\MonitoringKaryawan::findOrFail($id);
        $monitoring->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function advanceStage($id)
    {
        $monitoring = \App\Models\MonitoringKaryawan::findOrFail($id);

        $stages = ['Pemilahan', 'Pendataan', 'Pelabelan', 'Input E-Arsip'];
        $currentKey = array_search($monitoring->tahapan, $stages);

        if ($currentKey !== false && isset($stages[$currentKey + 1])) {
            $monitoring->tahapan = $stages[$currentKey + 1];
            $monitoring->save();
            return back()->with('success', 'Tahapan berhasil diperbarui ke ' . $monitoring->tahapan);
        }

        return back()->with('error', 'Tahapan sudah maksimal');
    }
}
