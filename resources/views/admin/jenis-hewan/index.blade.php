@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Kelola Jenis & Ras Hewan" subtitle="Manajemen jenis hewan dan ras yang terkait"
        :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard">

        <x-slot:actionButton>
            <button onclick="openAddJenisModal()"
                class="bg-rshp-orange text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Jenis Hewan
            </button>
        </x-slot:actionButton>
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">
        <!-- Combined Animal Management Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-rshp-dark-gray">Data Jenis dan Ras Hewan</h2>
                <p class="text-sm text-gray-600 mt-1">Manajemen jenis hewan dan ras yang terkait</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis Hewan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ras Hewan
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jenisHewan as $jenis)
                            <tr class="hover:bg-gray-50">
                                <!-- Animal Type Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-rshp-blue rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $jenis->nama_jenis_hewan }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $jenis->rasHewan->count() }} ras terdaftar
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Animal Breeds Column -->
                                <td class="px-6 py-4">
                                    @if($jenis->rasHewan->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($jenis->rasHewan as $ras)
                                                <div class="group relative">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $ras->nama_ras }}
                                                        <button type="button"
                                                            onclick="editRas({{ $ras->idras_hewan }}, '{{ $ras->nama_ras }}', {{ $jenis->idjenis_hewan }}, '{{ $jenis->nama_jenis_hewan }}')"
                                                            class="ml-1 hover:text-blue-900">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <button type="button"
                                                            onclick="deleteRas({{ $ras->idras_hewan }}, '{{ $ras->nama_ras }}')"
                                                            class="ml-1 hover:text-red-600">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-2">
                                            <span class="text-sm text-gray-400 italic">Belum ada ras terdaftar</span>
                                        </div>
                                    @endif
                                </td>

                                <!-- Action Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button"
                                            onclick="addRasToJenis({{ $jenis->idjenis_hewan }}, '{{ $jenis->nama_jenis_hewan }}')"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-rshp-orange hover:bg-orange-600 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Tambah Ras
                                        </button>
                                        <button type="button"
                                            onclick="deleteJenis({{ $jenis->idjenis_hewan }}, '{{ $jenis->nama_jenis_hewan }}')"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Hapus Jenis
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500">Belum ada data jenis hewan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Jenis Hewan Modal -->
    <div id="addJenisModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Tambah Jenis Hewan</h3>
                    <button type="button" onclick="closeAddJenisModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('jenis-hewan.store') }}" id="addJenisForm">
                    @csrf
                    <div class="mb-4">
                        <label for="nama_jenis_hewan" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Jenis Hewan
                        </label>
                        <input type="text" id="nama_jenis_hewan" name="nama_jenis_hewan" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-orange focus:border-transparent"
                            placeholder="Contoh: Kucing, Anjing, Burung">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddJenisModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rshp-orange text-white rounded-md hover:bg-orange-600 transition-colors">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Ras Hewan Modal -->
    <div id="addRasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Tambah Ras Hewan</h3>
                    <button type="button" onclick="closeAddRasModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('ras-hewan.store') }}" id="addRasForm">
                    @csrf
                    <input type="hidden" id="modal_idjenis_hewan" name="idjenis_hewan" value="">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Hewan
                        </label>
                        <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700"
                            id="modal_jenis_display">
                            Pilih jenis hewan dari tabel
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="modal_nama_ras" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Ras Hewan
                        </label>
                        <input type="text" id="modal_nama_ras" name="nama_ras" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-orange focus:border-transparent"
                            placeholder="Contoh: Persia, Golden Retriever, Lovebird">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddRasModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rshp-orange text-white rounded-md hover:bg-orange-600 transition-colors">
                            Tambah Ras
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Ras Hewan Modal -->
    <div id="editRasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-rshp-dark-gray">Edit Ras Hewan</h3>
                    <button type="button" onclick="closeEditRasModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form method="POST" id="editRasForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_modal_idjenis_hewan" name="idjenis_hewan" value="">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Hewan
                        </label>
                        <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700"
                            id="edit_modal_jenis_display">
                            -
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="edit_modal_nama_ras" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Ras Hewan
                        </label>
                        <input type="text" id="edit_modal_nama_ras" name="nama_ras" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-orange focus:border-transparent">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditRasModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add Jenis Modal Functions
        function openAddJenisModal() {
            document.getElementById('addJenisModal').classList.remove('hidden');
            setTimeout(() => document.getElementById('nama_jenis_hewan').focus(), 100);
        }

        function closeAddJenisModal() {
            document.getElementById('addJenisModal').classList.add('hidden');
            document.getElementById('addJenisForm').reset();
        }

        // Add Ras Modal Functions
        function addRasToJenis(jenisId, jenisName) {
            document.getElementById('modal_idjenis_hewan').value = jenisId;
            document.getElementById('modal_jenis_display').textContent = jenisName;
            document.getElementById('addRasModal').classList.remove('hidden');
            setTimeout(() => document.getElementById('modal_nama_ras').focus(), 100);
        }

        function closeAddRasModal() {
            document.getElementById('addRasModal').classList.add('hidden');
            document.getElementById('addRasForm').reset();
            document.getElementById('modal_jenis_display').textContent = 'Pilih jenis hewan dari tabel';
            document.getElementById('modal_idjenis_hewan').value = '';
        }

        // Edit Ras Modal Functions
        function editRas(rasId, rasName, jenisId, jenisName) {
            document.getElementById('edit_modal_nama_ras').value = rasName;
            document.getElementById('edit_modal_idjenis_hewan').value = jenisId;
            document.getElementById('edit_modal_jenis_display').textContent = jenisName;
            document.getElementById('editRasForm').action = `/admin/ras-hewan/${rasId}`;
            document.getElementById('editRasModal').classList.remove('hidden');
        }

        function closeEditRasModal() {
            document.getElementById('editRasModal').classList.add('hidden');
            document.getElementById('editRasForm').reset();
        }

        // Delete Functions
        function deleteRas(rasId, rasName) {
            if (confirm(`Apakah Anda yakin ingin menghapus ras "${rasName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/ras-hewan/${rasId}`;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteJenis(jenisId, jenisName) {
            if (confirm(`Apakah Anda yakin ingin menghapus jenis hewan "${jenisName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/jenis-hewan/${jenisId}`;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modals when clicking outside
        ['addJenisModal', 'addRasModal', 'editRasModal'].forEach(modalId => {
            document.getElementById(modalId).addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddJenisModal();
                closeAddRasModal();
                closeEditRasModal();
            }
        });
    </script>
@endsection
