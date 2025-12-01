@extends('layouts.app')

@section('content')    <!-- Page Header -->
    <x-admin-header title="Tambah Reservasi Dokter" subtitle="Buat reservasi dokter baru"
        :backRoute="route('data.temu-dokter.index')" backText="Kembali ke Daftar Reservasi" />

    <div class="mx-auto my-6 max-w-2xl w-full flex-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Form Reservasi Dokter</h2>
            </div>

            <form action="{{ route('data.temu-dokter.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Doctor Selection -->
                <div>
                    <label for="idrole_user" class="block text-sm font-medium text-gray-700 mb-2">
                        Dokter Pemeriksa <span class="text-red-500">*</span>
                    </label>
                    <select id="idrole_user" name="idrole_user" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('idrole_user') border-red-500 @enderror">
                        <option value="">Pilih dokter pemeriksa...</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->idrole_user }}" {{ old('idrole_user') == $doctor->idrole_user ? 'selected' : '' }}>
                                {{ $doctor->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('idrole_user')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Registration Time -->
                <div>
                    <label for="waktu_daftar" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu Pendaftaran <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="waktu_daftar" name="waktu_daftar" 
                        value="{{ old('waktu_daftar', now()->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('waktu_daftar') border-red-500 @enderror">
                    @error('waktu_daftar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('status') border-red-500 @enderror">
                        <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Menunggu</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Selesai</option>
                        <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800 mb-1">Informasi</h4>
                            <p class="text-blue-700 text-sm">
                                Nomor antrian akan digenerate otomatis berdasarkan urutan pendaftaran pada hari yang sama.
                                Setelah reservasi dibuat, Anda dapat menambahkan rekam medis dari halaman detail reservasi.
                            </p>
                        </div>
                    </div>
                </div>                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('data.temu-dokter.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
