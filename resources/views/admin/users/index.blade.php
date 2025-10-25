@extends('layouts.app')

@section('content')
  <!-- Page Header -->
  <x-admin-header title="Kelola Pengguna" subtitle="Manajemen pengguna sistem RSHP" :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard">

    <x-slot:actionButton>
      @if(Auth::user()->isAdministrator())
        <button onclick="openAddUserModal()"
          class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Tambah Pengguna
        </button>
      @endif
    </x-slot:actionButton>
  </x-admin-header>

  <div class="mx-auto my-6 max-w-7xl w-full flex-1">

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Pengguna</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ID
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nama
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Email
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  #{{ $user->iduser }}
                  @auth
                    @if($user->iduser == auth()->user()->iduser)
                      <span
                        class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-rshp-blue text-white">
                        Akun Anda
                      </span>
                    @endif
                  @endauth
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $user->nama }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $user->email }}
                </td>                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex items-center space-x-2">
                    @if(Auth::user()->isAdministrator())
                      <button onclick="editUser({{ $user->iduser }})" class="text-yellow-600 hover:text-yellow-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                          </path>
                        </svg>
                      </button>
                      <button onclick="resetPassword({{ $user->iduser }}, '{{ $user->nama }}')"
                        class="text-orange-600 hover:text-orange-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                          </path>
                        </svg>
                      </button>
                      @auth
                        @if($user->iduser == auth()->user()->iduser)
                          <button disabled class="text-gray-400 cursor-not-allowed"
                            title="Tidak dapat menghapus akun Anda sendiri">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                              </path>
                            </svg>
                          </button>
                        @else
                          <form action="{{ route('users.destroy', $user->iduser) }}" method="POST" class="inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                              </svg>
                            </button>
                          </form>
                        @endif
                      @endauth
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                  Tidak ada data pengguna
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add User Modal -->
  <div id="addUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Tambah Pengguna Baru</h3>
        <button onclick="closeAddUserModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('users.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
          <input type="text" name="nama" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
          <input type="email" name="email" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
          <input type="password" name="password" required minlength="6"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
          <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeAddUserModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-blue text-white rounded hover:bg-blue-700 transition-colors">
            Tambah
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit User Modal -->
  <div id="editUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Edit Pengguna</h3>
        <button onclick="closeEditUserModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form id="editUserForm" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
          <input type="text" name="nama" id="editNama" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
          <input type="email" name="email" id="editEmail" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeEditUserModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-blue text-white rounded hover:bg-blue-700 transition-colors">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Password Reset Result Modal -->
  <div id="passwordResetModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Password Berhasil Direset</h3>
        <button onclick="closePasswordResetModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div class="mt-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
          <p class="text-sm text-gray-700 mb-2">Password untuk <strong id="resetUserName"></strong> telah direset.</p>
          <div class="mt-3 p-3 bg-white border border-gray-200 rounded">
            <label class="block text-xs text-gray-500 mb-1">Password Baru:</label>
            <div class="flex items-center justify-between">
              <code id="newPassword" class="text-lg font-mono font-bold text-rshp-blue"></code>
              <button onclick="copyPassword()" class="text-rshp-blue hover:text-blue-700 ml-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                  </path>
                </svg>
              </button>
            </div>
          </div>
          <p class="text-xs text-red-600 mt-3">⚠️ Pastikan Anda menyalin password ini. Password tidak dapat ditampilkan
            lagi.</p>
        </div>
        <div class="flex justify-end mt-4">
          <button onclick="closePasswordResetModal()"
            class="px-4 py-2 bg-rshp-blue text-white rounded hover:bg-blue-700 transition-colors">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  </div>

  <script>
    // Add User Modal
    function openAddUserModal() {
      document.getElementById('addUserModal').classList.remove('hidden');
    }

    function closeAddUserModal() {
      document.getElementById('addUserModal').classList.add('hidden');
    }
      // Edit User Modal
    function editUser(userId) {
      fetch(`/admin/users/${userId}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          document.getElementById('editNama').value = data.nama;
          document.getElementById('editEmail').value = data.email;
          document.getElementById('editUserForm').action = `/admin/users/${userId}`;
          document.getElementById('editUserModal').classList.remove('hidden');
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat mengambil data pengguna: ' + error.message);
        });
    }

    function closeEditUserModal() {
      document.getElementById('editUserModal').classList.add('hidden');
    }
      // Reset Password
    function resetPassword(userId, userName) {
      if (confirm(`Apakah Anda yakin ingin mereset password untuk ${userName}?\n\nPassword baru akan dibuat secara otomatis.`)) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
          alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
          return;
        }

        fetch(`/admin/users/${userId}/reset-password`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          }
        })
          .then(response => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
          })
          .then(data => {
            if (data.success) {
              // Extract password from message
              const passwordMatch = data.message.match(/Password baru: (.+)/);
              if (passwordMatch) {
                document.getElementById('resetUserName').textContent = userName;
                document.getElementById('newPassword').textContent = passwordMatch[1];
                document.getElementById('passwordResetModal').classList.remove('hidden');
              }
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mereset password: ' + error.message);
          });
      }
    }

    function closePasswordResetModal() {
      document.getElementById('passwordResetModal').classList.add('hidden');
    }

    function copyPassword() {
      const password = document.getElementById('newPassword').textContent;
      navigator.clipboard.writeText(password).then(() => {
        alert('Password berhasil disalin ke clipboard!');
      }).catch(err => {
        console.error('Error copying password:', err);
      });
    }

    // Close modals on outside click
    window.onclick = function (event) {
      const modals = ['addUserModal', 'editUserModal', 'passwordResetModal'];
      modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
          modal.classList.add('hidden');
        }
      });
    }
  </script>
@endsection