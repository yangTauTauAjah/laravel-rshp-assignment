<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{    
    /**
     * Display a listing of pet owners
     */
    public function index()
    {
        // Query Builder: pemilik with user data and pets count - only active records
        $pemilikList = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('role_user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->leftJoin('pet', 'pemilik.idpemilik', '=', 'pet.idpemilik')
            ->where('role.nama_role', 'Pemilik')
            ->where('role_user.status', 1) // Only active records
            ->select(
                'pemilik.*', 
                'user.nama', 
                'user.email',
                'role_user.status as user_status',
                DB::raw('COUNT(pet.idpet) as pets_count')
            )
            ->groupBy('pemilik.idpemilik', 'pemilik.iduser', 'pemilik.no_wa', 'pemilik.alamat', 'user.nama', 'user.email', 'role_user.status')
            ->orderBy('user.nama')
            ->get();

        // Users not in pemilik - get users who don't have Pemilik role yet
        $availableUsers = DB::table('user')
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('role_user')
                    ->join('role', 'role_user.idrole', '=', 'role.idrole')
                    ->where('role.nama_role', 'Pemilik')
                    ->where('role_user.status', 1)
                    ->whereColumn('role_user.iduser', 'user.iduser');
            })
            ->select('iduser', 'nama', 'email')
            ->get();

        return view('data.pemilik.index', compact('pemilikList', 'availableUsers'));
    }
    
    /**
     * Store a newly created pemilik
     */
    public function store(Request $request)
    {
        // Validate based on registration type
        if ($request->registration_type === 'existing') {
            $request->validate([
                'existing_user_id' => 'required|exists:user,iduser',
                'no_wa' => 'required|string|max:45',
                'alamat' => 'required|string|max:100',
            ]);

            // Check if user is already a pemilik
            $existingPemilik = Pemilik::where('iduser', $request->existing_user_id)->first();
            if ($existingPemilik) {
                return redirect()->route('data.pemilik.index')
                    ->with('error', 'User ini sudah terdaftar sebagai pemilik hewan');
            }

            DB::beginTransaction();
            try {
                // Get the next idpemilik
                $lastPemilik = Pemilik::orderBy('idpemilik', 'desc')->first();
                $nextIdPemilik = $lastPemilik ? $lastPemilik->idpemilik + 1 : 1;

                // Create pemilik record for existing user
                Pemilik::create([
                    'idpemilik' => $nextIdPemilik,
                    'iduser' => $request->existing_user_id,
                    'no_wa' => $request->no_wa,
                    'alamat' => $request->alamat,
                ]);

                // Assign Pemilik role to the user
                $pemilikRole = DB::table('role')->where('nama_role', 'Pemilik')->first();
                if ($pemilikRole) {
                    // Check if user doesn't already have this role
                    $existingRole = DB::table('role_user')
                        ->where('iduser', $request->existing_user_id)
                        ->where('idrole', $pemilikRole->idrole)
                        ->exists();
                    
                    if (!$existingRole) {
                        DB::table('role_user')->insert([
                            'iduser' => $request->existing_user_id,
                            'idrole' => $pemilikRole->idrole
                        ]);
                    }
                }

                DB::commit();

                return redirect()->route('data.pemilik.index')
                    ->with('success', 'Data pemilik hewan berhasil ditambahkan dari user yang sudah ada');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('data.pemilik.index')
                    ->with('error', 'Gagal menambahkan data pemilik: ' . $e->getMessage());
            }
        } else {
            // New user registration
            $request->validate([
                'nama' => 'required|string|max:500',
                'email' => 'required|email|unique:user,email|max:200',
                'password' => 'required|string|min:6',
                'no_wa' => 'required|string|max:45',
                'alamat' => 'required|string|max:100',
            ]);

            DB::beginTransaction();
            try {
                // Create user first
                $user = User::create([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // Assign Pemilik role to the user
                $pemilikRole = DB::table('role')->where('nama_role', 'Pemilik')->first();
                if ($pemilikRole) {
                    // Check if user doesn't already have this role
                    $existingRole = DB::table('role_user')
                        ->where('iduser', $user->iduser)
                        ->where('idrole', $pemilikRole->idrole)
                        ->exists();
                    
                    if (!$existingRole) {
                        DB::table('role_user')->insert([
                            'iduser' => $user->iduser,
                            'idrole' => $pemilikRole->idrole
                        ]);
                    }
                }

                // Get the next idpemilik
                $lastPemilik = Pemilik::orderBy('idpemilik', 'desc')->first();
                $nextIdPemilik = $lastPemilik ? $lastPemilik->idpemilik + 1 : 1;

                // Create pemilik record
                Pemilik::create([
                    'idpemilik' => $nextIdPemilik,
                    'iduser' => $user->iduser,
                    'no_wa' => $request->no_wa,
                    'alamat' => $request->alamat,
                ]);

                DB::commit();

                return redirect()->route('data.pemilik.index')
                    ->with('success', 'Data pemilik hewan berhasil ditambahkan dengan user baru');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('data.pemilik.index')
                    ->with('error', 'Gagal menambahkan data pemilik: ' . $e->getMessage());
            }
        }
    }

    /**
     * Update the specified pemilik
     */
    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:500',
            'email' => 'required|email|max:200|unique:user,email,' . $pemilik->iduser . ',iduser',
            'no_wa' => 'required|string|max:45',
            'alamat' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Update user data
            $pemilik->user->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $pemilik->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Update pemilik data
            $pemilik->update([
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat,
            ]);

            DB::commit();

            return redirect()->route('data.pemilik.index')
                ->with('success', 'Data pemilik hewan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Gagal memperbarui data pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified pemilik
     */
    public function edit($id)
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.idpemilik', $id)
            ->select(
                'pemilik.*',
                'user.nama',
                'user.email'
            )
            ->first();

        if (!$pemilik) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Profil pemilik tidak ditemukan');
        }

        return view('data.pemilik.edit', compact('pemilik'));
    }

    /**
     * Remove the specified pemilik (soft delete by deactivating role)
     */
    public function destroy($id)
    {
        $pemilik = Pemilik::findOrFail($id);
        
        // Check if pemilik has pets
        /* if ($pemilik->pets()->count() > 0) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Tidak dapat menghapus pemilik yang memiliki hewan peliharaan terdaftar');
        } */

        DB::beginTransaction();
        try {
            // Instead of hard delete, deactivate the role_user record
            DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', $pemilik->iduser)
                ->where('role.nama_role', 'Pemilik')
                ->update(['role_user.status' => 0]);

            DB::commit();

            return redirect()->route('data.pemilik.index')
                ->with('success', 'Profil pemilik hewan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Gagal menonaktifkan data pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified pemilik details
     */
    public function show(Request $request, $id)
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('role_user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->leftJoin('pet', 'pemilik.idpemilik', '=', 'pet.idpemilik')
            ->where('pemilik.idpemilik', $id)
            ->where('role.nama_role', 'Pemilik')
            ->select(
                'pemilik.*',
                'user.nama',
                'user.email',
                'role_user.status as user_status',
                // 'pemilik.created_at as user_created_at',
                DB::raw('COUNT(pet.idpet) as pets_count')
            )
            ->groupBy('pemilik.idpemilik', 'pemilik.iduser', 'pemilik.no_wa', 'pemilik.alamat', 'user.nama', 'user.email', 'role_user.status'/* , 'pemilik.created_at' */)
            ->first();

        if (!$pemilik) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Profil pemilik tidak ditemukan');
        }

        if ($request->ajax()) {
            return response()->json($pemilik);
        }

        return view('data.pemilik.show', compact('pemilik'));
    }
}
