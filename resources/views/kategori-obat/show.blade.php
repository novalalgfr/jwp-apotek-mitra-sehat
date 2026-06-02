@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('header', 'Detail Kategori')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <div class="space-y-6 mb-8">
        
        <div class="border-b border-[#E6E4DD]/60 pb-5">
            <p class="text-sm font-medium text-[#8F8C87] mb-1">Nama Kategori</p>
            <p class="text-xl font-serif text-[#2D2A26]">{{ $kategoriObat->nama_kategori }}</p>
        </div>
        
        <div class="border-b border-[#E6E4DD]/60 pb-5">
            <p class="text-sm font-medium text-[#8F8C87] mb-1">Jumlah Obat Tersedia</p>
            <p class="text-[15px] font-medium text-[#2E5C3A] bg-[#F0F5F1] inline-flex px-3 py-1 rounded-lg">
                {{ $kategoriObat->obat_count }} Item
            </p>
        </div>

        <div>
            <p class="text-sm font-medium text-[#8F8C87] mb-1">Deskripsi Kategori</p>
            <p class="text-[15px] text-[#5C5954] leading-relaxed">
                {{ $kategoriObat->deskripsi ?: 'Tidak ada deskripsi yang dilampirkan pada kategori ini.' }}
            </p>
        </div>

    </div>

    <div class="pt-2">
        <a href="{{ route('kategori-obat.index') }}"
           class="inline-flex items-center text-sm font-medium text-[#73706A] hover:text-[#2D2A26] transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

</div>
@endsection