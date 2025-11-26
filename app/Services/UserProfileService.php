<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Dokter;
use App\Models\Perawat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserProfileService
{
    /**
     * Create a new user with automatic role assignment and profile creation
     */
    public function createUserWithProfile(array $userData, string $roleType, array $profileData)
    {
        return DB::transaction(function () use ($userData, $roleType, $profileData) {            // Create user
            $user = User::create([
                'nama' => $userData['nama'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            // Find role
            $role = Role::where('nama_role', $roleType)->first();
            if (!$role) {
                throw new \Exception("Role {$roleType} not found");
            }

            // Assign role to user
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => $role->idrole,
            ]);

            // Create profile based on role type
            $profile = null;
            if ($roleType === 'Dokter') {
                $profile = Dokter::create([
                    'iduser' => $user->iduser,
                    'alamat' => $profileData['alamat'],
                    'no_hp' => $profileData['no_hp'],
                    'bidang_dokter' => $profileData['bidang_dokter'],
                    'jenis_kelamin' => $profileData['jenis_kelamin'],
                ]);
            } elseif ($roleType === 'Perawat') {
                $profile = Perawat::create([
                    'iduser' => $user->iduser,
                    'alamat' => $profileData['alamat'],
                    'no_hp' => $profileData['no_hp'],
                    'pendidikan' => $profileData['pendidikan'],
                    'jenis_kelamin' => $profileData['jenis_kelamin'],
                ]);
            }

            return [
                'user' => $user,
                'role' => $role,
                'profile' => $profile,
            ];
        });
    }    /**
     * Get users with multiple roles
     */
    public function getUsersWithMultipleRoles()
    {
        return DB::table('user')
            ->join('role_user', 'user.iduser', '=', 'role_user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->select(
                'user.*',
                DB::raw('GROUP_CONCAT(role.nama_role) as roles'),
                DB::raw('COUNT(role.idrole) as role_count')
            )
            ->groupBy('user.iduser', 'user.nama', 'user.email', 'user.email_verified_at', 'user.password')
            ->having('role_count', '>', 1)
            ->get();
    }

    /**
     * Get user profiles for tabbed view
     */
    public function getUserProfiles($userId)
    {
        $user = User::findOrFail($userId);
        $profiles = [];

        // Check for dokter profile
        $dokter = Dokter::where('iduser', $userId)->first();
        if ($dokter) {
            $profiles['dokter'] = $dokter;
        }

        // Check for perawat profile
        $perawat = Perawat::where('iduser', $userId)->first();
        if ($perawat) {
            $profiles['perawat'] = $perawat;
        }

        // Get user roles
        $roles = DB::table('role_user')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role_user.iduser', $userId)
            ->pluck('role.nama_role')
            ->toArray();

        return [
            'user' => $user,
            'profiles' => $profiles,
            'roles' => $roles,
        ];
    }
}
