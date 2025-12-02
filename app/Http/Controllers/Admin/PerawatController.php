<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perawat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerawatController extends Controller
{
    /**
     * Display a listing of perawat profiles
     */
    public function index()
    {
        $perawatList = DB::table('perawat')
            ->join('user', 'perawat.iduser', '=', 'user.iduser')
            ->join('role_user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.nama_role', 'Perawat')
            ->where('role_user.status', 1) // Only active records
            ->select(
                'perawat.*',
                'user.nama',
                'user.email',
                'role_user.status as user_status'
            )
            ->orderBy('user.nama')
            ->get();

        return view('data.perawat.index', compact('perawatList'));
    }

    /**
     * Show the form for creating a new perawat profile
     */
    public function create()
    {
        // Get users who don't have Perawat role yet
        $availableUsers = DB::table('user')
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('role_user')
                    ->join('role', 'role_user.idrole', '=', 'role.idrole')
                    ->where('role.nama_role', 'Perawat')
                    ->whereColumn('role_user.iduser', 'user.iduser');
            })
            ->select('user.iduser', 'user.nama', 'user.email')
            ->orderBy('user.nama')
            ->get();

        return view('data.perawat.create', compact('availableUsers'));
    }

    /**
     * Store a newly created perawat profile
     */
    public function store(Request $request)
    {
        $request->validate([
            'iduser' => 'required|exists:user,iduser|unique:perawat,iduser',
            'alamat' => 'required|string|max:100',
            'no_hp' => 'required|string|max:45',
            'pendidikan' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:M,F'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Create perawat profile
                Perawat::create($request->all());

                // Assign Perawat role to the user
                $perawatRole = DB::table('role')->where('nama_role', 'Perawat')->first();
                if ($perawatRole) {
                    // Check if user doesn't already have this role
                    $existingRole = DB::table('role_user')
                        ->where('iduser', $request->iduser)
                        ->where('idrole', $perawatRole->idrole)
                        ->exists();
                    
                    if (!$existingRole) {
                        DB::table('role_user')->insert([
                            'iduser' => $request->iduser,
                            'idrole' => $perawatRole->idrole
                        ]);
                    }
                }
            });

            return redirect()->route('data.perawat.index')
                ->with('success', 'Profil perawat berhasil ditambahkan dan role Perawat telah diberikan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan profil perawat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified perawat profile
     */
    public function show($id)
    {
        $perawat = DB::table('perawat')
            ->join('user', 'perawat.iduser', '=', 'user.iduser')
            ->join('role_user', 'role_user.iduser', '=', 'user.iduser')
            ->where('perawat.idperawat', $id)
            ->select(
                'perawat.*',
                'user.nama',
                'user.email',
                'role_user.status as user_status',
                'perawat.created_at as user_created_at'
            )
            ->first();

        if (!$perawat) {
            return redirect()->route('data.perawat.index')
                ->with('error', 'Profil perawat tidak ditemukan');
        }

        return view('data.perawat.show', compact('perawat'));
    }

    /**
     * Show the form for editing the specified perawat profile
     */
    public function edit($id)
    {
        $perawat = Perawat::findOrFail($id);
        
        return view('data.perawat.edit', compact('perawat'));
    }

    /**
     * Update the specified perawat profile
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'alamat' => 'required|string|max:100',
            'no_hp' => 'required|string|max:45',
            'pendidikan' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:M,F'
        ]);

        try {
            $perawat = Perawat::findOrFail($id);
            $perawat->update($request->only(['alamat', 'no_hp', 'pendidikan', 'jenis_kelamin']));

            return redirect()->route('data.perawat.index')
                ->with('success', 'Profil perawat berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil perawat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified perawat profile
     */
    public function destroy($id)
    {
        try {
            $perawat = Perawat::findOrFail($id);
            
            // Instead of hard delete, deactivate the role_user record
            DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', $perawat->iduser)
                ->where('role.nama_role', 'Perawat')
                ->update(['role_user.status' => 0]);

            return redirect()->route('data.perawat.index')
                ->with('success', 'Profil perawat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data.perawat.index')
                ->with('error', 'Gagal menonaktifkan profil perawat: ' . $e->getMessage());
        }
    }
}
