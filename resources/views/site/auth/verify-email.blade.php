@extends('layouts.app')

@section('title', 'Verifikasi Email - RSHP UNAIR')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-auto flex justify-center">
                <h2 class="text-3xl font-bold text-rshp-blue">RSHP UNAIR</h2>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-rshp-dark-gray">
                Verifikasi Email Anda
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link yang telah kami kirimkan melalui email.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">
                    Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat registrasi.
                </span>
            </div>
        @endif

        <div class="bg-blue-50 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Verifikasi Email Diperlukan
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>
                            Untuk mengakses layanan RSHP UNAIR, Anda perlu memverifikasi alamat email Anda terlebih dahulu. 
                            Ini membantu kami memastikan keamanan akun Anda dan memberikan layanan terbaik.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-rshp-blue hover:bg-rshp-dark-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rshp-blue transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-rshp-light-blue group-hover:text-rshp-yellow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </span>
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rshp-blue transition-colors duration-200">
                    Logout
                </button>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-rshp-dark-gray mb-2">
                    📧 Tidak Menerima Email?
                </h3>
                <p class="text-xs text-gray-600 mb-2">
                    Periksa folder spam/junk email Anda. Jika masih belum menerima, klik tombol "Kirim Ulang" di atas.
                </p>
                <p class="text-xs text-gray-600">
                    Untuk bantuan lebih lanjut, hubungi admin RSHP UNAIR.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
