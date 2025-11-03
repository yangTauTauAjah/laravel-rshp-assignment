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
                Verifikasi Email
            </h2>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4 text-sm text-gray-600">
                Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email, kami dengan senang hati akan mengirimkan yang lain.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="bg-rshp-blue text-white px-4 py-2 rounded-md hover:bg-rshp-dark-blue transition-colors">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
