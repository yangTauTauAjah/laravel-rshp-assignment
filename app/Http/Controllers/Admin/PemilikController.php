<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{    /**
     * Display a listing of pet owners
     */
    public function index()
    {
        // Query Builder: pemilik with user data and pets count
        $pemilikList = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->leftJoin('pet', 'pemilik.idpemilik', '=', 'pet.idpemilik')
            ->select(
                'pemilik.*', 
                'user.nama', 
                'user.email',
                DB::raw('COUNT(pet.idpet) as pets_count')
            )
            ->groupBy('pemilik.idpemilik', 'pemilik.iduser', 'pemilik.no_wa', 'pemilik.alamat', 'user.nama', 'user.email')
            ->get();

        // Users not in pemilik
        $existingPemilikUserIds = DB::table('pemilik')->pluck('iduser')->toArray();
        $availableUsers = DB::table('user')
            ->whereNotIn('iduser', $existingPemilikUserIds)
            ->select('iduser', 'nama', 'email')
            ->get();

        return view('admin.pemilik.index', compact('pemilikList', 'availableUsers'));
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
                return redirect()->route('admin.pemilik.index')
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

                DB::commit();

                return redirect()->route('admin.pemilik.index')
                    ->with('success', 'Data pemilik hewan berhasil ditambahkan dari user yang sudah ada');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('admin.pemilik.index')
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

                return redirect()->route('admin.pemilik.index')
                    ->with('success', 'Data pemilik hewan berhasil ditambahkan dengan user baru');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('admin.pemilik.index')
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

            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Data pemilik hewan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Gagal memperbarui data pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified pemilik
     */
    public function destroy($id)
    {
        $pemilik = Pemilik::findOrFail($id);
        
        // Check if pemilik has pets
        if ($pemilik->pets()->count() > 0) {
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Tidak dapat menghapus pemilik yang memiliki hewan peliharaan terdaftar');
        }

        DB::beginTransaction();
        try {
            $user = $pemilik->user;
            
            // Delete pemilik first
            $pemilik->delete();
            
            // Then delete the associated user
            // $user->delete();

            DB::commit();

            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Data pemilik hewan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Gagal menghapus data pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Get pemilik details for AJAX
     */
    public function show($id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);
        
        return response()->json([
            'idpemilik' => $pemilik->idpemilik,
            'iduser' => $pemilik->iduser,
            'nama' => $pemilik->user->nama,
            'email' => $pemilik->user->email,
            'no_wa' => $pemilik->no_wa,
            'alamat' => $pemilik->alamat,
            'pets_count' => $pemilik->pets()->count(),
        ]);
    }
}
