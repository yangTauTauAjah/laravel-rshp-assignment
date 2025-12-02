@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Edit Detail Tindakan" subtitle="Edit detail tindakan dan terapi pada rekam medis"
        :backRoute="route('data.rekam-medis.index')" backText="Kembali ke Rekam Medis" />

    <div class="mx-auto my-6 max-w-5xl w-full flex-1">
        
        <!-- Info Card -->
        {{-- <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-blue-600 mb-2">Edit Detail Tindakan & Terapi</h4>
                    <p class="text-blue-700 text-sm leading-relaxed">
                        Halaman ini khusus untuk mengedit detail tindakan dan terapi yang dilakukan pada rekam medis. 
                        @if(Auth::user()->hasRole('Dokter') && !Auth::user()->hasRole('Administrator'))
                            Sebagai Dokter, Anda hanya dapat mengedit detail tindakan pada rekam medis yang Anda periksa sendiri.
                        @else
                            Data utama rekam medis (anamnesa, temuan klinis, diagnosa) dikelola secara terpisah.
                        @endif
                    </p>
                </div>
            </div>
        </div> --}}

        <!-- Medical Record Info -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Rekam Medis</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">ID Rekam Medis:</span>
                    <span class="ml-2">#{{ str_pad($rekamMedis->idrekam_medis, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Tanggal:</span>
                    <span class="ml-2">{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Detail Tindakan & Terapi</h2>
            </div>

            <form action="{{ route('data.rekam-medis.update-detail', $rekamMedis->idrekam_medis) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-md font-medium text-gray-900">Daftar Tindakan</h3>
                        <button type="button" onclick="addTindakanRow()"
                            class="bg-rshp-green text-white px-4 py-2 text-sm rounded-md hover:bg-green-700 transition-colors">
                            + Tambah Tindakan
                        </button>
                    </div>
                    
                    <div id="tindakanContainer" class="space-y-3">
                        @if(count($detailRekamMedis) > 0)
                            @foreach($detailRekamMedis as $index => $detail)
                                <div class="tindakan-row border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                        <div class="lg:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Kode Tindakan <span class="text-red-500">*</span>
                                            </label>
                                            <select name="detail_tindakan[{{ $index }}][idkode_tindakan_terapi]" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                                <option value="">Pilih kode tindakan...</option>
                                                @foreach($kodeTindakan as $kode)
                                                    <option value="{{ $kode->idkode_tindakan_terapi }}" 
                                                        {{ $detail->idkode_tindakan_terapi == $kode->idkode_tindakan_terapi ? 'selected' : '' }}>
                                                        {{ $kode->kode }} - {{ $kode->deskripsi_tindakan_terapi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Detail Tindakan
                                            </label>
                                            <div class="flex space-x-2">
                                                <textarea name="detail_tindakan[{{ $index }}][detail]" rows="3"
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                                                    placeholder="Detail spesifik tindakan (opsional)">{{ $detail->detail ?? '' }}</textarea>
                                                <button type="button" onclick="removeTindakanRow(this)"
                                                    class="text-red-600 hover:text-red-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-gray-500 py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2M9 5a2 2 0 012 2v11a2 2 0 01-2 2M9 5a2 2 0 012-2h2a2 2 0 012 2v11a2 2 0 01-2 2H11a2 2 0 01-2-2V5z"></path>
                                </svg>
                                <p class="text-lg font-medium text-gray-900 mb-2">Belum ada detail tindakan</p>
                                <p class="text-gray-500 mb-4">Klik "Tambah Tindakan" untuk menambahkan detail tindakan dan terapi</p>
                            </div>
                        @endif
                    </div>

                    <div class="text-sm text-gray-500 mt-4">
                        <em>Catatan: Anda dapat menambahkan beberapa tindakan sekaligus. Kosongkan form jika tidak ada tindakan yang dilakukan.</em>
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
                        Simpan Detail Tindakan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    let tindakanCounter = {{ count($detailRekamMedis) }};

    function addTindakanRow() {
        const container = document.getElementById('tindakanContainer');
        
        // Remove "no data" message if it exists
        const noDataMsg = container.querySelector('.text-center');
        if (noDataMsg) {
            noDataMsg.remove();
        }
        
        const newRow = document.createElement('div');
        newRow.className = 'tindakan-row border border-gray-200 rounded-lg p-4 bg-gray-50';
        newRow.innerHTML = `
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Tindakan <span class="text-red-500">*</span>
                    </label>
                    <select name="detail_tindakan[${tindakanCounter}][idkode_tindakan_terapi]" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                        <option value="">Pilih kode tindakan...</option>
                        @foreach($kodeTindakan as $kode)
                            <option value="{{ $kode->idkode_tindakan_terapi }}">
                                {{ $kode->kode }} - {{ $kode->deskripsi_tindakan_terapi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Detail Tindakan
                    </label>
                    <div class="flex space-x-2">
                        <textarea name="detail_tindakan[${tindakanCounter}][detail]" rows="3"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Detail spesifik tindakan (opsional)"></textarea>
                        <button type="button" onclick="removeTindakanRow(this)"
                            class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(newRow);
        tindakanCounter++;
    }

    function removeTindakanRow(button) {
        const row = button.closest('.tindakan-row');
        row.remove();
        
        // Show "no data" message if no rows left
        const container = document.getElementById('tindakanContainer');
        if (container.children.length === 0) {
            const noDataMsg = document.createElement('div');
            noDataMsg.className = 'text-center text-gray-500 py-8';
            noDataMsg.innerHTML = `
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2M9 5a2 2 0 012 2v11a2 2 0 01-2 2M9 5a2 2 0 012-2h2a2 2 0 012 2v11a2 2 0 01-2 2H11a2 2 0 01-2-2V5z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900 mb-2">Belum ada detail tindakan</p>
                <p class="text-gray-500 mb-4">Klik "Tambah Tindakan" untuk menambahkan detail tindakan dan terapi</p>
            `;
            container.appendChild(noDataMsg);
        }
    }

    // Auto-save form data to localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        // Clear localStorage when form is submitted successfully
        form.addEventListener('submit', function() {
            // Clear any saved data for this form
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (key && key.startsWith('edit_detail_rekam_medis_')) {
                    localStorage.removeItem(key);
                }
            }
        });
    });
</script>
