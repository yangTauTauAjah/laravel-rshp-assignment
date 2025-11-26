<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use App\Services\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    protected $userProfileService;

    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }
    /**
     * Display a listing of dokter profiles
     */
    public function index()
    {
        $dokterList = DB::table('dokter')
            ->join('user', 'dokter.iduser', '=', 'user.iduser')
            ->select(
                'dokter.*',
                'user.nama',
                'user.email'/* ,
                'user.status as user_status' */
            )
            ->orderBy('user.nama')
            ->get();

        return view('admin.dokter.index', compact('dokterList'));
    }

    /**
     * Show the form for creating a new dokter profile
     */
    public function create()
    {
        // Get users who don't have Dokter role yet
        $availableUsers = DB::table('user')
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('role_user')
                    ->join('role', 'role_user.idrole', '=', 'role.idrole')
                    ->where('role.nama_role', 'Dokter')
                    ->whereColumn('role_user.iduser', 'user.iduser');
            })
            ->select('user.iduser', 'user.nama', 'user.email')
            ->orderBy('user.nama')
            ->get();

        return view('admin.dokter.create', compact('availableUsers'));
    }

    /**
     * Show form for creating new user and dokter profile simultaneously
     */
    public function createWithUser()
    {
        return view('admin.dokter.create-with-user');
    }

    /**
     * Store a newly created dokter profile
     */
    public function store(Request $request)
    {
        // Check if we're creating a new user or using existing user
        if ($request->has('create_new_user') && $request->create_new_user == '1') {
            return $this->storeWithNewUser($request);
        }

        $request->validate([
            'iduser' => 'required|exists:user,iduser|unique:dokter,iduser',
            'alamat' => 'required|string|max:100',
            'no_hp' => 'required|string|max:45',
            'bidang_dokter' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:M,F'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Create dokter profile
                Dokter::create($request->all());

                // Assign Dokter role to the user
                $dokterRole = DB::table('role')->where('nama_role', 'Dokter')->first();
                if ($dokterRole) {
                    // Check if user doesn't already have this role
                    $existingRole = DB::table('role_user')
                        ->where('iduser', $request->iduser)
                        ->where('idrole', $dokterRole->idrole)
                        ->exists();
                    
                    if (!$existingRole) {
                        DB::table('role_user')->insert([
                            'iduser' => $request->iduser,
                            'idrole' => $dokterRole->idrole
                        ]);
                    }
                }
            });

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Profil dokter berhasil ditambahkan dan role Dokter telah diberikan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan profil dokter: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store a newly created user with dokter profile
     */
    public function storeWithNewUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string|max:100',
            'no_hp' => 'required|string|max:45',
            'bidang_dokter' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:M,F'
        ]);

        try {
            $result = $this->userProfileService->createUserWithProfile(
                [
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'password' => $request->password,
                ],
                'Dokter',
                [
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'bidang_dokter' => $request->bidang_dokter,
                    'jenis_kelamin' => $request->jenis_kelamin,
                ]
            );

            return redirect()->route('admin.dokter.index')
                ->with('success', 'User dan profil dokter berhasil dibuat dengan role Dokter');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat user dan profil dokter: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified dokter profile
     */
    public function show($id)
    {
        $dokter = DB::table('dokter')
            ->join('user', 'dokter.iduser', '=', 'user.iduser')
            ->where('dokter.iddokter', $id)
            ->select(
                'dokter.*',
                'user.nama',
                'user.email',
                // 'user.status as user_status',
                // 'user.created_at as user_created_at'
            )
            ->first();

        if (!$dokter) {
            return redirect()->route('admin.dokter.index')
                ->with('error', 'Profil dokter tidak ditemukan');
        }

        return view('admin.dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified dokter profile
     */
    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);
        
        return view('admin.dokter.edit', compact('dokter'));
    }

    /**
     * Update the specified dokter profile
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'alamat' => 'required|string|max:100',
            'no_hp' => 'required|string|max:45',
            'bidang_dokter' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:M,F'
        ]);

        try {
            $dokter = Dokter::findOrFail($id);
            $dokter->update($request->only(['alamat', 'no_hp', 'bidang_dokter', 'jenis_kelamin']));

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Profil dokter berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil dokter: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified dokter profile
     */
    public function destroy($id)
    {
        try {
            $dokter = Dokter::findOrFail($id);
            $dokter->delete();

            return redirect()->route('admin.dokter.index')
                ->with('success', 'Profil dokter berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.dokter.index')
                ->with('error', 'Gagal menghapus profil dokter: ' . $e->getMessage());
        }
    }
}
