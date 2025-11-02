@extends('layouts.app')

@section('title', 'Register - RSHP UNAIR')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-auto flex justify-center">
                <h2 class="text-3xl font-bold text-rshp-blue">RSHP UNAIR</h2>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-rshp-dark-gray">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau
                <a href="{{ route('login') }}" class="font-medium text-rshp-blue hover:text-rshp-dark-blue">
                    masuk ke akun yang sudah ada
                </a>
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-rshp-blue focus:border-rshp-blue sm:text-sm @error('name') border-red-500 @enderror" 
                           placeholder="Masukkan nama lengkap Anda"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-rshp-blue focus:border-rshp-blue sm:text-sm @error('email') border-red-500 @enderror" 
                           placeholder="alamat@email.com"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-rshp-blue focus:border-rshp-blue sm:text-sm @error('password') border-red-500 @enderror" 
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password *</label>
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-rshp-blue focus:border-rshp-blue sm:text-sm" 
                           placeholder="Ulangi password">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-rshp-blue hover:bg-rshp-dark-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rshp-blue transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-rshp-light-blue group-hover:text-rshp-yellow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                        </svg>
                    </span>
                    Daftar Sekarang
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-rshp-blue hover:text-rshp-dark-blue">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>

        <!-- Benefits Section -->
        <div class="mt-8">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-rshp-dark-gray mb-3">
                    ✨ Keuntungan Menjadi Member RSHP UNAIR:
                </h3>
                <ul class="text-xs text-gray-600 space-y-1">
                    <li>• Akses mudah untuk booking konsultasi</li>
                    <li>• Riwayat kesehatan hewan tersimpan aman</li>
                    <li>• Notifikasi jadwal vaksinasi</li>
                    <li>• Promo khusus dan diskon layanan</li>
                    <li>• Konsultasi online dengan dokter hewan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
