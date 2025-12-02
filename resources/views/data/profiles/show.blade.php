@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Multi-Role Profile: {{ $user->nama }}" subtitle="Kelola semua profile role pengguna"
        :backRoute="route('data.profiles.index')" backText="Kembali ke Multi-Role Profiles" />

    <div class="mx-auto my-6 max-w-6xl w-full flex-1">
        <!-- User Overview -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                        {{ strtoupper(substr($user->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-rshp-dark-gray">{{ $user->nama }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="flex items-center mt-2 space-x-2">
                            @foreach($roles as $role)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($role == 'Administrator') bg-purple-100 text-purple-800
                                    @elseif($role == 'Dokter') bg-green-100 text-green-800
                                    @elseif($role == 'Perawat') bg-blue-100 text-blue-800
                                    @elseif($role == 'Resepsionis') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabbed Profiles -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6">
                    <!-- Base User Tab -->
                    <button onclick="switchTab('user')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors border-rshp-green text-rshp-green"
                        id="tab-user">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        User Profile
                    </button>

                    <!-- Dokter Tab -->
                    @if(isset($profiles['dokter']))
                    <button onclick="switchTab('dokter')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        id="tab-dokter">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        Dokter Profile
                    </button>
                    @endif

                    <!-- Perawat Tab -->
                    @if(isset($profiles['perawat']))
                    <button onclick="switchTab('perawat')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        id="tab-perawat">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Perawat Profile
                    </button>
                    @endif
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- User Profile Tab -->
                <div id="content-user" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Basic Information</h3>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">User ID:</span>
                                <span class="text-rshp-dark-gray">#{{ $user->iduser }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Nama Lengkap:</span>
                                <span class="text-rshp-dark-gray">{{ $user->nama }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Email:</span>
                                <span class="text-rshp-dark-gray">{{ $user->email }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Status:</span>
                                @if($user->status == 1)
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

                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Account Information</h3>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Created At:</span>
                                <span class="text-rshp-dark-gray">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y H:i') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Last Updated:</span>
                                <span class="text-rshp-dark-gray">{{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-start py-2">
                                <span class="text-gray-600 font-medium">Assigned Roles:</span>
                                <div class="text-right">
                                    @foreach($roles as $role)
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-1
                                            @if($role == 'Administrator') bg-purple-100 text-purple-800
                                            @elseif($role == 'Dokter') bg-green-100 text-green-800
                                            @elseif($role == 'Perawat') bg-blue-100 text-blue-800
                                            @elseif($role == 'Resepsionis') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif mr-1">
                                            {{ $role }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    {{-- <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="{{ route('users.edit', $user->iduser) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit User
                            </a>
                            
                            <a href="{{ route('data.role-user.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                </svg>
                                Manage Roles
                            </a>
                        </div>
                    </div> --}}
                </div>

                <!-- Dokter Profile Tab -->
                @if(isset($profiles['dokter']))
                <div id="content-dokter" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Dokter Information</h3>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Dokter ID:</span>
                                <span class="text-rshp-dark-gray">#{{ $profiles['dokter']->iddokter }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Bidang Keahlian:</span>
                                <span class="text-rshp-dark-gray">{{ $profiles['dokter']->bidang_dokter }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Jenis Kelamin:</span>
                                <span class="text-rshp-dark-gray">
                                    {{ $profiles['dokter']->jenis_kelamin == 'M' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">No. Telepon:</span>
                                <span class="text-rshp-dark-gray">{{ $profiles['dokter']->no_hp }}</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Additional Info</h3>
                            
                            <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Alamat:</span>
                                <span class="text-rshp-dark-gray text-right max-w-xs">{{ $profiles['dokter']->alamat }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Profile Created:</span>
                                <span class="text-rshp-dark-gray">{{ \Carbon\Carbon::parse($profiles['dokter']->created_at)->format('d M Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Last Updated:</span>
                                <span class="text-rshp-dark-gray">{{ \Carbon\Carbon::parse($profiles['dokter']->updated_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="{{ route('data.dokter.show', $profiles['dokter']->iddokter) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Full Profile
                            </a>
                            
                            <a href="{{ route('data.dokter.edit', $profiles['dokter']->iddokter) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Perawat Profile Tab -->
                @if(isset($profiles['perawat']))
                <div id="content-perawat" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Perawat Information</h3>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Perawat ID:</span>
                                <span class="text-rshp-dark-gray">#{{ $profiles['perawat']->idperawat }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Pendidikan:</span>
                                <span class="text-rshp-dark-gray">{{ $profiles['perawat']->pendidikan }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Jenis Kelamin:</span>
                                <span class="text-rshp-dark-gray">
                                    {{ $profiles['perawat']->jenis_kelamin == 'M' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">No. Telepon:</span>
                                <span class="text-rshp-dark-gray">{{ $profiles['perawat']->no_hp }}</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-rshp-dark-gray border-b border-gray-200 pb-2">Additional Info</h3>
                            
                            <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Alamat:</span>
                                <span class="text-rshp-dark-gray text-right max-w-xs">{{ $profiles['perawat']->alamat }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Profile Created:</span>
                                <span class="text-rshp-dark-gray">{{ \Carbon\Carbon::parse($profiles['perawat']->created_at)->format('d M Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Last Updated:</span>
                                <span class="text-rshp-dark-gray">{{ \Carbon\Carbon::parse($profiles['perawat']->updated_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="{{ route('data.perawat.show', $profiles['perawat']->idperawat) }}"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Full Profile
                            </a>
                            
                            <a href="{{ route('data.perawat.edit', $profiles['perawat']->idperawat) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(function(content) {
        content.classList.add('hidden');
    });

    // Remove active state from all tab buttons
    document.querySelectorAll('.tab-button').forEach(function(button) {
        button.classList.remove('border-rshp-green', 'text-rshp-green');
        button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    });

    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Set active state for selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    activeButton.classList.add('border-rshp-green', 'text-rshp-green');
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    // The user tab is already set as active in the HTML, so no need to call switchTab here
});
</script>
@endpush
