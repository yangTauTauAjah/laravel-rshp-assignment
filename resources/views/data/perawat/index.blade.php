@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Manajemen Data Perawat" subtitle="Kelola profil perawat dan registrasi"
        :backRoute="route('data.dashboard')" backText="Kembali ke Dashboard">
        
        <x-slot:actionButton>
            @if(Auth::user()->isAdministrator())
                <a href="{{ route('data.perawat.create') }}"
                    class="bg-rshp-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Daftarkan Perawat Baru
                </a>
            @endif
        </x-slot:actionButton>
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">
        <!-- Perawat List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Perawat</h2>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                        {{ $perawatList->count() }} Perawat Terdaftar
                    </span>
                </div>
            </div>
            @if($perawatList->isEmpty())
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-12 w-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 119.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Perawat Terdaftar</h3>
                <p class="text-gray-600 mb-6">Sistem belum memiliki data perawat. Daftarkan perawat pertama untuk memulai.</p>
                @if(Auth::user()->isAdministrator())
                <a href="{{ route('data.perawat.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-rshp-green text-white rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Daftarkan Perawat
                </a>
                @endif
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Perawat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pendidikan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kontak
                            </th>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th> --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($perawatList as $perawat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-medium text-sm">
                                            {{ strtoupper(substr($perawat->nama, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-rshp-dark-gray">{{ $perawat->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $perawat->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-rshp-dark-gray">{{ $perawat->pendidikan }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $perawat->jenis_kelamin == 'M' ? 'Laki-laki' : 'Perempuan' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-rshp-dark-gray">{{ $perawat->no_hp }}</div>
                                <div class="text-sm text-gray-500 max-w-xs truncate">{{ $perawat->alamat }}</div>
                            </td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap">
                                @if($perawat->user_status == 1)
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
                            </td> --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- View Button -->
                                    <a href="{{ route('data.perawat.show', $perawat->idperawat) }}" 
                                        class="text-blue-600 hover:text-blue-900 transition-colors"
                                        title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    
                                    @if(Auth::user()->isAdministrator())
                                    <!-- Edit Button -->
                                    <a href="{{ route('data.perawat.edit', $perawat->idperawat) }}" 
                                        class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <button onclick="deletePerawat({{ $perawat->idperawat }}, '{{ $perawat->nama }}')" 
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-5">Hapus Data Perawat</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus data perawat <span id="deletePerawatName" class="font-semibold"></span>?
                    </p>
                    <p class="text-sm text-red-500 mt-2">
                        <strong>Perhatian:</strong> Tindakan ini tidak akan menghapus akun user.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600">
                        Hapus
                    </button>
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts') --}}
<script>
    let deleteForm = null;

    function deletePerawat(id, name) {
        document.getElementById('deletePerawatName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');

        if (deleteForm) {
            deleteForm.remove();
        }
        deleteForm = document.createElement('form');
        deleteForm.method = 'POST';
        deleteForm.action = `/data/perawat/${id}`;
        deleteForm.style.display = 'none';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        deleteForm.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        deleteForm.appendChild(methodInput);

        document.body.appendChild(deleteForm);

        document.getElementById('confirmDelete').onclick = function() {
            deleteForm.submit();
        };
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        if (deleteForm) {
            deleteForm.remove();
            deleteForm = null;
        }
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
{{-- @endpush --}}
