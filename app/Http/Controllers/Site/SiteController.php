<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.home');
    }

    public function cekKoneksi()
    {
        try {
            \DB::connection()->getPdo();
            return 'Koneksi ke database berhasil';
        } catch (\Exception $e) {
            return 'Koneksi ke database gagal: ' . $e->getMessage();
        }
    }

    public function layanan()
    {
        return view('site.layanan');
    }

    public function kontak()
    {
        return view('site.kontak');
    }

    public function strukturOrganisasi()
    {
        return view('site.struktur-organisasi');
    }
}
