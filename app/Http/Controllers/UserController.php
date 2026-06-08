<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Akses Ditolak. Hanya Superadmin yang dapat menambah admin baru.');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Akses Ditolak.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'role'     => 'required|in:superadmin,admin',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Akses Ditolak. Hanya Superadmin yang dapat mengedit data.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Akses Ditolak.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'role'     => 'required|in:superadmin,admin',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('users.index')->with('error', 'Akses Ditolak. Hanya Superadmin yang dapat menghapus data.');
        }

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tindakan ditolak. Anda tidak dapat menghapus akun yang sedang Anda gunakan.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}