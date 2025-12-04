@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Detail Profil Pemilik" subtitle="Informasi lengkap profil pemilik hewan"
        :backRoute="route('data.pemilik.index')" backText="Kembali ke Daftar Pemilik">
        
        <x-slot:actionButton>
            @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                <a href="{{ route('data.pemilik.edit', $pemilik->idpemilik) }}"
                    class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profil
                </a>
            @endif
        </x-slot:actionButton>
    </x-admin-header>

    <div class="mx-auto my-6 max-w-4xl w-full flex-1">
        <!-- Profile Overview -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 bg-rshp-green rounded-full flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr($pemilik->nama, 0, 2)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-rshp-dark-gray">{{ $pemilik->nama }}</h2>
                            <p class="text-rshp-green font-medium">Pemilik Hewan</p>
                            <div class="flex items-center mt-1">
                                @if($pemilik->user_status == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Nonaktif
                                    </span>
                                @endif                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Informasi Personal</h3>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Nama Lengkap:</span>
                            <span class="text-rshp-dark-gray">{{ $pemilik->nama }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Email:</span>
                            <span class="text-rshp-dark-gray">{{ $pemilik->email }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">No. WhatsApp:</span>
                            <span class="text-rshp-dark-gray flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                {{ $pemilik->no_wa }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-start py-2">
                            <span class="text-gray-600 font-medium">Alamat:</span>
                            <span class="text-rshp-dark-gray text-right max-w-xs">{{ $pemilik->alamat }}</span>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Informasi Akun</h3>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">ID Pemilik:</span>
                            <span class="text-rshp-dark-gray">#{{ $pemilik->idpemilik }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Status Akun:</span>
                            <span class="text-rshp-dark-gray">
                                {{ $pemilik->user_status == 1 ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Jumlah Hewan:</span>
                            <span class="text-rshp-dark-gray">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $pemilik->pets_count }} hewan
                                </span>
                            </span>
                        </div>
                        
                        {{-- <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Bergabung:</span>
                            <span class="text-rshp-dark-gray">
                                {{ \Carbon\Carbon::parse($pemilik->user_created_at)->format('d F Y') }}
                            </span>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics and Quick Actions -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pet Statistics -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-rshp-dark-gray mb-4">Statistik Hewan</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Total Hewan Terdaftar</span>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $pemilik->pets_count }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-rshp-dark-gray mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                    <a href="{{ route('data.pemilik.edit', $pemilik->idpemilik) }}"
                        class="flex items-center w-full px-3 py-2 text-sm text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profil Pemilik
                    </a>
                    @endif
                    
                    <a href="{{ route('data.pet.index') }}?pemilik={{ $pemilik->idpemilik }}"
                        class="flex items-center w-full px-3 py-2 text-sm text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        Lihat Hewan Peliharaan
                    </a>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
