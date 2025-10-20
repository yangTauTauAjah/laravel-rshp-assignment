@extends('layouts.app')

@section('title', 'Reset Password - RSHP UNAIR')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-rshp-blue to-rshp-blue-dark flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-auto flex justify-center">
                <img class="h-12 w-auto" src="{{ asset('images/logo-rshp.png') }}" alt="RSHP UNAIR">
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Reset Password
            </h2>
            <p class="mt-2 text-center text-sm text-rshp-blue-100">
                Masukkan password baru Anda
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ request('token') }}">
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" readonly 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-rshp-blue focus:border-rshp-blue focus:z-10 sm:text-sm bg-gray-50" 
                           placeholder="Alamat Email" value="{{ request('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="sr-only">Password Baru</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-rshp-blue focus:border-rshp-blue focus:z-10 sm:text-sm @error('password') border-red-300 @enderror" 
                           placeholder="Password Baru">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-rshp-blue focus:border-rshp-blue focus:z-10 sm:text-sm" 
                           placeholder="Konfirmasi Password Baru">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-rshp-blue hover:bg-rshp-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rshp-blue transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-rshp-blue-300 group-hover:text-rshp-blue-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Reset Password
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-rshp-blue-100 hover:text-white transition-colors duration-200">
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
