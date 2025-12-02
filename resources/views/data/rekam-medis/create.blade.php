@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Tambah Rekam Medis" subtitle="Buat rekam medis baru untuk hewan peliharaan"
        :backRoute="route('data.rekam-medis.index')" backText="Kembali ke Daftar Rekam Medis" />

    <div class="mx-auto my-6 max-w-4xl w-full flex-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Form Rekam Medis Baru</h2>
            </div>

            <form action="{{ route('data.rekam-medis.store') }}" method="POST" id="rekamMedisForm">
                @csrf
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
                                <option value="{{ $pet->idpet }}" {{ old('idpet') == $pet->idpet ? 'selected' : '' }}>
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
                                <option value="{{ $doctor->idrole_user }}" {{ old('dokter_pemeriksa') == $doctor->idrole_user ? 'selected' : '' }}>
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
                            placeholder="Keluhan pemilik, riwayat penyakit, gejala yang diamati...">{{ old('anamnesa') }}</textarea>
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
                            placeholder="Hasil pemeriksaan fisik, vital sign, temuan abnormal...">{{ old('temuan_klinis') }}</textarea>
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
                            placeholder="Diagnosa berdasarkan temuan klinis dan anamnesa...">{{ old('diagnosa') }}</textarea>
                        @error('diagnosa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Treatment Details Section -->
                    <div class="border-t pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Detail Tindakan & Terapi</h3>
                            <button type="button" onclick="addTindakanRow()"
                                class="bg-rshp-green text-white px-3 py-1 text-sm rounded-md hover:bg-green-700 transition-colors">
                                + Tambah Tindakan
                            </button>
                        </div>
                        
                        <div id="tindakanContainer">
                            <!-- Initial row will be added by JavaScript -->
                        </div>
                        
                        <p class="text-sm text-gray-500 mt-2">
                            <em>Opsional: Tambahkan detail tindakan dan terapi yang dilakukan</em>
                        </p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('data.rekam-medis.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let tindakanCounter = 0;
        let kodeTindakanData = [];        // Load treatment codes
        fetch('/data/rekam-medis/kode-tindakan')
            .then(response => response.json())
            .then(data => {
                kodeTindakanData = /data/;
            })
            .catch(error => {
                console.error('Error loading treatment codes:', error);
            });

        function addTindakanRow() {
            const container = document.getElementById('tindakanContainer');
            const rowHtml = `
                <div class="tindakan-row border border-gray-200 rounded-md p-4 mb-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Tindakan/Terapi
                            </label>
                            <select name="detail_tindakan[${tindakanCounter}][idkode_tindakan_terapi]" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih kode tindakan...</option>
                                ${kodeTindakanData.map(kode => 
                                    `<option value="${kode.idkode_tindakan_terapi}">
                                        ${kode.kode} - ${kode.deskripsi_tindakan_terapi}
                                    </option>`
                                ).join('')}
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Detail Tambahan
                            </label>
                            <div class="flex space-x-2">
                                <input type="text" name="detail_tindakan[${tindakanCounter}][detail]" 
                                    placeholder="Detail opsional..."
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <button type="button" onclick="removeTindakanRow(this)" 
                                    class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', rowHtml);
            tindakanCounter++;
        }

        function removeTindakanRow(button) {
            const row = button.closest('.tindakan-row');
            row.remove();
        }

        // Add initial row when page loads
        document.addEventListener('DOMContentLoaded', function() {
            addTindakanRow();
        });
    </script>
@endsection
