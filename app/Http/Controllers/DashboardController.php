<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatMasuk;
use App\Models\ObatKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        $totalObat = Obat::count();
        $totalMasuk = ObatMasuk::sum('jumlah');
        $totalKeluar = ObatKeluar::sum('jumlah');
        $stokTertinggi = Obat::orderBy('stok', 'desc')->first();
        $stokRendah = Obat::where('stok', '<', 10)->orderBy('stok', 'asc')->get();
        $stokHabis = Obat::where('stok', 0)->count();

        $recentMasuk = ObatMasuk::with('obat')->latest()->take(5)->get()->map(function($q) {
            return (object) [
                'tanggal' => $q->tanggal,
                'nama_obat' => $q->obat->nama_obat ?? '-',
                'jumlah' => $q->jumlah,
                'tipe' => 'masuk',
                'created_at' => $q->created_at
            ];
        });
        
        $recentKeluar = ObatKeluar::with('obat')->latest()->take(5)->get()->map(function($q) {
            return (object) [
                'tanggal' => $q->tanggal,
                'nama_obat' => $q->obat->nama_obat ?? '-',
                'jumlah' => $q->jumlah,
                'tipe' => 'keluar',
                'created_at' => $q->created_at
            ];
        });

        $aktivitasTerbaru = $recentMasuk->concat($recentKeluar)->sortByDesc('created_at')->take(5);

        return view('dashboard', compact(
            'totalObat',
            'totalMasuk',
            'totalKeluar',
            'stokTertinggi',
            'stokRendah',
            'stokHabis',
            'aktivitasTerbaru'
        ));
    }
}