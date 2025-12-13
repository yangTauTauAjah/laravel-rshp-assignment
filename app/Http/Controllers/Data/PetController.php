<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RasHewan;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of pets
     */
    public function index()
    {
        // Base query for pets - exclude soft-deleted pets
        $query = Pet::with(['rasHewan.jenisHewan', 'pemilik.user'])->whereNull('deleted_at');
        
        // Apply hierarchical role-based filtering
        if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Resepsionis')) {
            // Administrator and Resepsionis: no query modification, show all pets
            // No additional filtering needed
        } elseif (Auth::user()->hasRole('Pemilik')) {
            // Pemilik: filter query based on pemilik user id
            $pemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if ($pemilikId) {
                $query->where('idpemilik', $pemilikId);
            } else {
                // If pemilik profile not found, show no pets
                $pets = collect();
                $rasHewanList = RasHewan::with('jenisHewan')->get();
                $pemilikList = collect();
                $userRole = 'Pemilik';
                return view('data.pet.index', compact('pets', 'rasHewanList', 'pemilikList', 'userRole'));
            }
        }

        $pets = $query->get();
        
        // Get all breeds for the dropdown
        $rasHewanList = RasHewan::with('jenisHewan')->get();
        
        // Get owners list based on role - exclude deleted owners
        if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Resepsionis')) {
            // Administrator and Resepsionis can see all non-deleted owners
            $pemilikList = Pemilik::with(['user' => function($query) {
                $query->whereNull('deleted_at');
            }])->whereHas('user', function($query) {
                $query->whereNull('deleted_at');
            })->get();
        } elseif (Auth::user()->hasRole('Pemilik')) {
            // Pemilik can only see themselves in the dropdown
            $pemilikList = Pemilik::with(['user' => function($query) {
                $query->whereNull('deleted_at');
            }])->where('iduser', Auth::user()->iduser)->get();
        } else {
            // Other roles get empty list
            $pemilikList = collect();
        }
        
        // Get current user role for the view - hierarchical determination
        $userRole = 'Administrator'; // default for Administrator
        if (Auth::user()->hasRole('Administrator')) {
            $userRole = 'Administrator';
        } elseif (Auth::user()->hasRole('Resepsionis')) {
            $userRole = 'Resepsionis';
        } elseif (Auth::user()->hasRole('Pemilik')) {
            $userRole = 'Pemilik';
        }
        
        return view('data.pet.index', compact('pets', 'rasHewanList', 'pemilikList', 'userRole'));
    }

    /**
     * Store a newly created pet
     */    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date|before:today',
            'warna_tanda' => 'nullable|string|max:45',
            'jenis_kelamin' => 'required|in:M,F',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        // Authorization check for pemilik users - can only add pets for themselves
        if (Auth::user()->hasRole('Pemilik') && !Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
            $userPemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if (!$userPemilikId || $userPemilikId != $request->idpemilik) {
                return redirect()->route('data.pet.index')
                    ->with('error', 'Anda hanya dapat menambahkan hewan peliharaan untuk diri sendiri.');
            }
        }

        Pet::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
        ]);

        return redirect()->route('data.pet.index')
            ->with('success', 'Data hewan peliharaan berhasil ditambahkan');
    }

    /**
     * Show the form for creating a new pet (handled via modal in index view)
     */
    public function create()
    {
        // Since we use modals, redirect to index
        return redirect()->route('data.pet.index');
    }

    /**
     * Show the form for editing the specified pet (handled via modal in index view)
     */
    public function edit($id)
    {
        // Since we use modals, redirect to index
        return redirect()->route('data.pet.index');
    }

    /**
     * Update the specified pet
     */
    public function update(Request $request, $id)
    {
        // Only update non-deleted pets
        $pet = Pet::whereNull('deleted_at')->findOrFail($id);

        // Authorization check for pemilik users - can only edit their own pets
        if (Auth::user()->hasRole('Pemilik') && !Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
            $userPemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if (!$userPemilikId || $userPemilikId != $pet->idpemilik) {
                return redirect()->route('data.pet.index')
                    ->with('error', 'Anda hanya dapat mengedit hewan peliharaan Anda sendiri.');
            }
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date|before:today',
            'warna_tanda' => 'nullable|string|max:45',
            'jenis_kelamin' => 'required|in:M,F',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        // Additional authorization check for pemilik users on idpemilik field
        if (Auth::user()->hasRole('Pemilik') && !Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
            $userPemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if (!$userPemilikId || $userPemilikId != $request->idpemilik) {
                return redirect()->route('data.pet.index')
                    ->with('error', 'Anda hanya dapat mengedit hewan peliharaan untuk diri sendiri.');
            }
        }

        $pet->update([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
        ]);

        return redirect()->route('data.pet.index')
            ->with('success', 'Data hewan peliharaan berhasil diperbarui');
    }

    /**
     * Remove the specified pet
     */
    public function destroy($id)
    {
        try {
            // Only allow deletion of non-deleted pets
            $pet = Pet::whereNull('deleted_at')->findOrFail($id);
            
            // Authorization check for pemilik users - can only delete their own pets
            if (Auth::user()->hasRole('Pemilik') && !Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
                $userPemilikId = DB::table('pemilik')
                    ->where('iduser', Auth::user()->iduser)
                    ->value('idpemilik');
                
                if (!$userPemilikId || $userPemilikId != $pet->idpemilik) {
                    return redirect()->route('data.pet.index')
                        ->with('error', 'Anda hanya dapat menghapus hewan peliharaan Anda sendiri.');
                }
            }

            // Perform soft delete by setting deleted_at timestamp and deleted_by user ID
            $pet->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->iduser
            ]);
        } catch (\Exception $e) {
            return redirect()->route('data.pet.index')
                ->with('error', 'Gagal menghapus hewan peliharaan: ' . $e->getMessage());
        }

        return redirect()->route('data.pet.index')
            ->with('success', 'Data hewan peliharaan berhasil dihapus');
    }

    /**
     * Display the specified pet
     */
    public function show($id)
    {
        // Only show non-deleted pets
        $pet = Pet::with(['rasHewan.jenisHewan', 'pemilik.user'])->whereNull('deleted_at')->findOrFail($id);
        
        // Authorization check for pemilik users - can only view their own pets
        if (Auth::user()->hasRole('Pemilik') && !Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
            $userPemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if (!$userPemilikId || $userPemilikId != $pet->idpemilik) {
                return redirect()->route('data.pet.index')
                    ->with('error', 'Anda hanya dapat melihat hewan peliharaan Anda sendiri.');
            }
        }
        
        // Check if this is an AJAX request
        // if (request()->ajax()) {
            return response()->json([
                'idpet' => $pet->idpet,
                'nama' => $pet->nama,
                'tanggal_lahir' => $pet->tanggal_lahir,
                'warna_tanda' => $pet->warna_tanda,
                'jenis_kelamin' => $pet->jenis_kelamin,
                'idpemilik' => $pet->idpemilik,
                'idras_hewan' => $pet->idras_hewan,
            ]);
        // }
        
        // return view('data.pet.show', compact('pet'));
    }
}
