<?php

namespace App\Http\Controllers\Data;

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
        // Base query for pets
        $query = Pet::with(['rasHewan.jenisHewan', 'pemilik.user']);
        
        // Apply role-based filtering
        if (Auth::user()->hasRole('Administrator')) {
            // Administrator: Full access to all pets
            // No filtering needed
        } elseif (Auth::user()->hasRole('Pemilik')) {
            // Pemilik users: only show their own pets
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
        // For Resepsionis, Dokter, Perawat: show all pets

        $pets = $query->get();
        
        // Get all breeds for the dropdown
        $rasHewanList = RasHewan::with('jenisHewan')->get();
        
        // Get owners list based on role
        if (Auth::user()->hasRole('Pemilik')) {
            // Pemilik can only see themselves in the dropdown
            $pemilikList = Pemilik::with('user')->where('iduser', Auth::user()->iduser)->get();
        } else {
            // Resepsionis can see all owners
            $pemilikList = Pemilik::with('user')->get();
        }
        
        // Get current user role for the view
        $userRole = 'Resepsionis'; // default
        if (Auth::user()->hasRole('Pemilik')) {
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
        if (Auth::user()->hasRole('Pemilik')) {
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
     * Show the form for creating a new pet
     */
    public function create()
    {
        // Get all breeds for the dropdown
        $rasHewanList = RasHewan::with('jenisHewan')->get();
        
        // Get owners list based on role
        if (Auth::user()->hasRole('Pemilik')) {
            // Pemilik can only add pets for themselves
            $pemilikList = Pemilik::with('user')->where('iduser', Auth::user()->iduser)->get();
        } else {
            // Resepsionis can see all owners
            $pemilikList = Pemilik::with('user')->get();
        }
        
        return view('data.pet.create', compact('rasHewanList', 'pemilikList'));
    }

    /**
     * Show the form for editing the specified pet
     */
    public function edit($id)
    {
        $pet = Pet::with(['rasHewan.jenisHewan', 'pemilik.user'])->findOrFail($id);
        
        // Authorization check for pemilik users - can only edit their own pets
        if (Auth::user()->hasRole('Pemilik')) {
            $userPemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if (!$userPemilikId || $userPemilikId != $pet->idpemilik) {
                return redirect()->route('data.pet.index')
                    ->with('error', 'Anda hanya dapat mengedit hewan peliharaan Anda sendiri.');
            }
        }
        
        // Get all breeds for the dropdown
        $rasHewanList = RasHewan::with('jenisHewan')->get();
        
        // Get owners list based on role
        if (Auth::user()->hasRole('Pemilik')) {
            // Pemilik can only see themselves in the dropdown
            $pemilikList = Pemilik::with('user')->where('iduser', Auth::user()->iduser)->get();
        } else {
            // Resepsionis can see all owners
            $pemilikList = Pemilik::with('user')->get();
        }
        
        return view('data.pet.edit', compact('pet', 'rasHewanList', 'pemilikList'));
    }

    /**
     * Update the specified pet
     */    
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        // Authorization check for pemilik users - can only edit their own pets
        if (Auth::user()->hasRole('Pemilik')) {
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
        if (Auth::user()->hasRole('Pemilik')) {
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
        $pet = Pet::findOrFail($id);
        
        // Authorization check for pemilik users - can only delete their own pets
        if (Auth::user()->hasRole('Pemilik')) {
            $userPemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if (!$userPemilikId || $userPemilikId != $pet->idpemilik) {
                return redirect()->route('data.pet.index')
                    ->with('error', 'Anda hanya dapat menghapus hewan peliharaan Anda sendiri.');
            }
        }
        
        // Check if pet has medical records
        if ($pet->rekamMedis()->count() > 0) {
            return redirect()->route('data.pet.index')
                ->with('error', 'Tidak dapat menghapus hewan yang memiliki rekam medis');
        }

        $pet->delete();

        return redirect()->route('data.pet.index')
            ->with('success', 'Data hewan peliharaan berhasil dihapus');
    }

    /**
     * Display the specified pet
     */
    public function show($id)
    {
        $pet = Pet::with(['rasHewan.jenisHewan', 'pemilik.user'])->findOrFail($id);
        
        // Authorization check for pemilik users - can only view their own pets
        if (Auth::user()->hasRole('Pemilik')) {
            $userPemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if (!$userPemilikId || $userPemilikId != $pet->idpemilik) {
                return redirect()->route('data.pet.index')
                    ->with('error', 'Anda hanya dapat melihat hewan peliharaan Anda sendiri.');
            }
        }
        
        // Return JSON for AJAX requests
        return response()->json([
            'idpet' => $pet->idpet,
            'nama' => $pet->nama,
            'tanggal_lahir' => $pet->tanggal_lahir,
            'warna_tanda' => $pet->warna_tanda,
            'jenis_kelamin' => $pet->jenis_kelamin,
            'idpemilik' => $pet->idpemilik,
            'idras_hewan' => $pet->idras_hewan,
        ]);
    }
}
