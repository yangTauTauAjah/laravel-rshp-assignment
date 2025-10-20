<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of users with their roles
     */
    public function index()
    {
        // Get all users with their role relationships
        $users = User::with(['roleUsers.role'])->get();
        
        // Get all available roles for the modal
        $allRoles = Role::all();
        
        return view('admin.role.index', compact('users', 'allRoles'));
    }

    /**
     * Add a role to a user
     */
    public function addRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,iduser',
            'role_id' => 'required|exists:role,idrole',
        ]);

        // Check if user already has this role
        $existingRole = RoleUser::where('iduser', $request->user_id)
            ->where('idrole', $request->role_id)
            ->first();

        if ($existingRole) {
            // If exists but inactive, reactivate it
            if (!$existingRole->status) {
                $existingRole->update(['status' => 1]);
                return redirect()->route('admin.roles.index')
                    ->with('success', 'Peran berhasil diaktifkan kembali');
            }
            
            return redirect()->route('admin.roles.index')
                ->with('error', 'Pengguna sudah memiliki peran ini');
        }

        // Create new role assignment
        RoleUser::create([
            'iduser' => $request->user_id,
            'idrole' => $request->role_id,
            'status' => 1
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Peran berhasil ditambahkan');
    }

    /**
     * Toggle role status (activate/deactivate)
     */
    public function toggleRole(Request $request, $roleUserId)
    {
        $roleUser = RoleUser::findOrFail($roleUserId);
        
        $roleUser->update([
            'status' => !$roleUser->status
        ]);

        $message = $roleUser->status ? 'Peran berhasil diaktifkan' : 'Peran berhasil dinonaktifkan';

        return redirect()->route('admin.roles.index')
            ->with('success', $message);
    }

    /**
     * Remove a role from a user
     */
    public function removeRole($roleUserId)
    {
        $roleUser = RoleUser::findOrFail($roleUserId);
        
        // Check if trying to remove own admin role
        if (Auth::user()->iduser === $roleUser->iduser && $roleUser->idrole === 1) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Tidak dapat menghapus peran Administrator dari akun Anda sendiri');
        }

        $roleUser->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Peran berhasil dihapus');
    }

    /**
     * Get user roles data for AJAX request
     */
    public function getUserRoles($userId)
    {
        $user = User::with(['roleUsers.role'])->findOrFail($userId);
        
        return response()->json([
            'user' => [
                'iduser' => $user->iduser,
                'nama' => $user->nama,
                'email' => $user->email,
            ],
            'roles' => $user->roleUsers->map(function ($roleUser) {
                return [
                    'idrole_user' => $roleUser->idrole_user,
                    'idrole' => $roleUser->idrole,
                    'nama_role' => $roleUser->role->nama_role,
                    'status' => $roleUser->status,
                ];
            }),
        ]);
    }
}
