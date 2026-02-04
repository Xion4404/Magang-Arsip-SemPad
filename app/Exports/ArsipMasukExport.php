<?php

namespace App\Exports;

use App\Models\ArsipMasuk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ArsipMasukExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithDrawings, WithCustomStartCell, WithEvents
{
    protected $ids;
    protected $search;
    protected $unit_asal;
    protected $year;
    protected $penerima;

    public function __construct($ids = null, $search = null, $unit_asal = null, $year = null, $penerima = null)
    {
        $this->ids = $ids;
        $this->search = $search;
        $this->unit_asal = $unit_asal;
        $this->year = $year;
        $this->penerima = $penerima;
    }

    public function query()
    {
        $query = ArsipMasuk::with('penerima');

        if (!empty($this->ids)) {
            $query->whereIn('id', $this->ids);
        } else {
            if ($this->search) {
                $search = $this->search;
                $query->where(function($q) use ($search) {
                    $q->where('unit_asal', 'like', "%{$search}%")
                      ->orWhere('nomor_berita_acara', 'like', "%{$search}%")
                      ->orWhereHas('penerima', function($userQuery) use ($search) {
                          $userQuery->where('nama', 'like', "%{$search}%");
                      });
                });
            }

            if ($this->unit_asal) {
                $query->where('unit_asal', $this->unit_asal);
            }

            if ($this->year) {
                $query->whereYear('tanggal_terima', $this->year);
            }

            if ($this->penerima) {
                $query->where('user_penerima', $this->penerima);
            }
        }

        $query->orderBy('id', 'desc');

        return $query;
    }

    public function headings(): array
    {
        return [
            'No Berita Acara',
            'Unit Asal',
            'Tanggal Terima',
            'Jumlah Box',
            'Penerima',
        ];
    }

    public function map($item): array
    {
        return [
            $item->nomor_berita_acara,
            $item->unit_asal,
            \Carbon\Carbon::parse($item->tanggal_terima)->format('d-m-Y'),
            $item->jumlah_box_masuk,
            $item->penerima->nama ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            5 => ['font' => ['bold' => true]], // Header row is now at row 5
        ];
    }

    public function startCell(): string
    {
        return 'A5'; // Start data at A5 to make room for header
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo PT Semen Padang');
        $drawing->setPath(public_path('images/logo-sp.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Merge cells for Title
                $sheet->mergeCells('B1:E1');
                $sheet->mergeCells('B2:E2');
                $sheet->mergeCells('B3:E3');

                // Set Title Text
                $sheet->setCellValue('B1', 'PT SEMEN PADANG');
                $sheet->setCellValue('B2', 'DAFTAR ARSIP MASUK');
                $sheet->setCellValue('B3', 'Indarung, Padang 25237, Sumatera Barat');

                // Style Title
                $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKRED));
                $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('B3')->getFont()->setSize(10);

                // Align Center
                $sheet->getStyle('B1:B3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Style Table Header (Row 5)
                $sheet->getStyle('A5:E5')->getFill()
                      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFFCE4E4'); // Light red
                
                $sheet->getStyle('A5:E5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
