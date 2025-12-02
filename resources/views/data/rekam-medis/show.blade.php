@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Edit Data Rekam Medis" subtitle="Edit informasi utama rekam medis (hanya data, bukan detail tindakan)"
        :backRoute="route('data.rekam-medis.index')" backText="Kembali ke Rekam Medis" >

        {{-- @if(Auth::user()->isAdministrator() || Auth::user()->isPerawat())
        <x-slot:actionButton>
            <a href="{{ route('data.rekam-medis.edit', $rekamMedis->idrekam_medis) }}"
                class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit Rekam Medis
            </a>
        </x-slot:actionButton>
        @endif --}}
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Patient Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Informasi Pasien</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-16 w-16 bg-rshp-orange rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900">{{ $rekamMedis->pet_nama }}</h4>
                            <p class="text-gray-600">{{ $rekamMedis->nama_ras }} - {{ $rekamMedis->nama_jenis_hewan }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                            <p class="text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rekamMedis->jenis_kelamin == 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $rekamMedis->jenis_kelamin == 'M' ? 'Jantan' : 'Betina' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Lahir</label>
                            <p class="text-gray-900">
                                @if($rekamMedis->pet_tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($rekamMedis->pet_tanggal_lahir)->format('d M Y') }}
                                    <span class="text-sm text-gray-500">({{ \Carbon\Carbon::parse($rekamMedis->pet_tanggal_lahir)->age }} tahun)</span>
                                @else
                                    <span class="text-gray-400">Tidak diketahui</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($rekamMedis->warna_tanda)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Warna/Tanda Khusus</label>
                        <p class="text-gray-900">{{ $rekamMedis->warna_tanda }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Owner Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Informasi Pemilik</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Pemilik</label>
                        <p class="text-gray-900 font-medium">{{ $rekamMedis->pemilik_nama }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-900">{{ $rekamMedis->pemilik_email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">No. WhatsApp</label>
                        <p class="text-gray-900">{{ $rekamMedis->pemilik_no_wa }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Alamat</label>
                        <p class="text-gray-900">{{ $rekamMedis->pemilik_alamat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Record Information -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Rekam Medis #{{ $rekamMedis->idrekam_medis }}</h3>
                    <span class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <!-- Doctor Information -->
                <div>
                    <label class="text-sm font-medium text-gray-500">Dokter Pemeriksa</label>
                    <p class="text-gray-900 font-medium">{{ $rekamMedis->dokter_nama }}</p>
                </div>

                <!-- Anamnesis -->
                <div>
                    <label class="text-sm font-medium text-gray-500">Anamnesa</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-md">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $rekamMedis->anamnesa }}</p>
                    </div>
                </div>

                <!-- Clinical Findings -->
                <div>
                    <label class="text-sm font-medium text-gray-500">Temuan Klinis</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-md">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $rekamMedis->temuan_klinis }}</p>
                    </div>
                </div>

                <!-- Diagnosis -->
                <div>
                    <label class="text-sm font-medium text-gray-500">Diagnosa</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-md">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $rekamMedis->diagnosa }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Treatment Details -->
        @if($detailRekamMedis->isNotEmpty())
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-rshp-dark-gray">Detail Tindakan & Terapi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tindakan/Terapi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori Klinis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Detail
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($detailRekamMedis as $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-rshp-blue">
                                {{ $detail->kode }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $detail->deskripsi_tindakan_terapi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $detail->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $detail->nama_kategori_klinis }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $detail->detail ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-rshp-dark-gray">Detail Tindakan & Terapi</h3>
            </div>
            <div class="p-6 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <p>Belum ada detail tindakan atau terapi yang tercatat.</p>
            </div>
        </div>
        @endif

        <!-- Print Button -->
        <div class="mt-6 flex justify-end">
            <button onclick="window.print()" 
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Cetak Rekam Medis
            </button>
        </div>
    </div>

    <style>
        @media print {
            /* Hide navigation and header when printing */
            nav, header, .no-print {
                display: none !important;
            }
            
            /* Adjust layout for print */
            .mx-auto {
                margin: 0 !important;
                max-width: none !important;
            }
            
            /* Ensure content fits on page */
            .grid {
                display: block !important;
            }
            
            .lg\:grid-cols-2 > div {
                margin-bottom: 1rem !important;
                page-break-inside: avoid;
            }
        }
    </style>
@endsection
