<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of medical records
     */    public function index()
    {
        // Get all medical records with related data using Query Builder
        $rekamMedisList = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
            ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->join('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select(
                'rekam_medis.*',
                'pet.nama as pet_nama',
                'pet.jenis_kelamin',
                'pemilik_user.nama as pemilik_nama',
                'dokter_user.nama as dokter_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->orderBy('rekam_medis.created_at', 'desc')
            ->get();

        // Get pets with their owners for modal
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select(
                'pet.*',
                'user.nama as pemilik_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get();

        // Get doctors (users with role dokter) for modal
        $doctors = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.nama_role', 'Dokter')
            ->where('role_user.status', 1)
            ->select('role_user.idrole_user', 'user.nama')
            ->get();

        return view('admin.rekam-medis.index', compact('rekamMedisList', 'pets', 'doctors'));
    }

    /**
     * Show the form for creating a new medical record
     */
    public function create()
    {
        // Get pets with their owners
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select(
                'pet.*',
                'user.nama as pemilik_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get();

        // Get doctors (users with role dokter)
        $doctors = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.nama_role', 'Dokter')
            ->where('role_user.status', 1)
            ->select('role_user.idrole_user', 'user.nama')
            ->get();

        return view('admin.rekam-medis.create', compact('pets', 'doctors'));
    }    /**
     * Store a newly created medical record
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'anamnesa' => 'required|string',
                'temuan_klinis' => 'required|string',
                'diagnosa' => 'required|string',
                'idpet' => 'required|exists:pet,idpet',
                'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
                'detail_tindakan' => 'array',
                'detail_tindakan.*.idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
                'detail_tindakan.*.detail' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return JSON response for AJAX requests on validation failure
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e; // Re-throw for non-AJAX requests
        }

        DB::beginTransaction();
        try {
            // Insert medical record
            $rekamMedisId = DB::table('rekam_medis')->insertGetId([
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'idpet' => $request->idpet,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
                'created_at' => now(),
            ]);

            // Insert detail records if provided
            if ($request->has('detail_tindakan') && is_array($request->detail_tindakan)) {
                foreach ($request->detail_tindakan as $detail) {
                    if (!empty($detail['idkode_tindakan_terapi'])) {
                        DB::table('detail_rekam_medis')->insert([
                            'idrekam_medis' => $rekamMedisId,
                            'idkode_tindakan_terapi' => $detail['idkode_tindakan_terapi'],
                            'detail' => $detail['detail'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rekam medis berhasil ditambahkan',
                    'data' => [
                        'id' => $rekamMedisId
                    ]
                ]);
            }

            return redirect()->route('admin.rekam-medis.index')
                ->with('success', 'Rekam medis berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan rekam medis: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->with('error', 'Gagal menambahkan rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified medical record
     */
    public function show($id)
    {
        // Get medical record with related data
        $rekamMedis = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
            ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->join('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('rekam_medis.idrekam_medis', $id)
            ->select(
                'rekam_medis.*',
                'pet.nama as pet_nama',
                'pet.tanggal_lahir as pet_tanggal_lahir',
                'pet.jenis_kelamin',
                'pet.warna_tanda',
                'pemilik.no_wa as pemilik_no_wa',
                'pemilik.alamat as pemilik_alamat',
                'pemilik_user.nama as pemilik_nama',
                'pemilik_user.email as pemilik_email',
                'dokter_user.nama as dokter_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->first();

        if (!$rekamMedis) {
            abort(404);
        }

        // Get detail medical records
        $detailRekamMedis = DB::table('detail_rekam_medis')
            ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
            ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->where('detail_rekam_medis.idrekam_medis', $id)
            ->select(
                'detail_rekam_medis.*',
                'kode_tindakan_terapi.kode',
                'kode_tindakan_terapi.deskripsi_tindakan_terapi',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->get();

        return view('admin.rekam-medis.show', compact('rekamMedis', 'detailRekamMedis'));
    }

    /**
     * Show the form for editing the specified medical record
     */
    public function edit($id)
    {
        // Get medical record
        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (!$rekamMedis) {
            abort(404);
        }

        // Get pets with their owners
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select(
                'pet.*',
                'user.nama as pemilik_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get();

        // Get doctors
        $doctors = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.nama_role', 'Dokter')
            ->where('role_user.status', 1)
            ->select('role_user.idrole_user', 'user.nama')
            ->get();

        // Get existing detail records
        $detailRekamMedis = DB::table('detail_rekam_medis')
            ->where('idrekam_medis', $id)
            ->get();

        // Get treatment codes
        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->select(
                'kode_tindakan_terapi.*',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->get();

        return view('admin.rekam-medis.edit', compact('rekamMedis', 'pets', 'doctors', 'detailRekamMedis', 'kodeTindakan'));
    }

    /**
     * Update the specified medical record
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'anamnesa' => 'required|string',
            'temuan_klinis' => 'required|string',
            'diagnosa' => 'required|string',
            'idpet' => 'required|exists:pet,idpet',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
        ]);

        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (!$rekamMedis) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            // Update medical record
            DB::table('rekam_medis')->where('idrekam_medis', $id)->update([
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'idpet' => $request->idpet,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
            ]);

            DB::commit();

            return redirect()->route('admin.rekam-medis.index')
                ->with('success', 'Rekam medis berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified medical record
     */
    public function destroy($id)
    {
        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (!$rekamMedis) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            // Delete detail records first
            DB::table('detail_rekam_medis')->where('idrekam_medis', $id)->delete();
            
            // Delete medical record
            DB::table('rekam_medis')->where('idrekam_medis', $id)->delete();

            DB::commit();

            return redirect()->route('admin.rekam-medis.index')
                ->with('success', 'Rekam medis berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.rekam-medis.index')
                ->with('error', 'Gagal menghapus rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Get treatment codes for AJAX
     */
    public function getKodeTindakan()
    {
        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->select(
                'kode_tindakan_terapi.idkode_tindakan_terapi',
                'kode_tindakan_terapi.kode',
                'kode_tindakan_terapi.deskripsi_tindakan_terapi',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->get();

        return response()->json($kodeTindakan);
    }
}
