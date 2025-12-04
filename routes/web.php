<?php

use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PetController as AdminPetController;
use App\Http\Controllers\Admin\PemilikController as AdminPemilikController;
use App\Http\Controllers\Admin\TindakanTerapiController;
use App\Http\Controllers\Data\DashboardController as DataDashboardController;
use App\Http\Controllers\Data\PetController as DataPetController;
use App\Http\Controllers\Data\TemuDokterController as DataTemuDokterController;
use App\Http\Controllers\ADmin\RekamMedisController as AdminRekamMedisController;
use App\Http\Controllers\Data\RekamMedisController as DataRekamMedisController;
use App\Http\Controllers\Data\PemilikController as DataPemilikController;
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
    Route::get('/dashboard', [DataDashboardController::class, 'index'])->name('data.dashboard');
    
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
    Route::get('/pet', [AdminPetController::class, 'index'])->name('data.pet.index');
    Route::get('/pet/{id}', [AdminPetController::class, 'show'])->name('data.pet.show');
    
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/pet/create', [AdminPetController::class, 'create'])->name('data.pet.create');
        Route::post('/pet', [AdminPetController::class, 'store'])->name('data.pet.store');
        Route::get('/pet/{id}/edit', [AdminPetController::class, 'edit'])->name('data.pet.edit');
        Route::put('/pet/{id}', [AdminPetController::class, 'update'])->name('data.pet.update');
        Route::delete('/pet/{id}', [AdminPetController::class, 'destroy'])->name('data.pet.destroy');
    });

    // Pemilik Management Routes - Only Administrator Can Create
    Route::middleware('role:Administrator')->group(function () {
        Route::get('/pemilik/create', [AdminPemilikController::class, 'create'])->name('data.pemilik.create');
    });
    
    // Pemilik Management Routes - Administrator + Resepsionis only
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/pemilik', [AdminPemilikController::class, 'index'])->name('data.pemilik.index');
        Route::post('/pemilik', [AdminPemilikController::class, 'store'])->name('data.pemilik.store');
        Route::get('/pemilik/{id}', [AdminPemilikController::class, 'show'])->name('data.pemilik.show');
        Route::get('/pemilik/{id}/edit', [AdminPemilikController::class, 'edit'])->name('data.pemilik.edit');
        Route::put('/pemilik/{id}', [AdminPemilikController::class, 'update'])->name('data.pemilik.update');
        Route::delete('/pemilik/{id}', [AdminPemilikController::class, 'destroy'])->name('data.pemilik.destroy');
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

        // Temu Dokter Management Routes
        Route::get('/temu-dokter/create', [App\Http\Controllers\Admin\TemuDokterController::class, 'create'])->name('data.temu-dokter.create');
        Route::get('/temu-dokter/{id}/edit', [App\Http\Controllers\Admin\TemuDokterController::class, 'edit'])->name('data.temu-dokter.edit');
        Route::post('/temu-dokter', [App\Http\Controllers\Admin\TemuDokterController::class, 'store'])->name('data.temu-dokter.store');
        Route::put('/temu-dokter/{id}', [App\Http\Controllers\Admin\TemuDokterController::class, 'update'])->name('data.temu-dokter.update');
        Route::post('/temu-dokter/{id}/status', [App\Http\Controllers\Admin\TemuDokterController::class, 'updateStatus'])->name('data.temu-dokter.update-status');
        Route::delete('/temu-dokter/{temuDokterId}/rekam-medis/{rekamMedisId}', [App\Http\Controllers\Admin\TemuDokterController::class, 'destroyRekamMedis'])->name('data.temu-dokter.destroy-rekam-medis');
        Route::delete('/temu-dokter/{id}', [App\Http\Controllers\Admin\TemuDokterController::class, 'destroy'])->name('data.temu-dokter.destroy');
    });
    
    // Temu Dokter Management Routes - All roles view, Administrator + Resepsionis CRUD
    // Route::middleware('role:Administrator,Dokter,Resepsionis,Pemilik')->group(function () {
        Route::get('/temu-dokter', [DataTemuDokterController::class, 'index'])->name('data.temu-dokter.index');
        Route::get('/temu-dokter/kode-tindakan', [App\Http\Controllers\Admin\TemuDokterController::class, 'getKodeTindakan'])->name('data.temu-dokter.get-kode-tindakan');
        Route::get('/temu-dokter/{id}', [DataTemuDokterController::class, 'show'])->name('data.temu-dokter.show');

        Route::get('/rekam-medis', [AdminRekamMedisController::class, 'index'])->name('data.rekam-medis.index');
        Route::get('/rekam-medis/{id}', [AdminRekamMedisController::class, 'show'])->name('data.rekam-medis.show');
    // });
    
    Route::middleware('role:Administrator,Perawat')->group(function () {
        Route::get('/rekam-medis/{id}/edit-data', [AdminRekamMedisController::class, 'editData'])->name('data.rekam-medis.edit-data');
        Route::put('/rekam-medis/{id}/update-data', [AdminRekamMedisController::class, 'updateData'])->name('data.rekam-medis.update-data');
        Route::post('/temu-dokter/{id}/rekam-medis', [App\Http\Controllers\Admin\TemuDokterController::class, 'storeRekamMedis'])->name('data.temu-dokter.store-rekam-medis');
    });
    
    Route::middleware('role:Administrator,Dokter')->group(function () {
        Route::get('/rekam-medis/{id}/edit-detail', [AdminRekamMedisController::class, 'editDetail'])->name('data.rekam-medis.edit-detail');
        Route::put('/rekam-medis/{id}/update-detail', [AdminRekamMedisController::class, 'updateDetail'])->name('data.rekam-medis.update-detail');
        // Route::delete('/rekam-medis/detail/{detailId}', [App\Http\Controllers\Admin\RekamMedisController::class, 'deleteDetail'])->name('data.rekam-medis.delete-detail');
    });

    /* Route::middleware('role:Administrator,Dokter,Perawat')->group(function () {
        Route::get('/rekam-medis/{id}/edit', [AdminRekamMedisController::class, 'edit'])->name('data.rekam-medis.edit');
        Route::put('/rekam-medis/{id}', [AdminRekamMedisController::class, 'update'])->name('data.rekam-medis.update');
    }); */
    
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::get('/temu-dokter/create', [DataTemuDokterController::class, 'create'])->name('data.temu-dokter.create');
        Route::post('/temu-dokter', [DataTemuDokterController::class, 'store'])->name('data.temu-dokter.store');
        Route::get('/temu-dokter/{id}/edit', [DataTemuDokterController::class, 'edit'])->name('data.temu-dokter.edit');
        Route::put('/temu-dokter/{id}', [DataTemuDokterController::class, 'update'])->name('data.temu-dokter.update');
        Route::post('/temu-dokter/{id}/status', [DataTemuDokterController::class, 'updateStatus'])->name('data.temu-dokter.update-status');
    });

    Route::middleware('role:Administrator')->group(function () {
        // Dokter Management Routes
        Route::get('/dokter', [App\Http\Controllers\Admin\DokterController::class, 'index'])->name('data.dokter.index');
        Route::get('/dokter/create', [App\Http\Controllers\Admin\DokterController::class, 'create'])->name('data.dokter.create');
        Route::get('/dokter/create-with-user', [App\Http\Controllers\Admin\DokterController::class, 'createWithUser'])->name('data.dokter.create-with-user');
        Route::post('/dokter', [App\Http\Controllers\Admin\DokterController::class, 'store'])->name('data.dokter.store');
        Route::get('/dokter/{id}', [App\Http\Controllers\Admin\DokterController::class, 'show'])->name('data.dokter.show');
        Route::get('/dokter/{id}/edit', [App\Http\Controllers\Admin\DokterController::class, 'edit'])->name('data.dokter.edit');
        Route::put('/dokter/{id}', [App\Http\Controllers\Admin\DokterController::class, 'update'])->name('data.dokter.update');
        Route::delete('/dokter/{id}', [App\Http\Controllers\Admin\DokterController::class, 'destroy'])->name('data.dokter.destroy');

        // Perawat Management Routes
        Route::get('/perawat', [App\Http\Controllers\Admin\PerawatController::class, 'index'])->name('data.perawat.index');
        Route::get('/perawat/create', [App\Http\Controllers\Admin\PerawatController::class, 'create'])->name('data.perawat.create');
        Route::get('/perawat/create-with-user', [App\Http\Controllers\Admin\PerawatController::class, 'createWithUser'])->name('data.perawat.create-with-user');
        Route::post('/perawat', [App\Http\Controllers\Admin\PerawatController::class, 'store'])->name('data.perawat.store');
        Route::get('/perawat/{id}', [App\Http\Controllers\Admin\PerawatController::class, 'show'])->name('data.perawat.show');
        Route::get('/perawat/{id}/edit', [App\Http\Controllers\Admin\PerawatController::class, 'edit'])->name('data.perawat.edit');
        Route::put('/perawat/{id}', [App\Http\Controllers\Admin\PerawatController::class, 'update'])->name('data.perawat.update');
        Route::delete('/perawat/{id}', [App\Http\Controllers\Admin\PerawatController::class, 'destroy'])->name('data.perawat.destroy');
    });
});

// Include Breeze authentication routes
require __DIR__.'/auth.php';
