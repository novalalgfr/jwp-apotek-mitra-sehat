@extends('layouts.app')

@section('title', 'Manajemen Akun')
@section('header', 'Manajemen Akun')

@section('content')
<div class="bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] border border-[#E6E4DD]/50 p-8">

    <div class="flex justify-between items-center mb-8">
        <p class="text-sm text-[#73706A]">Kelola akses dan kredensial admin sistem.</p>
        <a href="{{ route('users.create') }}"
           class="bg-[#D97757] hover:bg-[#C6694C] text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors shadow-sm">
            Tambah Admin
        </a>
    </div>

    @if($users->isEmpty())
        <div class="text-center py-12 border border-[#E6E4DD] rounded-xl bg-[#FAF9F6]/50">
            <p class="text-sm text-[#73706A]">Belum ada data akun.</p>
        </div>
    @else
        <div class="border border-[#E6E4DD] rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#FAF9F6] border-b border-[#E6E4DD]">
                        <tr>
                            <th class="px-5 py-4 font-medium text-[#73706A] w-10">No</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Nama Lengkap</th>
                            <th class="px-5 py-4 font-medium text-[#73706A]">Username</th>
                            <th class="px-5 py-4 font-medium text-[#73706A] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6E4DD]">
                        @foreach($users as $i => $user)
                        <tr class="hover:bg-[#FAF9F6]/50 transition-colors bg-white">
                            <td class="px-5 py-4 text-[#73706A]">{{ $i + 1 }}</td>
                            <td class="px-5 py-4 font-medium text-[#2D2A26]">
                                {{ $user->name }}
                                @if(Auth::id() === $user->id)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-[#F0F5F1] text-[#2E5C3A]">Anda</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-[#5C5954]">{{ $user->username }}</td>
                            <td class="px-5 py-4 flex justify-end gap-4">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="text-sm font-medium text-[#73706A] hover:text-[#D97757] transition-colors">
                                    Edit
                                </a>
                                @if(Auth::id() !== $user->id)
                                    <form method="POST" action="{{ route('users.destroy', $user) }}"
                                          onsubmit="return confirm('Yakin menghapus akses admin ini?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-[#73706A] hover:text-[#B3412F] transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection