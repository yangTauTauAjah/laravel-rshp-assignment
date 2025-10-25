@extends('layouts.app')

@section('content')    <!-- Page Header -->    <x-admin-header title="Kelola Pemilik Hewan" subtitle="Manajemen data pemilik hewan peliharaan"
        :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard">

        @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
        <x-slot:actionButton>
            <button onclick="openAddPemilikModal()"
                class="bg-rshp-green text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pemilik Hewan
            </button>
        </x-slot:actionButton>
        @endif
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">

        <!-- Pemilik Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Pemilik Hewan</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pemilik
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. WhatsApp
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Hewan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pemilikList as $pemilik)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $pemilik->idpemilik }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-rshp-green rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">
                                                {{ strtoupper(substr($pemilik->user->nama, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $pemilik->user->nama }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pemilik->user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                        </svg>
                                        {{ $pemilik->no_wa }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs truncate" title="{{ $pemilik->alamat }}">
                                        {{ $pemilik->alamat }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $pemilik->pets->count() }} hewan
                                    </span>                                </td>                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                                        <button onclick="editPemilik({{ $pemilik->idpemilik }})"
                                            class="text-rshp-blue hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        @endif
                                        @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                                        <button
                                            onclick="deletePemilik({{ $pemilik->idpemilik }}, '{{ $pemilik->user->nama }}', {{ $pemilik->pets->count() }})"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data pemilik hewan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Pemilik Modal -->
    <div id="addPemilikModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white mb-10">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray">Tambah Pemilik Hewan</h3>
                    <button onclick="closeAddPemilikModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>                <!-- Add Pemilik Form -->
                <form action="{{ route('admin.pemilik.store') }}" method="POST" id="addPemilikForm">
                    @csrf

                    <!-- Registration Type Tabs -->
                    <div class="mb-6">
                        <div class="flex border-b border-gray-200">
                            <button type="button" onclick="switchRegistrationType('new')" id="newUserTab"
                                class="registration-tab active px-4 py-2 font-medium text-sm border-b-2 border-rshp-green text-rshp-green">
                                Buat User Baru
                            </button>
                            <button type="button" onclick="switchRegistrationType('existing')" id="existingUserTab"
                                class="registration-tab px-4 py-2 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                                Gunakan User yang Sudah Ada
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="registration_type" id="registration_type" value="new">

                    <!-- New User Fields -->
                    <div id="newUserFields" class="space-y-4 mb-4">
                        <!-- Nama -->
                        <div>
                            <label for="add_nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="add_nama" name="nama"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="add_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="add_email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="example@email.com">
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="add_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="add_password" name="password" minlength="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="Minimal 6 karakter">
                        </div>
                    </div>

                    <!-- Existing User Fields -->
                    <div id="existingUserFields" class="space-y-4 mb-4 hidden">
                        <!-- User Dropdown -->
                        <div>
                            <label for="existing_user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih User <span class="text-red-500">*</span>
                            </label>
                            <select id="existing_user_id" name="existing_user_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green">
                                <option value="">Pilih user yang sudah terdaftar</option>
                                @foreach ($availableUsers as $user)
                                    <option value="{{ $user->iduser }}">{{ $user->nama }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Hanya menampilkan user yang belum terdaftar sebagai pemilik</p>
                        </div>
                    </div>

                    <!-- Common Fields (for both types) -->
                    <div class="space-y-4 mb-4">
                        <!-- No. WhatsApp -->
                        <div>
                            <label for="add_no_wa" class="block text-sm font-medium text-gray-700 mb-2">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="add_no_wa" name="no_wa" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="add_alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea id="add_alamat" name="alamat" required rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeAddPemilikModal()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rshp-green text-white rounded-md hover:bg-green-700 transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Pemilik Modal -->
    <div id="editPemilikModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white mb-10">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-rshp-dark-gray">Edit Pemilik Hewan</h3>
                    <button onclick="closeEditPemilikModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Edit Pemilik Form -->
                <form id="editPemilikForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4 mb-4">
                        <!-- Nama -->
                        <div>
                            <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_nama" name="nama" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="edit_email" name="email" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="example@email.com">
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-gray-500">(Kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <input type="password" id="edit_password" name="password" minlength="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="Minimal 6 karakter">
                        </div>

                        <!-- No. WhatsApp -->
                        <div>
                            <label for="edit_no_wa" class="block text-sm font-medium text-gray-700 mb-2">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_no_wa" name="no_wa" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="edit_alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea id="edit_alamat" name="alamat" required rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-green"
                                placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                    </div>

                    <!-- Info about pets -->
                    <div id="petsInfoContainer" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md hidden">
                        <p class="text-sm text-blue-800">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Pemilik ini memiliki <span id="petsCount" class="font-semibold"></span> hewan terdaftar
                        </p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeEditPemilikModal()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-rshp-green text-white rounded-md hover:bg-green-700 transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>    <script>
        // Switch Registration Type
        function switchRegistrationType(type) {
            const registrationTypeInput = document.getElementById('registration_type');
            const newUserFields = document.getElementById('newUserFields');
            const existingUserFields = document.getElementById('existingUserFields');
            const newUserTab = document.getElementById('newUserTab');
            const existingUserTab = document.getElementById('existingUserTab');

            // Remove all required attributes first
            document.getElementById('add_nama').removeAttribute('required');
            document.getElementById('add_email').removeAttribute('required');
            document.getElementById('add_password').removeAttribute('required');
            document.getElementById('existing_user_id').removeAttribute('required');

            if (type === 'new') {
                registrationTypeInput.value = 'new';
                newUserFields.classList.remove('hidden');
                existingUserFields.classList.add('hidden');
                
                // Set required for new user fields
                document.getElementById('add_nama').setAttribute('required', 'required');
                document.getElementById('add_email').setAttribute('required', 'required');
                document.getElementById('add_password').setAttribute('required', 'required');

                // Update tab styling
                newUserTab.classList.add('border-rshp-green', 'text-rshp-green');
                newUserTab.classList.remove('border-transparent', 'text-gray-500');
                existingUserTab.classList.add('border-transparent', 'text-gray-500');
                existingUserTab.classList.remove('border-rshp-green', 'text-rshp-green');
            } else {
                registrationTypeInput.value = 'existing';
                newUserFields.classList.add('hidden');
                existingUserFields.classList.remove('hidden');
                
                // Set required for existing user field
                document.getElementById('existing_user_id').setAttribute('required', 'required');

                // Update tab styling
                existingUserTab.classList.add('border-rshp-green', 'text-rshp-green');
                existingUserTab.classList.remove('border-transparent', 'text-gray-500');
                newUserTab.classList.add('border-transparent', 'text-gray-500');
                newUserTab.classList.remove('border-rshp-green', 'text-rshp-green');
            }
        }

        // Open Add Pemilik Modal
        function openAddPemilikModal() {
            // Reset to new user type by default
            switchRegistrationType('new');
            document.getElementById('addPemilikForm').reset();
            document.getElementById('addPemilikModal').classList.remove('hidden');
        }

        // Close Add Pemilik Modal
        function closeAddPemilikModal() {
            document.getElementById('addPemilikModal').classList.add('hidden');
            document.getElementById('addPemilikForm').reset();
        }

        // Edit Pemilik
        async function editPemilik(pemilikId) {
            try {
                const response = await fetch(`/admin/pemilik/${pemilikId}`);
                const pemilik = await response.json();

                // Populate form fields
                document.getElementById('edit_nama').value = pemilik.nama;
                document.getElementById('edit_email').value = pemilik.email;
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_no_wa').value = pemilik.no_wa;
                document.getElementById('edit_alamat').value = pemilik.alamat;

                // Show pets info if owner has pets
                if (pemilik.pets_count > 0) {
                    document.getElementById('petsCount').textContent = pemilik.pets_count;
                    document.getElementById('petsInfoContainer').classList.remove('hidden');
                } else {
                    document.getElementById('petsInfoContainer').classList.add('hidden');
                }

                // Set form action
                document.getElementById('editPemilikForm').action = `/admin/pemilik/${pemilikId}`;

                // Show modal
                document.getElementById('editPemilikModal').classList.remove('hidden');
            } catch (error) {
                console.error('Error fetching pemilik data:', error);
                alert('Gagal memuat data pemilik');
            }
        }

        // Close Edit Pemilik Modal
        function closeEditPemilikModal() {
            document.getElementById('editPemilikModal').classList.add('hidden');
        }

        // Delete Pemilik
        function deletePemilik(pemilikId, pemilikName, petsCount) {
            if (petsCount > 0) {
                alert(
                    `Tidak dapat menghapus pemilik "${pemilikName}" karena masih memiliki ${petsCount} hewan terdaftar.`
                    );
                return;
            }

            if (confirm(`Apakah Anda yakin ingin menghapus data pemilik "${pemilikName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/pemilik/${pemilikId}`;

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
        document.getElementById('addPemilikModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddPemilikModal();
            }
        });

        document.getElementById('editPemilikModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditPemilikModal();
            }
        });
    </script>
@endsection
