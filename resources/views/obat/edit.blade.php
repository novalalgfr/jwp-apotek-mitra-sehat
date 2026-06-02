@extends('layouts.app')

@section('title', 'Edit Obat')
@section('header', 'Edit Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <form method="POST" action="{{ route('obat.update', $obat) }}" class="space-y-5">
        @csrf @method('PUT')

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Kategori <span class="text-[#B3412F]">*</span></label>
            <select name="kategori_id"
                    class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('kategori_id', $obat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Nama Obat <span class="text-[#B3412F]">*</span></label>
            <input type="text" name="nama_obat"
                   value="{{ old('nama_obat', $obat->nama_obat) }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
            @error('nama_obat')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Satuan <span class="text-[#B3412F]">*</span></label>
            <input type="text" name="satuan"
                   value="{{ old('satuan', $obat->satuan) }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
        </div>

        <div class="space-y-1.5 pb-2">
            <label class="block text-sm font-medium text-[#5C5954]">Stok <span class="text-[#B3412F]">*</span></label>
            <input type="number" name="stok" min="0"
                   value="{{ old('stok', $obat->stok) }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                Update Data
            </button>
            <a href="{{ route('obat.index') }}"
               class="bg-[#F3F2EE] hover:bg-[#EAE8E3] text-[#5C5954] text-sm font-medium px-6 py-2.5 rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection