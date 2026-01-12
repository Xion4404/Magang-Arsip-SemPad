<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Peminjaman::with('arsip');
        $request = $this->request;

        // Filter Search
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

        // Filter Status
        if (isset($request['status']) && $request['status'] != 'All') {
            if ($request['status'] == 'Sudah Dikembalikan') {
                $query->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
            } else {
                $query->where('status', $request['status']);
            }
        }

        // Filter Jenis Dokumen
        if (isset($request['jenis_dokumen']) && $request['jenis_dokumen'] != 'All') {
            $query->where('jenis_dokumen', $request['jenis_dokumen']);
        }

        // Filter Tanggal
        if (isset($request['start_date'])) {
            $query->whereDate('tanggal_pinjam', '>=', $request['start_date']);
        }
        if (isset($request['end_date'])) {
            $query->whereDate('tanggal_pinjam', '<=', $request['end_date']);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    // 2. JUDUL KOLOM (HEADER) - No Berkas sudah dihapus
    public function headings(): array
    {
        return [
            'Tanggal Pinjam',
            'Nama Peminjam',
            'NIP',
            'Unit',
            'Nama Arsip',
            // 'No Berkas', <-- INI SUDAH DIHAPUS
            'Jenis Dokumen',
            'Status',
        ];
    }

    // 3. ISI DATA PER BARIS - No Berkas sudah dihapus
    public function map($peminjaman): array
    {
        return [
            $peminjaman->tanggal_pinjam,
            $peminjaman->nama_peminjam,
            "'" . $peminjaman->nip,
            $peminjaman->unit_peminjam,
            $peminjaman->arsip->nama_berkas ?? 'Terhapus',
            // $peminjaman->arsip->no_berkas ?? '-', <-- INI JUGA SUDAH DIHAPUS
            $peminjaman->jenis_dokumen,
            $peminjaman->status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}