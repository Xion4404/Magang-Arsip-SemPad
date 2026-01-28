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

        return view('arsip-masuk.index', compact('arsipMasuk'));
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
