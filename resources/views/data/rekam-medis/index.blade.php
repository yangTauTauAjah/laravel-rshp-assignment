@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    @if(Auth::user()->hasRole('Dokter'))
        <x-admin-header title="Rekam Medis Pasien Saya" subtitle="Daftar rekam medis pasien yang telah Anda periksa"
            :backRoute="route('data.dashboard')" backText="Kembali ke Dashboard" />
    @elseif(Auth::user()->hasRole('Perawat'))
        <x-admin-header title="Kelola Rekam Medis" subtitle="Manajemen rekam medis hewan peliharaan - Perawat"
            :backRoute="route('data.dashboard')" backText="Kembali ke Dashboard" />
    @else
        <x-admin-header title="Kelola Rekam Medis" subtitle="Manajemen rekam medis hewan peliharaan"
            :backRoute="route('data.dashboard')" backText="Kembali ke Dashboard" />
    @endif

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">

        <!-- Info Card -->
        @if(Auth::user()->hasRole('Administrator'))
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-blue-600 mb-2">Informasi Pengelolaan Rekam Medis</h4>
                        {{-- Rekam medis sekarang dikelola melalui sistem <strong>Temu Dokter</strong>.  --}}
                    <p class="text-blue-700 text-sm leading-relaxed">
                        Untuk menambah rekam medis baru, silakan buat reservasi dokter terlebih dahulu di menu 
                        <a href="{{ route('data.temu-dokter.index') }}" class="underline font-semibold">Temu Dokter</a>, 
                        kemudian tambahkan rekam medis dari halaman detail reservasi tersebut.
                    </p>
                </div>
            </div>
        </div>
        @elseif(Auth::user()->hasRole('Dokter'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-green-600 mb-2">Rekam Medis Pasien Anda</h4>
                    <p class="text-green-700 text-sm leading-relaxed">
                        Halaman ini menampilkan daftar rekam medis dari semua pasien yang telah Anda periksa. 
                        Anda dapat melihat detail dan mengedit catatan medis untuk pasien-pasien Anda.
                    </p>
                </div>
            </div>
        </div>
        @elseif(Auth::user()->hasRole('Perawat'))
        <div class="mb-6 bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-purple-600 mb-2">Kelola Rekam Medis</h4>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Sebagai perawat, Anda dapat melihat dan mengelola rekam medis dari semua pasien. 
                        Anda dapat melihat detail, mengedit, dan membantu memelihara data rekam medis hewan peliharaan.
                    </p>
                </div>
            </div>
        </div>
        {{-- @endif
            </div>
        </div>
        @elseif(Auth::user()->hasRole('Perawat'))
        <div class="mb-6 bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-purple-600 mb-2">Akses Perawat - Rekam Medis</h4>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Sebagai perawat, Anda dapat melihat semua rekam medis dan mengedit informasi utama rekam medis. 
                        Namun, pengelolaan detail tindakan terapi hanya dapat dilakukan oleh dokter dan administrator.
                    </p>
                </div>
            </div>
        </div> --}}
        @endif

        <!-- Medical Records Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Rekam Medis</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hewan Pasien
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pemilik
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Diagnosa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dokter Pemeriksa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Temu Dokter
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rekamMedisList as $rekamMedis)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $rekamMedis->idrekam_medis }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y') }}
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- <div class="flex items-center ml-4"> --}}
                                        {{-- <div
                                            class="flex-shrink-0 h-10 w-10 bg-rshp-orange rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div> --}}
                                        {{-- <div class="ml-4"> --}}
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $rekamMedis->pet_nama }}
                                                <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $rekamMedis->jenis_kelamin == 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                    {{ $rekamMedis->jenis_kelamin == 'M' ? 'Jantan' : 'Betina' }}
                                                </span>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $rekamMedis->nama_ras }} - {{ $rekamMedis->nama_jenis_hewan }}
                                            </div>
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rekamMedis->pemilik_nama }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs truncate" title="{{ $rekamMedis->diagnosa }}">
                                        {{ $rekamMedis->diagnosa }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rekamMedis->dokter_nama }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($rekamMedis->idreservasi_dokter)
                                        <a href="{{ route('data.temu-dokter.show', $rekamMedis->idreservasi_dokter) }}" 
                                           class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full hover:bg-blue-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            #{{ str_pad($rekamMedis->no_urut ?? 0, 3, '0', STR_PAD_LEFT) }}
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                                            Manual
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
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
                                        <button onclick="deleteRekamMedis({{ $rekamMedis->idrekam_medis }}, '{{ $rekamMedis->pet_nama }}', '{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y') }}')"
                                            class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        @endif --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center py-8">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        @if(Auth::user()->hasRole('Dokter'))
                                            <p class="text-lg font-medium text-gray-900 mb-2">Belum ada rekam medis pasien</p>
                                            <p class="text-gray-500 mb-4">Anda belum memiliki rekam medis pasien yang telah diperiksa</p>
                                        @else
                                            <p class="text-lg font-medium text-gray-900 mb-2">Belum ada data rekam medis</p>
                                            <p class="text-gray-500 mb-4">Mulai dengan membuat reservasi dokter untuk menambah rekam medis baru</p>
                                            <a href="{{ route('data.temu-dokter.index') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-rshp-blue text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Buat Reservasi Dokter
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-5">Hapus Rekam Medis</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus rekam medis untuk <span id="deletePetName"
                            class="font-semibold"></span> pada tanggal <span id="deleteDate"
                            class="font-semibold"></span>?
                    </p>
                    <p class="text-sm text-red-500 mt-2">
                        <strong>Perhatian:</strong> Tindakan ini akan menghapus semua detail tindakan yang terkait dan
                        tidak dapat dibatalkan!
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Hapus
                    </button>
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteForm = null;

        // Delete Modal Functions
        function deleteRekamMedis(id, petName, date) {
            document.getElementById('deletePetName').textContent = petName;
            document.getElementById('deleteDate').textContent = date;
            document.getElementById('deleteModal').classList.remove('hidden');

            // Create form for deletion
            if (deleteForm) {
                deleteForm.remove();
            }
            deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = `/data/rekam-medis/${id}`;
            deleteForm.style.display = 'none';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            deleteForm.appendChild(csrfInput);

            // Add method override for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            deleteForm.appendChild(methodInput);

            document.body.appendChild(deleteForm);

            // Set up confirm button
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

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection