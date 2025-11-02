<?php

use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\TindakanTerapiController;
use App\Http\Controllers\ProfileController;
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

// Breeze Profile Routes
// we don't need this atm
/* Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); */

// Admin Routes - Protected by role middleware (Administrator, Dokter, Resepsionis, Perawat)
Route::middleware(['auth', 'role:Administrator,Dokter,Resepsionis,Perawat'])->prefix('admin')->group(function () {
    
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
});

// Include Breeze authentication routes
require __DIR__.'/auth.php';
