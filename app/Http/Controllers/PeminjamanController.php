<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        // INI DATA DUMMY (Pura-pura ada database)
        $peminjaman = [
            [
                'tanggal' => '07/01/2026',
                'nama_peminjam' => 'Annisa Revalina Harahap',
                'unit' => 'Unit Sistem Manajemen',
                'arsip' => 'Dokumen Kontrak Kerjasama 2025',
                'status' => 'Sedang Dipinjam'
            ],
            [
                'tanggal' => '06/01/2026',
                'nama_peminjam' => 'Budi Santoso',
                'unit' => 'Unit SDM & Umum',
                'arsip' => 'Laporan Keuangan Tahunan',
                'status' => 'Sudah Dikembalikan'
            ],
            [
                'tanggal' => '05/01/2026',
                'nama_peminjam' => 'Annisa Revalina Harahap',
                'unit' => 'Unit Sistem Manajemen',
                'arsip' => 'Blueprints Pabrik Indarung VI',
                'status' => 'Sedang Dipinjam'
            ],
            [
                'tanggal' => '04/01/2026',
                'nama_peminjam' => 'Siti Aminah',
                'unit' => 'Unit K3',
                'arsip' => 'Data Kecelakaan Kerja 2024',
                'status' => 'Sudah Dikembalikan'
            ],
            // Kamu bisa tambah data dummy lain di sini...
        ];

        return view('peminjaman.index', compact('peminjaman'));
    }
}