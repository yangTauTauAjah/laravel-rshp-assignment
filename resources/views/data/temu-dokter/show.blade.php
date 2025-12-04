@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Detail Reservasi Dokter" subtitle="Kembali ke index Temu Dokter"
        :backRoute="route('data.temu-dokter.index')" backText="Kembali ke Temu Dokter">
        @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
        <x-slot:actionButton>
            <button onclick="openAddTemuDokterModal()"
                class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Reservasi
            </button>
        </x-slot:actionButton>
        @endif
    </x-admin-header>
        
    <div class="mx-auto my-6 max-w-4xl w-full flex-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-rshp-dark-gray">Informasi Reservasi</h2>
                    @php
                        $statusConfig = match($temuDokter->status) {
                            '0' => ['text' => 'Menunggu', 'class' => 'bg-yellow-100 text-yellow-800'],
                            '1' => ['text' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                            '2' => ['text' => 'Batal', 'class' => 'bg-red-100 text-red-800'],
                            default => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-800']
                        };
                    @endphp
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusConfig['class'] }}">
                        {{ $statusConfig['text'] }}
                    </span>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Queue Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-blue-900">Nomor Antrian</h3>
                                <p class="text-2xl font-bold text-blue-600">
                                    #{{ str_pad($temuDokter->no_urut, 3, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-green-900">Waktu Reservasi</h3>
                                <p class="text-lg font-medium text-green-600">
                                    {{ \Carbon\Carbon::parse($temuDokter->waktu_daftar)->format('d M Y') }}
                                </p>
                                <p class="text-sm text-green-500">
                                    {{ \Carbon\Carbon::parse($temuDokter->waktu_daftar)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Dokter
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Dokter</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $temuDokter->dokter_nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-lg text-gray-900">{{ $temuDokter->dokter_email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <p class="text-lg text-gray-900">{{ $temuDokter->nama_role }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h5.586a1 1 0 00.707-.293l5.414-5.414a1 1 0 00.293-.707V7a2 2 0 00-2-2H9z"></path>
                        </svg>
                        Detail Reservasi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID Reservasi</label>
                            <p class="text-lg text-gray-900">{{ $temuDokter->idreservasi_dokter }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</label>
                            <p class="text-lg text-gray-900">
                                {{ \Carbon\Carbon::parse($temuDokter->waktu_daftar)->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Saat Ini</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusConfig['class'] }}">
                                {{ $statusConfig['text'] }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Hari</label>
                            <p class="text-lg text-gray-900">
                                @if(\Carbon\Carbon::parse($temuDokter->waktu_daftar)->isToday())
                                    <span class="text-green-600 font-semibold">Hari Ini</span>
                                @elseif(\Carbon\Carbon::parse($temuDokter->waktu_daftar)->isTomorrow())
                                    <span class="text-blue-600 font-semibold">Besok</span>
                                @elseif(\Carbon\Carbon::parse($temuDokter->waktu_daftar)->isPast())
                                    <span class="text-red-600 font-semibold">Sudah Terlewat</span>
                                @else
                                    {{ \Carbon\Carbon::parse($temuDokter->waktu_daftar)->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                <div class="border-t pt-6">
                    <div class="flex flex-wrap gap-3 mb-4">
                        @if($temuDokter->status == '0')
                        <button onclick="updateStatus('{{ $temuDokter->idreservasi_dokter }}', '1')"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tandai Selesai
                        </button>
                        <button onclick="updateStatus('{{ $temuDokter->idreservasi_dokter }}', '2')"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batalkan Reservasi
                        </button>
                        @elseif($temuDokter->status == '2')
                        <button onclick="updateStatus('{{ $temuDokter->idreservasi_dokter }}', '0')"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Aktifkan Kembali
                        </button>
                        @endif

                        <a href="{{ route('data.temu-dokter.edit', $temuDokter->idreservasi_dokter) }}"
                            class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Reservasi
                        </a>

                        {{-- @if(Auth::user()->isAdministrator())
                        <button onclick="deleteTemuDokter()"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Reservasi
                        </button>
                        @endif --}}
                    </div>
                </div>
                @endif

                <!-- Rekam Medis Section -->
                <div class="border-t pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Rekam Medis ({{ $rekamMedisList->count() }})
                        </h3>
                        @if((Auth::user()->isAdministrator() || Auth::user()->isDokter() || Auth::user()->isPerawat()) && $temuDokter->status == '0')
                        <button onclick="openAddRekamMedisModal()"
                            class="bg-rshp-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Rekam Medis
                        </button>
                        @endif
                    </div>

                    @if($rekamMedisList->count() > 0)
                    <div class="space-y-4">
                        @foreach($rekamMedisList as $rekamMedis)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ $rekamMedis->pet_nama }} ({{ $rekamMedis->nama_jenis_hewan }})
                                        </h4>
                                        <span class="ml-2 text-sm text-gray-500">
                                            - {{ $rekamMedis->pemilik_nama }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-600">Tanggal:</span>
                                            <span class="text-gray-900">{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y, H:i') }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-600">Diagnosa:</span>
                                            <span class="text-gray-900">{{ Str::limit($rekamMedis->diagnosa, 50) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <a href="{{ route('data.rekam-medis.show', $rekamMedis->idrekam_medis) }}"
                                        class="text-rshp-green hover:text-green-900" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    
                                    {{-- Role-based Edit Buttons --}}
                                    @if(Auth::user()->hasRole('Administrator'))
                                        {{-- Administrator can edit both data and details --}}
                                        <a href="{{ route('data.rekam-medis.edit-data', $rekamMedis->idrekam_medis) }}"
                                            class="text-rshp-blue hover:text-blue-900" title="Edit Data Rekam Medis">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('data.rekam-medis.edit-detail', $rekamMedis->idrekam_medis) }}"
                                            class="text-purple-600 hover:text-purple-900" title="Edit Detail Tindakan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2M9 5a2 2 0 012 2v11a2 2 0 01-2 2M9 5a2 2 0 012-2h2a2 2 0 012 2v11a2 2 0 01-2 2H11a2 2 0 01-2-2V5z">
                                                </path>
                                            </svg>
                                        </a>
                                    @elseif(Auth::user()->hasRole('Perawat') && !Auth::user()->hasRole('Dokter'))
                                        {{-- Perawat can only edit main data --}}
                                        <a href="{{ route('data.rekam-medis.edit-data', $rekamMedis->idrekam_medis) }}"
                                            class="text-rshp-blue hover:text-blue-900" title="Edit Data Rekam Medis">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                    @elseif(Auth::user()->hasRole('Dokter'))
                                        {{-- Check if this is the examining doctor --}}
                                        @php
                                            $dokterRoleUserId = DB::table('role_user')
                                                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                                                ->where('role_user.iduser', Auth::user()->iduser)
                                                ->where('role.nama_role', 'Dokter')
                                                ->where('role_user.status', 1)
                                                ->value('role_user.idrole_user');
                                        @endphp
                                        
                                        @if($dokterRoleUserId && $rekamMedis->dokter_pemeriksa == $dokterRoleUserId)
                                            {{-- Dokter can only edit details of their own records --}}
                                            <a href="{{ route('data.rekam-medis.edit-detail', $rekamMedis->idrekam_medis) }}"
                                                class="text-purple-600 hover:text-purple-900" title="Edit Detail Tindakan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2M9 5a2 2 0 012 2v11a2 2 0 01-2 2M9 5a2 2 0 012-2h2a2 2 0 012 2v11a2 2 0 01-2 2H11a2 2 0 01-2-2V5z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                    @endif
                                    {{-- @if(Auth::user()->isAdministrator())
                                    <button onclick="deleteRekamMedis({{ $rekamMedis->idrekam_medis }}, '{{ $rekamMedis->pet_nama }}')"
                                        class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500">Belum ada rekam medis untuk reservasi ini</p>
                        @if((Auth::user()->isAdministrator() || Auth::user()->isResepsionis()) && $temuDokter->status == '0')
                        <button onclick="openAddRekamMedisModal()"
                            class="mt-4 bg-rshp-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            Tambah Rekam Medis Pertama
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Rekam Medis Modal -->
    @if(Auth::user()->isAdministrator() || Auth::user()->isDokter())
    <div id="addRekamMedisModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Rekam Medis</h3>
                <button onclick="closeAddRekamMedisModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="addRekamMedisForm" action="{{ route('data.temu-dokter.store-rekam-medis', $temuDokter->idreservasi_dokter) }}" method="POST">
                @csrf
                <div class="space-y-4 max-h-96 overflow-y-auto">

                    <!-- Pet Selection -->
                    <div>
                        <label for="modal_idpet" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Hewan Pasien <span class="text-red-500">*</span>
                        </label>
                        <select id="modal_idpet" name="idpet" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="">Pilih hewan pasien...</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->idpet }}">
                                    {{ $pet->nama }} - {{ $pet->nama_ras }} ({{ $pet->nama_jenis_hewan }}) - Pemilik: {{ $pet->pemilik_nama }}
                                </option>
                            @endforeach
                        </select>
                        <div id="modal_idpet_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Anamnesis -->
                    <div>
                        <label for="modal_anamnesa" class="block text-sm font-medium text-gray-700 mb-2">
                            Anamnesa <span class="text-red-500">*</span>
                        </label>
                        <textarea id="modal_anamnesa" name="anamnesa" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Keluhan pemilik, riwayat penyakit, gejala yang diamati..."></textarea>
                        <div id="modal_anamnesa_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Clinical Findings -->
                    <div>
                        <label for="modal_temuan_klinis" class="block text-sm font-medium text-gray-700 mb-2">
                            Temuan Klinis <span class="text-red-500">*</span>
                        </label>
                        <textarea id="modal_temuan_klinis" name="temuan_klinis" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Hasil pemeriksaan fisik, vital sign, temuan abnormal..."></textarea>
                        <div id="modal_temuan_klinis_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Diagnosis -->
                    <div>
                        <label for="modal_diagnosa" class="block text-sm font-medium text-gray-700 mb-2">
                            Diagnosa <span class="text-red-500">*</span>
                        </label>
                        <textarea id="modal_diagnosa" name="diagnosa" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Diagnosa berdasarkan temuan klinis dan anamnesa..."></textarea>
                        <div id="modal_diagnosa_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    {{-- @if (!Auth::user()->isPerawat())
                    <!-- Treatment Details Section -->
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-md font-medium text-gray-900">Detail Tindakan & Terapi</h4>
                            <button type="button" onclick="addModalTindakanRow()"
                                class="bg-rshp-green text-white px-3 py-1 text-sm rounded-md hover:bg-green-700 transition-colors">
                                + Tambah Tindakan
                            </button>
                        </div>
                        
                        <div id="modalTindakanContainer">
                            <!-- Tindakan rows will be added here by JavaScript -->
                        </div>
                        
                        <p class="text-sm text-gray-500 mt-2">
                            <em>Opsional: Tambahkan detail tindakan dan terapi yang dilakukan</em>
                        </p>
                    </div>
                    @endif --}}
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeAddRekamMedisModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        let modalTindakanCounter = 0;
        let kodeTindakanData = [];

        // Load treatment codes when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadKodeTindakan();
        });

        function loadKodeTindakan() {
            fetch('/data/temu-dokter/kode-tindakan')
                .then(response => {console.log('test'); return response})
                .then(response => response.json())
                .then(data => {
                    kodeTindakanData = /data/;
                })
                .catch(error => {
                    console.error('Error loading treatment codes:', error);
                    kodeTindakanData = [];
                });
        }

        // Rekam Medis Modal Functions
        function openAddRekamMedisModal() {
            document.getElementById('addRekamMedisModal').classList.remove('hidden');
            // Reset form
            document.getElementById('addRekamMedisForm').reset();
            // Clear tindakan container
            document.getElementById('modalTindakanContainer').innerHTML = '';
            modalTindakanCounter = 0;
            // Clear any error messages
            clearModalErrors();
            // Add initial tindakan row
            addModalTindakanRow();
        }

        function closeAddRekamMedisModal() {
            document.getElementById('addRekamMedisModal').classList.add('hidden');
        }

        function clearModalErrors() {
            const errorElements = document.querySelectorAll('[id$="_error"]');
            errorElements.forEach(element => {
                element.textContent = '';
                element.classList.add('hidden');
            });
            // Remove error styling
            const inputs = document.querySelectorAll('#addRekamMedisForm input, #addRekamMedisForm select, #addRekamMedisForm textarea');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
            });
        }

        function addModalTindakanRow() {
            const container = document.getElementById('modalTindakanContainer');
            const rowHtml = `
                <div class="tindakan-row border border-gray-200 rounded-md p-3 mb-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Kode Tindakan/Terapi
                            </label>
                            <select name="detail_tindakan[${modalTindakanCounter}][idkode_tindakan_terapi]" 
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Detail Tambahan
                            </label>
                            <div class="flex space-x-2">
                                <input type="text" name="detail_tindakan[${modalTindakanCounter}][detail]" 
                                    placeholder="Detail opsional..."
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <button type="button" onclick="removeModalTindakanRow(this)" 
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
            modalTindakanCounter++;
        }

        function removeModalTindakanRow(button) {
            const row = button.closest('.tindakan-row');
            row.remove();
        }

        // Handle rekam medis form submission
        document.getElementById('addRekamMedisForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearModalErrors();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeAddRekamMedisModal();
                    // Show success message
                    showNotification('Rekam medis berhasil ditambahkan!', 'success');
                    // Reload page to show new record
                    window.location.reload();
                } else if (data.errors) {
                    // Show validation errors
                    Object.keys(data.errors).forEach(key => {
                        const errorElement = document.getElementById(`modal_${key}_error`);
                        const inputElement = document.querySelector(`[name="${key}"]`);
                        
                        if (errorElement && inputElement) {
                            errorElement.textContent = data.errors[key][0];
                            errorElement.classList.remove('hidden');
                            inputElement.classList.add('border-red-500');
                        }
                    });
                    showNotification('Mohon perbaiki kesalahan pada form.', 'error');
                } else {
                    showNotification(data.message || 'Terjadi kesalahan saat menyimpan data.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan sistem.', 'error');
            });
        });

        // Delete rekam medis function
        function deleteRekamMedis(rekamMedisId, petName) {
            if (confirm(`Apakah Anda yakin ingin menghapus rekam medis untuk ${petName}? Tindakan ini tidak dapat dibatalkan.`)) {
                fetch(`/data/temu-dokter/{{ $temuDokter->idreservasi_dokter }}/rekam-medis/${rekamMedisId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal menghapus rekam medis.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan sistem.', 'error');
                });
            }
        }

        // Status update function
        function updateStatus(id, status) {
            const statusText = {
                '0': 'Menunggu',
                '1': 'Selesai', 
                '2': 'Batal'
            };
            
            if (confirm(`Apakah Anda yakin ingin mengubah status menjadi ${statusText[status]}?`)) {
                fetch(`/data/temu-dokter/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        // Reload page to show updated status
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showNotification(data.message || 'Gagal mengubah status.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan sistem.', 'error');
                });
            }
        }

        function deleteTemuDokter() {
            if (confirm('Apakah Anda yakin ingin menghapus reservasi ini? Tindakan ini akan menghapus semua rekam medis terkait dan tidak dapat dibatalkan.')) {
                // Create form for deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("data.temu-dokter.destroy", $temuDokter->idreservasi_dokter) }}';

                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                // Add method override for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Close modal when clicking outside
        document.getElementById('addRekamMedisModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddRekamMedisModal();
            }
        });
    </script>
@endsection
