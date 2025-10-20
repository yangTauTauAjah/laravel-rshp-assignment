@extends('layouts.app')

@section('title', 'Layanan - RSHP UNAIR')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-rshp-blue to-rshp-light-blue text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Layanan Kami</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Rumah Sakit Hewan Pendidikan UNAIR menyediakan layanan kesehatan hewan terbaik dengan teknologi modern dan tenaga medis berpengalaman
        </p>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Services -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-rshp-dark-gray mb-4">Layanan Medis</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Kami menyediakan berbagai layanan kesehatan hewan dengan standar medis veteriner terbaik
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-rshp-light-blue to-blue-400 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray mb-3">Pemeriksaan Umum</h3>
                    <p class="text-gray-600 mb-4">
                        Pemeriksaan kesehatan rutin untuk menjaga kondisi optimal hewan kesayangan Anda
                    </p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Pemeriksaan fisik lengkap</li>
                        <li>• Konsultasi kesehatan</li>
                        <li>• Pemberian vitamin</li>
                        <li>• Cek kondisi umum</li>
                    </ul>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-rshp-orange to-orange-400 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray mb-3">Vaksinasi</h3>
                    <p class="text-gray-600 mb-4">
                        Program vaksinasi lengkap untuk melindungi hewan dari berbagai penyakit berbahaya
                    </p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Vaksin rabies</li>
                        <li>• Vaksin 4-in-1 (DHPPi)</li>
                        <li>• Vaksin kucing (Tricat)</li>
                        <li>• Jadwal vaksinasi teratur</li>
                    </ul>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-rshp-green to-green-400 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m5 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m-5 4h4"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray mb-3">Operasi & Bedah</h3>
                    <p class="text-gray-600 mb-4">
                        Layanan operasi dengan fasilitas bedah modern dan tim dokter hewan berpengalaman
                    </p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Sterilisasi (kastrasi/ovariohisterektomi)</li>
                        <li>• Operasi tumor</li>
                        <li>• Bedah tulang</li>
                        <li>• Operasi darurat</li>
                    </ul>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-400 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray mb-3">Laboratorium</h3>
                    <p class="text-gray-600 mb-4">
                        Pemeriksaan laboratorium lengkap untuk diagnosis yang tepat dan akurat
                    </p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Tes darah lengkap</li>
                        <li>• Urinalisis</li>
                        <li>• Tes feses</li>
                        <li>• Mikroskopi</li>
                    </ul>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-pink-500 to-pink-400 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray mb-3">Perawatan Intensif</h3>
                    <p class="text-gray-600 mb-4">
                        Rawat inap dengan perawatan intensif 24 jam untuk kondisi medis yang memerlukan perhatian khusus
                    </p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• ICU hewan</li>
                        <li>• Monitoring 24/7</li>
                        <li>• Terapi infus</li>
                        <li>• Perawatan pasca operasi</li>
                    </ul>
                </div>
            </div>

            <!-- Service 6 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-teal-500 to-teal-400 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray mb-3">Radiologi</h3>
                    <p class="text-gray-600 mb-4">
                        Pemeriksaan radiologi dengan teknologi terkini untuk diagnosis yang lebih akurat
                    </p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• X-Ray digital</li>
                        <li>• USG (Ultrasonografi)</li>
                        <li>• Analisis hasil radiologi</li>
                        <li>• Konsultasi radiologi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Services -->
<section class="py-16 bg-red-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-rshp-dark-gray mb-4">Layanan Darurat</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Siap melayani kondisi darurat hewan kesayangan Anda 24/7
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-red-600 mb-4">🚨 Layanan Darurat 24 Jam</h3>
                    <p class="text-gray-600 mb-6">
                        Tim dokter hewan kami siap melayani kondisi darurat kapan saja. Jangan ragu untuk menghubungi kami jika hewan kesayangan Anda memerlukan pertolongan segera.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <span class="font-semibold text-rshp-dark-gray">Hotline Darurat: 0858-0633-6433</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600">Buka 24 jam setiap hari</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-600">Kampus C UNAIR, Mulyorejo, Surabaya</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-red-100 rounded-full p-8 inline-block">
                        <svg class="w-24 h-24 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="mt-4 text-sm text-gray-600 max-w-xs mx-auto">
                        Kondisi darurat memerlukan penanganan segera. Hubungi kami sekarang juga!
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-rshp-blue text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Merawat Hewan Kesayangan Anda?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Jadwalkan konsultasi dengan dokter hewan profesional kami hari ini
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('kontak') }}" 
               class="bg-rshp-yellow text-rshp-dark-gray px-8 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition-colors duration-200 transform hover:scale-105">
                Hubungi Kami
            </a>
            <a href="tel:0858-0633-6433" 
               class="border-2 border-white text-white hover:bg-white hover:text-rshp-blue px-8 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105">
                Call Now: 0858-0633-6433
            </a>
        </div>
    </div>
</section>
@endsection
