<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pemilik;
use App\Models\Pet;
use App\Models\RekamMedis;
use App\Models\JenisHewan;
use App\Models\KodeTindakanTerapi;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard cards
        $stats = [
            'total_users' => User::count(),
            'total_pemilik' => Pemilik::count(),
            'total_pets' => Pet::count(),
            'total_rekam_medis' => RekamMedis::count(),
            'total_jenis_hewan' => JenisHewan::count(),
            'total_kode_tindakan' => KodeTindakanTerapi::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
