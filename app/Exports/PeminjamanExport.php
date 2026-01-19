<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PeminjamanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Peminjaman::query()->with('arsip');
        
        // Kita ambil filter yang dikirim dari Controller
        $request = $this->filters; 

        // 1. FILTER SEARCH
        if (isset($request['search']) && $request['search'] != null) {
            $keyword = $request['search'];
            $query->where(function($q) use ($keyword) {
                $q->where('nama_peminjam', 'LIKE', "%$keyword%")
                  ->orWhere('nip', 'LIKE', "%$keyword%")
                  ->orWhere('unit_peminjam', 'LIKE', "%$keyword%")
                  ->orWhereHas('arsip', function($qArsip) use ($keyword) {
                      $qArsip->where('nama_berkas', 'LIKE', "%$keyword%")
                             ->orWhere('no_berkas', 'LIKE', "%$keyword%");
                  });
            });
        }

        // 2. FILTER STATUS
        if (isset($request['status']) && $request['status'] != 'All') {
            if ($request['status'] == 'Sudah Dikembalikan' || $request['status'] == 'Telah Dikembalikan') {
                $query->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
            } else {
                $query->where('status', $request['status']);
            }
        }

        // 3. FILTER MEDIA (Softfile / Hardfile)
        if (isset($request['media']) && $request['media'] != 'All') {
            $query->where('jenis_dokumen', 'LIKE', '%' . $request['media'] . '%');
        }

        // 4. FILTER KEAMANAN (PENTING: Ini yang bikin filter keamanan jalan di Excel)
        if (isset($request['keamanan']) && $request['keamanan'] != 'All') {
            $keamanan = $request['keamanan'];
            $query->whereHas('arsip', function($q) use ($keamanan) {
                $q->where('klasifikasi_keamanan', $keamanan);
            });
        }

        // 5. FILTER TANGGAL
        if (isset($request['start_date']) && $request['start_date'] != null) {
            $query->whereDate('tanggal_pinjam', '>=', $request['start_date']);
        }
        if (isset($request['end_date']) && $request['end_date'] != null) {
            $query->whereDate('tanggal_pinjam', '<=', $request['end_date']);
        }

        return $query->orderBy('id', 'desc');
    }

    public function headings(): array
    {
        return [
            'Tanggal Pinjam',
            'Nama Peminjam',
            'NIP',
            'Jabatan',
            'Unit',
            'Nama Arsip',
            'Keamanan',
            'Media',
            'Ket. Fisik',
            'Status'
        ];
    }

    public function map($peminjaman): array
    {
        // Pecah string "Hardfile - Berkas Asli"
        $fullString = $peminjaman->jenis_dokumen;
        $media = Str::before($fullString, ' - ');
        $ketFisik = Str::contains($fullString, ' - ') ? Str::after($fullString, ' - ') : '-';

        return [
            Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y'),
            $peminjaman->nama_peminjam,
            $peminjaman->nip,
            $peminjaman->jabatan_peminjam,
            $peminjaman->unit_peminjam,
            $peminjaman->arsip ? $peminjaman->arsip->nama_berkas : 'Arsip Terhapus',
            $peminjaman->arsip ? ($peminjaman->arsip->klasifikasi_keamanan ?? 'Biasa') : '-',
            $media,
            $ketFisik,
            $peminjaman->status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold Header
        ];
    }
}