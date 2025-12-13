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
     */
    public function index()
    {
        // Build base query for medical records
        $query = DB::table('rekam_medis')
            ->join('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
            ->join('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->join('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan');
            
        // Apply hierarchical role-based filtering
        if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Perawat')) {
            // Administrator, Perawat: no query modification, show all records
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
                $query->where('rekam_medis.dokter_pemeriksa', $dokterRoleUserId);
            } else {
                // If no active dokter role found, return empty result
                $rekamMedisList = collect();
                $pets = collect();
                $doctors = collect();
                $userRole = 'Dokter';
                return view('data.rekam-medis.index', compact('rekamMedisList', 'pets', 'doctors', 'userRole'));
            }
        } elseif (Auth::user()->hasRole('Pemilik')) {
            // Pemilik: filter query based on pemilik user id
            $pemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if ($pemilikId) {
                $query->where('pet.idpemilik', $pemilikId);
            } else {
                // If no pemilik profile found, return empty result
                $rekamMedisList = collect();
                $pets = collect();
                $doctors = collect();
                $userRole = 'Pemilik';
                return view('data.rekam-medis.index', compact('rekamMedisList', 'pets', 'doctors', 'userRole'));
            }
        }

        $rekamMedisList = $query
            ->select(
                'rekam_medis.*',
                'pet.nama as pet_nama',
                'pet.jenis_kelamin',
                'pemilik_user.nama as pemilik_nama',
                'dokter_user.nama as dokter_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'temu_dokter.no_urut',
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
        
        // Get current user role for the view - hierarchical determination
        $userRole = 'Administrator'; // default for Administrator
        if (Auth::user()->hasRole('Administrator')) {
            $userRole = 'Administrator';
        } elseif (Auth::user()->hasRole('Perawat')) {
            $userRole = 'Perawat';
        } elseif (Auth::user()->hasRole('Dokter')) {
            $userRole = 'Dokter';
        } elseif (Auth::user()->hasRole('Pemilik')) {
            $userRole = 'Pemilik';
        } elseif (Auth::user()->hasRole('Resepsionis')) {
            $userRole = 'Resepsionis';
        }
        
        return view('data.rekam-medis.index', compact('rekamMedisList', 'pets', 'doctors', 'userRole'));
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

        // Authorization check for pemilik users - only allow viewing their own pets' records
        if (Auth::user()->hasRole('Pemilik') && !Auth::user()->hasRole('Administrator')) {
            $pemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            // Get the pet's owner ID from the record
            $petPemilikId = DB::table('pet')
                ->where('idpet', $rekamMedis->idpet)
                ->value('idpemilik');
            
            if (!$pemilikId || $pemilikId != $petPemilikId) {
                return redirect()->route('data.rekam-medis.index')
                    ->with('error', 'Anda hanya dapat melihat rekam medis hewan peliharaan Anda sendiri.');
            }
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

        // Determine if user can edit this record
        $canEdit = false;
        if (Auth::user()->hasRole('Administrator')) {
            $canEdit = true;
        } elseif (Auth::user()->hasRole('Dokter')) {
            // Dokter can edit their own records
            $dokterRoleUserId = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            $canEdit = $dokterRoleUserId && $rekamMedis->dokter_pemeriksa == $dokterRoleUserId;
        } elseif (Auth::user()->hasRole('Perawat') && !Auth::user()->hasRole('Dokter')) {
            // Perawat can edit all records (main data only)
            $canEdit = true;
        }

        return view('data.rekam-medis.show', compact('rekamMedis', 'detailRekamMedis', 'canEdit'));
    }

    /**
     * Show the form for editing main medical record data (for Perawat)
     */
    public function editData($id)
    {
        // Get medical record
        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (!$rekamMedis) {
            abort(404);
        }

        // Authorization check - only Perawat and Administrator can edit main data
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Perawat')) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit data rekam medis.');
        }

        // Additional check for Perawat - cannot edit if they are also Dokter
        if (Auth::user()->hasRole('Perawat') && Auth::user()->hasRole('Dokter') && !Auth::user()->hasRole('Administrator')) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Sebagai Dokter, Anda hanya dapat mengedit detail tindakan, bukan data utama rekam medis.');
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

        return view('data.rekam-medis.edit-data', compact('rekamMedis', 'pets', 'doctors'));
    }

    /**
     * Show the form for editing medical record details (for Dokter)
     */
    public function editDetail($id)
    {
        // Get medical record
        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (!$rekamMedis) {
            abort(404);
        }

        // Authorization check - only Dokter and Administrator can edit details
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Dokter')) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit detail tindakan.');
        }

        // Additional check for Dokter - must be the examining doctor (unless Administrator)
        if (Auth::user()->hasRole('Dokter') && !Auth::user()->hasRole('Administrator')) {
            $dokterRoleUserId = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if (!$dokterRoleUserId || $rekamMedis->dokter_pemeriksa != $dokterRoleUserId) {
                return redirect()->route('data.rekam-medis.index')
                    ->with('error', 'Anda hanya dapat mengedit detail tindakan dari rekam medis yang Anda periksa sendiri.');
            }
        }

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

        return view('data.rekam-medis.edit-detail', compact('rekamMedis', 'detailRekamMedis', 'kodeTindakan'));
    }

    /**
     * Update main medical record data (for Perawat)
     */
    public function updateData(Request $request, $id)
    {
        // Authorization check - only Perawat and Administrator can update main data
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Perawat')) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit data rekam medis.');
        }

        // Additional check for Perawat - cannot edit if they are also Dokter
        if (Auth::user()->hasRole('Perawat') && Auth::user()->hasRole('Dokter') && !Auth::user()->hasRole('Administrator')) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Sebagai Dokter, Anda hanya dapat mengedit detail tindakan, bukan data utama rekam medis.');
        }

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
            // Update medical record main data only
            DB::table('rekam_medis')->where('idrekam_medis', $id)->update([
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'idpet' => $request->idpet,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
                // 'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('data.rekam-medis.index')
                ->with('success', 'Data rekam medis berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update medical record details (for Dokter)
     */
    public function updateDetail(Request $request, $id)
    {
        // Authorization check - only Dokter and Administrator can update details
        if (!Auth::user()->hasRole('Administrator') && !Auth::user()->hasRole('Dokter')) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit detail tindakan.');
        }

        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (!$rekamMedis) {
            abort(404);
        }

        // Additional check for Dokter - must be the examining doctor (unless Administrator)
        if (Auth::user()->hasRole('Dokter') && !Auth::user()->hasRole('Administrator')) {
            $dokterRoleUserId = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if (!$dokterRoleUserId || $rekamMedis->dokter_pemeriksa != $dokterRoleUserId) {
                return redirect()->route('data.rekam-medis.index')
                    ->with('error', 'Anda hanya dapat mengedit detail tindakan dari rekam medis yang Anda periksa sendiri.');
            }
        }

        $request->validate([
            'detail_tindakan' => 'array',
            'detail_tindakan.*.idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail_tindakan.*.detail' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Delete existing detail records
            DB::table('detail_rekam_medis')->where('idrekam_medis', $id)->delete();
            
            // Insert new detail records if provided
            if ($request->has('detail_tindakan') && is_array($request->detail_tindakan)) {
                foreach ($request->detail_tindakan as $detail) {
                    if (!empty($detail['idkode_tindakan_terapi'])) {
                        DB::table('detail_rekam_medis')->insert([
                            'idrekam_medis' => $id,
                            'idkode_tindakan_terapi' => $detail['idkode_tindakan_terapi'],
                            'detail' => $detail['detail'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('data.rekam-medis.index')
                ->with('success', 'Detail tindakan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui detail tindakan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
