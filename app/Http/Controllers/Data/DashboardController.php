<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard for non-admin users
     */
    public function index()
    {
        $user = Auth::user();
        $userRoles = $user->roles->pluck('nama_role')->toArray();
        
        $dashboardData = [];
        
        // Dokter Dashboard Data
        if (in_array('Dokter', $userRoles)) {
            $doctorRoleUser = DB::table('role_user')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->where('role_user.iduser', $user->iduser)
                ->where('role.nama_role', 'Dokter')
                ->where('role_user.status', 1)
                ->first();
            
            if ($doctorRoleUser) {
                $dashboardData['dokter'] = [
                    'today_appointments' => DB::table('temu_dokter')
                        ->where('idrole_user', $doctorRoleUser->idrole_user)
                        ->whereDate('waktu_daftar', today())
                        ->count(),
                    'pending_appointments' => DB::table('temu_dokter')
                        ->where('idrole_user', $doctorRoleUser->idrole_user)
                        ->where('status', '0')
                        ->count(),
                    'my_medical_records' => DB::table('rekam_medis')
                        ->where('dokter_pemeriksa', $doctorRoleUser->idrole_user)
                        ->count(),
                ];
            }
        }
        
        // Perawat Dashboard Data
        if (in_array('Perawat', $userRoles)) {
            $dashboardData['perawat'] = [
                'total_medical_records' => DB::table('rekam_medis')->count(),
                'today_medical_records' => DB::table('rekam_medis')
                    ->whereDate('created_at', today())
                    ->count(),
                'pending_appointments' => DB::table('temu_dokter')
                    ->where('status', '0')
                    ->count(),
            ];
        }
        
        // Pemilik Dashboard Data
        if (in_array('Pemilik', $userRoles)) {
            $pemilik = DB::table('pemilik')
                ->where('iduser', $user->iduser)
                ->first();
            
            if ($pemilik) {
                $dashboardData['pemilik'] = [
                    'my_pets' => DB::table('pet')
                        ->where('idpemilik', $pemilik->idpemilik)
                        ->count(),
                    'my_appointments' => DB::table('temu_dokter')
                        ->join('rekam_medis', 'temu_dokter.idreservasi_dokter', '=', 'rekam_medis.idreservasi_dokter')
                        ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                        ->where('pet.idpemilik', $pemilik->idpemilik)
                        ->count(),
                    'my_medical_records' => DB::table('rekam_medis')
                        ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                        ->where('pet.idpemilik', $pemilik->idpemilik)
                        ->count(),
                ];
            }
        }
        
        // Resepsionis Dashboard Data
        if (in_array('Resepsionis', $userRoles)) {
            $dashboardData['resepsionis'] = [
                'total_owners' => DB::table('pemilik')
                    ->join('role_user', 'pemilik.iduser', '=', 'role_user.iduser')
                    ->where('role_user.status', 1)
                    ->count(),
                'total_pets' => DB::table('pet')->count(),
                'today_appointments' => DB::table('temu_dokter')
                    ->whereDate('waktu_daftar', today())
                    ->count(),
                'pending_appointments' => DB::table('temu_dokter')
                    ->where('status', '0')
                    ->count(),
            ];
        }
        
        return view('data.dashboard', compact('dashboardData', 'userRoles'));
    }
}
