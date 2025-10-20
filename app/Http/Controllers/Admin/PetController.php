<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RasHewan;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of pets
     */
    public function index()
    {
        // Get all pets with their relationships
        $pets = Pet::with(['rasHewan.jenisHewan', 'pemilik.user'])->get();
        
        // Get all breeds for the dropdown
        $rasHewanList = RasHewan::with('jenisHewan')->get();
        
        // Get all owners for the dropdown
        $pemilikList = Pemilik::with('user')->get();
        
        return view('admin.pet.index', compact('pets', 'rasHewanList', 'pemilikList'));
    }

    /**
     * Store a newly created pet
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'warna_tanda' => 'nullable|string|max:45',
            'jenis_kelamin' => 'required|in:M,F',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        Pet::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
        ]);

        return redirect()->route('admin.pet.index')
            ->with('success', 'Data hewan peliharaan berhasil ditambahkan');
    }

    /**
     * Update the specified pet
     */
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'warna_tanda' => 'nullable|string|max:45',
            'jenis_kelamin' => 'required|in:M,F',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        $pet->update([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => $request->warna_tanda,
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
        ]);

        return redirect()->route('admin.pet.index')
            ->with('success', 'Data hewan peliharaan berhasil diperbarui');
    }

    /**
     * Remove the specified pet
     */
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        
        // Check if pet has medical records
        if ($pet->rekamMedis()->count() > 0) {
            return redirect()->route('admin.pet.index')
                ->with('error', 'Tidak dapat menghapus hewan yang memiliki rekam medis');
        }

        $pet->delete();

        return redirect()->route('admin.pet.index')
            ->with('success', 'Data hewan peliharaan berhasil dihapus');
    }

    /**
     * Get pet details for AJAX
     */
    public function show($id)
    {
        $pet = Pet::with(['rasHewan.jenisHewan', 'pemilik.user'])->findOrFail($id);
        
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
