@extends('layouts.app')

@section('title', 'Struktur Organisasi - RSHP UNAIR')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-rshp-blue to-rshp-light-blue text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Struktur Organisasi</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Tim profesional dan berpengalaman yang mengutamakan kesejahteraan hewan dengan pelayanan terbaik
        </p>
    </div>
</section>

<!-- Organization Overview -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-rshp-dark-gray mb-4">Tentang RSHP UNAIR</h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto">
                Rumah Sakit Hewan Pendidikan Universitas Airlangga adalah institusi pendidikan dan pelayanan kesehatan hewan 
                yang berkomitmen memberikan layanan terbaik dengan dukungan tenaga profesional dan fasilitas modern.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Vision -->
            <div class="text-center p-6 bg-blue-50 rounded-lg">
                <div class="bg-rshp-blue p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-rshp-dark-gray mb-3">Visi</h3>
                <p class="text-gray-600">
                    Menjadi rumah sakit hewan pendidikan terdepan yang menghasilkan lulusan veteriner berkualitas dan memberikan pelayanan kesehatan hewan terbaik.
                </p>
            </div>

            <!-- Mission -->
            <div class="text-center p-6 bg-green-50 rounded-lg">
                <div class="bg-rshp-green p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-rshp-dark-gray mb-3">Misi</h3>
                <p class="text-gray-600">
                    Menyelenggarakan pendidikan, penelitian, dan pengabdian masyarakat di bidang kedokteran hewan dengan standar internasional.
                </p>
            </div>

            <!-- Values -->
            <div class="text-center p-6 bg-yellow-50 rounded-lg">
                <div class="bg-rshp-yellow p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-rshp-dark-gray mb-3">Nilai</h3>
                <p class="text-gray-600">
                    Integritas, profesionalisme, inovasi, dan kepedulian terhadap kesejahteraan hewan dan kepuasan klien.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Organizational Chart -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-rshp-dark-gray mb-4">Struktur Organisasi</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Hierarki kepemimpinan dan struktur organisasi RSHP UNAIR
            </p>
        </div>

        <!-- Director Level -->
        <div class="text-center mb-12">
            <div class="inline-block bg-white p-6 rounded-lg shadow-lg border-2 border-rshp-blue">
                <div class="w-20 h-20 bg-rshp-blue rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-rshp-dark-gray">Direktur RSHP</h3>
                <p class="text-sm text-gray-600">Prof. Dr. drh. Mirni Lamid, M.P.</p>
                <div class="mt-2 px-3 py-1 bg-rshp-blue text-white text-xs rounded-full">Direktur</div>
            </div>
        </div>

        <!-- Management Level -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Deputy Director -->
            <div class="text-center">
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-rshp-light-blue rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Wakil Direktur</h3>
                    <p class="text-sm text-gray-600 mb-2">Dr. drh. Suwarno, M.P.</p>
                    <div class="px-3 py-1 bg-rshp-light-blue text-white text-xs rounded-full">Wakil Direktur</div>
                </div>
            </div>

            <!-- Head of Medical Services -->
            <div class="text-center">
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-rshp-green rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Kepala Medis</h3>
                    <p class="text-sm text-gray-600 mb-2">drh. Bambang Sumiarto, M.Si.</p>
                    <div class="px-3 py-1 bg-rshp-green text-white text-xs rounded-full">Kepala Medis</div>
                </div>
            </div>

            <!-- Head of Administration -->
            <div class="text-center">
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-rshp-orange rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Kepala Administrasi</h3>
                    <p class="text-sm text-gray-600 mb-2">Dra. Siti Nurhalifah, M.M.</p>
                    <div class="px-3 py-1 bg-rshp-orange text-white text-xs rounded-full">Kepala Administrasi</div>
                </div>
            </div>
        </div>

        <!-- Department Level -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Surgery Department -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-red-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m5 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m-5 4h4"></path>
                    </svg>
                </div>
                <h4 class="text-md font-semibold text-rshp-dark-gray mb-2">Bedah & Operasi</h4>
                <p class="text-sm text-gray-600 mb-2">drh. Ahmad Fauzi, M.Vet.</p>
                <div class="text-xs text-gray-500">Kepala Divisi</div>
            </div>

            <!-- Internal Medicine -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h4 class="text-md font-semibold text-rshp-dark-gray mb-2">Penyakit Dalam</h4>
                <p class="text-sm text-gray-600 mb-2">drh. Sari Dewi, M.Sc.</p>
                <div class="text-xs text-gray-500">Kepala Divisi</div>
            </div>

            <!-- Laboratory -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h4 class="text-md font-semibold text-rshp-dark-gray mb-2">Laboratorium</h4>
                <p class="text-sm text-gray-600 mb-2">drh. Ratna Sari, M.Si.</p>
                <div class="text-xs text-gray-500">Kepala Lab</div>
            </div>

            <!-- Radiology -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-teal-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </div>
                <h4 class="text-md font-semibold text-rshp-dark-gray mb-2">Radiologi</h4>
                <p class="text-sm text-gray-600 mb-2">drh. Budi Santoso, M.Vet.</p>
                <div class="text-xs text-gray-500">Kepala Divisi</div>
            </div>
        </div>
    </div>
