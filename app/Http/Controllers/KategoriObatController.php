<?php

namespace App\Http\Controllers;

use App\Models\KategoriObat;
use Illuminate\Http\Request;

class KategoriObatController extends Controller
{
    public function index()
    {
        $kategoris = KategoriObat::withCount('obat')->latest()->get();
        return view('kategori-obat.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori-obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_obat,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        KategoriObat::create($request->only('nama_kategori', 'deskripsi'));

        return redirect()->route('kategori-obat.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(KategoriObat $kategoriObat)
    {
        $kategoriObat->loadCount('obat');
        return view('kategori-obat.show', compact('kategoriObat'));
    }

    public function edit(KategoriObat $kategoriObat)
    {
        return view('kategori-obat.edit', compact('kategoriObat'));
    }

    public function update(Request $request, KategoriObat $kategoriObat)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_obat,nama_kategori,' . $kategoriObat->id,
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        $kategoriObat->update($request->only('nama_kategori', 'deskripsi'));

        return redirect()->route('kategori-obat.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriObat $kategoriObat)
    {
        // Cek apakah masih ada obat di kategori ini
        if ($kategoriObat->obat()->count() > 0) {
            return redirect()->route('kategori-obat.index')
                             ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki obat.');
        }

        $kategoriObat->delete();

        return redirect()->route('kategori-obat.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}