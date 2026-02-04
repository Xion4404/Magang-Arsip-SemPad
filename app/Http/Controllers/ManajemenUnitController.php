<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class ManajemenUnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($request->has('search')) {
            $query->where('nama_unit', 'like', '%' . $request->search . '%');
        }

        $units = $query->orderBy('nama_unit', 'asc')->get();

        return view('manajemen-unit.index', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|unique:units,nama_unit',
            'keterangan' => 'nullable|string'
        ]);

        Unit::create($request->all());

        return redirect()->route('manajemen-unit.index')->with('success', 'Unit berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_unit' => 'required|unique:units,nama_unit,' . $id,
            'keterangan' => 'nullable|string'
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update($request->all());

        return redirect()->route('manajemen-unit.index')->with('success', 'Unit berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('manajemen-unit.index')->with('success', 'Unit berhasil dihapus!');
    }
}