</section>

<!-- Medical Staff -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-rshp-dark-gray mb-4">Tim Dokter Hewan</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Tim dokter hewan berpengalaman dan bersertifikat yang siap melayani hewan kesayangan Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Doctor 1 -->
            <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-br from-rshp-blue to-blue-400 flex items-center justify-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-rshp-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-rshp-dark-gray mb-2">drh. Lisa Permatasari, M.Vet.</h3>
                    <p class="text-rshp-blue font-medium mb-2">Dokter Hewan Senior</p>
                    <p class="text-gray-600 text-sm mb-3">Spesialis bedah dan penyakit dalam dengan pengalaman 15 tahun</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">Bedah</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Penyakit Dalam</span>
                    </div>
                </div>
            </div>

            <!-- Doctor 2 -->
            <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-br from-rshp-green to-green-400 flex items-center justify-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-rshp-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-rshp-dark-gray mb-2">drh. Andi Kurniawan, M.Si.</h3>
                    <p class="text-rshp-green font-medium mb-2">Dokter Hewan</p>
                    <p class="text-gray-600 text-sm mb-3">Ahli vaksinasi dan perawatan hewan kecil dengan dedikasi tinggi</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Vaksinasi</span>
                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">Hewan Kecil</span>
                    </div>
                </div>
            </div>

            <!-- Doctor 3 -->
            <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gradient-to-br from-rshp-orange to-orange-400 flex items-center justify-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-rshp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-rshp-dark-gray mb-2">drh. Maya Indrawati, M.Vet.</h3>
                    <p class="text-rshp-orange font-medium mb-2">Dokter Hewan</p>
                    <p class="text-gray-600 text-sm mb-3">Spesialis radiologi dan diagnostik dengan teknologi terkini</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-teal-100 text-teal-800 text-xs rounded">Radiologi</span>
                        <span class="px-2 py-1 bg-pink-100 text-pink-800 text-xs rounded">Diagnostik</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Support Staff -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-rshp-dark-gray mb-4">Tim Pendukung</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Tim pendukung profesional yang memastikan operasional rumah sakit berjalan dengan baik
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Nurses -->
            <div class="text-center bg-white p-6 rounded-lg shadow-md">
                <div class="w-16 h-16 bg-pink-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Perawat Hewan</h3>
                <p class="text-gray-600 text-sm">Tim perawat berpengalaman dalam perawatan dan handling hewan</p>
                <p class="text-rshp-blue font-medium mt-2">8 Orang</p>
            </div>

            <!-- Lab Technicians -->
            <div class="text-center bg-white p-6 rounded-lg shadow-md">
                <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Teknisi Lab</h3>
                <p class="text-gray-600 text-sm">Ahli dalam analisis laboratorium dan diagnostik</p>
                <p class="text-rshp-blue font-medium mt-2">4 Orang</p>
            </div>

            <!-- Administrative Staff -->
            <div class="text-center bg-white p-6 rounded-lg shadow-md">
                <div class="w-16 h-16 bg-yellow-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Staf Administrasi</h3>
                <p class="text-gray-600 text-sm">Mengelola administrasi dan layanan pelanggan</p>
                <p class="text-rshp-blue font-medium mt-2">6 Orang</p>
            </div>

            <!-- Support Staff -->
            <div class="text-center bg-white p-6 rounded-lg shadow-md">
                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-rshp-dark-gray mb-2">Tim Pendukung</h3>
                <p class="text-gray-600 text-sm">Maintenance, keamanan, dan cleaning service</p>
                <p class="text-rshp-blue font-medium mt-2">5 Orang</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-rshp-blue text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Bergabung dengan Tim Kami</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Kami selalu mencari profesional yang berkomitmen untuk bergabung dengan tim RSHP UNAIR
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('kontak') }}" 
               class="bg-rshp-yellow text-rshp-dark-gray px-8 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition-colors duration-200 transform hover:scale-105">
                Info Karir
            </a>
            <a href="{{ route('layanan') }}" 
               class="border-2 border-white text-white hover:bg-white hover:text-rshp-blue px-8 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105">
                Lihat Layanan Kami
            </a>
        </div>
    </div>
</section>
@endsection
