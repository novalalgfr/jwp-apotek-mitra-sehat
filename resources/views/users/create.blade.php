@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('header', 'Tambah Pengguna')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8 max-w-xl">

    <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
        @csrf

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Nama Lengkap <span class="text-[#B3412F]">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all"
                   placeholder="Masukkan nama lengkap">
            @error('name')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Username <span class="text-[#B3412F]">*</span></label>
            <input type="text" name="username" value="{{ old('username') }}"
                   class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all"
                   placeholder="Masukkan username unik">
            @error('username')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-[#5C5954]">Role Akses <span class="text-[#B3412F]">*</span></label>
            <select name="role"
                    class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Standar)</option>
                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin (Akses Penuh)</option>
            </select>
            @error('role')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5 pb-2">
            <label class="block text-sm font-medium text-[#5C5954]">Password <span class="text-[#B3412F]">*</span></label>
            <div class="relative">
                <input type="password" name="password" id="password-input"
                       class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 pr-11 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all">
                <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8F8C87] hover:text-[#2D2A26] transition-colors focus:outline-none">
                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-[#B3412F] text-xs mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                Simpan
            </button>
            <a href="{{ route('users.index') }}"
               class="bg-[#F3F2EE] hover:bg-[#EAE8E3] text-[#5C5954] text-sm font-medium px-6 py-2.5 rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>

</div>

<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const input = document.getElementById('password-input');
        input.type = input.type === 'password' ? 'text' : 'password';
        document.getElementById('eye-icon').classList.toggle('hidden');
        document.getElementById('eye-slash-icon').classList.toggle('hidden');
    });
</script>
@endsection