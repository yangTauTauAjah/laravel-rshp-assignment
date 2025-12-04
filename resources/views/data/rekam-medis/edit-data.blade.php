@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Edit Data Rekam Medis" subtitle="Edit informasi utama rekam medis (hanya data, bukan detail tindakan)"
        :backRoute="route('data.rekam-medis.index')" backText="Kembali ke Rekam Medis" />

    <div class="mx-auto my-6 max-w-4xl w-full flex-1">
        
        <!-- Info Card -->
        {{-- <div class="mb-6 bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-purple-600 mb-2">Edit Data Utama Rekam Medis</h4>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Halaman ini untuk mengedit data utama rekam medis seperti anamnesa, temuan klinis, dan diagnosa. 
                        @if(Auth::user()->hasRole('Perawat') && !Auth::user()->hasRole('Administrator'))
                            Sebagai Perawat, Anda dapat mengedit data utama tetapi tidak dapat mengelola detail tindakan.
                        @else
                            Detail tindakan dikelola secara terpisah melalui halaman "Edit Detail Tindakan".
                        @endif
                    </p>
                </div>
            </div>
        </div> --}}

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Form Edit Data Rekam Medis</h2>
            </div>

            <form action="{{ route('data.rekam-medis.update-data', $rekamMedis->idrekam_medis) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Pet Selection -->
                    <div>
                        <label for="idpet" class="block text-sm font-medium text-gray-700 mb-2">
                            Hewan Pasien <span class="text-red-500">*</span>
                        </label>
                        <select id="idpet" name="idpet" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('idpet') border-red-500 @enderror">
                            <option value="">Pilih hewan pasien...</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->idpet }}" {{ $rekamMedis->idpet == $pet->idpet ? 'selected' : '' }}>
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('dokter_pemeriksa') border-red-500 @enderror">
                            <option value="">Pilih dokter pemeriksa...</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->idrole_user }}" {{ $rekamMedis->dokter_pemeriksa == $doctor->idrole_user ? 'selected' : '' }}>
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('anamnesa') border-red-500 @enderror"
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('temuan_klinis') border-red-500 @enderror"
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
                        <textarea id="diagnosa" name="diagnosa" required rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue @error('diagnosa') border-red-500 @enderror"
                            placeholder="Diagnosa berdasarkan temuan klinis dan anamnesa...">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                        @error('diagnosa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t">
                    <a href="{{ route('data.rekam-medis.index') }}"
                        class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-save form data to localStorage while typing
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                localStorage.setItem(`edit_rekam_medis_${this.name}`, this.value);
            });
        });
        
        // Clear localStorage when form is submitted successfully
        form.addEventListener('submit', function() {
            inputs.forEach(input => {
                localStorage.removeItem(`edit_rekam_medis_${input.name}`);
            });
        });
    });
</script>
@endpush
