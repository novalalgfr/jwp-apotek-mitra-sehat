<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatKeluar;
use Illuminate\Http\Request;

class ObatKeluarController extends Controller
{
    public function index()
    {
        $obatKeluars = ObatKeluar::with('obat.kategori')->latest()->get();
        return view('obat-keluar.index', compact('obatKeluars'));
    }

    public function create()
    {
        $obats = Obat::where('stok', '>', 0)->orderBy('nama_obat')->get();
        return view('obat-keluar.create', compact('obats'));
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
            'tanggal.required' => 'Tanggal wajib diisi.',
            'jumlah.min'       => 'Jumlah minimal 1.',
        ]);

        $obat = Obat::find($request->obat_id);

        if ($request->jumlah > $obat->stok) {
            return back()->withInput()->withErrors([
                'jumlah' => 'Jumlah keluar (' . $request->jumlah . ') melebihi stok tersedia (' . $obat->stok . ').',
            ]);
        }

        ObatKeluar::create($request->only('obat_id', 'tanggal', 'jumlah', 'keterangan'));

        $obat->stok -= $request->jumlah;
        $obat->status = $obat->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obat->save();

        $pesan = 'Obat keluar berhasil dicatat.';
        if ($obat->stok == 0) {
            $pesan .= ' ⚠️ Stok ' . $obat->nama_obat . ' sekarang habis!';
            return redirect()->route('obat-keluar.index')->with('warning', $pesan);
        } elseif ($obat->stok < 10) {
            $pesan .= ' ⚠️ Stok ' . $obat->nama_obat . ' tinggal ' . $obat->stok . '.';
            return redirect()->route('obat-keluar.index')->with('warning', $pesan);
        }

        return redirect()->route('obat-keluar.index')->with('success', $pesan);
    }

    public function show(ObatKeluar $obatKeluar)
    {
        $obatKeluar->load('obat.kategori');
        return view('obat-keluar.show', compact('obatKeluar'));
    }

    public function edit(ObatKeluar $obatKeluar)
    {
        $obats = Obat::orderBy('nama_obat')->get();
        return view('obat-keluar.edit', compact('obatKeluar', 'obats'));
    }

    public function update(Request $request, ObatKeluar $obatKeluar)
    {
        $request->validate([
            'obat_id'    => 'required|exists:obat,id',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $obatLama = Obat::find($obatKeluar->obat_id);
        $obatLama->stok += $obatKeluar->jumlah;
        $obatLama->status = $obatLama->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obatLama->save();

        $obatBaru = Obat::find($request->obat_id);
        if ($request->jumlah > $obatBaru->stok) {
            $obatLama->stok -= $obatKeluar->jumlah;
            $obatLama->status = $obatLama->stok > 0 ? 'tersedia' : 'tidak tersedia';
            $obatLama->save();

            return back()->withInput()->withErrors([
                'jumlah' => 'Jumlah keluar melebihi stok tersedia (' . $obatBaru->stok . ').',
            ]);
        }

        $obatKeluar->update($request->only('obat_id', 'tanggal', 'jumlah', 'keterangan'));

        $obatBaru->stok -= $request->jumlah;
        $obatBaru->status = $obatBaru->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obatBaru->save();

        return redirect()->route('obat-keluar.index')
                         ->with('success', 'Data obat keluar berhasil diperbarui.');
    }

    public function destroy(ObatKeluar $obatKeluar)
    {
        $obat = Obat::find($obatKeluar->obat_id);
        $obat->stok += $obatKeluar->jumlah;
        $obat->status = $obat->stok > 0 ? 'tersedia' : 'tidak tersedia';
        $obat->save();

        $obatKeluar->delete();

        return redirect()->route('obat-keluar.index')
                         ->with('success', 'Data obat keluar berhasil dihapus.');
    }
}