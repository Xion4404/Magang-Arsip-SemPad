<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArsipMasukController extends Controller
{
    public function index()
    {
        $arsipMasuk = \App\Models\ArsipMasuk::with('penerima')
            ->latest('tanggal_terima')
            ->paginate(10);

        // Filter by Search (General)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('unit_asal', 'like', "%{$search}%")
                  ->orWhere('nomor_berita_acara', 'like', "%{$search}%")
                  ->orWhereHas('penerima', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Unit Asal
        if ($request->has('unit_asal') && $request->unit_asal != '') {
            $query->where('unit_asal', $request->unit_asal);
        }

        // Filter by Penerima
        if ($request->has('penerima') && $request->penerima != '') {
            $query->where('user_penerima', $request->penerima);
        }

        // Filter by Year
        if ($request->has('year') && $request->year != '') {
            $query->whereYear('tanggal_terima', $request->year);
        }

        $arsipMasuk = $query->get();
        
        // Get Options for Filters
        $unitAsalOptions = ArsipMasuk::select('unit_asal')->distinct()->pluck('unit_asal');
        $yearOptions = ArsipMasuk::selectRaw('YEAR(tanggal_terima) as year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $users = User::all();

        return view('arsip-masuk.index', compact('arsipMasuk', 'unitAsalOptions', 'yearOptions', 'users'));
    }

    public function export(Request $request)
    {
        $type = $request->input('type');
        $ids = json_decode($request->input('ids'), true);
        $search = $request->input('search');
        $unit_asal = $request->input('unit_asal');
        $year = $request->input('year');
        $penerima = $request->input('penerima');

        $export = new \App\Exports\ArsipMasukExport($ids, $search, $unit_asal, $year, $penerima);
        $filename = 'arsip-masuk-' . date('Y-m-d') . ($type === 'pdf' ? '.pdf' : '.xlsx');

        if ($type === 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
        }

        if ($type === 'pdf') {
            $query = $export->query();
            $data = $query->get();
            $isPdf = true;
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('arsip-masuk.pdf', compact('data', 'isPdf'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download($filename);
        }

        if ($type === 'print') {
            $query = $export->query();
            $data = $query->get();
            $isPdf = false;
            
            return view('arsip-masuk.pdf', compact('data', 'isPdf'));
        }

        return redirect()->back();
    }

    public function show($id)
    {
        $arsipMasuk = ArsipMasuk::with(['berkas.klasifikasi', 'penerima'])->findOrFail($id);
        return view('arsip-masuk.show', compact('arsipMasuk'));
    }

    public function create()
    {
        return view('arsip-masuk.create');
    }

    public function store(Request $request)
    {
        // Placeholder
        return redirect()->route('arsip-masuk.index')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        return view('arsip-masuk.show');
    }

    public function getKlasifikasiOptions()
    {
        // Placeholder
        return response()->json([]);
    }

    // Berkas Methods
    public function createBerkas($id)
    {
        return view('arsip-masuk.berkas.create');
    }

    public function storeBerkas(Request $request, $id)
    {
        // Placeholder
        return back()->with('success', 'Berkas berhasil ditambahkan');
    }

    public function editBerkas($id, $berkasId)
    {
        return view('arsip-masuk.berkas.edit');
    }

    public function updateBerkas(Request $request, $id, $berkasId)
    {
        // Placeholder
        return back()->with('success', 'Berkas berhasil diupdate');
    }

    public function destroyBerkas($id, $berkasId)
    {
        // Placeholder
        return back()->with('success', 'Berkas berhasil dihapus');
    }
}
