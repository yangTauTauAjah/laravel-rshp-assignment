@extends('layouts.app')

@section('content')
  <!-- Page Header -->
  <x-admin-header title="Kelola Peran Pengguna" subtitle="Manajemen peran dan hak akses pengguna sistem RSHP"
    :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard" />

  <div class="mx-auto my-6 max-w-7xl w-full flex-1">

    <!-- Users and Roles Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Pengguna dan Peran</h2>
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
                Peran
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
                    @if ($user->iduser == auth()->user()->iduser)
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
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  @if ($user->roleUsers->count() > 0)
                    <div class="flex flex-wrap gap-1">
                      @foreach ($user->roleUsers as $roleUser)
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleUser->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                          {{ $roleUser->role->nama_role }}
                          @if (!$roleUser->status)
                            <span class="ml-1 text-xs opacity-75">(Nonaktif)</span>
                          @endif
                        </span>
                      @endforeach
                    </div>
                  @else
                    <span class="text-gray-400">Tidak ada peran</span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex items-center space-x-2">
                    <button onclick="manageUserRoles({{ $user->iduser }})"
                      class="bg-rshp-green text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-green-700 transition-colors">
                      Kelola Peran
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                  Tidak ada data pengguna
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Role Descriptions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-8">
      <h2 class="text-lg font-semibold text-rshp-dark-gray mb-4">Deskripsi Peran</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="font-medium text-rshp-blue mb-2">Administrator</h3>
          <p class="text-sm text-gray-600">Akses penuh ke semua fitur sistem, termasuk manajemen pengguna dan
            peran.</p>
        </div>
        <div>
          <h3 class="font-medium text-rshp-blue mb-2">Dokter</h3>
          <p class="text-sm text-gray-600">Pemeriksaan pasien, rekam medis, jadwal praktik, dan resep obat.</p>
        </div>
        <div>
          <h3 class="font-medium text-rshp-blue mb-2">Perawat</h3>
          <p class="text-sm text-gray-600">Asistensi dokter, perawatan pasien, monitoring vital signs, dan
            persiapan alat.</p>
        </div>
        <div>
          <h3 class="font-medium text-rshp-blue mb-2">Resepsionis</h3>
          <p class="text-sm text-gray-600">Pendaftaran pasien, jadwal kunjungan, pembayaran, dan informasi pasien.
          </p>
        </div>
      </div>
    </div>

  </div>

  <!-- Role Management Modal -->
  <div id="roleManagementModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white mb-10">
      <div class="mt-3">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-semibold text-rshp-dark-gray">Kelola Peran Pengguna</h3>
          <button onclick="closeRoleModal()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
              </path>
            </svg>
          </button>
        </div>

        <!-- User Information -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-600">Nama</p>
              <p class="font-medium text-rshp-dark-gray" id="modalUserName"></p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Email</p>
              <p class="font-medium text-rshp-dark-gray" id="modalUserEmail"></p>
            </div>
          </div>
        </div>

        <!-- Current Roles -->
        <div class="mb-6">
          <h4 class="text-lg font-semibold text-rshp-dark-gray mb-3">Peran Saat Ini</h4>
          <div id="currentRolesContainer" class="space-y-2">
            <!-- Roles will be populated here -->
          </div>
        </div>

        <!-- Add New Role -->
        <div class="mb-6">
          <h4 class="text-lg font-semibold text-rshp-dark-gray mb-3">Tambah Peran Baru</h4>
          <form id="addRoleForm" onsubmit="addRole(event)" class="flex items-center space-x-4">
            @csrf
            <input type="hidden" name="user_id" id="modalUserId">

            <select name="role_id" id="newRoleSelect" required
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rshp-blue">
              <option value="">Pilih peran...</option>
              @foreach ($allRoles as $role)
                <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
              @endforeach
            </select>

            <button type="submit"
              class="bg-rshp-green text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
              Tambah Peran
            </button>
          </form>
        </div>

        <!-- Role Descriptions -->
        <div class="bg-gray-50 rounded-lg p-4">
          <h4 class="text-lg font-semibold text-rshp-dark-gray mb-3">Deskripsi Peran</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
              <h5 class="font-medium text-rshp-blue mb-1">Administrator</h5>
              <p class="text-gray-600">Akses penuh ke semua fitur sistem, termasuk manajemen pengguna dan
                peran.</p>
            </div>
            <div>
              <h5 class="font-medium text-rshp-blue mb-1">Dokter</h5>
              <p class="text-gray-600">Pemeriksaan pasien, rekam medis, jadwal praktik, dan resep obat.</p>
            </div>
            <div>
              <h5 class="font-medium text-rshp-blue mb-1">Perawat</h5>
              <p class="text-gray-600">Asistensi dokter, perawatan pasien, monitoring vital signs, dan
                persiapan alat.</p>
            </div>
            <div>
              <h5 class="font-medium text-rshp-blue mb-1">Resepsionis</h5>
              <p class="text-gray-600">Pendaftaran pasien, jadwal kunjungan, pembayaran, dan informasi pasien.
              </p>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end mt-6">
          <button onclick="closeRoleModal()"
            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let currentUserId = null;
    let currentUserRoles = [];

    // Open modal and fetch user roles
    async function manageUserRoles(userId) {
      currentUserId = userId;

      try {
        const response = await fetch(`/admin/roles/user/${userId}`);
        const data = await response.json();

        // Populate user info
        document.getElementById('modalUserName').textContent = data.user.nama;
        document.getElementById('modalUserEmail').textContent = data.user.email;
        document.getElementById('modalUserId').value = data.user.iduser;

        // Store current roles
        currentUserRoles = data.roles;

        // Populate current roles
        displayCurrentRoles(data.roles);

        // Update available roles in select
        updateAvailableRoles(data.roles);

        // Show modal
        document.getElementById('roleManagementModal').classList.remove('hidden');
      } catch (error) {
        console.error('Error fetching user roles:', error);
        alert('Gagal memuat data peran pengguna');
      }
    }

    // Display current roles
    function displayCurrentRoles(roles) {
      const container = document.getElementById('currentRolesContainer');

      if (roles.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-sm">Pengguna belum memiliki peran</p>';
        return;
      }

      container.innerHTML = roles.map(role => `
                      <div class="flex items-center justify-between bg-white border border-gray-200 rounded-lg p-3">
                          <div class="flex items-center space-x-3">
                              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${role.status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                  ${role.nama_role}
                              </span>
                              <span class="text-sm ${role.status ? 'text-green-600' : 'text-red-600'}">
                                  ${role.status ? 'Aktif' : 'Nonaktif'}
                              </span>
                          </div>
                          <div class="flex items-center space-x-2">
                              <button onclick="toggleRoleStatus(${role.idrole_user})" 
                                  class="px-3 py-1 text-xs font-medium rounded-md ${role.status ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-blue-100 text-blue-800 hover:bg-blue-200'} transition-colors">
                                  ${role.status ? 'Nonaktifkan' : 'Aktifkan'}
                              </button>
                              <button onclick="removeRole(${role.idrole_user})" 
                                  class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors">
                                  Hapus
                              </button>
                          </div>
                      </div>
                  `).join('');
    }

    // Update available roles in select dropdown
    function updateAvailableRoles(currentRoles) {
      const select = document.getElementById('newRoleSelect');
      const currentRoleIds = currentRoles.filter(r => r.status).map(r => r.idrole);

      // Re-enable all options first
      Array.from(select.options).forEach(option => {
        if (option.value) {
          option.disabled = currentRoleIds.includes(parseInt(option.value));
        }
      });

      // Reset selection
      select.value = '';
    }

    // Add role to user
    async function addRole(event) {
      event.preventDefault();

      const formData = new FormData(event.target);

      try {
        const response = await fetch('{{ route('admin.roles.add') }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          },
          body: formData
        });

        if (response.ok) {
          window.location.reload();
        } else {
          const data = await response.json();
          alert(data.message || 'Gagal menambahkan peran');
        }
      } catch (error) {
        console.error('Error adding role:', error);
        alert('Terjadi kesalahan saat menambahkan peran');
      }
    }

    // Toggle role status
    async function toggleRoleStatus(roleUserId) {
      if (!confirm('Apakah Anda yakin ingin mengubah status peran ini?')) {
        return;
      }

      try {
        const response = await fetch(`/admin/roles/toggle/${roleUserId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          }
        });

        if (response.ok) {
          window.location.reload();
        } else {
          alert('Gagal mengubah status peran');
        }
      } catch (error) {
        console.error('Error toggling role:', error);
        alert('Terjadi kesalahan saat mengubah status peran');
      }
    }

    // Remove role from user
    async function removeRole(roleUserId) {
      if (!confirm('Apakah Anda yakin ingin menghapus peran ini?')) {
        return;
      }

      try {
        const response = await fetch(`/admin/roles/remove/${roleUserId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          }
        });

        if (response.ok) {
          window.location.reload();
        } else {
          const data = await response.json();
          alert(data.message || 'Gagal menghapus peran');
        }
      } catch (error) {
        console.error('Error removing role:', error);
        alert('Terjadi kesalahan saat menghapus peran');
      }
    }

    // Close modal
    function closeRoleModal() {
      document.getElementById('roleManagementModal').classList.add('hidden');
      currentUserId = null;
      currentUserRoles = [];
    }

    // Close modal on background click
    document.getElementById('roleManagementModal').addEventListener('click', function (e) {
      if (e.target === this) {
        closeRoleModal();
      }
    });
  </script>
@endsection