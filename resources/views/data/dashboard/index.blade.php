@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Data Dashboard" subtitle="Panel Manajemen Data Berdasarkan Role Anda"
        :backRoute="route('home')" backText="Kembali ke Beranda">
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">

        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-rshp-blue to-blue-600 rounded-lg shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Selamat Datang di Data Dashboard!</h2>
                    <p class="text-blue-100 text-lg">Akses dan kelola data sesuai dengan role Anda di sistem.</p>
                </div>
                <svg class="w-24 h-24 text-blue-200 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>    @if(isset($dashboardData['dokter']))
        <!-- Dokter Dashboard -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-rshp-dark-gray mb-4">Dashboard Dokter</h3>
            <p class="text-gray-600 mb-6">Statistik dan data untuk aktivitas dokter</p>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h8M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Janji Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['dokter']['today_appointments'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Janji Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['dokter']['pending_appointments'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Rekam Medis Saya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['dokter']['my_medical_records'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif    @if(isset($dashboardData['perawat']))
        <!-- Perawat Dashboard -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-rshp-dark-gray mb-4">Dashboard Perawat</h3>
            <p class="text-gray-600 mb-6">Statistik dan data untuk aktivitas perawat</p>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Rekam Medis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['perawat']['total_medical_records'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Rekam Medis Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['perawat']['today_medical_records'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h8M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Janji Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['perawat']['pending_appointments'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif    @if(isset($dashboardData['pemilik']))
        <!-- Pemilik Dashboard -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-rshp-dark-gray mb-4">Dashboard Pemilik</h3>
            <p class="text-gray-600 mb-6">Statistik dan data untuk hewan peliharaan Anda</p>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-rshp-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Hewan Peliharaan Saya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['pemilik']['my_pets'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-rshp-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h8M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Janji Temu Saya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['pemilik']['my_appointments'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Rekam Medis Hewan Saya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['pemilik']['my_medical_records'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif    @if(isset($dashboardData['resepsionis']))
        <!-- Resepsionis Dashboard -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-rshp-dark-gray mb-4">Dashboard Resepsionis</h3>
            <p class="text-gray-600 mb-6">Statistik dan data untuk manajemen klinik</p>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Pemilik</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['resepsionis']['total_owners'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-rshp-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Hewan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['resepsionis']['total_pets'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-rshp-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h8M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Janji Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['resepsionis']['today_appointments'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-rshp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Janji Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dashboardData['resepsionis']['pending_appointments'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif        <!-- Management Modules -->
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-rshp-dark-gray mb-4">Modul Data Management</h3>
            <p class="text-gray-600 mb-6">Akses fitur sesuai dengan role dan hak akses Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @if(in_array('Resepsionis', $userRoles))
                <!-- Pemilik Management Card - Resepsionis -->
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
                        <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rshp-green transition-colors">Kelola Pemilik</h4>
                        <p class="text-gray-600 text-sm">Manajemen data pemilik hewan, registrasi pemilik baru</p>
                    </div>
                </a>
            @endif

            @if(in_array('Resepsionis', $userRoles) || in_array('Pemilik', $userRoles))
                <!-- Pet Management Card -->
                <a href="{{ route('data.pet.index') }}"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-rshp-yellow transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-yellow-100 rounded-lg p-3 group-hover:bg-rshp-yellow transition-colors">
                                <svg class="w-8 h-8 text-rshp-yellow group-hover:text-white transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-rshp-yellow transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rshp-yellow transition-colors">Kelola Hewan</h4>
                        <p class="text-gray-600 text-sm">Manajemen data hewan peliharaan dan registrasi pasien</p>
                    </div>
                </a>

                <!-- Temu Dokter Management Card -->
                <a href="{{ route('data.temu-dokter.index') }}"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-purple-500 transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-500 transition-colors">
                                <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h8M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-500 transition-colors">Janji Temu</h4>
                        <p class="text-gray-600 text-sm">Kelola reservasi dan jadwal konsultasi dokter</p>
                    </div>
                </a>
            @endif

            @if(in_array('Dokter', $userRoles) || in_array('Perawat', $userRoles) || in_array('Pemilik', $userRoles))
                <!-- Rekam Medis Management Card -->
                <a href="{{ route('data.rekam-medis.index') }}"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-500 transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-indigo-100 rounded-lg p-3 group-hover:bg-indigo-500 transition-colors">
                                <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-500 transition-colors">Rekam Medis</h4>
                        <p class="text-gray-600 text-sm">Akses rekam medis sesuai dengan role dan permission</p>
                    </div>
                </a>
            @endif
        </div>

        <!-- Additional Info Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-rshp-blue mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-rshp-blue mb-2">Informasi Dashboard</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Gunakan menu navigasi di atas atau kartu modul untuk mengakses fitur yang tersedia. Role Anda: 
                        <strong>{{ implode(', ', $userRoles) }}</strong>.
                        @if(in_array('Resepsionis', $userRoles))
                            Anda dapat melakukan manajemen data pemilik, hewan, dan janji temu.
                        @elseif(in_array('Dokter', $userRoles))
                            Anda dapat mengelola rekam medis pasien dan melihat jadwal konsultasi.
                        @elseif(in_array('Perawat', $userRoles))
                            Anda dapat mengedit rekam medis dan melihat jadwal dokter.
                        @elseif(in_array('Pemilik', $userRoles))
                            Anda dapat mengelola data hewan peliharaan dan melihat rekam medis.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
