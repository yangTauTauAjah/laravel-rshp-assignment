@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Kelola Rekam Medis" subtitle="Manajemen rekam medis hewan peliharaan"
        :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard">        @if(Auth::user()->isAdministrator() || Auth::user()->isDokter())
        <x-slot:actionButton>
            <button onclick="openAddRekamMedisModal()"
                class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Rekam Medis
            </button>
        </x-slot:actionButton>
        @endif
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">

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
                                                {{ $rekamMedis->pet_nama }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $rekamMedis->nama_ras }} - {{ $rekamMedis->nama_jenis_hewan }}
                                                <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $rekamMedis->jenis_kelamin == 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                    {{ $rekamMedis->jenis_kelamin == 'M' ? 'Jantan' : 'Betina' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.rekam-medis.show', $rekamMedis->idrekam_medis) }}"
                                            class="text-rshp-green hover:text-green-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if(Auth::user()->isAdministrator() || Auth::user()->isDokter())
                                        <a href="{{ route('admin.rekam-medis.edit', $rekamMedis->idrekam_medis) }}"
                                            class="text-rshp-blue hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        @endif
                                        @if(Auth::user()->isAdministrator())
                                        <button onclick="deleteRekamMedis({{ $rekamMedis->idrekam_medis }}, '{{ $rekamMedis->pet_nama }}', '{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d M Y') }}')"
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
                                    Belum ada data rekam medis
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>    <!-- Add Rekam Medis Modal -->
    <div id="addRekamMedisModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Rekam Medis</h3>
                <button onclick="closeAddRekamMedisModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="addRekamMedisForm" action="{{ route('admin.rekam-medis.store') }}" method="POST">
                @csrf
                <div class="space-y-4 max-h-96 overflow-y-auto">

                    <!-- Pet Selection -->
                    <div>
                        <label for="modal_idpet" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Hewan Pasien <span class="text-red-500">*</span>
                        </label>
                        <select id="modal_idpet" name="idpet" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="">Pilih hewan pasien...</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->idpet }}">
                                    {{ $pet->nama }} - {{ $pet->nama_ras }} ({{ $pet->nama_jenis_hewan }}) - Pemilik: {{ $pet->pemilik_nama }}
                                </option>
                            @endforeach
                        </select>
                        <div id="modal_idpet_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Doctor Selection -->
                    <div>
                        <label for="modal_dokter_pemeriksa" class="block text-sm font-medium text-gray-700 mb-2">
                            Dokter Pemeriksa <span class="text-red-500">*</span>
                        </label>
                        <select id="modal_dokter_pemeriksa" name="dokter_pemeriksa" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="">Pilih dokter pemeriksa...</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->idrole_user }}">
                                    {{ $doctor->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div id="modal_dokter_pemeriksa_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Anamnesis -->
                    <div>
                        <label for="modal_anamnesa" class="block text-sm font-medium text-gray-700 mb-2">
                            Anamnesa <span class="text-red-500">*</span>
                        </label>
                        <textarea id="modal_anamnesa" name="anamnesa" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Keluhan pemilik, riwayat penyakit, gejala yang diamati..."></textarea>
                        <div id="modal_anamnesa_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Clinical Findings -->
                    <div>
                        <label for="modal_temuan_klinis" class="block text-sm font-medium text-gray-700 mb-2">
                            Temuan Klinis <span class="text-red-500">*</span>
                        </label>
                        <textarea id="modal_temuan_klinis" name="temuan_klinis" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Hasil pemeriksaan fisik, vital sign, temuan abnormal..."></textarea>
                        <div id="modal_temuan_klinis_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Diagnosis -->
                    <div>
                        <label for="modal_diagnosa" class="block text-sm font-medium text-gray-700 mb-2">
                            Diagnosa <span class="text-red-500">*</span>
                        </label>
                        <textarea id="modal_diagnosa" name="diagnosa" required rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Diagnosa berdasarkan temuan klinis dan anamnesa..."></textarea>
                        <div id="modal_diagnosa_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Treatment Details Section -->
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-md font-medium text-gray-900">Detail Tindakan & Terapi</h4>
                            <button type="button" onclick="addModalTindakanRow()"
                                class="bg-rshp-green text-white px-3 py-1 text-sm rounded-md hover:bg-green-700 transition-colors">
                                + Tambah Tindakan
                            </button>
                        </div>
                        
                        <div id="modalTindakanContainer">
                            <!-- Tindakan rows will be added here by JavaScript -->
                        </div>
                        
                        <p class="text-sm text-gray-500 mt-2">
                            <em>Opsional: Tambahkan detail tindakan dan terapi yang dilakukan</em>
                        </p>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeAddRekamMedisModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
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
    </div>    <script>
        let deleteForm = null;
        let modalTindakanCounter = 0;
        let kodeTindakanData = [];

        // Load treatment codes when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadKodeTindakan();
        });

        function loadKodeTindakan() {
            fetch('/admin/rekam-medis/kode-tindakan')
                .then(response => response.json())
                .then(data => {
                    kodeTindakanData = data;
                })
                .catch(error => {
                    console.error('Error loading treatment codes:', error);
                    kodeTindakanData = [];
                });
        }

        // Add Rekam Medis Modal Functions
        function openAddRekamMedisModal() {
            document.getElementById('addRekamMedisModal').classList.remove('hidden');
            // Reset form
            document.getElementById('addRekamMedisForm').reset();
            // Clear tindakan container
            document.getElementById('modalTindakanContainer').innerHTML = '';
            modalTindakanCounter = 0;
            // Clear any error messages
            clearModalErrors();
            // Add initial tindakan row
            addModalTindakanRow();
        }

        function closeAddRekamMedisModal() {
            document.getElementById('addRekamMedisModal').classList.add('hidden');
        }

        function clearModalErrors() {
            const errorElements = document.querySelectorAll('[id$="_error"]');
            errorElements.forEach(element => {
                element.textContent = '';
                element.classList.add('hidden');
            });
            // Remove error styling
            const inputs = document.querySelectorAll('#addRekamMedisForm input, #addRekamMedisForm select, #addRekamMedisForm textarea');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
            });
        }

        function addModalTindakanRow() {
            const container = document.getElementById('modalTindakanContainer');
            const rowHtml = `
                <div class="tindakan-row border border-gray-200 rounded-md p-3 mb-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Kode Tindakan/Terapi
                            </label>
                            <select name="detail_tindakan[${modalTindakanCounter}][idkode_tindakan_terapi]" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <option value="">Pilih kode tindakan...</option>
                                ${kodeTindakanData.map(kode => 
                                    `<option value="${kode.idkode_tindakan_terapi}">
                                        ${kode.kode} - ${kode.deskripsi_tindakan_terapi}
                                    </option>`
                                ).join('')}
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Detail Tambahan
                            </label>
                            <div class="flex space-x-2">
                                <input type="text" name="detail_tindakan[${modalTindakanCounter}][detail]" 
                                    placeholder="Detail opsional..."
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                                <button type="button" onclick="removeModalTindakanRow(this)" 
                                    class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', rowHtml);
            modalTindakanCounter++;
        }

        function removeModalTindakanRow(button) {
            const row = button.closest('.tindakan-row');
            row.remove();
        }

        // Handle form submission
        document.getElementById('addRekamMedisForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearModalErrors();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeAddRekamMedisModal();
                    // Show success message
                    showNotification('Rekam medis berhasil ditambahkan!', 'success');
                    // Reload page to show new record
                    window.location.reload();
                } else if (data.errors) {
                    // Show validation errors
                    Object.keys(data.errors).forEach(key => {
                        const errorElement = document.getElementById(`modal_${key}_error`);
                        const inputElement = document.querySelector(`[name="${key}"]`);
                        
                        if (errorElement && inputElement) {
                            errorElement.textContent = data.errors[key][0];
                            errorElement.classList.remove('hidden');
                            inputElement.classList.add('border-red-500');
                        }
                    });
                    showNotification('Mohon perbaiki kesalahan pada form.', 'error');
                } else {
                    showNotification(data.message || 'Terjadi kesalahan saat menyimpan data.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan sistem.', 'error');
            });
        });

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

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
            deleteForm.action = `/admin/rekam-medis/${id}`;
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

        // Close modals when clicking outside
        document.getElementById('addRekamMedisModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddRekamMedisModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
