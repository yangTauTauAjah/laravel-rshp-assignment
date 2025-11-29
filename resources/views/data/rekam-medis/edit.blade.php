@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Edit Rekam Medis" subtitle="Perbarui informasi rekam medis hewan peliharaan"
        :backRoute="route('data.rekam-medis.show', $rekamMedis->idrekam_medis)" backText="Kembali ke Detail">
        
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
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Edit Rekam Medis #{{ $rekamMedis->idrekam_medis }}</h2>
            </div>

            <form action="{{ route('data.rekam-medis.update', $rekamMedis->idrekam_medis) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">

                    <!-- Pet Selection -->
                    <div>
                        <label for="idpet" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Hewan Pasien <span class="text-red-500">*</span>
                        </label>
                        <select id="idpet" name="idpet" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="">Pilih hewan pasien...</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->idpet }}" 
                                    {{ (old('idpet', $rekamMedis->idpet) == $pet->idpet) ? 'selected' : '' }}>
                                    {{ $pet->nama }} - {{ $pet->nama_ras }} ({{ $pet->nama_jenis_hewan }}) - Pemilik: {{ $pet->pemilik_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('idpet')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor Selection -->
                    <div>
                        <label for="dokter_pemeriksa" class="block text-sm font-medium text-gray-700 mb-2">
                            Dokter Pemeriksa <span class="text-red-500">*</span>
                        </label>
                        <select id="dokter_pemeriksa" name="dokter_pemeriksa" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="">Pilih dokter pemeriksa...</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->idrole_user }}" 
                                    {{ (old('dokter_pemeriksa', $rekamMedis->dokter_pemeriksa) == $doctor->idrole_user) ? 'selected' : '' }}>
                                    {{ $doctor->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('dokter_pemeriksa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Anamnesis -->
                    <div>
                        <label for="anamnesa" class="block text-sm font-medium text-gray-700 mb-2">
                            Anamnesa <span class="text-red-500">*</span>
                        </label>
                        <textarea id="anamnesa" name="anamnesa" required rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Keluhan pemilik, riwayat penyakit, gejala yang diamati...">{{ old('anamnesa', $rekamMedis->anamnesa) }}</textarea>
                        @error('anamnesa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Clinical Findings -->
                    <div>
                        <label for="temuan_klinis" class="block text-sm font-medium text-gray-700 mb-2">
                            Temuan Klinis <span class="text-red-500">*</span>
                        </label>
                        <textarea id="temuan_klinis" name="temuan_klinis" required rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Hasil pemeriksaan fisik, vital sign, temuan abnormal...">{{ old('temuan_klinis', $rekamMedis->temuan_klinis) }}</textarea>
                        @error('temuan_klinis')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Diagnosis -->
                    <div>
                        <label for="diagnosa" class="block text-sm font-medium text-gray-700 mb-2">
                            Diagnosa <span class="text-red-500">*</span>
                        </label>
                        <textarea id="diagnosa" name="diagnosa" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Diagnosa berdasarkan temuan klinis dan anamnesa...">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                        @error('diagnosa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Existing Treatment Details Display - Only visible for Dokter and Administrator -->
                    @if($detailRekamMedis->isNotEmpty())
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Tindakan & Terapi Saat Ini</h3>
                        <div class="bg-gray-50 rounded-md p-4">
                            <div class="space-y-3">
                                @foreach($detailRekamMedis as $detail)
                                <div class="flex justify-between items-center py-2 px-3 bg-white rounded border">
                                    <div class="flex-1">
                                        <span class="font-medium text-rshp-blue">{{ $detail->idkode_tindakan_terapi }}</span>
                                        @if($detail->detail)
                                            <span class="ml-2 text-gray-600">- {{ $detail->detail }}</span>
                                        @endif
                                    </div>
                                    @if($canManageDetails)
                                    <form method="POST" action="{{ route('data.rekam-medis.delete-detail', $detail->iddetail_rekam_medis) }}" 
                                        class="inline" onsubmit="return confirm('Hapus detail tindakan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @if($canManageDetails)
                            <p class="text-sm text-gray-500 mt-3">
                                <em>Catatan: Untuk mengedit detail tindakan, silakan hapus dan tambah ulang melalui halaman detail rekam medis.</em>
                            </p>
                            @else
                            <div class="bg-amber-50 border border-amber-200 rounded-md p-3 mt-3">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-amber-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-amber-800">Akses Terbatas</p>
                                        <p class="text-sm text-amber-700 mt-1">
                                            Sebagai perawat, Anda hanya dapat melihat detail tindakan. Pengelolaan detail tindakan hanya dapat dilakukan oleh dokter atau administrator.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Information about created date -->
                    <div class="border-t pt-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm">
                                    <p class="font-medium text-blue-800">Informasi Rekam Medis</p>
                                    <p class="text-blue-700 mt-1">
                                        Rekam medis ini dibuat pada: <strong>{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y, H:i') }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('data.rekam-medis.show', $rekamMedis->idrekam_medis) }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                        Update Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
