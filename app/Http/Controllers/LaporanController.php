<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use App\Models\ObatKeluar;
use Illuminate\Http\Request;

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

    public function exportExcel(Request $request)
    {
        $dari   = $request->dari;
        $sampai = $request->sampai;

        return back()->with('success', 'Fungsi Export Excel belum diimplementasikan.');
    }

    public function exportPdf(Request $request)
    {
        $dari   = $request->dari;
        $sampai = $request->sampai;

        return back()->with('success', 'Fungsi Export PDF belum diimplementasikan.');
    }
}