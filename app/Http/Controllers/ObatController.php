<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\KategoriObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_obat'   => 'required|string|max:150',
            'satuan'      => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('obat_images', 'public');
        }

        Obat::create([
            'kategori_id' => $request->kategori_id,
            'gambar'      => $gambarPath,
            'nama_obat'   => $request->nama_obat,
            'satuan'      => $request->satuan,
            'stok'        => $request->stok,
            'status'      => $request->stok > 0 ? 'tersedia' : 'tidak tersedia',
        ]);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
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
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_obat'   => 'required|string|max:150',
            'satuan'      => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
        ]);

        $data = [
            'kategori_id' => $request->kategori_id,
            'nama_obat'   => $request->nama_obat,
            'satuan'      => $request->satuan,
            'stok'        => $request->stok,
            'status'      => $request->stok > 0 ? 'tersedia' : 'tidak tersedia',
        ];

        if ($request->hasFile('gambar')) {
            if ($obat->gambar) {
                Storage::disk('public')->delete($obat->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('obat_images', 'public');
        }

        $obat->update($data);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        if ($obat->obatMasuk()->count() > 0 || $obat->obatKeluar()->count() > 0) {
            return redirect()->route('obat.index')->with('error', 'Obat tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        if ($obat->gambar) {
            Storage::disk('public')->delete($obat->gambar);
        }

        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}