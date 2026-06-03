<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use App\Models\ObatKeluar;
use Illuminate\Http\Request;

use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari   = $request->dari;
        $sampai = $request->sampai;

        $queryMasuk = ObatMasuk::with('obat.kategori')
            ->when($dari, fn($q) => $q->whereDate('tanggal', '>=', $dari))
            ->when($sampai, fn($q) => $q->whereDate('tanggal', '<=', $sampai));

        $queryKeluar = ObatKeluar::with('obat.kategori')
            ->when($dari, fn($q) => $q->whereDate('tanggal', '>=', $dari))
            ->when($sampai, fn($q) => $q->whereDate('tanggal', '<=', $sampai));

        $masuk = $queryMasuk->get()->map(fn($item) => [
            'tanggal'       => $item->tanggal,
            'nama_obat'     => $item->obat->nama_obat ?? '-',
            'kategori'      => $item->obat->kategori->nama_kategori ?? '-',
            'tipe'          => 'masuk',
            'jumlah'        => $item->jumlah,
            'keterangan'    => $item->keterangan ?? '-',
        ]);

        $keluar = $queryKeluar->get()->map(fn($item) => [
            'tanggal'       => $item->tanggal,
            'nama_obat'     => $item->obat->nama_obat ?? '-',
            'kategori'      => $item->obat->kategori->nama_kategori ?? '-',
            'tipe'          => 'keluar',
            'jumlah'        => $item->jumlah,
            'keterangan'    => $item->keterangan ?? '-',
        ]);

        $laporan = $masuk->concat($keluar)
                         ->sortBy('tanggal')
                         ->values();

        $totalMasuk  = $masuk->sum('jumlah');
        $totalKeluar = $keluar->sum('jumlah');

        return view('laporan.index', compact(
            'laporan',
            'dari',
            'sampai',
            'totalMasuk',
            'totalKeluar'
        ));
    }

    private function getLaporanData($dari, $sampai)
    {
        $queryMasuk = ObatMasuk::with('obat.kategori')
            ->when($dari, fn($q) => $q->whereDate('tanggal', '>=', $dari))
            ->when($sampai, fn($q) => $q->whereDate('tanggal', '<=', $sampai));

        $queryKeluar = ObatKeluar::with('obat.kategori')
            ->when($dari, fn($q) => $q->whereDate('tanggal', '>=', $dari))
            ->when($sampai, fn($q) => $q->whereDate('tanggal', '<=', $sampai));

        $masuk = $queryMasuk->get()->map(fn($item) => [
            'tanggal'       => $item->tanggal,
            'nama_obat'     => $item->obat->nama_obat ?? '-',
            'kategori'      => $item->obat->kategori->nama_kategori ?? '-',
            'tipe'          => 'masuk',
            'jumlah'        => $item->jumlah,
            'keterangan'    => $item->keterangan ?? '-',
        ]);

        $keluar = $queryKeluar->get()->map(fn($item) => [
            'tanggal'       => $item->tanggal,
            'nama_obat'     => $item->obat->nama_obat ?? '-',
            'kategori'      => $item->obat->kategori->nama_kategori ?? '-',
            'tipe'          => 'keluar',
            'jumlah'        => $item->jumlah,
            'keterangan'    => $item->keterangan ?? '-',
        ]);

        return $masuk->concat($keluar)->sortBy('tanggal')->values();
    }

    public function exportExcel(Request $request)
    {
        $laporan = $this->getLaporanData($request->dari, $request->sampai);
        
        // Return unduhan file Excel
        return Excel::download(new LaporanExport($laporan->toArray()), 'Laporan_Transaksi_Obat.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $dari    = $request->dari;
        $sampai  = $request->sampai;
        $laporan = $this->getLaporanData($dari, $sampai);
        
        $totalMasuk  = $laporan->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = $laporan->where('tipe', 'keluar')->sum('jumlah');

        // Render data ke view PDF
        $pdf = Pdf::loadView('laporan.pdf', compact(
            'laporan', 'dari', 'sampai', 'totalMasuk', 'totalKeluar'
        ));

        // Return unduhan file PDF
        return $pdf->download('Laporan_Transaksi_Obat.pdf');
    }
}