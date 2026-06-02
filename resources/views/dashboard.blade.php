@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 id="greeting" class="text-2xl font-serif text-[#2D2A26] font-medium">Selamat datang, {{ Auth::user()->name ?? 'Noval' }}</h2>
            <p class="text-sm text-[#73706A] mt-1">Berikut adalah ringkasan performa persediaan hari ini.</p>
        </div>
        <div class="bg-white border border-[#E6E4DD]/70 shadow-[0_2px_8px_rgba(0,0,0,0.02)] px-4 py-2.5 rounded-xl flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-[#2E5C3A] animate-pulse"></div>
            <div class="font-mono text-sm text-[#5C5954] font-medium tracking-wide" id="live-clock">
                00:00:00
            </div>
        </div>
    </div>

    @if($stokHabis > 0)
        <div class="bg-[#FDF6F5] border border-[#F3E1DE] px-5 py-4 rounded-xl mb-8 flex items-start gap-3">
            <div class="text-[#B3412F] mt-0.5">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#B3412F]">Perhatian</h3>
                <p class="text-sm text-[#B3412F]/80 mt-1">Terdapat {{ $stokHabis }} obat dengan stok habis. Lakukan pengecekan persediaan.</p>
            </div>
        </div>
    @endif

    <div class="flex flex-wrap gap-4 mb-8">
        <a href="{{ route('obat-masuk.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-[#E6E4DD] rounded-xl text-sm font-medium text-[#2D2A26] hover:bg-[#FAF9F6] transition-all hover:-translate-y-0.5 shadow-sm">
            <svg class="w-4 h-4 mr-2 text-[#2E5C3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Catat Obat Masuk
        </a>
        <a href="{{ route('obat-keluar.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-[#E6E4DD] rounded-xl text-sm font-medium text-[#2D2A26] hover:bg-[#FAF9F6] transition-all hover:-translate-y-0.5 shadow-sm">
            <svg class="w-4 h-4 mr-2 text-[#B3412F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Catat Obat Keluar
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 hover:shadow-sm transition-shadow">
            <p class="text-sm font-medium text-[#8F8C87] mb-2">Total Obat</p>
            <p class="text-3xl font-serif text-[#2D2A26]">{{ $totalObat }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 hover:shadow-sm transition-shadow">
            <p class="text-sm font-medium text-[#8F8C87] mb-2">Stok Masuk</p>
            <p class="text-3xl font-serif text-[#2E5C3A]">{{ $totalMasuk }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 hover:shadow-sm transition-shadow">
            <p class="text-sm font-medium text-[#8F8C87] mb-2">Stok Keluar</p>
            <p class="text-3xl font-serif text-[#B3412F]">{{ $totalKeluar }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 hover:shadow-sm transition-shadow">
            <p class="text-sm font-medium text-[#8F8C87] mb-2">Stok Tertinggi</p>
            @if($stokTertinggi)
                <p class="text-3xl font-serif text-[#2D2A26]">{{ $stokTertinggi->stok }}</p>
                <p class="text-sm text-[#73706A] mt-1 truncate">{{ $stokTertinggi->nama_obat }}</p>
            @else
                <p class="text-3xl font-serif text-[#73706A]">-</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2">
            <h2 class="text-lg font-serif font-medium text-[#2D2A26] mb-4">Tren Transaksi (7 Hari Terakhir)</h2>
            <div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-6 relative w-full h-[300px]">
                <canvas id="transactionChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-1">
            <h2 class="text-lg font-serif font-medium text-[#2D2A26] mb-4">Aktivitas Terbaru</h2>
            <div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-6 h-[300px] overflow-y-auto">
                @if($aktivitasTerbaru->isEmpty())
                    <p class="text-sm text-[#73706A] text-center py-6">Belum ada aktivitas transaksi.</p>
                @else
                    <div class="space-y-6">
                        @foreach($aktivitasTerbaru as $aktivitas)
                            <div class="flex items-start gap-4">
                                <div class="mt-0.5 flex-shrink-0">
                                    @if($aktivitas->tipe === 'masuk')
                                        <div class="w-7 h-7 rounded-full bg-[#F0F5F1] flex items-center justify-center text-[#2E5C3A]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-[#FDF6F5] flex items-center justify-center text-[#B3412F]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-[#2D2A26] truncate">{{ $aktivitas->nama_obat }}</p>
                                    <p class="text-[11px] text-[#8F8C87] mt-0.5">{{ \Carbon\Carbon::parse($aktivitas->tanggal)->locale('id')->diffForHumans() }}</p>
                                </div>
                                <div class="text-sm font-medium {{ $aktivitas->tipe === 'masuk' ? 'text-[#2E5C3A]' : 'text-[#B3412F]' }}">
                                    {{ $aktivitas->tipe === 'masuk' ? '+' : '-' }}{{ $aktivitas->jumlah }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-end mb-4">
            <h2 class="text-lg font-serif font-medium text-[#2D2A26]">Peringatan Stok Rendah</h2>
            <a href="{{ route('obat.index') }}" class="text-sm font-medium text-[#D97757] hover:text-[#C6694C] transition-colors">
                Kelola Inventaris &rarr;
            </a>
        </div>
        
        <div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 overflow-hidden">
            @if($stokRendah->isEmpty())
                <div class="px-6 py-12 text-center bg-[#FAF9F6]/30">
                    <p class="text-sm text-[#73706A]">Semua persediaan obat dalam kondisi aman.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#FAF9F6] border-b border-[#E6E4DD]">
                            <tr>
                                <th class="px-6 py-4 font-medium text-[#73706A]">Nama Obat</th>
                                <th class="px-6 py-4 font-medium text-[#73706A]">Kategori</th>
                                <th class="px-6 py-4 font-medium text-[#73706A]">Stok Tersisa</th>
                                <th class="px-6 py-4 font-medium text-[#73706A]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E6E4DD]">
                            @foreach($stokRendah as $obat)
                                <tr class="hover:bg-[#FAF9F6]/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-[#2D2A26]">{{ $obat->nama_obat }}</td>
                                    <td class="px-6 py-4 text-[#73706A]">{{ $obat->kategori->nama_kategori ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="{{ $obat->stok == 0 ? 'text-[#B3412F] font-medium' : 'text-[#D97757] font-medium' }}">
                                            {{ $obat->stok }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($obat->status === 'tersedia')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#F0F5F1] text-[#2E5C3A]">Tersedia</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#FDF6F5] text-[#B3412F]">Kosong</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
            document.getElementById('live-clock').textContent = timeString;

            const hour = now.getHours();
            let greeting = 'Selamat malam,';
            if (hour >= 5 && hour < 11) greeting = 'Selamat pagi,';
            else if (hour >= 11 && hour < 15) greeting = 'Selamat siang,';
            else if (hour >= 15 && hour < 18) greeting = 'Selamat sore,';

            const user = "{{ Auth::user()->name ?? 'Noval' }}";
            document.getElementById('greeting').textContent = `${greeting} ${user}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        const ctx = document.getElementById('transactionChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: [12, 19, 15, 25, 22, 30, 28],
                        borderColor: '#2E5C3A',
                        backgroundColor: 'rgba(46, 92, 58, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Barang Keluar',
                        data: [5, 10, 8, 15, 12, 20, 18],
                        borderColor: '#B3412F',
                        backgroundColor: 'rgba(179, 65, 47, 0.05)',
                        tension: 0.4,
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: { boxWidth: 12, usePointStyle: true, font: { family: 'Inter', size: 11 } }
                    }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    y: { grid: { color: '#E6E4DD', drawBorder: false }, border: { display: false }, beginAtZero: true }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                }
            }
        });
    </script>

@endsection