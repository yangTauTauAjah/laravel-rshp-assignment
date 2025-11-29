<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PemilikController extends Controller
{
    /**
     * Display a listing of pemilik (only for Resepsionis)
     */
    public function index()
    {
        // Only Resepsionis can access this
        if (!Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk mengelola data pemilik.');
        }

        // Get active pemilik with their user data
        $pemilikList = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('role_user', function($join) {
                $join->on('user.iduser', '=', 'role_user.iduser')
                     ->where('role_user.status', '=', 1);
            })
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->leftJoin('pet', 'pemilik.idpemilik', '=', 'pet.idpemilik')
            ->where('role.nama_role', 'Pemilik')
            ->select(
                'pemilik.*',
                'user.nama',
                'user.email',
                'user.email_verified_at',
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
        // Only Resepsionis can create
        if (!Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Anda tidak memiliki akses untuk menambah data pemilik.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);

            // Create pemilik profile
            $pemilik = Pemilik::create([
                'iduser' => $user->iduser,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            // Assign Pemilik role
            $pemilikRole = Role::where('nama_role', 'Pemilik')->first();
            if ($pemilikRole) {
                DB::table('role_user')->insert([
                    'iduser' => $user->iduser,
                    'idrole' => $pemilikRole->idrole,
                    'status' => 1,
                ]);
            }

            DB::commit();

            return redirect()->route('data.pemilik.index')
                ->with('success', 'Data pemilik berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data pemilik: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified pemilik
     */
    public function show($id)
    {
        // Only Resepsionis can view details
        if (!Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat detail pemilik.');
        }

        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.idpemilik', $id)
            ->select('pemilik.*', 'user.nama', 'user.email', 'user.email_verified_at', 'user.created_at')
            ->first();

        if (!$pemilik) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        // Get pets count and recent pets
        $petsCount = DB::table('pet')->where('idpemilik', $id)->count();
        $recentPets = DB::table('pet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('pet.idpemilik', $id)
            ->select(
                'pet.nama',
                'pet.jenis_kelamin',
                'pet.tanggal_lahir',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->orderBy('pet.created_at', 'desc')
            ->limit(5)
            ->get();

        // Get medical records count
        $medicalRecordsCount = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->where('pet.idpemilik', $id)
            ->count();

        return view('data.pemilik.show', compact('pemilik', 'petsCount', 'recentPets', 'medicalRecordsCount'));
    }

    /**
     * Show the form for editing the specified pemilik
     */
    public function edit($id)
    {
        // Only Resepsionis can edit
        if (!Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit data pemilik.');
        }

        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.idpemilik', $id)
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->first();

        if (!$pemilik) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        return view('data.pemilik.edit', compact('pemilik'));
    }

    /**
     * Update the specified pemilik
     */
    public function update(Request $request, $id)
    {
        // Only Resepsionis can update
        if (!Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah data pemilik.');
        }

        $pemilik = Pemilik::findOrFail($id);
        $user = User::findOrFail($pemilik->iduser);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('user', 'email')->ignore($user->iduser, 'iduser'),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $userData = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Update pemilik profile
            $pemilik->update([
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);

            DB::commit();

            return redirect()->route('data.pemilik.index')
                ->with('success', 'Data pemilik berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data pemilik: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified pemilik (soft delete)
     */
    public function destroy($id)
    {
        // Only Resepsionis can delete
        if (!Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus data pemilik.');
        }

        $pemilik = Pemilik::findOrFail($id);

        // Check if pemilik has pets
        /* $petsCount = DB::table('pet')->where('idpemilik', $id)->count();
        if ($petsCount > 0) {
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Tidak dapat menghapus pemilik yang masih memiliki hewan peliharaan');
        } */

        DB::beginTransaction();
        try {
            // Soft delete by deactivating role_user status
            DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', $pemilik->iduser)
                ->where('role.nama_role', 'Pemilik')
                ->update(['role_user.status' => 0]);

            DB::commit();

            return redirect()->route('data.pemilik.index')
                ->with('success', 'Data pemilik berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('data.pemilik.index')
                ->with('error', 'Gagal menghapus data pemilik: ' . $e->getMessage());
        }
    }
}
