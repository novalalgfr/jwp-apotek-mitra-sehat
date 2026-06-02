@extends('layouts.app')

@section('title', 'Detail Obat')
@section('header', 'Detail Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <div class="space-y-6 mb-8">
        
        <div class="border-b border-[#E6E4DD]/60 pb-5">
            <p class="text-sm font-medium text-[#8F8C87] mb-1">Nama Obat</p>
            <p class="text-xl font-serif text-[#2D2A26]">{{ $obat->nama_obat }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-6 border-b border-[#E6E4DD]/60 pb-5">
            <div>
                <p class="text-sm font-medium text-[#8F8C87] mb-1">Kategori</p>
                <p class="text-[15px] text-[#2D2A26]">{{ $obat->kategori->nama_kategori ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-[#8F8C87] mb-1">Satuan</p>
                <p class="text-[15px] text-[#2D2A26]">{{ $obat->satuan }}</p>
            </div>
        </div>

        <div class="border-b border-[#E6E4DD]/60 pb-5">
            <p class="text-sm font-medium text-[#8F8C87] mb-2">Informasi Stok</p>
            <div class="flex items-center gap-3">
                <span class="text-[15px] font-medium text-[#2D2A26] bg-[#F3F2EE] px-3 py-1 rounded-lg">
                    {{ $obat->stok }} Unit
                </span>
                @if($obat->stok == 0)
                    <span class="text-xs font-medium text-[#B3412F]">Stok habis!</span>
                @elseif($obat->stok < 10)
                    <span class="text-xs font-medium text-[#D97757]">Stok menipis</span>
                @endif
            </div>
        </div>
        
        <div>
            <p class="text-sm font-medium text-[#8F8C87] mb-2">Status Ketersediaan</p>
            @if($obat->status === 'tersedia')
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#F0F5F1] text-[#2E5C3A]">
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#FDF6F5] text-[#B3412F]">
                    Tidak Tersedia
                </span>
            @endif
        </div>

    </div>

    <div class="pt-2">
        <a href="{{ route('obat.index') }}"
           class="inline-flex items-center text-sm font-medium text-[#73706A] hover:text-[#2D2A26] transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

</div>
@endsection