@extends('layouts.app')

@section('title', 'Daftar Obat')
@section('header', 'Daftar Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8">

    <div class="flex justify-between items-center mb-8">
        <p class="text-sm text-[#73706A]">Kelola data obat dan ketersediaan stok persediaan.</p>
        <a href="{{ route('obat.create') }}"
           class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors shadow-sm">
            Tambah Data
        </a>
    </div>

    @if($obats->isEmpty())
        <div class="text-center py-12 border border-[#E6E4DD] rounded-xl bg-[#FAF9F6]/50">
            <p class="text-sm text-[#73706A]">Belum ada data obat yang terdaftar.</p>
        </div>
    @else
        <div class="border border-[#E6E4DD] rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#FAF9F6] border-b border-[#E6E4DD]">
                        <tr>
                            <th class="px-5 py-4 font-medium text-[#73706A] w-10">No</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Nama Obat</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Kategori</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Satuan</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Stok</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Status</th>
                            <th class="px-5 py-4 font-medium text-[#73706A] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6E4DD]">
                        @foreach($obats as $i => $obat)
                        <tr class="hover:bg-[#FAF9F6]/50 transition-colors bg-white">
                            <td class="px-5 py-4 text-[#73706A]">{{ $i + 1 }}</td>
                            <td class="px-5 py-4 font-medium text-[#2D2A26]">{{ $obat->nama_obat }}</td>
                            <td class="px-5 py-4 text-[#73706A]">{{ $obat->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-5 py-4 text-[#5C5954]">{{ $obat->satuan }}</td>
                            <td class="px-5 py-4">
                                <span class="{{ $obat->stok == 0 ? 'text-[#B3412F] font-medium' : ($obat->stok < 10 ? 'text-[#D97757] font-medium' : 'text-[#2D2A26]') }}">
                                    {{ $obat->stok }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($obat->status === 'tersedia')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#F0F5F1] text-[#2E5C3A]">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#FDF6F5] text-[#B3412F]">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 flex justify-end gap-4">
                                <a href="{{ route('obat.show', $obat) }}"
                                   class="text-sm font-medium text-[#73706A] hover:text-[#2D2A26] transition-colors">
                                    Detail
                                </a>
                                <a href="{{ route('obat.edit', $obat) }}"
                                   class="text-sm font-medium text-[#73706A] hover:text-[#D97757] transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('obat.destroy', $obat) }}"
                                      onsubmit="return confirm('Yakin menghapus obat ini?')" class="inline">
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