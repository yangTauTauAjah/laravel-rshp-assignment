<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisHewan;
use App\Models\RasHewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JenisHewanController extends Controller
{
    public function index()
    {
        $jenisHewan = JenisHewan::with('rasHewan')->get();
        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }

    public function storeJenis(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis_hewan' => 'required|string|max:100',
        ]);

        JenisHewan::create($validated);

        return redirect()->route('jenis-hewan.index')->with('success', 'Jenis hewan berhasil ditambahkan');
    }

    public function destroyJenis($id)
    {
        $jenis = JenisHewan::findOrFail($id);
        
        // Check if there are related breeds
        if ($jenis->rasHewan()->count() > 0) {
            return redirect()->route('jenis-hewan.index')->with('error', 'Tidak dapat menghapus jenis hewan yang masih memiliki ras');
        }

        $jenis->delete();

        return redirect()->route('jenis-hewan.index')->with('success', 'Jenis hewan berhasil dihapus');
    }

    public function storeRas(Request $request)
    {
        $validated = $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        RasHewan::create($validated);

        return redirect()->route('jenis-hewan.index')->with('success', 'Ras hewan berhasil ditambahkan');
    }

    public function updateRas(Request $request, $id)
    {
        $ras = RasHewan::findOrFail($id);

        $validated = $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        $ras->update($validated);

        return redirect()->route('jenis-hewan.index')->with('success', 'Ras hewan berhasil diperbarui');
    }

    public function destroyRas($id)
    {
        $ras = RasHewan::findOrFail($id);
        $ras->delete();

        return redirect()->route('jenis-hewan.index')->with('success', 'Ras hewan berhasil dihapus');
    }
}
