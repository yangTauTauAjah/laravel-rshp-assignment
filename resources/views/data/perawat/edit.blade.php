@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Edit Profil Perawat" subtitle="Perbarui informasi profil perawat"
        :backRoute="route('data.perawat.show', $perawat->idperawat)" backText="Kembali ke Detail">
        
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
                    <div class="h-12 w-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($perawat->user->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-rshp-dark-gray">Edit Profil: {{ $perawat->user->nama }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Perbarui informasi profil perawat</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('data.perawat.update', $perawat->idperawat) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- Note -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800">Catatan</h4>
                            <p class="text-sm text-blue-700 mt-1">
                                Untuk mengubah informasi nama dan email, silakan edit melalui manajemen user. 
                                Halaman ini hanya untuk mengubah informasi khusus profil perawat.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Current User Info (Read-only) -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Informasi User (Tidak dapat diubah)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $perawat->user->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $perawat->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Editable Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Gender -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="M" {{ old('jenis_kelamin', $perawat->jenis_kelamin) == 'M' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="F" {{ old('jenis_kelamin', $perawat->jenis_kelamin) == 'F' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="no_hp" id="no_hp" required
                            value="{{ old('no_hp', $perawat->no_hp) }}"
                            placeholder="Contoh: 08123456789"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>                <!-- Speciality -->
                <div class="mb-6">
                    <label for="pendidikan" class="block text-sm font-medium text-gray-700 mb-2">
                        Pendidikan/Keahlian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="pendidikan" id="pendidikan" required
                        value="{{ old('pendidikan', $perawat->pendidikan) }}"
                        placeholder="Contoh: D3 Keperawatan, S1 Keperawatan + Spesialis ICU, dll."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('pendidikan') border-red-500 @enderror">
                    @error('pendidikan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" required rows="3"
                        placeholder="Alamat lengkap tempat tinggal"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('alamat') border-red-500 @enderror">{{ old('alamat', $perawat->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('data.perawat.show', $perawat->idperawat) }}"
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
                {{-- <a href="{{ route('data.role-user.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                    </svg>
                    Kelola Role User
                </a> --}}
                
                <button onclick="confirmDelete({{ $perawat->idperawat }})"
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
                    Apakah Anda yakin ingin menghapus profil perawat <strong>{{ $perawat->user->nama }}</strong>? 
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
    // Phone number formatting
    $('#no_hp').on('input', function() {
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

function confirmDelete(perawatId) {
    document.getElementById('deleteForm').action = `/data/perawat/${perawatId}`;
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
