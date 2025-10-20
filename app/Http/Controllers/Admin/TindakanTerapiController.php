<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TindakanTerapiController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $kategoriKlinises = KategoriKlinis::orderBy('nama_kategori_klinis')->get();
        $kodeTindakanTerapis = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])
            ->orderBy('kode')
            ->get();
        
        return view('admin.tindakan-terapi.index', compact('kategoris', 'kategoriKlinises', 'kodeTindakanTerapis'));
    }

    // ===== KATEGORI METHODS =====
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id . ',idkategori'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Check if kategori has related kode tindakan terapi
        if ($kategori->kodeTindakanTerapi()->count() > 0) {
            return redirect()->route('admin.tindakan-terapi.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki kode tindakan terapi terkait');
        }

        $kategori->delete();

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kategori berhasil dihapus');
    }

    // ===== KATEGORI KLINIS METHODS =====
    public function storeKategoriKlinis(Request $request)
    {
        $request->validate([
            'nama_kategori_klinis' => 'required|string|max:255|unique:kategori_klinis,nama_kategori_klinis'
        ]);

        KategoriKlinis::create([
            'nama_kategori_klinis' => $request->nama_kategori_klinis
        ]);

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kategori Klinis berhasil ditambahkan');
    }

    public function updateKategoriKlinis(Request $request, $id)
    {
        $kategoriKlinis = KategoriKlinis::findOrFail($id);

        $request->validate([
            'nama_kategori_klinis' => 'required|string|max:255|unique:kategori_klinis,nama_kategori_klinis,' . $id . ',idkategori_klinis'
        ]);

        $kategoriKlinis->update([
            'nama_kategori_klinis' => $request->nama_kategori_klinis
        ]);

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kategori Klinis berhasil diperbarui');
    }

    public function destroyKategoriKlinis($id)
    {
        $kategoriKlinis = KategoriKlinis::findOrFail($id);

        // Check if kategori klinis has related kode tindakan terapi
        if ($kategoriKlinis->kodeTindakanTerapi()->count() > 0) {
            return redirect()->route('admin.tindakan-terapi.index')
                ->with('error', 'Kategori Klinis tidak dapat dihapus karena masih memiliki kode tindakan terapi terkait');
        }

        $kategoriKlinis->delete();

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kategori Klinis berhasil dihapus');
    }

    // ===== KODE TINDAKAN TERAPI METHODS =====
    public function storeKodeTindakan(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:kode_tindakan_terapi,kode',
            'deskripsi_tindakan_terapi' => 'required|string',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis'
        ]);

        KodeTindakanTerapi::create([
            'kode' => $request->kode,
            'deskripsi_tindakan_terapi' => $request->deskripsi_tindakan_terapi,
            'idkategori' => $request->idkategori,
            'idkategori_klinis' => $request->idkategori_klinis
        ]);

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kode Tindakan Terapi berhasil ditambahkan');
    }

    public function editKodeTindakan($id)
    {
        $kodeTindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->findOrFail($id);
        return response()->json($kodeTindakan);
    }

    public function updateKodeTindakan(Request $request, $id)
    {
        $kodeTindakan = KodeTindakanTerapi::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:50|unique:kode_tindakan_terapi,kode,' . $id . ',idkode_tindakan_terapi',
            'deskripsi_tindakan_terapi' => 'required|string',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis'
        ]);

        $kodeTindakan->update([
            'kode' => $request->kode,
            'deskripsi_tindakan_terapi' => $request->deskripsi_tindakan_terapi,
            'idkategori' => $request->idkategori,
            'idkategori_klinis' => $request->idkategori_klinis
        ]);

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kode Tindakan Terapi berhasil diperbarui');
    }

    public function destroyKodeTindakan($id)
    {
        $kodeTindakan = KodeTindakanTerapi::findOrFail($id);

        // Check if kode tindakan has related detail rekam medis
        if ($kodeTindakan->detailRekamMedis()->count() > 0) {
            return redirect()->route('admin.tindakan-terapi.index')
                ->with('error', 'Kode Tindakan Terapi tidak dapat dihapus karena sudah digunakan dalam rekam medis');
        }

        $kodeTindakan->delete();

        return redirect()->route('admin.tindakan-terapi.index')
            ->with('success', 'Kode Tindakan Terapi berhasil dihapus');
    }
}
