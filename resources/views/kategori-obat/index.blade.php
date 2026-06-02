@extends('layouts.app')

@section('title', 'Kategori Obat')
@section('header', 'Kategori Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8">

    <div class="flex justify-between items-center mb-8">
        <p class="text-sm text-[#73706A]">Kelola data kategori klasifikasi obat.</p>
        <a href="{{ route('kategori-obat.create') }}"
           class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors shadow-sm">
            Tambah Kategori
        </a>
    </div>

    @if($kategoris->isEmpty())
        <div class="text-center py-12 border border-[#E6E4DD] rounded-xl bg-[#FAF9F6]/50">
            <p class="text-sm text-[#73706A]">Belum ada data kategori obat.</p>
        </div>
    @else
        <div class="border border-[#E6E4DD] rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#FAF9F6] border-b border-[#E6E4DD]">
                        <tr>
                            <th class="px-5 py-4 font-medium text-[#73706A] w-10">No</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Nama Kategori</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Deskripsi</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Jumlah Obat</th>
                            <th class="px-5 py-4 font-medium text-[#73706A] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6E4DD]">
                        @foreach($kategoris as $i => $kategori)
                        <tr class="hover:bg-[#FAF9F6]/50 transition-colors bg-white">
                            <td class="px-5 py-4 text-[#73706A]">{{ $i + 1 }}</td>
                            <td class="px-5 py-4 font-medium text-[#2D2A26]">{{ $kategori->nama_kategori }}</td>
                            <td class="px-5 py-4 text-[#73706A]">{{ $kategori->deskripsi ?? '-' }}</td>
                            <td class="px-5 py-4 text-[#5C5954]">{{ $kategori->obat_count }}</td>
                            <td class="px-5 py-4 flex justify-end gap-4">
                                <a href="{{ route('kategori-obat.show', $kategori) }}"
                                   class="text-sm font-medium text-[#73706A] hover:text-[#2D2A26] transition-colors">
                                    Detail
                                </a>
                                <a href="{{ route('kategori-obat.edit', $kategori) }}"
                                   class="text-sm font-medium text-[#73706A] hover:text-[#D97757] transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('kategori-obat.destroy', $kategori) }}"
                                      onsubmit="return confirm('Yakin menghapus kategori ini?')" class="inline">
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