<?php

use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\TindakanTerapiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('site.cek-koneksi');

Route::get('/home', [SiteController::class, 'index'])->name('home');
Route::get('/layanan', [SiteController::class, 'layanan'])->name('layanan');
Route::get('/kontak', [SiteController::class, 'kontak'])->name('kontak');
Route::get('/struktur-organisasi', [SiteController::class, 'strukturOrganisasi'])->name('struktur-organisasi');

// Dashboard redirect after login - redirect to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes - Protected by role middleware (Administrator, Dokter, Resepsionis, Perawat) and email verification
Route::middleware(['auth', 'verified', 'role:Administrator,Dokter,Resepsionis,Perawat'])->prefix('admin')->group(function () {
    
    // Admin Dashboard - All roles can access
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management Routes - Administrator only
    Route::middleware('role:Administrator')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    });
    
    // Role Management Routes - Administrator only
    Route::middleware('role:Administrator')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/roles/user/{id}', [RoleController::class, 'getUserRoles'])->name('admin.roles.user');
        Route::post('/roles/add', [RoleController::class, 'addRole'])->name('admin.roles.add');
        Route::post('/roles/toggle/{id}', [RoleController::class, 'toggleRole'])->name('admin.roles.toggle');
        // Route::delete('/roles/remove/{id}', [RoleController::class, 'removeRole'])->name('admin.roles.remove');
    });
    
    // Jenis Hewan & Ras Hewan Routes
    // View: Administrator, Dokter, Resepsionis
    // CRUD: Administrator, Resepsionis
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan.index');
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::post('/jenis-hewan', [JenisHewanController::class, 'storeJenis'])->name('jenis-hewan.store');
        Route::delete('/jenis-hewan/{id}', [JenisHewanController::class, 'destroyJenis'])->name('jenis-hewan.destroy');
        Route::post('/ras-hewan', [JenisHewanController::class, 'storeRas'])->name('ras-hewan.store');
        Route::put('/ras-hewan/{id}', [JenisHewanController::class, 'updateRas'])->name('ras-hewan.update');
        Route::delete('/ras-hewan/{id}', [JenisHewanController::class, 'destroyRas'])->name('ras-hewan.destroy');
    });
    
    // Pet Management Routes
    // View: Administrator, Dokter, Resepsionis
    // CRUD: Administrator, Resepsionis
    Route::get('/pet', [PetController::class, 'index'])->name('admin.pet.index');
    Route::get('/pet/{id}', [PetController::class, 'show'])->name('admin.pet.show');
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::post('/pet', [PetController::class, 'store'])->name('admin.pet.store');
        Route::put('/pet/{id}', [PetController::class, 'update'])->name('admin.pet.update');
        Route::delete('/pet/{id}', [PetController::class, 'destroy'])->name('admin.pet.destroy');
    });
    
    // Pemilik Management Routes
    // View: Administrator, Dokter, Resepsionis
    // CRUD: Administrator, Resepsionis
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('admin.pemilik.index');
    Route::get('/pemilik/{id}', [PemilikController::class, 'show'])->name('admin.pemilik.show');
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        Route::post('/pemilik', [PemilikController::class, 'store'])->name('admin.pemilik.store');
        Route::put('/pemilik/{id}', [PemilikController::class, 'update'])->name('admin.pemilik.update');
        Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy'])->name('admin.pemilik.destroy');
    });
    
    // Note: Removed duplicate dokter routes - see proper organization below
    
    // Note: Removed duplicate perawat routes - see proper organization below
    
    // Tindakan Terapi Management Routes
    // View: Administrator, Dokter, Resepsionis
    // CRUD: Administrator, Resepsionis
    Route::get('/tindakan-terapi', [TindakanTerapiController::class, 'index'])->name('admin.tindakan-terapi.index');
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        // Kategori Routes
        Route::post('/kategori', [TindakanTerapiController::class, 'storeKategori'])->name('admin.kategori.store');
        Route::put('/kategori/{id}', [TindakanTerapiController::class, 'updateKategori'])->name('admin.kategori.update');
        Route::delete('/kategori/{id}', [TindakanTerapiController::class, 'destroyKategori'])->name('admin.kategori.destroy');
        
        // Kategori Klinis Routes
        Route::post('/kategori-klinis', [TindakanTerapiController::class, 'storeKategoriKlinis'])->name('admin.kategori-klinis.store');
        Route::put('/kategori-klinis/{id}', [TindakanTerapiController::class, 'updateKategoriKlinis'])->name('admin.kategori-klinis.update');
        Route::delete('/kategori-klinis/{id}', [TindakanTerapiController::class, 'destroyKategoriKlinis'])->name('admin.kategori-klinis.destroy');
        
        // Kode Tindakan Terapi Routes
        Route::post('/kode-tindakan', [TindakanTerapiController::class, 'storeKodeTindakan'])->name('admin.kode-tindakan.store');
        Route::get('/kode-tindakan/{id}/edit', [TindakanTerapiController::class, 'editKodeTindakan'])->name('admin.kode-tindakan.edit');
        Route::put('/kode-tindakan/{id}', [TindakanTerapiController::class, 'updateKodeTindakan'])->name('admin.kode-tindakan.update');
        Route::delete('/kode-tindakan/{id}', [TindakanTerapiController::class, 'destroyKodeTindakan'])->name('admin.kode-tindakan.destroy');
    });
    
    // Rekam Medis Management Routes
    // View: Administrator, Dokter, Resepsionis
    // CRUD: Administrator, Dokter
    // Note: Specific routes (without parameters) must come before parameterized routes
    Route::get('/rekam-medis', [App\Http\Controllers\Admin\RekamMedisController::class, 'index'])->name('admin.rekam-medis.index');
    Route::get('/rekam-medis/kode-tindakan', [App\Http\Controllers\Admin\RekamMedisController::class, 'getKodeTindakan'])->name('admin.rekam-medis.get-kode-tindakan');
    Route::middleware('role:Administrator,Dokter')->group(function () {
        // Specific routes without parameters - must come first
        Route::get('/rekam-medis/create', [App\Http\Controllers\Admin\RekamMedisController::class, 'create'])->name('admin.rekam-medis.create');
        
        // General CRUD routes
        Route::post('/rekam-medis', [App\Http\Controllers\Admin\RekamMedisController::class, 'store'])->name('admin.rekam-medis.store');
        
        // Parameterized routes - must come after specific routes
        Route::get('/rekam-medis/{id}/edit', [App\Http\Controllers\Admin\RekamMedisController::class, 'edit'])->name('admin.rekam-medis.edit');
        Route::put('/rekam-medis/{id}', [App\Http\Controllers\Admin\RekamMedisController::class, 'update'])->name('admin.rekam-medis.update');
        
        // Detail tindakan management
        Route::delete('/rekam-medis/detail/{detailId}', [App\Http\Controllers\Admin\RekamMedisController::class, 'deleteDetail'])->name('admin.rekam-medis.delete-detail');
    });
    
    // View-only routes (accessible to more roles)
    Route::get('/rekam-medis/{id}', [App\Http\Controllers\Admin\RekamMedisController::class, 'show'])->name('admin.rekam-medis.show');
    
    Route::middleware('role:Administrator')->group(function () {
        Route::delete('/rekam-medis/{id}', [App\Http\Controllers\Admin\RekamMedisController::class, 'destroy'])->name('admin.rekam-medis.destroy');
    });
    
    // Temu Dokter (Doctor Appointment) Management Routes
    // View: Administrator, Resepsionis, Perawat
    // CRUD: Administrator, Resepsionis
    // Note: Specific routes (without parameters) must come before parameterized routes
    Route::middleware('role:Administrator,Resepsionis,Perawat')->group(function () {
        Route::get('/temu-dokter', [App\Http\Controllers\Admin\TemuDokterController::class, 'index'])->name('admin.temu-dokter.index');
    });
    Route::middleware('role:Administrator,Resepsionis')->group(function () {
        // Specific routes without parameters - must come first
        Route::get('/temu-dokter/create', [App\Http\Controllers\Admin\TemuDokterController::class, 'create'])->name('admin.temu-dokter.create');
        
        // General CRUD routes
        Route::post('/temu-dokter', [App\Http\Controllers\Admin\TemuDokterController::class, 'store'])->name('admin.temu-dokter.store');
        
        // Parameterized routes - must come after specific routes
        Route::get('/temu-dokter/{id}/edit', [App\Http\Controllers\Admin\TemuDokterController::class, 'edit'])->name('admin.temu-dokter.edit');
        Route::put('/temu-dokter/{id}', [App\Http\Controllers\Admin\TemuDokterController::class, 'update'])->name('admin.temu-dokter.update');
        Route::post('/temu-dokter/{id}/status', [App\Http\Controllers\Admin\TemuDokterController::class, 'updateStatus'])->name('admin.temu-dokter.update-status');
        Route::delete('/temu-dokter/{temuDokterId}/rekam-medis/{rekamMedisId}', [App\Http\Controllers\Admin\TemuDokterController::class, 'destroyRekamMedis'])->name('admin.temu-dokter.destroy-rekam-medis');
    });
    
    // Routes that doctors also need access to (for rekam medis management)
    Route::middleware('role:Administrator,Resepsionis,Dokter')->group(function () {
        Route::get('/temu-dokter/kode-tindakan', [App\Http\Controllers\Admin\TemuDokterController::class, 'getKodeTindakan'])->name('admin.temu-dokter.get-kode-tindakan');
        Route::post('/temu-dokter/{id}/rekam-medis', [App\Http\Controllers\Admin\TemuDokterController::class, 'storeRekamMedis'])->name('admin.temu-dokter.store-rekam-medis');
    });
    
    // Routes accessible by view roles (including show route)
    Route::middleware('role:Administrator,Resepsionis,Perawat')->group(function () {
        Route::get('/temu-dokter/{id}', [App\Http\Controllers\Admin\TemuDokterController::class, 'show'])->name('admin.temu-dokter.show');
    });
    
    Route::middleware('role:Administrator')->group(function () {
        Route::delete('/temu-dokter/{id}', [App\Http\Controllers\Admin\TemuDokterController::class, 'destroy'])->name('admin.temu-dokter.destroy');
    });

    // Dokter Management Routes - Administrator only
    // Note: Specific routes (without parameters) must come before parameterized routes
    Route::middleware('role:Administrator')->group(function () {
        Route::get('/dokter', [App\Http\Controllers\Admin\DokterController::class, 'index'])->name('admin.dokter.index');
        
        // Specific routes without parameters - must come first
        Route::get('/dokter/create', [App\Http\Controllers\Admin\DokterController::class, 'create'])->name('admin.dokter.create');
        Route::get('/dokter/create-with-user', [App\Http\Controllers\Admin\DokterController::class, 'createWithUser'])->name('admin.dokter.create-with-user');
        
        // General CRUD routes
        Route::post('/dokter', [App\Http\Controllers\Admin\DokterController::class, 'store'])->name('admin.dokter.store');
        
        // Parameterized routes - must come after specific routes
        Route::get('/dokter/{id}', [App\Http\Controllers\Admin\DokterController::class, 'show'])->name('admin.dokter.show');
        Route::get('/dokter/{id}/edit', [App\Http\Controllers\Admin\DokterController::class, 'edit'])->name('admin.dokter.edit');
        Route::put('/dokter/{id}', [App\Http\Controllers\Admin\DokterController::class, 'update'])->name('admin.dokter.update');
        Route::delete('/dokter/{id}', [App\Http\Controllers\Admin\DokterController::class, 'destroy'])->name('admin.dokter.destroy');
    });

    // Perawat Management Routes - Administrator only
    // Note: Specific routes (without parameters) must come before parameterized routes
    Route::middleware('role:Administrator')->group(function () {
        Route::get('/perawat', [App\Http\Controllers\Admin\PerawatController::class, 'index'])->name('admin.perawat.index');
        
        // Specific routes without parameters - must come first
        Route::get('/perawat/create', [App\Http\Controllers\Admin\PerawatController::class, 'create'])->name('admin.perawat.create');
        Route::get('/perawat/create-with-user', [App\Http\Controllers\Admin\PerawatController::class, 'createWithUser'])->name('admin.perawat.create-with-user');
        
        // General CRUD routes
        Route::post('/perawat', [App\Http\Controllers\Admin\PerawatController::class, 'store'])->name('admin.perawat.store');
        
        // Parameterized routes - must come after specific routes
        Route::get('/perawat/{id}', [App\Http\Controllers\Admin\PerawatController::class, 'show'])->name('admin.perawat.show');
        Route::get('/perawat/{id}/edit', [App\Http\Controllers\Admin\PerawatController::class, 'edit'])->name('admin.perawat.edit');
        Route::put('/perawat/{id}', [App\Http\Controllers\Admin\PerawatController::class, 'update'])->name('admin.perawat.update');
        Route::delete('/perawat/{id}', [App\Http\Controllers\Admin\PerawatController::class, 'destroy'])->name('admin.perawat.destroy');
    });

    // Profile Management Routes - Administrator only
    Route::middleware('role:Administrator')->group(function () {
        Route::get('/profiles', [App\Http\Controllers\Admin\UserProfileController::class, 'index'])->name('admin.profiles.index');
        Route::get('/profiles/{userId}', [App\Http\Controllers\Admin\UserProfileController::class, 'show'])->name('admin.profiles.show');
        Route::get('/profiles/{userId}/data/{profileType}', [App\Http\Controllers\Admin\UserProfileController::class, 'getProfileData'])->name('admin.profiles.data');
    });
});

// Include Breeze authentication routes
require __DIR__.'/auth.php';
