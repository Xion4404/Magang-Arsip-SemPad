<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // === 1. TAMPILKAN DATA (INDEX + SEARCH + FILTER) ===
    public function index(Request $request)
    {
        // A. Cek apakah session kosong? Jika ya, isi dengan data dummy default
        if (!session()->has('data_peminjaman')) {
            $defaultData = [
                [
                    'tanggal' => '2026-01-07',
                    'nama_peminjam' => 'Annisa Revalina Harahap',
                    'unit' => 'Unit Sistem Manajemen',
                    'arsip' => 'Dokumen Kontrak Kerjasama 2025',
                    'status' => 'Sedang Dipinjam'
                ],
                [
                    'tanggal' => '2026-01-06',
                    'nama_peminjam' => 'Budi Santoso',
                    'unit' => 'Unit SDM & Umum',
                    'arsip' => 'Laporan Keuangan Tahunan',
                    'status' => 'Sudah Dikembalikan'
                ],
            ];
            session(['data_peminjaman' => $defaultData]);
        }

        // B. Ambil Data Mentah dari Session
        $allData = session('data_peminjaman');

        // C. LOGIKA FILTER & SEARCH (Menggunakan Collection Laravel)
        $peminjaman = collect($allData);

        // 1. Filter Search (Mencari di semua kolom)
        if ($request->has('search') && $request->search != null) {
            $keyword = strtolower($request->search);
            $peminjaman = $peminjaman->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item['nama_peminjam']), $keyword) ||
                       str_contains(strtolower($item['unit']), $keyword) ||
                       str_contains(strtolower($item['arsip']), $keyword) ||
                       str_contains(strtolower($item['status']), $keyword) ||
                       str_contains($item['tanggal'], $keyword);
            });
        }

        // 2. Filter Status (Dari Popup Sorting)
        if ($request->has('status') && $request->status != 'All') {
            $peminjaman = $peminjaman->where('status', $request->status);
        }

        // 3. Filter Tanggal (Dari Popup Sorting)
        if ($request->start_date) {
            $peminjaman = $peminjaman->where('tanggal', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $peminjaman = $peminjaman->where('tanggal', '<=', $request->end_date);
        }

        // D. Kembalikan data yang sudah difilter (values() untuk reset index array)
        $peminjaman = $peminjaman->values()->all();

        return view('peminjaman.index', compact('peminjaman'));
    }

    // === 2. FORM TAMBAH (CREATE) ===
    public function create()
    {
        $units = ['Unit Sistem Manajemen', 'Unit SDM & Umum', 'Unit K3', 'Unit Operasional', 'Unit Keuangan'];
        $daftarArsip = ['Dokumen Kontrak Kerjasama 2025', 'Laporan Keuangan Tahunan 2024', 'Blueprints Pabrik Indarung VI', 'Data Kecelakaan Kerja 2024'];

        return view('peminjaman.create', compact('units', 'daftarArsip'));
    }

    // === 3. PROSES SIMPAN BARU (STORE) ===
    public function store(Request $request)
    {
        $dataBaru = [
            'tanggal' => $request->tanggal,
            'nama_peminjam' => $request->nama_peminjam,
            'unit' => $request->unit,
            'arsip' => implode(', ', $request->arsip ?? []),
            'status' => 'Sedang Dipinjam'
        ];

        $currentData = session('data_peminjaman', []);
        array_unshift($currentData, $dataBaru); // Tambah ke paling atas
        session(['data_peminjaman' => $currentData]);

        return redirect('/peminjaman');
    }

    // === 4. UBAH STATUS JADI KEMBALI (COMPLETE) ===
    public function complete($id)
    {
        $data = session('data_peminjaman');
        if (isset($data[$id])) {
            $data[$id]['status'] = 'Sudah Dikembalikan';
            session(['data_peminjaman' => $data]);
        }
        return redirect('/peminjaman');
    }

    // === 5. FORM EDIT ===
    public function edit($id)
    {
        $data = session('data_peminjaman');
        
        // Cek data ada ga?
        if (!isset($data[$id])) return redirect('/peminjaman');

        $editData = $data[$id]; // Ambil data spesifik berdasarkan index ($id)
        
        // Data Dropdown
        $units = ['Unit Sistem Manajemen', 'Unit SDM & Umum', 'Unit K3', 'Unit Operasional', 'Unit Keuangan'];
        $daftarArsip = ['Dokumen Kontrak Kerjasama 2025', 'Laporan Keuangan Tahunan 2024', 'Blueprints Pabrik Indarung VI', 'Data Kecelakaan Kerja 2024'];

        return view('peminjaman.edit', compact('editData', 'id', 'units', 'daftarArsip'));
    }

    // === 6. PROSES UPDATE ===
    public function update(Request $request, $id)
    {
        $data = session('data_peminjaman');

        if (isset($data[$id])) {
            $data[$id]['tanggal'] = $request->tanggal;
            $data[$id]['nama_peminjam'] = $request->nama_peminjam;
            $data[$id]['unit'] = $request->unit;
            // Jika user pilih arsip baru, update. Jika tidak, pakai yang lama.
            if($request->arsip) {
                $data[$id]['arsip'] = implode(', ', $request->arsip);
            }
        }

        session(['data_peminjaman' => $data]);
        return redirect('/peminjaman');
    }

    // === 7. HAPUS DATA (DESTROY) ===
    public function destroy($id)
    {
        $data = session('data_peminjaman');
        
        if (isset($data[$id])) {
            unset($data[$id]); // Hapus data
            $data = array_values($data); // Urutkan ulang index array (supaya 0,1,2 rapi lagi)
            session(['data_peminjaman' => $data]);
        }

        return redirect('/peminjaman');
    }
}