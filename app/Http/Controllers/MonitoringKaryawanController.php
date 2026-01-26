<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringKaryawanController extends Controller
{
    public function index()
    {
        return view('monitoring.index');
    }

    public function create()
    {
        return view('monitoring.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        return view('monitoring.edit');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function advanceStage($id)
    {
        return back()->with('success', 'Status berhasil diperbarui');
    }
}
