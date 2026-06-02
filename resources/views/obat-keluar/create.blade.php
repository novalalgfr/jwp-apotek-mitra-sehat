@extends('layouts.app')

@section('title', 'Tambah Obat Keluar')
@section('header', 'Tambah Obat Keluar')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    @if(session('obats_empty'))
        <div class="bg-[#FDF6F5] border border-[#F3E1DE] px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
            <span class="text-[#B3412F] mt-0.5">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </span>
            <span class="font-medium text-sm text-[#B3412F]">
                Semua obat stoknya habis. Lakukan restock terlebih dahulu.
            </span>
        </div>
    @endif

    <form method="POST" action="{{ route('obat-keluar.store') }}" class="space-y-5">
        @csrf

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Obat <span class="text-[#B3412F]">*</span></label>
            <select name="obat_id"
                    class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
                <option value="">-- Pilih Obat --</option>
                @foreach($obats as $obat)
                    <option value="{{ $obat->id }}" {{ old('obat_id') == $obat->id ? 'selected' : '' }}>
                        {{ $obat->nama_obat }} (Stok: {{ $obat->stok }} {{ $obat->satuan }})
                    </option>
                @endforeach
            </select>
            @error('obat_id')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Tanggal <span class="text-[#B3412F]">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
            @error('tanggal')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Jumlah <span class="text-[#B3412F]">*</span></label>
            <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
            @error('jumlah')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5 pb-2">
            <label class="block text-sm font-medium text-[#5C5954]">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all placeholder:text-[#A8A5A0]"
                      placeholder="Contoh: Penjualan harian (opsional)">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                Simpan
            </button>
            <a href="{{ route('obat-keluar.index') }}"
               class="bg-[#F3F2EE] hover:bg-[#EAE8E3] text-[#5C5954] text-sm font-medium px-6 py-2.5 rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection