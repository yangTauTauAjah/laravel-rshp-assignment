@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Edit Reservasi Dokter" subtitle="Perbarui informasi reservasi dokter"
        :backRoute="route('data.temu-dokter.show', $temuDokter->idreservasi_dokter)" backText="Kembali ke Detail">
        
        <x-slot:actionButton>
            <a href="{{ route('data.dashboard') }}"
                class="inline-flex items-center px-3 py-2 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
                Dashboard
            </a>
        </x-slot:actionButton>
    </x-admin-header>

    <div class="mx-auto my-6 max-w-4xl w-full flex-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Form Edit Reservasi</h2>
            </div>

            <form action="{{ route('data.temu-dokter.update', $temuDokter->idreservasi_dokter) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">

                    <!-- Doctor Selection -->
                    <div>
                        <label for="idrole_user" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Dokter <span class="text-red-500">*</span>
                        </label>
                        <select id="idrole_user" name="idrole_user" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="">Pilih dokter...</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->idrole_user }}" 
                                    {{ old('idrole_user', $temuDokter->idrole_user) == $doctor->idrole_user ? 'selected' : '' }}>
                                    {{ $doctor->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('idrole_user')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div>
                        <label for="waktu_daftar" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Reservasi <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="waktu_daftar" name="waktu_daftar" required
                            value="{{ old('waktu_daftar', \Carbon\Carbon::parse($temuDokter->waktu_daftar)->format('Y-m-d\TH:i')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                        @error('waktu_daftar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Queue Number -->
                    <div>
                        <label for="no_urut" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Antrian <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="no_urut" name="no_urut" min="1" required
                            value="{{ old('no_urut', $temuDokter->no_urut) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                        @error('no_urut')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">
                            <em>Pastikan nomor antrian tidak duplikat untuk dokter dan tanggal yang sama</em>
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Reservasi <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="0" {{ old('status', $temuDokter->status) == '0' ? 'selected' : '' }}>
                                Menunggu
                            </option>
                            <option value="1" {{ old('status', $temuDokter->status) == '1' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="2" {{ old('status', $temuDokter->status) == '2' ? 'selected' : '' }}>
                                Batal
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Information Display -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Saat Ini</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-600">ID Reservasi:</span>
                                <span class="text-gray-900">{{ $temuDokter->idreservasi_dokter }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Dibuat:</span>
                                <span class="text-gray-900">{{ \Carbon\Carbon::parse($temuDokter->waktu_daftar)->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('data.temu-dokter.show', $temuDokter->idreservasi_dokter) }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                        Perbarui Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
