<?php

use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Data\DashboardController;
use App\Http\Controllers\Data\JenisHewanController;
use App\Http\Controllers\Data\UserController;
use App\Http\Controllers\Data\RoleController;
use App\Http\Controllers\Data\PetController;
use App\Http\Controllers\Data\DokterController;
use App\Http\Controllers\Data\PerawatController;
use App\Http\Controllers\Data\PemilikController;
use App\Http\Controllers\Data\TindakanTerapiController;
use App\Http\Controllers\Data\TemuDokterController;
use App\Http\Controllers\Data\RekamMedisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('site.cek-koneksi');

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/layanan', [SiteController::class, 'layanan'])->name('layanan');
Route::get('/kontak', [SiteController::class, 'kontak'])->name('kontak');
Route::get('/struktur-organisasi', [SiteController::class, 'strukturOrganisasi'])->name('struktur-organisasi');

// Dashboard redirect after login - redirect based on role
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('Administrator')) {
        return redirect()->route('data.dashboard');
    } else {
        return redirect()->route('data.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes - Authenticated users only
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{profileType}/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{profileType}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'verified', 'role:Administrator,Dokter,Perawat,Resepsionis,Pemilik'])->prefix('data')->group(function () {
    
    // Data Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('data.dashboard');
    
    Route::middleware('role:Administrator')->group(function () {
        // User Management Routes
        Route::get('/users', [UserController::class, 'index'])->name('data.users.index');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('data.users.show');
        Route::post('/users', [UserController::class, 'store'])->name('data.users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('data.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('data.users.destroy');
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('data.users.reset-password');
        
        // Role Management Routes
        Route::get('/roles', [RoleController::class, 'index'])->name('data.roles.index');
        Route::get('/roles/user/{id}', [RoleController::class, 'getUserRoles'])->name('data.roles.user');
        Route::post('/roles/add', [RoleController::class, 'addRole'])->name('data.roles.add');
        Route::post('/roles/toggle/{id}', [RoleController::class, 'toggleRole'])->name('data.roles.toggle');
    });
    
    // Jenis Hewan & Ras Hewan Routes - Resepsionis + Administrator
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('data.jenis-hewan.index');
        Route::post('/jenis-hewan', [JenisHewanController::class, 'storeJenis'])->name('data.jenis-hewan.store');
        Route::delete('/jenis-hewan/{id}', [JenisHewanController::class, 'destroyJenis'])->name('data.jenis-hewan.destroy');
        Route::post('/ras-hewan', [JenisHewanController::class, 'storeRas'])->name('data.ras-hewan.store');
        Route::put('/ras-hewan/{id}', [JenisHewanController::class, 'updateRas'])->name('data.ras-hewan.update');
        Route::delete('/ras-hewan/{id}', [JenisHewanController::class, 'destroyRas'])->name('data.ras-hewan.destroy');
    });
    
    // Pet Management Routes - Administrator + Resepsionis (CRUD), Pemilik (view only - own pets)
    Route::get('/pet', [PetController::class, 'index'])->name('data.pet.index');
    Route::get('/pet/{id}', [PetController::class, 'show'])->name('data.pet.show');
    
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/pet/create', [PetController::class, 'create'])->name('data.pet.create');
        Route::post('/pet', [PetController::class, 'store'])->name('data.pet.store');
        Route::get('/pet/{id}/edit', [PetController::class, 'edit'])->name('data.pet.edit');
        Route::put('/pet/{id}', [PetController::class, 'update'])->name('data.pet.update');
        Route::delete('/pet/{id}', [PetController::class, 'destroy'])->name('data.pet.destroy');
    });

    // Pemilik Management Routes - Only Administrator Can Create
    Route::middleware('role:Administrator')->group(function () {
        Route::get('/pemilik/create', [PemilikController::class, 'create'])->name('data.pemilik.create');
    });
    
    // Pemilik Management Routes - Administrator + Resepsionis only
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/pemilik', [PemilikController::class, 'index'])->name('data.pemilik.index');
        Route::post('/pemilik', [PemilikController::class, 'store'])->name('data.pemilik.store');
        Route::get('/pemilik/{id}', [PemilikController::class, 'show'])->name('data.pemilik.show');
        Route::get('/pemilik/{id}/edit', [PemilikController::class, 'edit'])->name('data.pemilik.edit');
        Route::put('/pemilik/{id}', [PemilikController::class, 'update'])->name('data.pemilik.update');
        Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy'])->name('data.pemilik.destroy');
    });

    Route::middleware('role:Administrator')->group(function () {
        // Tindakan Terapi Management Routes
        Route::get('/tindakan-terapi', [TindakanTerapiController::class, 'index'])->name('data.tindakan-terapi.index');

        // Kategori Routes
        Route::post('/kategori', [TindakanTerapiController::class, 'storeKategori'])->name('data.kategori.store');
        Route::put('/kategori/{id}', [TindakanTerapiController::class, 'updateKategori'])->name('data.kategori.update');
        Route::delete('/kategori/{id}', [TindakanTerapiController::class, 'destroyKategori'])->name('data.kategori.destroy');

        // Kategori Klinis Routes
        Route::post('/kategori-klinis', [TindakanTerapiController::class, 'storeKategoriKlinis'])->name('data.kategori-klinis.store');
        Route::put('/kategori-klinis/{id}', [TindakanTerapiController::class, 'updateKategoriKlinis'])->name('data.kategori-klinis.update');
        Route::delete('/kategori-klinis/{id}', [TindakanTerapiController::class, 'destroyKategoriKlinis'])->name('data.kategori-klinis.destroy');
        
        // Kode Tindakan Terapi Routes
        Route::post('/kode-tindakan', [TindakanTerapiController::class, 'storeKodeTindakan'])->name('data.kode-tindakan.store');
        Route::get('/kode-tindakan/{id}/edit', [TindakanTerapiController::class, 'editKodeTindakan'])->name('data.kode-tindakan.edit');
        Route::put('/kode-tindakan/{id}', [TindakanTerapiController::class, 'updateKodeTindakan'])->name('data.kode-tindakan.update');
        Route::delete('/kode-tindakan/{id}', [TindakanTerapiController::class, 'destroyKodeTindakan'])->name('data.kode-tindakan.destroy');
    });
    
    // Temu Dokter Management Routes - All roles view, Administrator + Resepsionis CRUD
    // Route::middleware('role:Administrator,Dokter,Resepsionis,Pemilik')->group(function () {
        Route::get('/temu-dokter', [TemuDokterController::class, 'index'])->name('data.temu-dokter.index');
        Route::get('/temu-dokter/kode-tindakan', [TemuDokterController::class, 'getKodeTindakan'])->name('data.temu-dokter.get-kode-tindakan');
        Route::get('/temu-dokter/{id}', [TemuDokterController::class, 'show'])->name('data.temu-dokter.show');

        Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('data.rekam-medis.index');
        Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show'])->name('data.rekam-medis.show');
    // });
    
    Route::middleware('role:Administrator,Perawat')->group(function () {
        Route::get('/rekam-medis/{id}/edit-data', [RekamMedisController::class, 'editData'])->name('data.rekam-medis.edit-data');
        Route::put('/rekam-medis/{id}/update-data', [RekamMedisController::class, 'updateData'])->name('data.rekam-medis.update-data');
        Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('data.rekam-medis.destroy');
        Route::post('/temu-dokter/{id}/rekam-medis', [TemuDokterController::class, 'storeRekamMedis'])->name('data.temu-dokter.store-rekam-medis');
    });
    
    Route::middleware('role:Administrator,Dokter')->group(function () {
        Route::get('/rekam-medis/{id}/edit-detail', [RekamMedisController::class, 'editDetail'])->name('data.rekam-medis.edit-detail');
        Route::put('/rekam-medis/{id}/update-detail', [RekamMedisController::class, 'updateDetail'])->name('data.rekam-medis.update-detail');
        Route::delete('/detail-rekam-medis/{detailId}', [RekamMedisController::class, 'deleteDetail'])->name('data.rekam-medis.delete-detail');
    });
    
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/temu-dokter/create', [TemuDokterController::class, 'create'])->name('data.temu-dokter.create');
        Route::post('/temu-dokter', [TemuDokterController::class, 'store'])->name('data.temu-dokter.store');
        Route::get('/temu-dokter/{id}/edit', [TemuDokterController::class, 'edit'])->name('data.temu-dokter.edit');
        Route::put('/temu-dokter/{id}', [TemuDokterController::class, 'update'])->name('data.temu-dokter.update');
        Route::post('/temu-dokter/{id}/status', [TemuDokterController::class, 'updateStatus'])->name('data.temu-dokter.update-status');
        Route::delete('/temu-dokter/{temuDokterId}/rekam-medis/{rekamMedisId}', [TemuDokterController::class, 'destroyRekamMedis'])->name('data.temu-dokter.destroy-rekam-medis');
        Route::delete('/temu-dokter/{id}', [TemuDokterController::class, 'destroy'])->name('data.temu-dokter.destroy');
    });

    Route::middleware('role:Administrator')->group(function () {
        // Dokter Management Routes
        Route::get('/dokter', [DokterController::class, 'index'])->name('data.dokter.index');
        Route::get('/dokter/create', [DokterController::class, 'create'])->name('data.dokter.create');
        Route::get('/dokter/create-with-user', [DokterController::class, 'createWithUser'])->name('data.dokter.create-with-user');
        Route::post('/dokter', [DokterController::class, 'store'])->name('data.dokter.store');
        Route::get('/dokter/{id}', [DokterController::class, 'show'])->name('data.dokter.show');
        Route::get('/dokter/{id}/edit', [DokterController::class, 'edit'])->name('data.dokter.edit');
        Route::put('/dokter/{id}', [DokterController::class, 'update'])->name('data.dokter.update');
        Route::delete('/dokter/{id}', [DokterController::class, 'destroy'])->name('data.dokter.destroy');

        // Perawat Management Routes
        Route::get('/perawat', [PerawatController::class, 'index'])->name('data.perawat.index');
        Route::get('/perawat/create', [PerawatController::class, 'create'])->name('data.perawat.create');
        Route::get('/perawat/create-with-user', [PerawatController::class, 'createWithUser'])->name('data.perawat.create-with-user');
        Route::post('/perawat', [PerawatController::class, 'store'])->name('data.perawat.store');
        Route::get('/perawat/{id}', [PerawatController::class, 'show'])->name('data.perawat.show');
        Route::get('/perawat/{id}/edit', [PerawatController::class, 'edit'])->name('data.perawat.edit');
        Route::put('/perawat/{id}', [PerawatController::class, 'update'])->name('data.perawat.update');
        Route::delete('/perawat/{id}', [PerawatController::class, 'destroy'])->name('data.perawat.destroy');
    });
    
    // Jenis Hewan Management Routes - Administrator and Resepsionis only
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('data.jenis-hewan.index');
        Route::post('/jenis-hewan', [JenisHewanController::class, 'storeJenis'])->name('data.jenis-hewan.store');
        Route::delete('/jenis-hewan/{id}', [JenisHewanController::class, 'destroyJenis'])->name('data.jenis-hewan.destroy');
        Route::post('/ras-hewan', [JenisHewanController::class, 'storeRas'])->name('data.ras-hewan.store');
        Route::put('/ras-hewan/{id}', [JenisHewanController::class, 'updateRas'])->name('data.ras-hewan.update');
        Route::delete('/ras-hewan/{id}', [JenisHewanController::class, 'destroyRas'])->name('data.ras-hewan.destroy');
    });
});

// Include Breeze authentication routes
require __DIR__.'/auth.php';
