@extends('layouts.app')

@section('title', 'Detail Obat Keluar')
@section('header', 'Informasi Transaksi')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <div class="space-y-6 mb-8">
        
        <div class="border-b border-[#E6E4DD]/60 pb-5">
            <p class="text-sm font-medium text-[#8F8C87] mb-1">Nama Obat</p>
            <p class="text-lg font-serif text-[#2D2A26]">{{ $obatKeluar->obat->nama_obat ?? '-' }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-6 border-b border-[#E6E4DD]/60 pb-5">
            <div>
                <p class="text-sm font-medium text-[#8F8C87] mb-1">Kategori</p>
                <p class="text-[15px] text-[#2D2A26]">{{ $obatKeluar->obat->kategori->nama_kategori ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-[#8F8C87] mb-1">Tanggal Keluar</p>
                <p class="text-[15px] text-[#2D2A26]">{{ \Carbon\Carbon::parse($obatKeluar->tanggal)->locale('id')->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div class="border-b border-[#E6E4DD]/60 pb-5">
            <p class="text-sm font-medium text-[#8F8C87] mb-1">Kuantitas Keluar</p>
            <p class="text-[15px] font-medium text-[#B3412F] bg-[#FDF6F5] inline-flex px-3 py-1 rounded-lg">
                -{{ $obatKeluar->jumlah }} Unit
            </p>
        </div>
        
        <div>
            <p class="text-sm font-medium text-[#8F8C87] mb-1">Keterangan Catatan</p>
            <p class="text-[15px] text-[#5C5954] leading-relaxed">
                {{ $obatKeluar->keterangan ?: 'Tidak ada catatan yang dilampirkan pada transaksi ini.' }}
            </p>
        </div>

    </div>

    <div class="pt-2">
        <a href="{{ route('obat-keluar.index') }}"
           class="inline-flex items-center text-sm font-medium text-[#73706A] hover:text-[#2D2A26] transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

</div>
@endsection