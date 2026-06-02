@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <form method="POST" action="{{ route('kategori-obat.store') }}" class="space-y-5">
        @csrf

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Nama Kategori <span class="text-[#B3412F]">*</span></label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all"
                   placeholder="Contoh: Antibiotik">
            @error('nama_kategori')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5 pb-2">
            <label class="block text-sm font-medium text-[#5C5954]">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all placeholder:text-[#A8A5A0]"
                      placeholder="Deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                Simpan
            </button>
            <a href="{{ route('kategori-obat.index') }}"
               class="bg-[#F3F2EE] hover:bg-[#EAE8E3] text-[#5C5954] text-sm font-medium px-6 py-2.5 rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection