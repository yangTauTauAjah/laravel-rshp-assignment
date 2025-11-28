<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Pemilik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Show the user's own profile with tabs for different roles
     */
    public function show()
    {
        $user = Auth::user();
        $userId = $user->iduser;
        
        // Get user's roles
        $userRoles = DB::table('role_user')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role_user.iduser', $userId)
            ->where('role_user.status', 1)
            ->pluck('role.nama_role')
            ->toArray();

        $profiles = [];
        
        // Check for Pemilik profile
        $pemilik = Pemilik::where('iduser', $userId)->first();
        if ($pemilik && in_array('Pemilik', $userRoles)) {
            $profiles['pemilik'] = $pemilik;
        }
        
        // Check for Dokter profile
        $dokter = Dokter::where('iduser', $userId)->first();
        if ($dokter && in_array('Dokter', $userRoles)) {
            $profiles['dokter'] = $dokter;
        }
        
        // Check for Perawat profile
        $perawat = Perawat::where('iduser', $userId)->first();
        if ($perawat && in_array('Perawat', $userRoles)) {
            $profiles['perawat'] = $perawat;
        }

        return view('profile.show', compact('user', 'profiles', 'userRoles'));
    }

    /**
     * Show the form for editing the user's profile
     */
    public function edit($profileType)
    {
        $user = Auth::user();
        $userId = $user->iduser;

        // Verify user has permission to edit this profile type
        $userRoles = DB::table('role_user')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role_user.iduser', $userId)
            ->pluck('role.nama_role')
            ->toArray();

        $profile = null;
        switch ($profileType) {
            case 'pemilik':
                if (in_array('Pemilik', $userRoles)) {
                    $profile = Pemilik::where('iduser', $userId)->first();
                }
                break;
            case 'dokter':
                if (in_array('Dokter', $userRoles)) {
                    $profile = Dokter::where('iduser', $userId)->first();
                }
                break;
            case 'perawat':
                if (in_array('Perawat', $userRoles)) {
                    $profile = Perawat::where('iduser', $userId)->first();
                }
                break;
        }

        if (!$profile) {
            return redirect()->route('profile.show')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        return view('profile.edit', compact('user', 'profile', 'profileType'));
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request, $profileType)
    {
        $user = Auth::user();
        $userId = $user->iduser;

        // Verify user has permission to edit this profile type
        $userRoles = DB::table('role_user')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role_user.iduser', $userId)
            ->pluck('role.nama_role')
            ->toArray();        switch ($profileType) {
            case 'pemilik':
                if (in_array('Pemilik', $userRoles)) {
                    $request->validate([
                        'alamat' => 'required|string|max:100',
                        'no_wa' => 'required|string|max:45'
                    ]);
                    
                    Pemilik::where('iduser', $userId)->update([
                        'alamat' => $request->alamat,
                        'no_wa' => $request->no_wa
                    ]);
                }
                break;
                
            case 'dokter':
                if (in_array('Dokter', $userRoles)) {
                    $request->validate([
                        'alamat' => 'required|string|max:100',
                        'no_hp' => 'required|string|max:45',
                        'bidang_dokter' => 'required|string|max:100',
                        'jenis_kelamin' => 'required|in:M,F'
                    ]);
                    
                    Dokter::where('iduser', $userId)->update([
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'bidang_dokter' => $request->bidang_dokter,
                        'jenis_kelamin' => $request->jenis_kelamin
                    ]);
                }
                break;
                
            case 'perawat':
                if (in_array('Perawat', $userRoles)) {
                    $request->validate([
                        'alamat' => 'required|string|max:100',
                        'no_hp' => 'required|string|max:45',
                        'pendidikan' => 'required|string|max:100',
                        'jenis_kelamin' => 'required|in:M,F'
                    ]);
                    
                    Perawat::where('iduser', $userId)->update([
                        'alamat' => $request->alamat,
                        'no_hp' => $request->no_hp,
                        'pendidikan' => $request->pendidikan,
                        'jenis_kelamin' => $request->jenis_kelamin
                    ]);
                }
                break;
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
