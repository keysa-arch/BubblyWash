<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('user.index', compact('users'));
    }

    // =====================
    // CREATE
    // =====================
    public function create()
    {
        return view('user.create');
    }

    // =====================
    // STORE
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:superadmin,admin,customer',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    // =====================
    // EDIT
    // =====================
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:superadmin,admin,customer',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        // Ganti password hanya kalau diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('user.index')
            ->with('success', 'User berhasil diperbarui');
    }

    // =====================
    // DELETE
    // =====================
    public function destroy(User $user)
    {
        // Cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}