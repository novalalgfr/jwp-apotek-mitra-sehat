<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatMasuk;
use Illuminate\Http\Request;

class ObatMasukController extends Controller
{
    public function index()
    {
        $obatMasuks = ObatMasuk::with('obat.kategori')->latest()->get();
        return view('obat-masuk.index', compact('obatMasuks'));
    }

    public function create()
    {
        $obats = Obat::orderBy('nama_obat')->get();
        return view('obat-masuk.create', compact('obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_id'    => 'required|exists:obat,id',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ], [
            'obat_id.required' => 'Obat wajib dipilih.',
            'obat_id.exists'   => 'Obat tidak valid.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'jumlah.required'  => 'Jumlah wajib diisi.',
            'jumlah.min'       => 'Jumlah minimal 1.',
        ]);

        ObatMasuk::create($request->only('obat_id', 'tanggal', 'jumlah', 'keterangan'));

        $obat = Obat::find($request->obat_id);
        $obat->stok += $request->jumlah;
        $obat->status = $obat->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obat->save();

        return redirect()->route('obat-masuk.index')
                         ->with('success', 'Obat masuk berhasil dicatat. Stok ' . $obat->nama_obat . ' bertambah ' . $request->jumlah . '.');
    }

    public function show(ObatMasuk $obatMasuk)
    {
        $obatMasuk->load('obat.kategori');
        return view('obat-masuk.show', compact('obatMasuk'));
    }

    public function edit(ObatMasuk $obatMasuk)
    {
        $obats = Obat::orderBy('nama_obat')->get();
        return view('obat-masuk.edit', compact('obatMasuk', 'obats'));
    }

    public function update(Request $request, ObatMasuk $obatMasuk)
    {
        $request->validate([
            'obat_id'    => 'required|exists:obat,id',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ], [
            'jumlah.min' => 'Jumlah minimal 1.',
        ]);

        $obatLama = Obat::find($obatMasuk->obat_id);
        $obatLama->stok -= $obatMasuk->jumlah;
        $obatLama->status = $obatLama->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obatLama->save();

        $obatMasuk->update($request->only('obat_id', 'tanggal', 'jumlah', 'keterangan'));

        $obatBaru = Obat::find($request->obat_id);
        $obatBaru->stok += $request->jumlah;
        $obatBaru->status = $obatBaru->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obatBaru->save();

        return redirect()->route('obat-masuk.index')
                         ->with('success', 'Data obat masuk berhasil diperbarui.');
    }

    public function destroy(ObatMasuk $obatMasuk)
    {
        $obat = Obat::find($obatMasuk->obat_id);
        $obat->stok -= $obatMasuk->jumlah;

        if ($obat->stok < 0) $obat->stok = 0;

        $obat->status = $obat->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obat->save();

        $obatMasuk->delete();

        return redirect()->route('obat-masuk.index')
                         ->with('success', 'Data obat masuk berhasil dihapus.');
    }
}