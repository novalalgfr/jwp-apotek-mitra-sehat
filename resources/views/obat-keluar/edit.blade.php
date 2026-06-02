@extends('layouts.app')

@section('title', 'Edit Obat Keluar')
@section('header', 'Edit Obat Keluar')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <form method="POST" action="{{ route('obat-keluar.update', $obatKeluar) }}" class="space-y-5">
        @csrf @method('PUT')

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Obat <span class="text-[#B3412F]">*</span></label>
            <select name="obat_id"
                    class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
                <option value="">-- Pilih Obat --</option>
                @foreach($obats as $obat)
                    <option value="{{ $obat->id }}"
                        {{ old('obat_id', $obatKeluar->obat_id) == $obat->id ? 'selected' : '' }}>
                        {{ $obat->nama_obat }} (Stok: {{ $obat->stok }} {{ $obat->satuan }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Tanggal <span class="text-[#B3412F]">*</span></label>
            <input type="date" name="tanggal"
                   value="{{ old('tanggal', $obatKeluar->tanggal) }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Jumlah <span class="text-[#B3412F]">*</span></label>
            <input type="number" name="jumlah" min="1"
                   value="{{ old('jumlah', $obatKeluar->jumlah) }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
            @error('jumlah')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5 pb-2">
            <label class="block text-sm font-medium text-[#5C5954]">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">{{ old('keterangan', $obatKeluar->keterangan) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                Update Data
            </button>
            <a href="{{ route('obat-keluar.index') }}"
               class="bg-[#F3F2EE] hover:bg-[#EAE8E3] text-[#5C5954] text-sm font-medium px-6 py-2.5 rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection