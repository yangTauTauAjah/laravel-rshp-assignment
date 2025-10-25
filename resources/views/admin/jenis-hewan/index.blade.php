@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Kelola Jenis & Ras Hewan" subtitle="Manajemen data jenis hewan dan ras yang terkait"
        :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard">

        @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
            <x-slot:actionButton>
                <button onclick="openAddJenisModal()"
                    class="bg-rshp-orange text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Jenis Hewan
                </button>
            </x-slot:actionButton>
        @endif
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">
        <!-- Jenis & Ras Hewan Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Jenis dan Ras Hewan</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola jenis hewan dan ras yang terkait</p>
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
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $jenis->nama_jenis_hewan }}
                                    </div>
                                </td>

                                <!-- Animal Breeds Column -->
                                <td class="px-6 py-4">
                                    @if($jenis->rasHewan->isNotEmpty())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($jenis->rasHewan as $ras)
                                                <div
                                                    class="inline-flex items-center bg-gray-100 border border-gray-300 text-gray-800 px-3 py-1 rounded-full text-sm font-medium group hover:bg-gray-200 transition-colors">
                                                    <span class="mr-2">{{ $ras->nama_ras }}</span>
                                                    @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                                                        <div class="flex items-center space-x-1">
                                                            <button type="button"
                                                                class="bg-blue-500 hover:bg-blue-600 text-white rounded-full p-1 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300"
                                                                onclick="editRas({{ $ras->idras_hewan }}, '{{ $ras->nama_ras }}', {{ $jenis->idjenis_hewan }}, '{{ $jenis->nama_jenis_hewan }}')"
                                                                title="Edit ras {{ $ras->nama_ras }}">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                            <button type="button"
                                                                class="bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors focus:outline-none focus:ring-2 focus:ring-red-300"
                                                                onclick="deleteRas({{ $ras->idras_hewan }}, '{{ $ras->nama_ras }}')"
                                                                title="Hapus ras {{ $ras->nama_ras }}">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-400 italic py-2">
                                            Belum ada ras hewan
                                        </div>
                                    @endif
                                </td>

                                <!-- Action Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                                        <div class="flex items-center justify-center space-x-2">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-rshp-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rshp-orange transition-colors"
                                                onclick="addRasToJenis({{ $jenis->idjenis_hewan }}, '{{ $jenis->nama_jenis_hewan }}')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Tambah Ras
                                            </button>
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                                onclick="deleteJenis({{ $jenis->idjenis_hewan }}, '{{ $jenis->nama_jenis_hewan }}')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Hapus Jenis
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500 italic">View Only</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada data jenis hewan</p>
                                        <p class="text-sm">Mulai dengan menambahkan jenis hewan pertama</p>
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
    @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
        <div id="addJenisModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
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

                    <form method="POST" action="{{ route('jenis-hewan.store') }}" class="space-y-4" id="addJenisForm">
                        @csrf
                        <div>
                            <label for="nama_jenis_hewan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jenis Hewan
                            </label>
                            <input type="text" id="nama_jenis_hewan" name="nama_jenis_hewan" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-orange focus:border-transparent"
                                placeholder="Contoh: Kucing, Anjing, Burung">
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closeAddJenisModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-rshp-orange text-white rounded-md hover:bg-orange-600 transition-colors">
                                Tambah Jenis Hewan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Ras Hewan Modal -->
        <div id="addRasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
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

                    <form method="POST" action="{{ route('ras-hewan.store') }}" class="space-y-4" id="addRasForm">
                        @csrf
                        <input type="hidden" id="modal_idjenis_hewan" name="idjenis_hewan" value="">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Hewan
                            </label>
                            <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700"
                                id="modal_jenis_display">
                                Pilih jenis hewan dari tabel
                            </div>
                        </div>

                        <div>
                            <label for="modal_nama_ras" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ras Hewan
                            </label>
                            <input type="text" id="modal_nama_ras" name="nama_ras" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-orange focus:border-transparent"
                                placeholder="Contoh: Persia, Golden Retriever, Lovebird">
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closeAddRasModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-rshp-orange text-white rounded-md hover:bg-orange-600 transition-colors">
                                Tambah Ras Hewan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Ras Hewan Modal -->
        <div id="editRasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
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

                    <form method="POST" action="" class="space-y-4" id="editRasForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_modal_idjenis_hewan" name="idjenis_hewan" value="">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Hewan
                            </label>
                            <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700"
                                id="edit_modal_jenis_display">
                                Pilih jenis hewan dari tabel
                            </div>
                        </div>

                        <div>
                            <label for="edit_modal_nama_ras" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ras Hewan
                            </label>
                            <input type="text" id="edit_modal_nama_ras" name="nama_ras" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-orange focus:border-transparent"
                                placeholder="Contoh: Persia, Golden Retriever, Lovebird">
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closeEditRasModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Update Ras Hewan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- JavaScript -->
    <script>
        // Add Jenis Hewan Modal Functions
        function openAddJenisModal() {
            document.getElementById('addJenisModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('nama_jenis_hewan').focus();
            }, 100);
        }

        function closeAddJenisModal() {
            document.getElementById('addJenisModal').classList.add('hidden');
            document.getElementById('addJenisForm').reset();
        }

        // Add Ras Hewan Modal Functions
        function openAddRasModal() {
            document.getElementById('addRasModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('modal_nama_ras').focus();
            }, 100);
        }

        function closeAddRasModal() {
            document.getElementById('addRasModal').classList.add('hidden');
            document.getElementById('addRasForm').reset();
            document.getElementById('modal_jenis_display').textContent = 'Pilih jenis hewan dari tabel';
            document.getElementById('modal_idjenis_hewan').value = '';
        }

        function addRasToJenis(jenisId, jenisName) {
            document.getElementById('modal_idjenis_hewan').value = jenisId;
            document.getElementById('modal_jenis_display').textContent = jenisName;
            openAddRasModal();
        }

        // Edit Ras Hewan Modal Functions
        function openEditRasModal() {
            document.getElementById('editRasModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('edit_modal_nama_ras').focus();
            }, 100);
        }

        function closeEditRasModal() {
            document.getElementById('editRasModal').classList.add('hidden');
            document.getElementById('editRasForm').reset();
            document.getElementById('edit_modal_jenis_display').textContent = 'Pilih jenis hewan dari tabel';
            document.getElementById('edit_modal_idjenis_hewan').value = '';
        }

        function editRas(rasId, rasName, jenisId, jenisName) {
            document.getElementById('edit_modal_nama_ras').value = rasName;
            document.getElementById('edit_modal_idjenis_hewan').value = jenisId;
            document.getElementById('edit_modal_jenis_display').textContent = jenisName;

            // Set the form action
            const form = document.getElementById('editRasForm');
            form.action = `/admin/ras-hewan/${rasId}`;

            openEditRasModal();
        }

        // Delete Functions
        function deleteRas(rasId, rasName) {
            if (confirm(`Apakah Anda yakin ingin menghapus ras "${rasName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/ras-hewan/${rasId}`;
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteJenis(jenisId, jenisName) {
            if (confirm(`Apakah Anda yakin ingin menghapus jenis hewan "${jenisName}"?\n\nPeringatan: Semua ras yang terkait dengan jenis ini juga akan terhapus.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/jenis-hewan/${jenisId}`;
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modals when clicking outside
        document.getElementById('addJenisModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeAddJenisModal();
        });

        document.getElementById('addRasModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeAddRasModal();
        });

        document.getElementById('editRasModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeEditRasModal();
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAddJenisModal();
                closeAddRasModal();
                closeEditRasModal();
            }
        });
    </script>
@endsection