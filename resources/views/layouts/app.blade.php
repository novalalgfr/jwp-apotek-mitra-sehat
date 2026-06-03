<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Apotek Mitra Sehat')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Newsreader:opsz,wght@6..72,400;6..72,500;6..72,600&display=swap" rel="stylesheet">
    <style>
        .font-serif { font-family: 'Newsreader', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF9F6] min-h-screen flex font-sans text-[#2D2A26] antialiased">

    {{-- Sidebar --}}
    <aside class="w-64 bg-[#F3F2EE] flex flex-col min-h-screen fixed z-20 border-r border-[#E6E4DD]">
        
        {{-- Brand --}}
        <div class="px-6 py-8">
            <div class="text-2xl font-serif font-medium tracking-tight text-[#2D2A26]">Mitra Sehat.</div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-4 space-y-1">
            
            <a href="{{ route('dashboard') }}"
               class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-white shadow-sm text-[#2D2A26]' : 'text-[#5C5954] hover:bg-[#EAE8E3]' }}">
                Dashboard
            </a>

            <div class="pt-4 pb-2 px-3 text-[11px] font-medium text-[#8F8C87] uppercase tracking-wider">
                Persediaan
            </div>

            <a href="{{ route('obat-masuk.index') }}"
               class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('obat-masuk.*') ? 'bg-white shadow-sm text-[#2D2A26]' : 'text-[#5C5954] hover:bg-[#EAE8E3]' }}">
                Obat Masuk
            </a>

            <a href="{{ route('obat-keluar.index') }}"
               class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('obat-keluar.*') ? 'bg-white shadow-sm text-[#2D2A26]' : 'text-[#5C5954] hover:bg-[#EAE8E3]' }}">
                Obat Keluar
            </a>

            <div class="pt-4 pb-2 px-3 text-[11px] font-medium text-[#8F8C87] uppercase tracking-wider">
                Master Data
            </div>

            <a href="{{ route('kategori-obat.index') }}"
               class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('kategori-obat.*') ? 'bg-white shadow-sm text-[#2D2A26]' : 'text-[#5C5954] hover:bg-[#EAE8E3]' }}">
                Kategori Obat
            </a>

            <a href="{{ route('obat.index') }}"
               class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('obat.*') ? 'bg-white shadow-sm text-[#2D2A26]' : 'text-[#5C5954] hover:bg-[#EAE8E3]' }}">
                Daftar Obat
            </a>

            <div class="pt-4 pb-2 px-3 text-[11px] font-medium text-[#8F8C87] uppercase tracking-wider">
                Lainnya
            </div>

            <a href="{{ route('laporan.index') }}"
               class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('laporan.*') ? 'bg-white shadow-sm text-[#2D2A26]' : 'text-[#5C5954] hover:bg-[#EAE8E3]' }}">
                Laporan
            </a>

			<a href="{{ route('users.index') }}"
			   class="flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-white shadow-sm text-[#2D2A26]' : 'text-[#5C5954] hover:bg-[#EAE8E3]' }}">
				Manajemen Admin
			</a>

        </nav>

        {{-- Logout --}}
        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-[#B3412F] hover:bg-[#EAE8E3] transition-colors">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- Main Content Window --}}
    <div class="ml-64 flex-1 flex flex-col min-h-screen">

        {{-- Topbar --}}
        <header class="px-10 py-8 flex items-center justify-between">
            <h1 class="text-2xl font-serif font-medium">@yield('header', 'Dashboard')</h1>
            <div class="text-sm font-medium text-[#73706A]">
                {{ Auth::user()->name ?? 'Noval' }}
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-10">
            @if(session('success'))
                <div class="bg-[#F0F5F1] text-[#2E5C3A] px-4 py-3 rounded-xl text-sm mb-4 font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-[#FDF6F5] text-[#B3412F] px-4 py-3 rounded-xl text-sm mb-4 font-medium">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Dynamic Content Area --}}
        <main class="flex-1 px-10 pb-10">
            @yield('content')
        </main>

    </div>

</body>
</html>