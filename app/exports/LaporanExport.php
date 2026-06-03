<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $laporan;

    public function __construct(array $laporan)
    {
        $this->laporan = $laporan;
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->laporan as $index => $item) {
            $data[] = [
                $index + 1,
                \Carbon\Carbon::parse($item['tanggal'])->format('d M Y'),
                $item['nama_obat'],
                $item['kategori'],
                ucfirst($item['tipe']),
                $item['tipe'] === 'masuk' ? '+' . $item['jumlah'] : '-' . $item['jumlah'],
                $item['keterangan']
            ];
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Obat',
            'Kategori',
            'Tipe',
            'Jumlah',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]], // Bold baris pertama (header)
        ];
    }
}