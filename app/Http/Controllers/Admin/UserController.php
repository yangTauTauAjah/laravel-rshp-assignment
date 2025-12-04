<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // Filter out soft-deleted users
        $users = User::whereNull('deleted_at')->get();
        return view('data.users.index', compact('users'));
    }

    public function show($id)
    {
        // Only show non-deleted users
        $user = User::whereNull('deleted_at')->findOrFail($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:500',
            'email' => 'required|email|max:200|unique:user,email,NULL,iduser,deleted_at,NULL',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('data.users.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // Only update non-deleted users
        $user = User::whereNull('deleted_at')->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:500',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('user', 'email')->ignore($user->iduser, 'iduser')->whereNull('deleted_at')
            ],
        ]);

        $user->update($validated);

        return redirect()->route('data.users.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Only allow deletion of non-deleted users
        $user = User::whereNull('deleted_at')->findOrFail($id);
        
        // Prevent users from deleting their own account
        if (Auth::check() && Auth::user()->iduser == $user->iduser) {
            return redirect()->route('data.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        // Perform soft delete by setting deleted_at timestamp and deleted_by user ID
        $user->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->iduser
        ]);

        return redirect()->route('data.users.index')->with('success', 'Pengguna berhasil dihapus');
    }

    public function resetPassword($id)
    {
        // Only reset password for non-deleted users
        $user = User::whereNull('deleted_at')->findOrFail($id);
        
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
