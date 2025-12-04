@extends('layouts.app')

@section('content')
    <div class="mx-auto my-6 max-w-6xl w-full flex-1 px-4">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-rshp-dark-gray">Profil Saya</h1>
            <p class="text-gray-600 mt-1">Kelola informasi profil Anda berdasarkan role yang dimiliki</p>
        </div>
        @if(empty($profiles))
            <!-- No profiles available -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Profil</h3>
                @if(auth()->user()->hasRole('administrator'))
                    <p class="text-gray-600 mb-4">Sebagai administrator, Anda dapat membuat profil untuk diri sendiri melalui halaman pengelolaan data.</p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <a href="{{ route('data.pemilik.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Buat Profil Pemilik
                        </a>
                        <a href="{{ route('data.dokter.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Buat Profil Dokter
                        </a>
                        <a href="{{ route('data.perawat.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Buat Profil Perawat
                        </a>
                    </div>
                @else
                    <p class="text-gray-600">Anda belum memiliki profil khusus. Hubungi administrator untuk mendapatkan akses profil.</p>
                @endif
            </div>
        @else
            <!-- Tabs Navigation -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        @if(isset($profiles['pemilik']))
                            <button onclick="showTab('pemilik')" 
                                    id="tab-pemilik"
                                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil Pemilik
                            </button>
                        @endif
                        
                        @if(isset($profiles['dokter']))
                            <button onclick="showTab('dokter')" 
                                    id="tab-dokter"
                                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Profil Dokter
                            </button>
                        @endif
                        
                        @if(isset($profiles['perawat']))
                            <button onclick="showTab('perawat')" 
                                    id="tab-perawat"
                                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                Profil Perawat
                            </button>
                        @endif
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    @if(isset($profiles['pemilik']))
                        <div id="content-pemilik" class="tab-content hidden">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h2 class="text-xl font-semibold text-rshp-dark-gray">Profil Pemilik</h2>
                                    <p class="text-gray-600 mt-1">Informasi sebagai pemilik hewan peliharaan</p>
                                </div>
                                <a href="{{ route('profile.edit', 'pemilik') }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profil
                                </a>
                            </div>
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->nama }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['pemilik']->alamat ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['pemilik']->no_wa ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Data Management Section for Pemilik -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Kelola Data Saya</h3>
                                    <p class="text-gray-600">Akses fitur manajemen data khusus pemilik</p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <a href="{{ route('data.pet.index') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-green-100 rounded-lg p-3 group-hover:bg-green-500 transition-colors">
                                                    <svg class="w-8 h-8 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-500 transition-colors">Hewan Peliharaan</h4>
                                            <p class="text-gray-600 text-sm">Kelola data hewan peliharaan saya</p>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ route('data.rekam-medis.index') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-blue-100 rounded-lg p-3 group-hover:bg-blue-500 transition-colors">
                                                    <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-500 transition-colors">Rekam Medis</h4>
                                            <p class="text-gray-600 text-sm">Lihat rekam medis hewan saya (read-only)</p>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ route('data.temu-dokter.index') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-purple-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-500 transition-colors">
                                                    <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h8M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-500 transition-colors">Janji Temu</h4>
                                            <p class="text-gray-600 text-sm">Kelola janji temu dengan dokter</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($profiles['dokter']))
                        <div id="content-dokter" class="tab-content hidden">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h2 class="text-xl font-semibold text-rshp-dark-gray">Profil Dokter</h2>
                                    <p class="text-gray-600 mt-1">Informasi sebagai dokter hewan</p>
                                </div>
                                <a href="{{ route('profile.edit', 'dokter') }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profil
                                </a>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                        <p class="mt-1 text-sm text-gray-900">Dr. {{ $user->nama }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Bidang Keahlian</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['dokter']->bidang_dokter }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $profiles['dokter']->jenis_kelamin == 'M' ? 'Laki-laki' : 'Perempuan' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['dokter']->alamat }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['dokter']->no_hp }}</p>
                                    </div>
                                </div>
                            </div>
                              <!-- Data Management Section for Dokter -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Akses Fitur Dokter</h3>
                                    <p class="text-gray-600">Panel kontrol untuk manajemen rekam medis dan dashboard</p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <a href="{{ route('data.rekam-medis.index') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-blue-100 rounded-lg p-3 group-hover:bg-blue-500 transition-colors">
                                                    <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-500 transition-colors">Rekam Medis</h4>
                                            <p class="text-gray-600 text-sm">Kelola rekam medis pasien saya dan buat diagnosis</p>
                                        </div>
                                    </a>

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
                                    
                                    {{-- <a href="{{ route('data.dashboard') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-indigo-100 rounded-lg p-3 group-hover:bg-indigo-500 transition-colors">
                                                    <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-500 transition-colors">Dashboard</h4>
                                            <p class="text-gray-600 text-sm">Lihat statistik, jadwal, dan aktivitas harian saya</p>
                                        </div>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($profiles['perawat']))
                        <div id="content-perawat" class="tab-content hidden">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h2 class="text-xl font-semibold text-rshp-dark-gray">Profil Perawat</h2>
                                    <p class="text-gray-600 mt-1">Informasi sebagai perawat hewan</p>
                                </div>
                                <a href="{{ route('profile.edit', 'perawat') }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profil
                                </a>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->nama }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Pendidikan</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['perawat']->pendidikan }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ $profiles['perawat']->jenis_kelamin == 'M' ? 'Laki-laki' : 'Perempuan' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['perawat']->alamat }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profiles['perawat']->no_hp }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Management Section for Perawat -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Akses Fitur Perawat</h3>
                                    <p class="text-gray-600">Panel kontrol untuk mendukung layanan medis dan administratif</p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <a href="{{ route('data.rekam-medis.index') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-purple-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-500 transition-colors">
                                                    <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-500 transition-colors">Rekam Medis</h4>
                                            <p class="text-gray-600 text-sm">Edit rekam medis pasien dan bantu dokumentasi</p>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ route('data.temu-dokter.index') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-teal-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-teal-100 rounded-lg p-3 group-hover:bg-teal-500 transition-colors">
                                                    <svg class="w-8 h-8 text-teal-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h8M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-teal-500 transition-colors">Jadwal Dokter</h4>
                                            <p class="text-gray-600 text-sm">Lihat jadwal janji temu dan atur antrian pasien</p>
                                        </div>
                                    </a>
                                    
                                    {{-- <a href="{{ route('data.dashboard') }}" 
                                       class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-500 transition-all duration-300 group">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-indigo-100 rounded-lg p-3 group-hover:bg-indigo-500 transition-colors">
                                                    <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                                    </svg>
                                                </div>
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-500 transition-colors">Dashboard</h4>
                                            <p class="text-gray-600 text-sm">Lihat statistik klinik dan aktivitas harian</p>
                                        </div>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <script>
        let activeTab = '';
        
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active styling from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-rshp-blue', 'text-rshp-blue');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            const content = document.getElementById(`content-${tabName}`);
            if (content) {
                content.classList.remove('hidden');
            }
            
            // Add active styling to selected tab
            const tab = document.getElementById(`tab-${tabName}`);
            if (tab) {
                tab.classList.remove('border-transparent', 'text-gray-500');
                tab.classList.add('border-rshp-blue', 'text-rshp-blue');
            }
            
            activeTab = tabName;
        }
        
        // Initialize first available tab
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($profiles['pemilik']))
                showTab('pemilik');
            @elseif(isset($profiles['dokter']))
                showTab('dokter');
            @elseif(isset($profiles['perawat']))
                showTab('perawat');
            @endif
        });
    </script>
@endsection
