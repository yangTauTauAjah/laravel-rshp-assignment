@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Kelola Data Hewan Peliharaan" subtitle="Manajemen data hewan peliharaan pasien"
        :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard">

        <x-slot:actionButton>
            <button onclick="openAddPetModal()"
                class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Hewan Peliharaan
            </button>
        </x-slot:actionButton>
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">

        <!-- Pets Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Hewan Peliharaan</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Hewan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis & Ras
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelamin
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Lahir
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pemilik
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pets as $pet)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $pet->idpet }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-rshp-orange rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $pet->nama }}
                                            </div>
                                            @if ($pet->warna_tanda)
                                                <div class="text-sm text-gray-500">
                                                    {{ $pet->warna_tanda }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $pet->rasHewan->nama_ras }}</div>
                                    <div class="text-sm text-gray-500">{{ $pet->rasHewan->jenisHewan->nama_jenis_hewan }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pet->jenis_kelamin == 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $pet->jenis_kelamin == 'M' ? 'Jantan' : 'Betina' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($pet->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d M Y') }}
                                        <div class="text-xs text-gray-500">
                                            ({{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun)
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pet->pemilik->user->nama }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="editPet({{ $pet->idpet }})"
                                            class="text-rshp-blue hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button onclick="deletePet({{ $pet->idpet }}, '{{ $pet->nama }}')"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data hewan peliharaan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Pet Modal -->
    <div id="addPetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white mb-10">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray">Tambah Hewan Peliharaan</h3>
                    <button onclick="closeAddPetModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Add Pet Form -->
                <form action="{{ route('admin.pet.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Nama -->
                        <div>
                            <label for="add_nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Hewan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="add_nama" name="nama" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                                placeholder="Masukkan nama hewan">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="add_jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select id="add_jenis_kelamin" name="jenis_kelamin" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="M">Jantan</option>
                                <option value="F">Betina</option>
                            </select>
                        </div>

                        <!-- Ras Hewan -->
                        <div>
                            <label for="add_idras_hewan" class="block text-sm font-medium text-gray-700 mb-2">
                                Ras Hewan <span class="text-red-500">*</span>
                            </label>
                            <select id="add_idras_hewan" name="idras_hewan" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih ras hewan</option>
                                @foreach ($rasHewanList as $ras)
                                    <option value="{{ $ras->idras_hewan }}">
                                        {{ $ras->nama_ras }} ({{ $ras->jenisHewan->nama_jenis_hewan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pemilik -->
                        <div>
                            <label for="add_idpemilik" class="block text-sm font-medium text-gray-700 mb-2">
                                Pemilik <span class="text-red-500">*</span>
                            </label>
                            <select id="add_idpemilik" name="idpemilik" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih pemilik</option>
                                @foreach ($pemilikList as $pemilik)
                                    <option value="{{ $pemilik->idpemilik }}">
                                        {{ $pemilik->user->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="add_tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" id="add_tanggal_lahir" name="tanggal_lahir"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                        </div>

                        <!-- Warna/Tanda -->
                        <div>
                            <label for="add_warna_tanda" class="block text-sm font-medium text-gray-700 mb-2">
                                Warna/Tanda Khusus
                            </label>
                            <input type="text" id="add_warna_tanda" name="warna_tanda"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                                placeholder="Contoh: Putih loreng hitam">
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeAddPetModal()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Pet Modal -->
    <div id="editPetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white mb-10">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray">Edit Hewan Peliharaan</h3>
                    <button onclick="closeEditPetModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Edit Pet Form -->
                <form id="editPetForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Nama -->
                        <div>
                            <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Hewan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_nama" name="nama" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                                placeholder="Masukkan nama hewan">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="edit_jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_jenis_kelamin" name="jenis_kelamin" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="M">Jantan</option>
                                <option value="F">Betina</option>
                            </select>
                        </div>

                        <!-- Ras Hewan -->
                        <div>
                            <label for="edit_idras_hewan" class="block text-sm font-medium text-gray-700 mb-2">
                                Ras Hewan <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_idras_hewan" name="idras_hewan" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih ras hewan</option>
                                @foreach ($rasHewanList as $ras)
                                    <option value="{{ $ras->idras_hewan }}">
                                        {{ $ras->nama_ras }} ({{ $ras->jenisHewan->nama_jenis_hewan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pemilik -->
                        <div>
                            <label for="edit_idpemilik" class="block text-sm font-medium text-gray-700 mb-2">
                                Pemilik <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_idpemilik" name="idpemilik" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih pemilik</option>
                                @foreach ($pemilikList as $pemilik)
                                    <option value="{{ $pemilik->idpemilik }}">
                                        {{ $pemilik->user->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="edit_tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                        </div>

                        <!-- Warna/Tanda -->
                        <div>
                            <label for="edit_warna_tanda" class="block text-sm font-medium text-gray-700 mb-2">
                                Warna/Tanda Khusus
                            </label>
                            <input type="text" id="edit_warna_tanda" name="warna_tanda"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                                placeholder="Contoh: Putih loreng hitam">
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeEditPetModal()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Open Add Pet Modal
        function openAddPetModal() {
            document.getElementById('addPetModal').classList.remove('hidden');
        }

        // Close Add Pet Modal
        function closeAddPetModal() {
            document.getElementById('addPetModal').classList.add('hidden');
            document.getElementById('addPetForm').reset();
        }

        // Edit Pet
        async function editPet(petId) {
            try {
                const response = await fetch(`/admin/pet/${petId}`);
                const pet = await response.json();

                // Populate form fields
                document.getElementById('edit_nama').value = pet.nama;
                document.getElementById('edit_jenis_kelamin').value = pet.jenis_kelamin;
                document.getElementById('edit_idras_hewan').value = pet.idras_hewan;
                document.getElementById('edit_idpemilik').value = pet.idpemilik;
                document.getElementById('edit_tanggal_lahir').value = pet.tanggal_lahir || '';
                document.getElementById('edit_warna_tanda').value = pet.warna_tanda || '';

                // Set form action
                document.getElementById('editPetForm').action = `/admin/pet/${petId}`;

                // Show modal
                document.getElementById('editPetModal').classList.remove('hidden');
            } catch (error) {
                console.error('Error fetching pet data:', error);
                alert('Gagal memuat data hewan peliharaan');
            }
        }

        // Close Edit Pet Modal
        function closeEditPetModal() {
            document.getElementById('editPetModal').classList.add('hidden');
        }

        // Delete Pet
        function deletePet(petId, petName) {
            if (confirm(`Apakah Anda yakin ingin menghapus data hewan "${petName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/pet/${petId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modals on background click
        document.getElementById('addPetModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddPetModal();
            }
        });

        document.getElementById('editPetModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditPetModal();
            }
        });
    </script>
@endsection
