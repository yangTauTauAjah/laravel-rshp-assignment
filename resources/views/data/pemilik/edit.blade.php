@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Edit Profil Pemilik" subtitle="Perbarui informasi profil pemilik hewan"
        :backRoute="route('data.pemilik.show', $pemilik->idpemilik)" backText="Kembali ke Detail">
        
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
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-rshp-green rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($pemilik->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-rshp-dark-gray">Edit Profil: {{ $pemilik->nama }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Perbarui informasi profil pemilik hewan</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('data.pemilik.update', $pemilik->idpemilik) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- User Information (Editable) -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-4">Informasi Pengguna</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" required
                                value="{{ old('nama', $pemilik->nama) }}"
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('nama') border-red-500 @enderror">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" required
                                value="{{ old('email', $pemilik->email) }}"
                                placeholder="contoh@email.com"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-4">Ubah Password (Opsional)</h4>
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mb-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-yellow-700">
                                    Kosongkan field password jika tidak ingin mengubah password.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password" name="password" id="password"
                            placeholder="Masukkan password baru (minimal 6 karakter)"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-4">Informasi Kontak</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- WhatsApp Number -->
                        <div>
                            <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="no_wa" id="no_wa" required
                                value="{{ old('no_wa', $pemilik->no_wa) }}"
                                placeholder="Contoh: 08123456789"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('no_wa') border-red-500 @enderror">
                            @error('no_wa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address (moved to this section for better organization) -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" required rows="3"
                                placeholder="Alamat lengkap tempat tinggal"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('alamat') border-red-500 @enderror">{{ old('alamat', $pemilik->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('data.pemilik.show', $pemilik->idpemilik) }}"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-rshp-green text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Actions -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-rshp-dark-gray mb-4">Aksi Lainnya</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('data.pet.index') }}?pemilik={{ $pemilik->idpemilik }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    Lihat Hewan Peliharaan
                </a>
                
                <button onclick="confirmDelete({{ $pemilik->idpemilik }})"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Profil
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                </div>
                <p class="text-sm text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus profil pemilik <strong>{{ $pemilik->nama }}</strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex justify-end space-x-3">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // WhatsApp number formatting
    $('#no_wa').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        $(this).val(value);
    });

    // Form validation
    $('form[action*="update"]').on('submit', function(e) {
        let isValid = true;
        
        // Check required fields
        $('[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('border-red-500');
            } else {
                $(this).removeClass('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });
});

function confirmDelete(pemilikId) {
    document.getElementById('deleteForm').action = `/data/pemilik/${pemilikId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush
