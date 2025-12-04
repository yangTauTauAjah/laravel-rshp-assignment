@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Dashboard Admin" subtitle="Panel Manajemen Data Rumah Sakit Hewan Pendidikan UNAIR"
        :backRoute="route('home')" backText="Kembali ke Beranda">
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">

        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-rshp-blue to-blue-600 rounded-lg shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Selamat Datang di Dashboard Admin!</h2>
                    <p class="text-blue-100 text-lg">Kelola semua data rumah sakit hewan dengan mudah dan efisien.</p>
                </div>
                <svg class="w-24 h-24 text-blue-200 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>

        <!-- Quick Stats -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-rshp-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-rshp-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pemilik Hewan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pemilik'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-rshp-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Hewan Peliharaan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pets'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Rekam Medis</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_rekam_medis'] }}</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Management Modules -->
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-rshp-dark-gray mb-4">Modul Manajemen Data</h3>
            <p class="text-gray-600 mb-6">Pilih modul yang ingin Anda kelola</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- User Management Card - Administrator only -->
            @if(Auth::user()->isAdministrator())
            <a href="{{ route('data.users.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-rshp-blue transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 rounded-lg p-3 group-hover:bg-rshp-blue transition-colors">
                            <svg class="w-8 h-8 text-rshp-blue group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-rshp-blue transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rshp-blue transition-colors">Kelola User
                    </h4>
                    <p class="text-gray-600 text-sm">Manajemen pengguna sistem, tambah user baru, edit, dan hapus data user</p>
                </div>
            </a>
            @endif
            
            <!-- Role Management Card - Administrator only -->
            @if(Auth::user()->isAdministrator())
            <a href="{{ route('data.roles.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-purple-500 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-500 transition-colors">
                            <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-500 transition-colors">Kelola Role
                    </h4>
                    <p class="text-gray-600 text-sm">Manajemen role user, atur hak akses dan permission pengguna sistem</p>
                </div>
            </a>
            @endif

            <!-- Temu Dokter Management Card - Administrator, Dokter, Resepsionis, Pemilik -->
            @if(Auth::user()->isAdministrator() || Auth::user()->isDokter() || Auth::user()->isResepsionis() || Auth::user()->isPemilik())
            <a href="{{ route('data.temu-dokter.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-500 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 rounded-lg p-3 group-hover:bg-indigo-500 transition-colors">
                            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m0 0v8a2 2 0 01-2 2H10a2 2 0 01-2-2v-8m0 0V9a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-500 transition-colors">Temu Dokter</h4>
                    <p class="text-gray-600 text-sm">Manajemen reservasi dan antrian konsultasi dengan dokter</p>
                </div>
            </a>
            @endif

            <!-- Dokter Management Card - Administrator only -->
            @if(Auth::user()->isAdministrator())
            <a href="{{ route('data.dokter.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-rshp-green transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 rounded-lg p-3 group-hover:bg-rshp-green transition-colors">
                            <svg class="w-8 h-8 text-rshp-green group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-rshp-green transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rshp-green transition-colors">Data Dokter</h4>
                    <p class="text-gray-600 text-sm">Manajemen profil dokter, registrasi dokter baru, dan data keahlian</p>
                </div>
            </a>
            @endif
            
            <!-- Perawat Management Card - Administrator only -->
            @if(Auth::user()->isAdministrator())
            <a href="{{ route('data.perawat.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-purple-500 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-500 transition-colors">
                            <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-500 transition-colors">Data Perawat</h4>
                    <p class="text-gray-600 text-sm">Manajemen profil perawat, registrasi perawat baru, dan data pendidikan</p>
                </div>
            </a>
            @endif
            
            <!-- Pemilik Management Card - Administrator, Dokter, Resepsionis -->
            @if(Auth::user()->isAdministrator() || Auth::user()->isDokter() || Auth::user()->isResepsionis())
            <a href="{{ route('data.pemilik.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-rshp-green transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 rounded-lg p-3 group-hover:bg-rshp-green transition-colors">
                            <svg class="w-8 h-8 text-rshp-green group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-rshp-green transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rshp-green transition-colors">Data Pemilik</h4>
                    <p class="text-gray-600 text-sm">Manajemen data pemilik hewan, registrasi pemilik baru dengan dual method</p>
                </div>
            </a>
            @endif
            
            <!-- Tindakan Terapi Card - Administrator -->
            @if(Auth::user()->isAdministrator())
            <a href="{{ route('data.tindakan-terapi.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-500 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 rounded-lg p-3 group-hover:bg-indigo-500 transition-colors">
                            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-500 transition-colors">Tindakan Terapi
                    </h4>
                    <p class="text-gray-600 text-sm">Manajemen kategori, kategori klinis, dan kode tindakan terapi</p>
                </div>
            </a>
            @endif

            <!-- Rekam Medis Card - Administrator, Dokter, Perawat, Pemilik -->
            @if(Auth::user()->isAdministrator() || Auth::user()->isDokter() || Auth::user()->isPerawat() || Auth::user()->isPemilik())
            <a href="{{ route('data.rekam-medis.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-purple-600 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-600 transition-colors">
                            <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-600 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Rekam Medis
                    </h4>
                    <p class="text-gray-600 text-sm">Manajemen rekam medis hewan, diagnosa, anamnesa, dan detail tindakan</p>
                </div>
            </a>
            @endif
            
            <!-- Pet Management Card - Administrator, Dokter, Resepsionis -->
            @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis() || Auth::user()->isPemilik())
            <a href="{{ route('data.pet.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-yellow-500 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-yellow-100 rounded-lg p-3 group-hover:bg-yellow-500 transition-colors">
                            <svg class="w-8 h-8 text-yellow-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-yellow-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-yellow-500 transition-colors">Kelola Hewan
                    </h4>
                    <p class="text-gray-600 text-sm">Manajemen data hewan peliharaan, registrasi pasien hewan baru</p>
                </div>
            </a>
            @endif
            
            <!-- Jenis & Ras Hewan Card - Administrator, Dokter, Resepsionis -->
            @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
            <a href="{{ route('data.jenis-hewan.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-orange-500 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-orange-100 rounded-lg p-3 group-hover:bg-orange-500 transition-colors">
                            <svg class="w-8 h-8 text-orange-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-orange-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-500 transition-colors">Jenis & Ras Hewan
                    </h4>
                    <p class="text-gray-600 text-sm">Manajemen jenis dan ras hewan, kelola klasifikasi hewan peliharaan</p>
                </div>
            </a>
            @endif

            <!-- Multi-Role Profiles Card - Administrator only -->
            {{-- @if(Auth::user()->isAdministrator())
            <a href="{{ route('data.profiles.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-500 transition-all duration-300 group">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 rounded-lg p-3 group-hover:bg-indigo-500 transition-colors">
                            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-500 transition-colors">Multi-Role Profiles
                    </h4>
                    <p class="text-gray-600 text-sm">Kelola pengguna dengan multiple role dalam tampilan tab terintegrasi</p>
                </div>
            </a>
            @endif --}}
        </div>

        <!-- Additional Info Section -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-rshp-blue mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-rshp-blue mb-2">Informasi Dashboard</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Gunakan menu navigasi di atas untuk mengakses berbagai modul manajemen data. Hak akses Anda: 
                        <strong>{{ Auth::user()->roles->pluck('nama_role')->join(', ') }}</strong>.
                        @if(Auth::user()->isAdministrator())
                            Anda memiliki akses penuh ke semua modul dengan fitur CRUD lengkap.
                        @elseif(Auth::user()->isResepsionis())
                            Anda dapat melakukan CRUD pada modul Jenis Hewan, Pet, Pemilik, dan Tindakan Terapi.
                        @elseif(Auth::user()->isDokter())
                            Anda dapat melihat data tetapi tidak dapat melakukan perubahan.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
