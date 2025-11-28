@extends('layouts.app')

@section('content')
    <div class="mx-auto my-6 max-w-4xl w-full flex-1 px-4">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-rshp-dark-gray">
                        Edit Profil {{ ucfirst($profileType) }}
                    </h1>
                    <p class="text-gray-600 mt-1">Perbarui informasi profil {{ $profileType }} Anda</p>
                </div>
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center px-3 py-2 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Profil
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">
                    Informasi {{ ucfirst($profileType) }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Perbarui informasi profil {{ $profileType }} Anda di bawah ini
                </p>
            </div>

            <form action="{{ route('profile.update', $profileType) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information (Read Only) -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" value="{{ $user->nama }}" disabled
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                            <p class="mt-1 text-xs text-gray-500">Nama tidak dapat diubah dari halaman profil</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                            <p class="mt-1 text-xs text-gray-500">Email tidak dapat diubah dari halaman profil</p>
                        </div>
                    </div>

                    <!-- Editable Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-rshp-blue @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="M" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'M' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="F" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'F' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="no_hp" id="no_hp" required
                                   value="{{ old('no_hp', $profile->no_hp) }}"
                                   placeholder="Contoh: 08123456789"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-rshp-blue @error('no_hp') border-red-500 @enderror">
                            @error('no_hp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Full Width Fields -->
                <div class="mt-6 space-y-4">
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" required
                                  placeholder="Masukkan alamat lengkap..."
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-rshp-blue @error('alamat') border-red-500 @enderror">{{ old('alamat', $profile->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($profileType == 'dokter')
                        <div>
                            <label for="bidang_dokter" class="block text-sm font-medium text-gray-700">
                                Bidang Keahlian <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="bidang_dokter" id="bidang_dokter" required
                                   value="{{ old('bidang_dokter', $profile->bidang_dokter) }}"
                                   placeholder="Contoh: Dokter Hewan Umum, Spesialis Bedah, dll"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-rshp-blue @error('bidang_dokter') border-red-500 @enderror">
                            @error('bidang_dokter')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    @if($profileType == 'perawat')
                        <div>
                            <label for="pendidikan" class="block text-sm font-medium text-gray-700">
                                Pendidikan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pendidikan" id="pendidikan" required
                                   value="{{ old('pendidikan', $profile->pendidikan) }}"
                                   placeholder="Contoh: S1 Kedokteran Hewan, D3 Perawatan Hewan, dll"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rshp-blue focus:border-rshp-blue @error('pendidikan') border-red-500 @enderror">
                            @error('pendidikan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('profile.show') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-rshp-blue text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
