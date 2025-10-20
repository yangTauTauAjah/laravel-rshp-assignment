<?php

use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Auth\AuthController;
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

// Admin Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Authentication Routes
Route::prefix('auth')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Data Management Routes - Jenis Hewan & Ras Hewan
Route::get('/admin/jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan.index');
Route::post('/admin/jenis-hewan', [JenisHewanController::class, 'storeJenis'])->name('jenis-hewan.store');
Route::delete('/admin/jenis-hewan/{id}', [JenisHewanController::class, 'destroyJenis'])->name('jenis-hewan.destroy');
Route::post('/admin/ras-hewan', [JenisHewanController::class, 'storeRas'])->name('ras-hewan.store');
Route::put('/admin/ras-hewan/{id}', [JenisHewanController::class, 'updateRas'])->name('ras-hewan.update');
Route::delete('/admin/ras-hewan/{id}', [JenisHewanController::class, 'destroyRas'])->name('ras-hewan.destroy');

// User Management Routes
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

// Role Management Routes
Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
Route::get('/admin/roles/user/{id}', [RoleController::class, 'getUserRoles'])->name('admin.roles.user');
Route::post('/admin/roles/add', [RoleController::class, 'addRole'])->name('admin.roles.add');
Route::post('/admin/roles/toggle/{id}', [RoleController::class, 'toggleRole'])->name('admin.roles.toggle');
Route::delete('/admin/roles/remove/{id}', [RoleController::class, 'removeRole'])->name('admin.roles.remove');

// Pet Management Routes
Route::get('/admin/pet', [PetController::class, 'index'])->name('admin.pet.index');
Route::get('/admin/pet/{id}', [PetController::class, 'show'])->name('admin.pet.show');
Route::post('/admin/pet', [PetController::class, 'store'])->name('admin.pet.store');
Route::put('/admin/pet/{id}', [PetController::class, 'update'])->name('admin.pet.update');
Route::delete('/admin/pet/{id}', [PetController::class, 'destroy'])->name('admin.pet.destroy');

// Pemilik Management Routes
Route::get('/admin/pemilik', [PemilikController::class, 'index'])->name('admin.pemilik.index');
Route::get('/admin/pemilik/{id}', [PemilikController::class, 'show'])->name('admin.pemilik.show');
Route::post('/admin/pemilik', [PemilikController::class, 'store'])->name('admin.pemilik.store');
Route::put('/admin/pemilik/{id}', [PemilikController::class, 'update'])->name('admin.pemilik.update');
Route::delete('/admin/pemilik/{id}', [PemilikController::class, 'destroy'])->name('admin.pemilik.destroy');

// Tindakan Terapi Management Routes (Kategori, Kategori Klinis, Kode Tindakan)
Route::get('/admin/tindakan-terapi', [TindakanTerapiController::class, 'index'])->name('admin.tindakan-terapi.index');

// Kategori Routes
Route::post('/admin/kategori', [TindakanTerapiController::class, 'storeKategori'])->name('admin.kategori.store');
Route::put('/admin/kategori/{id}', [TindakanTerapiController::class, 'updateKategori'])->name('admin.kategori.update');
Route::delete('/admin/kategori/{id}', [TindakanTerapiController::class, 'destroyKategori'])->name('admin.kategori.destroy');

// Kategori Klinis Routes
Route::post('/admin/kategori-klinis', [TindakanTerapiController::class, 'storeKategoriKlinis'])->name('admin.kategori-klinis.store');
Route::put('/admin/kategori-klinis/{id}', [TindakanTerapiController::class, 'updateKategoriKlinis'])->name('admin.kategori-klinis.update');
Route::delete('/admin/kategori-klinis/{id}', [TindakanTerapiController::class, 'destroyKategoriKlinis'])->name('admin.kategori-klinis.destroy');

// Kode Tindakan Terapi Routes
Route::post('/admin/kode-tindakan', [TindakanTerapiController::class, 'storeKodeTindakan'])->name('admin.kode-tindakan.store');
Route::get('/admin/kode-tindakan/{id}/edit', [TindakanTerapiController::class, 'editKodeTindakan'])->name('admin.kode-tindakan.edit');
Route::put('/admin/kode-tindakan/{id}', [TindakanTerapiController::class, 'updateKodeTindakan'])->name('admin.kode-tindakan.update');
Route::delete('/admin/kode-tindakan/{id}', [TindakanTerapiController::class, 'destroyKodeTindakan'])->name('admin.kode-tindakan.destroy');