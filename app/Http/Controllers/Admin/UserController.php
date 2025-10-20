<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:500',
            'email' => 'required|email|unique:user,email|max:200',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:500',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('user', 'email')->ignore($user->iduser, 'iduser')
            ],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent users from deleting their own account
        if (auth()->check() && auth()->user()->iduser == $user->iduser) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        
        // Generate random password
        $newPassword = bin2hex(random_bytes(8));
        
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return response()->json([
            'success' => true,
            'message' => "Password berhasil direset. Password baru: {$newPassword}"
        ]);
    }
}
