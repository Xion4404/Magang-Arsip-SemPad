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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PeminjamanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting, WithDrawings
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
            ->orderBy('peminjaman.created_at', 'desc');

        return $query;
    }

    public function headings(): array
    {
        return [
            ['PT SEMEN PADANG'],
            ['DAFTAR ARSIP DOKUMEN'],
            ['Indarung, Padang 25237, Sumatera Barat'],
            [''], // Baris Kosong
            [
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
                'Otentikasi', // Mapped to Detail Fisik
                'No. Box',
                'Status'
            ]
        ];
    }

    public function map($detail): array
    {
        $this->rowNumber++;
        $peminjaman = $detail->peminjaman;

        // Logika Nama Arsip: DB Relation > Snapshot (View Logic)
        $namaArsip = $detail->arsip ? $detail->arsip->nama_berkas : $detail->nama_arsip;

        // Logic No Box: View Logic
        $noBox = ($detail->arsip && $detail->arsip->no_box) ? $detail->arsip->no_box : ($detail->no_box ?? '-');

        // Logic Hak Akses: Snapshot Priority (NEW FIX)
        // Prioritize updated snapshot (hak_akses column on detail table)
        $hakAkses = $detail->hak_akses;
        if (empty($hakAkses) && $detail->arsip && $detail->arsip->klasifikasi) {
            $hakAkses = $detail->arsip->klasifikasi->hak_akses;
        }

        return [
            $this->rowNumber,
            $peminjaman ? Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : '-',
            $peminjaman->nama_peminjam ?? '-',
            $peminjaman->nip ? " " . $peminjaman->nip : '-', // ADD SPACE TO FORCE TEXT
            $peminjaman->jabatan_peminjam ?? '-',
            $peminjaman->unit_peminjam ?? '-',
            $peminjaman->keperluan ?? '-',
            $namaArsip,
            $hakAkses ?? '-',
            $detail->jenis_arsip,
            $detail->detail_fisik ?? '-',
            $noBox,
            $peminjaman->status ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Merge Header Rows (A1:M1, A2:M2, A3:M3)
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');

        // 2. Style: PT SEMEN PADANG (Red, Bold, Center, 14pt)
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'], // Red
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 3. Style: DAFTAR ARSIP DOKUMEN (Black, Bold, Center, 12pt)
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 4. Style: Address (Black, Regular, Center, 10pt)
        $sheet->getStyle('A3')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 5. Style: Table Headers (Row 5 - Bold, Border, Light Red Background)
        $sheet->getStyle('A5:M5')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFCCCC'], // Light Red
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // 6. Style: Data Rows (Border for all cells starting from A6)
        $highestRow = $sheet->getHighestRow();
        if ($highestRow >= 6) {
            $sheet->getStyle('A6:M' . $highestRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Center alignment for specific columns (No, NIP, Jabatan, Unit, Akses, Jenis, Otentikasi, Box, Status)
            // Columns: A, D, E, F, I, J, K, L, M
            $sheet->getStyle('A6:A' . $highestRow)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('B6:B' . $highestRow)->getAlignment()->setHorizontal('center'); // Tanggal
            $sheet->getStyle('D6:F' . $highestRow)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('I6:M' . $highestRow)->getAlignment()->setHorizontal('center');
        }

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT, // NIP (D)
            'L' => NumberFormat::FORMAT_TEXT, // No. Box (L)
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo PT Semen Padang');
        $drawing->setPath(public_path('images/logo-sp.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);
        return [$drawing];
    }
}