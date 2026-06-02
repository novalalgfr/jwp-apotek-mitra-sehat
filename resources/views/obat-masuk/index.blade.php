@extends('layouts.app')

@section('title', 'Obat Masuk')
@section('header', 'Obat Masuk')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8">

    <div class="flex justify-between items-center mb-8">
        <p class="text-sm text-[#73706A]">Catat dan pantau transaksi persediaan obat masuk.</p>
        <a href="{{ route('obat-masuk.create') }}"
           class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors shadow-sm">
            Tambah Data
        </a>
    </div>

    @if($obatMasuks->isEmpty())
        <div class="text-center py-12 border border-[#E6E4DD] rounded-xl bg-[#FAF9F6]/50">
            <p class="text-sm text-[#73706A]">Belum ada riwayat transaksi obat masuk.</p>
        </div>
    @else
        <div class="border border-[#E6E4DD] rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#FAF9F6] border-b border-[#E6E4DD]">
                        <tr>
                            <th class="px-5 py-4 font-medium text-[#73706A] w-10">No</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Tanggal</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Nama Obat</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Kategori</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Masuk</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Keterangan</th>
                            <th class="px-5 py-4 font-medium text-[#73706A] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6E4DD]">
                        @foreach($obatMasuks as $i => $item)
                        <tr class="hover:bg-[#FAF9F6]/50 transition-colors bg-white">
                            <td class="px-5 py-4 text-[#73706A]">{{ $i + 1 }}</td>
                            <td class="px-5 py-4 text-[#5C5954]">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                            <td class="px-5 py-4 font-medium text-[#2D2A26]">{{ $item->obat->nama_obat ?? '-' }}</td>
                            <td class="px-5 py-4 text-[#73706A]">{{ $item->obat->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-5 py-4 font-medium text-[#2E5C3A]">+{{ $item->jumlah }}</td>
                            <td class="px-5 py-4 text-[#73706A]">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-5 py-4 flex justify-end gap-4">
                                <a href="{{ route('obat-masuk.show', $item) }}"
                                   class="text-sm font-medium text-[#73706A] hover:text-[#2D2A26] transition-colors">
                                    Detail
                                </a>
                                <a href="{{ route('obat-masuk.edit', $item) }}"
                                   class="text-sm font-medium text-[#73706A] hover:text-[#D97757] transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('obat-masuk.destroy', $item) }}"
                                      onsubmit="return confirm('Yakin menghapus data ini? Stok akan dikalkulasi ulang.')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-[#73706A] hover:text-[#B3412F] transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection