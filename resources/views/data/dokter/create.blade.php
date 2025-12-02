@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Daftarkan Dokter Baru" subtitle="Tambahkan profil dokter ke sistem"
        :backRoute="route('data.dokter.index')" backText="Kembali ke Daftar Dokter" />

    <div class="mx-auto my-6 max-w-4xl w-full flex-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-rshp-dark-gray">Informasi Dokter</h3>
                <p class="text-sm text-gray-600 mt-1">Isi semua informasi yang diperlukan untuk profil dokter</p>
            </div>

            @if($availableUsers->isEmpty())
            <div class="p-6">
                <div class="text-center py-8">
                    <div class="mx-auto h-16 w-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada User Tersedia</h3>
                    <p class="text-gray-600 mb-4">
                        Semua user sudah memiliki role Dokter, atau belum ada user yang dapat diberikan role Dokter. 
                        Sistem akan menampilkan user yang belum memiliki role Dokter untuk dapat diberikan akses sebagai dokter.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('data.dokter.create-with-user') }}"
                            class="bg-rshp-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            Buat User & Dokter Baru
                        </a>
                        <a href="{{ route('data.dokter.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            @else
            <form action="{{ route('data.dokter.store') }}" method="POST" class="p-6">
                @csrf                <!-- User Selection -->
                <div class="mb-6">
                    <label for="iduser" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih User <span class="text-red-500">*</span>
                    </label>
                    <select name="iduser" id="iduser" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('iduser') border-red-500 @enderror">
                        <option value="">-- Pilih User --</option>
                        @foreach($availableUsers as $user)
                            <option value="{{ $user->iduser }}" {{ old('iduser') == $user->iduser ? 'selected' : '' }}>
                                {{ $user->nama }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-sm text-blue-600">
                        <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        User yang dipilih akan otomatis diberikan role "Dokter" setelah profil dibuat
                    </p>
                    @error('iduser')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Personal Information Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Gender -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="M" {{ old('jenis_kelamin') == 'M' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="F" {{ old('jenis_kelamin') == 'F' ? 'selected' : '' }}>Perempuan</option>
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
                            value="{{ old('no_hp') }}"
                            placeholder="Contoh: 08123456789"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Speciality -->
                <div class="mb-6">
                    <label for="bidang_dokter" class="block text-sm font-medium text-gray-700 mb-2">
                        Bidang Keahlian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bidang_dokter" id="bidang_dokter" required
                        value="{{ old('bidang_dokter') }}"
                        placeholder="Contoh: Obstetri dan Ginekologi, Pediatri, Anestesi, dll."
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('bidang_dokter') border-red-500 @enderror">
                    @error('bidang_dokter')
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
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-rshp-green focus:border-rshp-green @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('data.dokter.index') }}"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-rshp-green text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Profil Dokter
                    </button>
                </div>
            </form>
            @endif
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
    $('form').on('submit', function(e) {
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
</script>
@endpush
