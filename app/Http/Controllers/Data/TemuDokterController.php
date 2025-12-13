<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of doctor appointments
     */
    public function index()
    {
        // Base query for temu dokter
        $query = DB::table('temu_dokter')
            ->join('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.nama_role', 'Dokter');

        // Apply hierarchical role-based filtering
        if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Resepsionis') || Auth::user()->hasRole('Perawat')) {
            // Administrator, Resepsionis, Perawat: no query modification, show all appointments
            // No additional filtering needed
        } elseif (Auth::user()->hasRole('Dokter')) {
            // Dokter: filter query based on dokter id
            $dokterRoleUserId = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if ($dokterRoleUserId) {
                $query->where('temu_dokter.idrole_user', $dokterRoleUserId);
            } else {
                // If no active dokter role found, show no appointments
                return view('data.temu-dokter.index', ['temuDokterList' => collect(), 'doctors' => collect()]);
            }
        } elseif (Auth::user()->hasRole('Pemilik')) {
            // Pemilik: filter query based on pemilik user id
            $pemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if ($pemilikId) {
                $query->join('rekam_medis', 'temu_dokter.idreservasi_dokter', '=', 'rekam_medis.idreservasi_dokter')
                    ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                    ->where('pet.idpemilik', $pemilikId);
            } else {
                // If pemilik profile not found, show no appointments
                return view('data.temu-dokter.index', ['temuDokterList' => collect(), 'doctors' => collect()]);
            }
        }

        $temuDokterList = $query->select(
                'temu_dokter.*',
                'user.nama as dokter_nama',
                'user.email as dokter_email',
                'role.nama_role'
            )
            ->orderBy('temu_dokter.waktu_daftar', 'desc')
            ->get();

        // Get doctors for dropdown (only for Administrator and Resepsionis)
        $doctors = collect();
        if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Resepsionis')) {
            $doctors = DB::table('role_user')
                ->join('user', 'role_user.iduser', '=', 'user.iduser')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->select('role_user.idrole_user', 'user.nama')
                ->get();
        }

        return view('data.temu-dokter.index', compact('temuDokterList', 'doctors'));
    }

    /**
     * Show the form for creating a new appointment
     */
    public function create()
    {
        // Only Administrator, Resepsionis and Pemilik can create appointments
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis') && !Auth::user()->hasRole('Pemilik')) {
            return redirect()->route('data.temu-dokter.index')
                ->with('error', 'Anda tidak memiliki akses untuk membuat janji temu.');
        }

        // Get active doctors
        $doctors = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.nama_role', 'Dokter')
            ->where('role_user.status', 1)
            ->select('role_user.idrole_user', 'user.nama')
            ->get();

        return view('data.temu-dokter.create', compact('doctors'));
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request)
    {
        // Only Administrator, Resepsionis and Pemilik can create appointments
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis') && !Auth::user()->hasRole('Pemilik')) {
            return redirect()->route('data.temu-dokter.index')
                ->with('error', 'Anda tidak memiliki akses untuk membuat janji temu.');
        }

        $request->validate([
            'idrole_user' => 'required|exists:role_user,idrole_user',
            'waktu_daftar' => 'required|date',
            'no_urut' => 'nullable|integer|min:1'
        ]);

        try {
            // Get next queue number if not provided
            $noUrut = $request->no_urut;
            if (!$noUrut) {
                $maxUrut = DB::table('temu_dokter')
                    ->where('idrole_user', $request->idrole_user)
                    ->whereDate('waktu_daftar', date('Y-m-d', strtotime($request->waktu_daftar)))
                    ->max('no_urut');
                $noUrut = ($maxUrut ?? 0) + 1;
            }

            $appointmentId = DB::table('temu_dokter')->insertGetId([
                'idrole_user' => $request->idrole_user,
                'waktu_daftar' => $request->waktu_daftar,
                'no_urut' => $noUrut,
                'status' => '0' // Menunggu
            ]);

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reservasi dokter berhasil ditambahkan',
                    'data' => ['id' => $appointmentId]
                ]);
            }

            return redirect()->route('data.temu-dokter.index')
                ->with('success', 'Reservasi dokter berhasil ditambahkan');
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan reservasi: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->with('error', 'Gagal menambahkan reservasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified appointment
     */
    public function show($id)
    {
        $temuDokter = DB::table('temu_dokter')
            ->join('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('temu_dokter.idreservasi_dokter', $id)
            ->select(
                'temu_dokter.*',
                'user.nama as dokter_nama',
                'user.email as dokter_email',
                'role.nama_role'
            )
            ->first();

        if (!$temuDokter) {
            return redirect()->route('data.temu-dokter.index')
                ->with('error', 'Data reservasi tidak ditemukan');
        }

        // Authorization check for Pemilik
        if (Auth::user()->hasRole('Pemilik')) {
            $pemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if ($pemilikId) {
                $hasAccess = DB::table('rekam_medis')
                    ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                    ->where('rekam_medis.idreservasi_dokter', $id)
                    ->where('pet.idpemilik', $pemilikId)
                    ->exists();
                
                if (!$hasAccess) {
                    return redirect()->route('data.temu-dokter.index')
                        ->with('error', 'Anda tidak memiliki akses untuk melihat reservasi ini.');
                }
            }
        }

        // Get related medical records
        $rekamMedisList = DB::table('rekam_medis')
            ->leftJoin('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->leftJoin('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->leftJoin('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
            ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('rekam_medis.idreservasi_dokter', $id)
            ->select(
                'rekam_medis.*',
                'pet.nama as pet_nama',
                'pet.jenis_kelamin',
                'pemilik_user.nama as pemilik_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->orderBy('rekam_medis.created_at', 'desc')
            ->get();

        // Get pets for adding new rekam medis
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

        return view('data.temu-dokter.show', compact('temuDokter', 'rekamMedisList', 'pets'));
    }

    /**
     * Show the form for editing the specified appointment
     */
    public function edit($id)
    {
        // Only Administrator and Resepsionis can edit appointments
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.temu-dokter.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit janji temu.');
        }

        $temuDokter = DB::table('temu_dokter')
            ->where('idreservasi_dokter', $id)
            ->first();

        if (!$temuDokter) {
            return redirect()->route('data.temu-dokter.index')
                ->with('error', 'Data reservasi tidak ditemukan');
        }

        // Get active doctors
        $doctors = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.nama_role', 'Dokter')
            ->where('role_user.status', 1)
            ->select('role_user.idrole_user', 'user.nama')
            ->get();

        return view('data.temu-dokter.edit', compact('temuDokter', 'doctors'));
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, $id)
    {
        // Only Administrator and Resepsionis can edit appointments
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
            return redirect()->route('data.temu-dokter.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit janji temu.');
        }

        $request->validate([
            'idrole_user' => 'required|exists:role_user,idrole_user',
            'waktu_daftar' => 'required|date',
            'no_urut' => 'nullable|integer|min:1',
            'status' => 'required|in:0,1,2'
        ]);

        try {
            $affected = DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->update([
                    'idrole_user' => $request->idrole_user,
                    'waktu_daftar' => $request->waktu_daftar,
                    'no_urut' => $request->no_urut,
                    'status' => $request->status
                ]);

            if ($affected === 0) {
                return redirect()->route('data.temu-dokter.index')
                    ->with('error', 'Data reservasi tidak ditemukan');
            }

            return redirect()->route('data.temu-dokter.index')
                ->with('success', 'Data reservasi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified appointment
     */
    public function destroy($id)
    {
        try {
            $affected = DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->delete();

            if ($affected === 0) {
                return redirect()->route('data.temu-dokter.index')
                    ->with('error', 'Data reservasi tidak ditemukan');
            }

            return redirect()->route('data.temu-dokter.index')
                ->with('success', 'Data reservasi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data.temu-dokter.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, $id)
    {
        // Only Administrator and Resepsionis can update status
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Resepsionis')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah status.'
            ], 403);
        }

        $request->validate([
            'status' => 'required|in:0,1,2'
        ]);

        try {
            $affected = DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->update(['status' => $request->status]);

            if ($affected === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data reservasi tidak ditemukan'
                ], 404);
            }

            $statusText = match($request->status) {
                '0' => 'Menunggu',
                '1' => 'Selesai',
                '2' => 'Batal'
            };

            return response()->json([
                'success' => true,
                'message' => "Status berhasil diubah menjadi {$statusText}",
                'status' => $request->status,
                'status_text' => $statusText
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store rekam medis for specific temu dokter
     */
    public function storeRekamMedis(Request $request, $temuDokterId)
    {
        $request->validate([
            'anamnesa' => 'required|string',
            'temuan_klinis' => 'required|string',
            'diagnosa' => 'required|string',
            'idpet' => 'required|exists:pet,idpet',
            'detail_tindakan' => 'array',
            'detail_tindakan.*.idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail_tindakan.*.detail' => 'nullable|string',
        ]);

        // Verify temu dokter exists
        $temuDokter = DB::table('temu_dokter')->where('idreservasi_dokter', $temuDokterId)->first();
        if (!$temuDokter) {
            return response()->json([
                'success' => false,
                'message' => 'Data reservasi dokter tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Insert medical record with temu dokter relationship
            $rekamMedisId = DB::table('rekam_medis')->insertGetId([
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'idpet' => $request->idpet,
                'dokter_pemeriksa' => $temuDokter->idrole_user,
                'idreservasi_dokter' => $temuDokterId,
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

            return response()->json([
                'success' => true,
                'message' => 'Rekam medis berhasil ditambahkan',
                'data' => ['id' => $rekamMedisId]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan rekam medis: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove rekam medis from temu dokter
     */
    public function destroyRekamMedis($temuDokterId, $rekamMedisId)
    {
        try {
            // Verify the rekam medis belongs to this temu dokter
            $rekamMedis = DB::table('rekam_medis')
                ->where('idrekam_medis', $rekamMedisId)
                ->where('idreservasi_dokter', $temuDokterId)
                ->first();

            if (!$rekamMedis) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekam medis tidak ditemukan atau tidak terkait dengan reservasi ini'
                ], 404);
            }

            // Delete detail records first (due to foreign key)
            DB::table('detail_rekam_medis')->where('idrekam_medis', $rekamMedisId)->delete();
            
            // Delete rekam medis
            DB::table('rekam_medis')->where('idrekam_medis', $rekamMedisId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rekam medis berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus rekam medis: ' . $e->getMessage()
            ], 500);
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
                'kode_tindakan_terapi.*',
                'kategori.nama_kategori',
                'kategori_klinis.nama_kategori_klinis'
            )
            ->orderBy('kode_tindakan_terapi.kode')
            ->get();

        return response()->json($kodeTindakan);
    }
}
