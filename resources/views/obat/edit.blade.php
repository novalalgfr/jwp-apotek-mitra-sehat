@extends('layouts.app')

@section('title', 'Edit Obat')
@section('header', 'Edit Obat')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <form method="POST" action="{{ route('obat.update', $obat) }}" class="space-y-5" enctype="multipart/form-data">
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
            @error('satuan')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Foto Obat <span class="text-[#8F8C87] font-normal">(Opsional)</span></label>
            
            @if(isset($obat) && $obat->gambar)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $obat->gambar) }}" alt="Preview" class="w-20 h-20 rounded-xl object-cover border border-[#E6E4DD]">
                </div>
            @endif

            <input type="file" name="gambar" accept="image/*"
                   class="w-full text-sm text-[#5C5954] file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-[#F3F2EE] file:text-[#2D2A26] hover:file:bg-[#EAE8E3] transition-all cursor-pointer bg-white border border-[#E6E4DD] rounded-xl focus:outline-none">
            <p class="text-[11px] text-[#8F8C87] mt-1">Format: JPG, PNG, WEBP. Maks 2MB. Biarkan kosong jika tidak ingin mengubah foto.</p>
            
            @error('gambar')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5 pb-2">
            <label class="block text-sm font-medium text-[#5C5954]">Stok <span class="text-[#B3412F]">*</span></label>
            <input type="number" name="stok" min="0"
                   value="{{ old('stok', $obat->stok) }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
            @error('stok')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
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