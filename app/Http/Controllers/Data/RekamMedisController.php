<?php

namespace App\Http\Controllers\Data;

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
        $query = DB::table('rekam_medis')
            ->leftJoin('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->leftJoin('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->leftJoin('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
            ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->leftJoin('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->leftJoin('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser');

        // Apply role-based filtering
        if (Auth::user()->hasRole('Dokter')) {
            // Dokter users: only show their own medical records
            $doctorRoleUser = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if ($doctorRoleUser) {
                $query->where('rekam_medis.dokter_pemeriksa', $doctorRoleUser);
            } else {
                // If doctor profile not found, show no records
                return view('data.rekam-medis.index', ['rekamMedisList' => collect()]);
            }
        } elseif (Auth::user()->hasRole('Pemilik')) {
            // Pemilik users: only show medical records for their pets
            $pemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            if ($pemilikId) {
                $query->where('pet.idpemilik', $pemilikId);
            } else {
                // If pemilik profile not found, show no records
                return view('data.rekam-medis.index', ['rekamMedisList' => collect()]);
            }
        }
        // For Perawat: show all medical records

        $rekamMedisList = $query->select(
                'rekam_medis.*',
                'pet.nama as pet_nama',
                'pet.jenis_kelamin',
                'pemilik_user.nama as pemilik_nama',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'dokter_user.nama as dokter_nama'
            )
            ->orderBy('rekam_medis.created_at', 'desc')
            ->get();

        return view('data.rekam-medis.index', compact('rekamMedisList'));
    }

    /**
     * Display the specified medical record
     */
    public function show($id)
    {
        $rekamMedis = DB::table('rekam_medis')
            ->leftJoin('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->leftJoin('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->leftJoin('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
            ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->leftJoin('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
            ->leftJoin('user as dokter_user', 'role_user.iduser', '=', 'dokter_user.iduser')
            ->leftJoin('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
            ->where('rekam_medis.idrekam_medis', $id)
            ->select(
                'rekam_medis.*',
                'pet.nama as pet_nama',
                'pet.jenis_kelamin',
                'pet.tanggal_lahir as pet_tanggal_lahir',
                'pet.warna_tanda',
                'pemilik.no_wa as pemilik_no_wa',
                'pemilik.alamat as pemilik_alamat',
                'pemilik_user.nama as pemilik_nama',
                'pemilik_user.email as pemilik_email',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'dokter_user.nama as dokter_nama',
                'temu_dokter.waktu_daftar',
                'temu_dokter.no_urut'
            )
            ->first();

        if (!$rekamMedis) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan');
        }

        // Authorization checks
        if (Auth::user()->hasRole('Dokter')) {
            // Dokter can only view their own medical records
            $doctorRoleUser = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if (!$doctorRoleUser || $doctorRoleUser != $rekamMedis->dokter_pemeriksa) {
                return redirect()->route('data.rekam-medis.index')
                    ->with('error', 'Anda hanya dapat melihat rekam medis yang Anda buat.');
            }
        } elseif (Auth::user()->hasRole('Pemilik')) {
            // Pemilik can only view medical records for their pets
            $pemilikId = DB::table('pemilik')
                ->where('iduser', Auth::user()->iduser)
                ->value('idpemilik');
            
            $petPemilikId = DB::table('pet')
                ->where('idpet', $rekamMedis->idpet)
                ->value('idpemilik');
            
            if (!$pemilikId || $pemilikId != $petPemilikId) {
                return redirect()->route('data.rekam-medis.index')
                    ->with('error', 'Anda hanya dapat melihat rekam medis hewan peliharaan Anda.');
            }
        }

        // Get detail records
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

        // Check if user can edit (Dokter who created it, or Perawat for main record)
        $canEdit = false;
        $canManageDetails = false;

        if (Auth::user()->hasRole('Dokter')) {
            $doctorRoleUser = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if ($doctorRoleUser && $doctorRoleUser == $rekamMedis->dokter_pemeriksa) {
                $canEdit = true;
                $canManageDetails = true;
            }
        } elseif (Auth::user()->hasRole('Perawat')) {
            $canEdit = true; // Can edit main record only
            $canManageDetails = false; // Cannot manage details
        }

        return view('data.rekam-medis.show', compact('rekamMedis', 'detailRekamMedis', 'canEdit', 'canManageDetails'));
    }

    /**
     * Show the form for editing the specified medical record
     */
    public function edit($id)
    {
        $rekamMedis = DB::table('rekam_medis')
            ->leftJoin('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->leftJoin('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->leftJoin('user as pemilik_user', 'pemilik.iduser', '=', 'pemilik_user.iduser')
            ->where('rekam_medis.idrekam_medis', $id)
            ->select(
                'rekam_medis.*',
                'pet.nama as pet_nama',
                'pemilik_user.nama as pemilik_nama'
            )
            ->first();

        if (!$rekamMedis) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan');
        }

        // Authorization checks
        if (Auth::user()->hasRole('Dokter')) {
            // Dokter can only edit their own medical records
            $doctorRoleUser = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if (!$doctorRoleUser || $doctorRoleUser != $rekamMedis->dokter_pemeriksa) {
                return redirect()->route('data.rekam-medis.index')
                    ->with('error', 'Anda hanya dapat mengedit rekam medis yang Anda buat.');
            }
        } elseif (!Auth::user()->hasRole('Perawat')) {
            // Only Dokter and Perawat can edit
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit rekam medis.');
        }

        // Get detail records (for Dokter only)
        $detailRekamMedis = collect();
        $kodeTindakanList = collect();
        
        if (Auth::user()->hasRole('Dokter')) {
            $detailRekamMedis = DB::table('detail_rekam_medis')
                ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
                ->where('detail_rekam_medis.idrekam_medis', $id)
                ->select('detail_rekam_medis.*', 'kode_tindakan_terapi.nama_tindakan')
                ->get();
            
            $kodeTindakanList = DB::table('kode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->select(
                    'kode_tindakan_terapi.*',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                )
                ->orderBy('kode_tindakan_terapi.kode')
                ->get();
        }

        // Check permissions
        $canManageDetails = Auth::user()->hasRole('Dokter');

        return view('data.rekam-medis.edit', compact('rekamMedis', 'detailRekamMedis', 'kodeTindakanList', 'canManageDetails'));
    }

    /**
     * Update the specified medical record
     */
    public function update(Request $request, $id)
    {
        $rekamMedis = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        
        if (!$rekamMedis) {
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Rekam medis tidak ditemukan');
        }

        // Authorization checks
        if (Auth::user()->hasRole('Dokter')) {
            // Dokter can only edit their own medical records
            $doctorRoleUser = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', Auth::user()->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->value('role_user.idrole_user');
            
            if (!$doctorRoleUser || $doctorRoleUser != $rekamMedis->dokter_pemeriksa) {
                return redirect()->route('data.rekam-medis.index')
                    ->with('error', 'Anda hanya dapat mengedit rekam medis yang Anda buat.');
            }
        } elseif (!Auth::user()->hasRole('Perawat')) {
            // Only Dokter and Perawat can edit
            return redirect()->route('data.rekam-medis.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit rekam medis.');
        }

        $request->validate([
            'anamnesa' => 'required|string',
            'temuan_klinis' => 'required|string',
            'diagnosa' => 'required|string',
            'detail_tindakan' => 'sometimes|array',
            'detail_tindakan.*.idkode_tindakan_terapi' => 'required_with:detail_tindakan.*|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail_tindakan.*.detail' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update main record
            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->update([
                    'anamnesa' => $request->anamnesa,
                    'temuan_klinis' => $request->temuan_klinis,
                    'diagnosa' => $request->diagnosa,
                    'updated_at' => now(),
                ]);

            // Update detail records (only for Dokter)
            if (Auth::user()->hasRole('Dokter') && $request->has('detail_tindakan')) {
                // Delete existing details
                DB::table('detail_rekam_medis')->where('idrekam_medis', $id)->delete();
                
                // Insert new details
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

            return redirect()->route('data.rekam-medis.show', $id)
                ->with('success', 'Rekam medis berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }
}
