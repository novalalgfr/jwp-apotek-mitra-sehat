<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\KategoriObat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::with('kategori')->latest()->get();
        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        $kategoris = KategoriObat::orderBy('nama_kategori')->get();
        return view('obat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_obat,id',
            'nama_obat'   => 'required|string|max:150',
            'satuan'      => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'nama_obat.required'   => 'Nama obat wajib diisi.',
            'satuan.required'      => 'Satuan wajib diisi.',
            'stok.min'             => 'Stok tidak boleh negatif.',
        ]);

        $status = $request->stok > 0 ? 'tersedia' : 'tidak tersedia';

        Obat::create([
            'kategori_id' => $request->kategori_id,
            'nama_obat'   => $request->nama_obat,
            'satuan'      => $request->satuan,
            'stok'        => $request->stok,
            'status'      => $status,
        ]);

        return redirect()->route('obat.index')
                         ->with('success', 'Obat berhasil ditambahkan.');
    }

    public function show(Obat $obat)
    {
        $obat->load('kategori');
        return view('obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        $kategoris = KategoriObat::orderBy('nama_kategori')->get();
        return view('obat.edit', compact('obat', 'kategoris'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_obat,id',
            'nama_obat'   => 'required|string|max:150',
            'satuan'      => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'stok.min'             => 'Stok tidak boleh negatif.',
        ]);

        $status = $request->stok > 0 ? 'tersedia' : 'tidak tersedia';

        $obat->update([
            'kategori_id' => $request->kategori_id,
            'nama_obat'   => $request->nama_obat,
            'satuan'      => $request->satuan,
            'stok'        => $request->stok,
            'status'      => $status,
        ]);

        return redirect()->route('obat.index')
                         ->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        // Cek apakah ada transaksi terkait
        if ($obat->obatMasuk()->count() > 0 || $obat->obatKeluar()->count() > 0) {
            return redirect()->route('obat.index')
                             ->with('error', 'Obat tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        $obat->delete();

        return redirect()->route('obat.index')
                         ->with('success', 'Obat berhasil dihapus.');
    }
}