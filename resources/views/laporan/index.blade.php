@extends('layouts.app')

@section('title', 'Laporan')
@section('header', 'Laporan')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <p class="text-sm text-[#73706A]">Rekapitulasi riwayat transaksi keluar masuk persediaan obat.</p>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('laporan.export-excel', request()->all()) }}"
               class="inline-flex items-center bg-[#F0F5F1] hover:bg-[#E2EBE4] text-[#2E5C3A] text-sm font-medium px-4 py-2.5 rounded-xl transition-colors border border-[#D1E0D5]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </a>
            <a href="{{ route('laporan.export-pdf', request()->all()) }}"
               class="inline-flex items-center bg-[#FDF6F5] hover:bg-[#F3E1DE] text-[#B3412F] text-sm font-medium px-4 py-2.5 rounded-xl transition-colors border border-[#F3E1DE]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                Export PDF
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('laporan.index') }}"
          class="flex flex-wrap items-end gap-4 mb-8 bg-[#FAF9F6] p-5 rounded-xl border border-[#E6E4DD]">

        <div class="space-y-1.5">
            <label class="block text-xs font-medium text-[#5C5954]">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ $dari }}"
                   class="bg-white border border-[#D6D3CD] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#2D2A26] focus:ring-1 focus:ring-[#2D2A26] transition-all text-[#2D2A26]">
        </div>

        <div class="space-y-1.5">
            <label class="block text-xs font-medium text-[#5C5954]">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ $sampai }}"
                   class="bg-white border border-[#D6D3CD] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#2D2A26] focus:ring-1 focus:ring-[#2D2A26] transition-all text-[#2D2A26]">
        </div>

        <button type="submit"
                class="bg-[#2D2A26] hover:bg-[#43403B] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors">
            Terapkan Filter
        </button>

        @if($dari || $sampai)
            <a href="{{ route('laporan.index') }}"
               class="bg-white border border-[#D6D3CD] text-[#5C5954] text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#F3F2EE] transition-colors">
                Reset
            </a>
        @endif

    </form>

    @if($dari || $sampai)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
            <div class="bg-white border border-[#E6E4DD] rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                <p class="text-sm font-medium text-[#8F8C87]">Total Obat Masuk</p>
                <p class="text-3xl font-serif text-[#2E5C3A] mt-2">+{{ $totalMasuk }}</p>
                <p class="text-xs text-[#73706A] mt-2">
                    Periode: {{ $dari ? \Carbon\Carbon::parse($dari)->format('d M Y') : 'Awal' }} — {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d M Y') : 'Akhir' }}
                </p>
            </div>
            <div class="bg-white border border-[#E6E4DD] rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                <p class="text-sm font-medium text-[#8F8C87]">Total Obat Keluar</p>
                <p class="text-3xl font-serif text-[#B3412F] mt-2">-{{ $totalKeluar }}</p>
                <p class="text-xs text-[#73706A] mt-2">
                    Periode: {{ $dari ? \Carbon\Carbon::parse($dari)->format('d M Y') : 'Awal' }} — {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d M Y') : 'Akhir' }}
                </p>
            </div>
        </div>
    @endif

    @if($laporan->isEmpty())
        <div class="text-center py-12 border border-[#E6E4DD] rounded-xl bg-[#FAF9F6]/50">
            <p class="text-sm text-[#73706A]">
                {{ $dari || $sampai ? 'Tidak ditemukan data transaksi pada rentang tanggal tersebut.' : 'Belum ada data transaksi yang tercatat.' }}
            </p>
        </div>
    @else
        <div class="border border-[#E6E4DD] rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#FAF9F6] border-b border-[#E6E4DD]">
                        <tr>
                            <th class="px-5 py-4 font-medium text-[#73706A] w-10">No</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Tanggal</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Nama Obat</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Kategori</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Tipe</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Jumlah</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6E4DD]">
                        @foreach($laporan as $i => $item)
                        <tr class="hover:bg-[#FAF9F6]/50 transition-colors bg-white">
                            <td class="px-5 py-4 text-[#73706A]">{{ $i + 1 }}</td>
                            <td class="px-5 py-4 text-[#5C5954]">
                                {{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-5 py-4 font-medium text-[#2D2A26]">{{ $item['nama_obat'] }}</td>
                            <td class="px-5 py-4 text-[#73706A]">{{ $item['kategori'] }}</td>
                            <td class="px-5 py-4">
                                @if($item['tipe'] === 'masuk')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#F0F5F1] text-[#2E5C3A]">
                                        Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#FDF6F5] text-[#B3412F]">
                                        Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-medium {{ $item['tipe'] === 'masuk' ? 'text-[#2E5C3A]' : 'text-[#B3412F]' }}">
                                {{ $item['tipe'] === 'masuk' ? '+' : '-' }}{{ $item['jumlah'] }}
                            </td>
                            <td class="px-5 py-4 text-[#73706A]">{{ $item['keterangan'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-[#FAF9F6] border-t border-[#E6E4DD]">
                        <tr>
                            <td colspan="5" class="px-5 py-4 text-sm font-medium text-[#5C5954] text-right">Total Akumulasi:</td>
                            <td colspan="2" class="px-5 py-4 text-sm">
                                <span class="text-[#2E5C3A] font-medium">+{{ $totalMasuk }}</span>
                                <span class="text-[#D6D3CD] mx-2">|</span>
                                <span class="text-[#B3412F] font-medium">-{{ $totalKeluar }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection