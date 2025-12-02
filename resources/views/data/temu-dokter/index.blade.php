@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Kelola Temu Dokter" subtitle="Manajemen reservasi dan antrian dokter"
        :backRoute="route('data.dashboard')" backText="Kembali ke Dashboard">
        @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
        <x-slot:actionButton>
            <button onclick="openAddTemuDokterModal()"
                class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Reservasi
            </button>
        </x-slot:actionButton>
        @endif
    </x-admin-header>

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Menunggu</h3>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $temuDokterList->where('status', '0')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Selesai</h3>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $temuDokterList->where('status', '1')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Batal</h3>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $temuDokterList->where('status', '2')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h5.586a1 1 0 00.707-.293l5.414-5.414a1 1 0 00.293-.707V7a2 2 0 00-2-2H9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Hari Ini</h3>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $temuDokterList->filter(function($item) { 
                                return \Carbon\Carbon::parse($item->waktu_daftar)->isToday(); 
                            })->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctor Appointments Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Reservasi Dokter</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Antrian
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu Daftar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dokter
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($temuDokterList as $temuDokter)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ str_pad($temuDokter->no_urut, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($temuDokter->waktu_daftar)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $temuDokter->dokter_nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $temuDokter->dokter_email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = match($temuDokter->status) {
                                            '0' => ['text' => 'Menunggu', 'class' => 'bg-yellow-100 text-yellow-800'],
                                            '1' => ['text' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                                            '2' => ['text' => 'Batal', 'class' => 'bg-red-100 text-red-800'],
                                            default => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-800']
                                        };
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusConfig['class'] }}">
                                        {{ $statusConfig['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('data.temu-dokter.show', $temuDokter->idreservasi_dokter) }}"
                                            class="text-rshp-green hover:text-green-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                                        <!-- Status Update Buttons -->
                                        @if($temuDokter->status == '0')
                                        <button onclick="updateStatus({{ $temuDokter->idreservasi_dokter }}, '1')"
                                            class="text-green-600 hover:text-green-900" title="Selesai">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                        <button onclick="updateStatus({{ $temuDokter->idreservasi_dokter }}, '2')"
                                            class="text-red-600 hover:text-red-900" title="Batal">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        @endif
                                        <a href="{{ route('data.temu-dokter.edit', $temuDokter->idreservasi_dokter) }}"
                                            class="text-rshp-blue hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        @endif
                                        {{-- @if(Auth::user()->isAdministrator())
                                        <button onclick="deleteTemuDokter({{ $temuDokter->idreservasi_dokter }}, '{{ $temuDokter->dokter_nama }}', '{{ \Carbon\Carbon::parse($temuDokter->waktu_daftar)->format('d M Y H:i') }}')"
                                            class="text-red-600 hover:text-red-900">
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
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data reservasi dokter
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add TemuDokter Modal -->
    <div id="addTemuDokterModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Buat Reservasi Dokter</h3>
                <button onclick="closeAddTemuDokterModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="addTemuDokterForm" action="{{ route('data.temu-dokter.store') }}" method="POST">
                @csrf
                <div class="space-y-4">

                    <!-- Doctor Selection -->
                    <div>
                        <label for="modal_idrole_user" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Dokter <span class="text-red-500">*</span>
                        </label>
                        <select id="modal_idrole_user" name="idrole_user" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
                            <option value="">Pilih dokter...</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->idrole_user }}">
                                    {{ $doctor->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div id="modal_idrole_user_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Date and Time -->
                    <div>
                        <label for="modal_waktu_daftar" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Reservasi <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="modal_waktu_daftar" name="waktu_daftar" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            value="{{ now()->format('Y-m-d\TH:i') }}">
                        <div id="modal_waktu_daftar_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Queue Number (Optional) -->
                    <div>
                        <label for="modal_no_urut" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Antrian (opsional)
                        </label>
                        <input type="number" id="modal_no_urut" name="no_urut" min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue"
                            placeholder="Otomatis jika kosong">
                        <div id="modal_no_urut_error" class="text-red-500 text-xs mt-1 hidden"></div>
                        <p class="text-sm text-gray-500 mt-1">
                            <em>Biarkan kosong untuk mendapatkan nomor antrian otomatis</em>
                        </p>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeAddTemuDokterModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-rshp-blue text-white rounded-md hover:bg-blue-700 transition-colors">
                        Buat Reservasi
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
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-5">Hapus Reservasi</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus reservasi untuk dokter <span id="deleteDokterName"
                            class="font-semibold"></span> pada <span id="deleteDateTime"
                            class="font-semibold"></span>?
                    </p>
                    <p class="text-sm text-red-500 mt-2">
                        <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan!
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

        // Add TemuDokter Modal Functions
        function openAddTemuDokterModal() {
            document.getElementById('addTemuDokterModal').classList.remove('hidden');
            // Reset form
            document.getElementById('addTemuDokterForm').reset();
            // Set current datetime
            document.getElementById('modal_waktu_daftar').value = new Date().toISOString().slice(0, 16);
            // Clear any error messages
            clearModalErrors();
        }

        function closeAddTemuDokterModal() {
            document.getElementById('addTemuDokterModal').classList.add('hidden');
        }

        function clearModalErrors() {
            const errorElements = document.querySelectorAll('[id$="_error"]');
            errorElements.forEach(element => {
                element.textContent = '';
                element.classList.add('hidden');
            });
            // Remove error styling
            const inputs = document.querySelectorAll('#addTemuDokterForm input, #addTemuDokterForm select');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
            });
        }

        // Handle form submission
        document.getElementById('addTemuDokterForm').addEventListener('submit', function(e) {
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
                    closeAddTemuDokterModal();
                    // Show success message
                    showNotification('Reservasi dokter berhasil dibuat!', 'success');
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

        // Status update function
        function updateStatus(id, status) {
            const statusText = status === '1' ? 'Selesai' : 'Batal';
            
            if (confirm(`Apakah Anda yakin ingin mengubah status menjadi ${statusText}?`)) {
                fetch(`/data/temu-dokter/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal mengubah status.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan sistem.', 'error');
                });
            }
        }

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
        function deleteTemuDokter(id, dokterName, dateTime) {
            document.getElementById('deleteDokterName').textContent = dokterName;
            document.getElementById('deleteDateTime').textContent = dateTime;
            document.getElementById('deleteModal').classList.remove('hidden');

            // Create form for deletion
            if (deleteForm) {
                deleteForm.remove();
            }
            deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = `/data/temu-dokter/${id}`;
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
        document.getElementById('addTemuDokterModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddTemuDokterModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
