<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManajemenMediaController extends Controller
{
    public function index()
    {
        $media = \App\Models\MediaInformasi::latest('tanggal')->paginate(10);
        return view('manajemen-media.index', compact('media'));
    }

    public function create()
    {
        return view('manajemen-media.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/media'), $filename);
            $validated['gambar'] = 'images/media/' . $filename;
        }

        \App\Models\MediaInformasi::create($validated);

        return redirect()->route('manajemen-media.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit($id)
    {
        $media = \App\Models\MediaInformasi::findOrFail($id);
        return view('manajemen-media.edit', compact('media'));
    }

    public function update(Request $request, $id)
    {
        $media = \App\Models\MediaInformasi::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($media->gambar && file_exists(public_path($media->gambar))) {
                unlink(public_path($media->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/media'), $filename);
            $validated['gambar'] = 'images/media/' . $filename;
        }

        $media->update($validated);

        return redirect()->route('manajemen-media.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $media = \App\Models\MediaInformasi::findOrFail($id);

        if ($media->gambar && file_exists(public_path($media->gambar))) {
            unlink(public_path($media->gambar));
        }

        $media->delete();

        return redirect()->route('manajemen-media.index')->with('success', 'Berita berhasil dihapus');
    }
}