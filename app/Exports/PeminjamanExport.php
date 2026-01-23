<?php

namespace App\Exports;

use App\Models\DetailPeminjaman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PeminjamanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;
    private $rowNumber = 0;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        // Ubah query utama ke DetailPeminjaman agar arsip yang muncul sesuai filter (Atomic)
        $query = DetailPeminjaman::query()->with(['peminjaman', 'arsip']);

        $request = $this->filters;

        // 1. FILTER SEARCH (Cari di Parent Peminjaman ATAU di Detail Arsip)
        if (isset($request['search']) && $request['search'] != null) {
            $keyword = $request['search'];
            $query->where(function ($q) use ($keyword) {
                // Cari di Peminjam
                $q->whereHas('peminjaman', function ($qP) use ($keyword) {
                    $qP->where('nama_peminjam', 'LIKE', "%$keyword%")
                        ->orWhere('nip', 'LIKE', "%$keyword%")
                        ->orWhere('unit_peminjam', 'LIKE', "%$keyword%");
                })
                    // Atau cari di Arsip (Snapshot Name)
                    ->orWhere('nama_arsip', 'LIKE', "%$keyword%")
                    ->orWhere('no_box', 'LIKE', "%$keyword%")
                    // Atau cari di Relasi Arsip (Master)
                    ->orWhereHas('arsip', function ($qArsip) use ($keyword) {
                        $qArsip->where('nama_berkas', 'LIKE', "%$keyword%")
                            ->orWhere('no_berkas', 'LIKE', "%$keyword%");
                    });
            });
        }

        // 2. FILTER STATUS (Filter Parent Peminjaman)
        if (isset($request['status']) && $request['status'] != 'All') {
            $status = $request['status'];
            $query->whereHas('peminjaman', function ($q) use ($status) {
                if ($status == 'Sudah Dikembalikan' || $status == 'Telah Dikembalikan') {
                    $q->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
                } else {
                    $q->where('status', $status);
                }
            });
        }

        // 3. FILTER MEDIA / JENIS ARSIP (Filter Detail Langsung -> Strict Filter)
        if (isset($request['media']) && $request['media'] != 'All') {
            $query->where('jenis_arsip', $request['media']);
        }

        // 4. FILTER KEAMANAN / HAK AKSES (Filter Detail Langsung -> Strict Filter)
        if (isset($request['keamanan']) && $request['keamanan'] != 'All') {
            $query->where('hak_akses', $request['keamanan']);
        }

        // 5. FILTER TANGGAL (Filter Parent Peminjaman)
        if (isset($request['start_date']) && $request['start_date'] != null) {
            $query->whereHas('peminjaman', function ($q) use ($request) {
                $q->whereDate('tanggal_pinjam', '>=', $request['start_date']);
            });
        }
        if (isset($request['end_date']) && $request['end_date'] != null) {
            $query->whereHas('peminjaman', function ($q) use ($request) {
                $q->whereDate('tanggal_pinjam', '<=', $request['end_date']);
            });
        }

        // Urutkan berdasarkan tanggal pinjam terbaru (via parent)
        $query->select('detail_peminjaman.*')
            ->join('peminjaman', 'detail_peminjaman.peminjaman_id', '=', 'peminjaman.id')
            ->orderBy('peminjaman.tanggal_pinjam', 'desc');

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Peminjam',
            'NIP',
            'Jabatan',
            'Unit',
            'Keperluan',
            'Nama Arsip',
            'Hak Akses',
            'Jenis Arsip',
            'Otentikasi',
            'No. Box',
            'Status'
        ];
    }

    public function map($detail): array
    {
        $this->rowNumber++;
        $peminjaman = $detail->peminjaman;

        // Logika Nama Arsip: DB Relation > Snapshot
        // Note: Meskipun Detail ada 'nama_arsip', kita cek relasi dulu untuk konsistensi jika ada update master, 
        // TAPI karena request snapshot logic, kita pakai logic view:
        // View: $detail->arsip ? $detail->arsip->nama_berkas : $detail->nama_arsip
        $namaArsip = $detail->arsip ? $detail->arsip->nama_berkas : $detail->nama_arsip;

        // Logic No Box: View Logic
        $noBox = ($detail->arsip && $detail->arsip->no_box) ? $detail->arsip->no_box : ($detail->no_box ?? '-');

        // Logic Hak Akses: View Logic
        // View: $akses = $detail->arsip ? $detail->arsip->klasifikasi_keamanan : $detail->hak_akses;
        $hakAkses = $detail->arsip ? $detail->arsip->klasifikasi_keamanan : $detail->hak_akses;

        return [
            $this->rowNumber,
            $peminjaman ? Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : '-',
            $peminjaman->nama_peminjam ?? '-',
            $peminjaman->nip ?? '-',
            $peminjaman->jabatan_peminjam ?? '-',
            $peminjaman->unit_peminjam ?? '-',
            $peminjaman->keperluan ?? '-',
            $namaArsip,
            $hakAkses,
            $detail->jenis_arsip,
            $detail->detail_fisik ?? '-', // 'Otentikasi' mapped to Detail Fisik as per index.blade.php
            $noBox,
            $peminjaman->status ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold Header
        ];
    }
}