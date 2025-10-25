@extends('layouts.app')

@section('content')  <!-- Page Header -->  <x-admin-header title="Manajemen Tindakan Terapi" subtitle="Kelola Kategori, Kategori Klinis, dan Kode Tindakan Terapi"
    :backRoute="route('admin.dashboard')" backText="Kembali ke Dashboard">

    @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
    <x-slot:actionButton>
      <button onclick="openAddKodeTindakanModal()"
        class="bg-rshp-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kode Tindakan
      </button>
    </x-slot:actionButton>
    @endif
  </x-admin-header>

  <div class="mx-auto my-6 max-w-7xl w-full flex-1">


    <!-- Kode Tindakan Terapi Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
      <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-rshp-dark-gray">Daftar Kode Tindakan Terapi</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori Klinis
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($kodeTindakanTerapis as $index => $kodeTindakan)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-rshp-blue text-white">
                    {{ $kodeTindakan->kode }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $kodeTindakan->deskripsi_tindakan_terapi }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $kodeTindakan->kategori->nama_kategori ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $kodeTindakan->kategoriKlinis->nama_kategori_klinis ?? '-' }}
                </td>                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                  <button onclick="editKodeTindakan({{ $kodeTindakan->idkode_tindakan_terapi }})"
                    class="text-yellow-600 hover:text-yellow-900 mr-3">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                      </path>
                    </svg>
                  </button>
                  @endif
                  @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                  <form action="{{ route('admin.kode-tindakan.destroy', $kodeTindakan->idkode_tindakan_terapi) }}"
                    method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kode tindakan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900">
                      <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                      </svg>
                    </button>
                  </form>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                  Belum ada kode tindakan terapi
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <!-- Three Column Layout for Categories -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Kategori Section -->      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-rshp-blue text-white flex justify-between items-center">
          <h2 class="text-lg font-semibold">Kategori</h2>
          @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
          <button onclick="openAddKategoriModal()"
            class="bg-white text-rshp-blue px-3 py-1 rounded hover:bg-gray-100 transition-colors text-sm font-medium">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah
          </button>
          @endif
        </div>
        <div class="p-4">
          @forelse($kategoris as $kategori)            <div
              class="flex justify-between items-center p-3 mb-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
              <span class="text-gray-700 font-medium">{{ $kategori->nama_kategori }}</span>
              <div class="flex space-x-2">
                @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                <button
                  onclick="openEditKategoriModal({{ $kategori->idkategori }}, '{{ addslashes($kategori->nama_kategori) }}')"
                  class="text-yellow-600 hover:text-yellow-700">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                  </svg>
                </button>
                @endif
                @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                <form action="{{ route('admin.kategori.destroy', $kategori->idkategori) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                      </path>
                    </svg>
                  </button>
                </form>
                @endif
              </div>
            </div>
          @empty
            <div class="text-center py-8 text-gray-500">
              <p>Belum ada kategori</p>
            </div>
          @endforelse
        </div>
      </div>

      <!-- Kategori Klinis Section -->      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-rshp-green text-white flex justify-between items-center">
          <h2 class="text-lg font-semibold">Kategori Klinis</h2>
          @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
          <button onclick="openAddKategoriKlinisModal()"
            class="bg-white text-rshp-green px-3 py-1 rounded hover:bg-gray-100 transition-colors text-sm font-medium">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah
          </button>
          @endif
        </div>
        <div class="p-4">
          @forelse($kategoriKlinises as $kategoriKlinis)
            <div
              class="flex justify-between items-center p-3 mb-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">              <span class="text-gray-700 font-medium">{{ $kategoriKlinis->nama_kategori_klinis }}</span>
              <div class="flex space-x-2">
                @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                <button
                  onclick="openEditKategoriKlinisModal({{ $kategoriKlinis->idkategori_klinis }}, '{{ addslashes($kategoriKlinis->nama_kategori_klinis) }}')"
                  class="text-yellow-600 hover:text-yellow-700">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                  </svg>
                </button>
                @endif
                @if(Auth::user()->isAdministrator() || Auth::user()->isResepsionis())
                <form action="{{ route('admin.kategori-klinis.destroy', $kategoriKlinis->idkategori_klinis) }}"
                  method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori klinis ini?')" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                      </path>
                    </svg>
                  </button>
                </form>
                @endif
              </div>
            </div>
          @empty
            <div class="text-center py-8 text-gray-500">
              <p>Belum ada kategori klinis</p>
            </div>
          @endforelse
        </div>
      </div>

      <!-- Info Card -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-100 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-700">Informasi</h2>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div class="flex items-start">
              <svg class="w-6 h-6 text-rshp-blue mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div>
                <p class="text-sm text-gray-700 font-medium">Kelola Kategori & Kategori Klinis</p>
                <p class="text-xs text-gray-500 mt-1">Gunakan tombol di kartu sebelah untuk menambah kategori atau
                  kategori klinis.</p>
              </div>
            </div>
            <div class="flex items-start">
              <svg class="w-6 h-6 text-rshp-green mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
              </svg>
              <div>
                <p class="text-sm text-gray-700 font-medium">Kode Tindakan Terapi</p>
                <p class="text-xs text-gray-500 mt-1">Gunakan tombol di atas atau di bawah tabel untuk menambah kode
                  tindakan terapi.</p>
              </div>
            </div>
            <div class="flex items-start">
              <svg class="w-6 h-6 text-yellow-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                </path>
              </svg>
              <div>
                <p class="text-sm text-gray-700 font-medium">Peringatan</p>
                <p class="text-xs text-gray-500 mt-1">Kategori yang memiliki kode tindakan tidak dapat dihapus.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Kategori Modal -->
  <div id="addKategoriModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori</h3>
        <button onclick="closeAddKategoriModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.kategori.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
          <input type="text" name="nama_kategori" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeAddKategoriModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-blue text-white rounded hover:bg-blue-700 transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Kategori Modal -->
  <div id="editKategoriModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Edit Kategori</h3>
        <button onclick="closeEditKategoriModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form id="editKategoriForm" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
          <input type="text" name="nama_kategori" id="edit_kategori_nama" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeEditKategoriModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-blue text-white rounded hover:bg-blue-700 transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Add Kategori Klinis Modal -->
  <div id="addKategoriKlinisModal"
    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori Klinis</h3>
        <button onclick="closeAddKategoriKlinisModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.kategori-klinis.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori Klinis</label>
          <input type="text" name="nama_kategori_klinis" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-green">
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeAddKategoriKlinisModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-green text-white rounded hover:bg-green-700 transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Kategori Klinis Modal -->
  <div id="editKategoriKlinisModal"
    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Edit Kategori Klinis</h3>
        <button onclick="closeEditKategoriKlinisModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form id="editKategoriKlinisForm" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori Klinis</label>
          <input type="text" name="nama_kategori_klinis" id="edit_kategori_klinis_nama" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-green">
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeEditKategoriKlinisModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-green text-white rounded hover:bg-green-700 transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Add Kode Tindakan Modal -->
  <div id="addKodeTindakanModal"
    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Tambah Kode Tindakan Terapi</h3>
        <button onclick="closeAddKodeTindakanModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.kode-tindakan.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Kode</label>
            <input type="text" name="kode" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <select name="idkategori" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
              <option value="">Pilih Kategori</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->idkategori }}">{{ $kategori->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Klinis</label>
          <select name="idkategori_klinis" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
            <option value="">Pilih Kategori Klinis</option>
            @foreach($kategoriKlinises as $kategoriKlinis)
              <option value="{{ $kategoriKlinis->idkategori_klinis }}">{{ $kategoriKlinis->nama_kategori_klinis }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Tindakan Terapi</label>
          <textarea name="deskripsi_tindakan_terapi" rows="3" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue"></textarea>
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeAddKodeTindakanModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-blue text-white rounded hover:bg-blue-700 transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Kode Tindakan Modal -->
  <div id="editKodeTindakanModal"
    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Edit Kode Tindakan Terapi</h3>
        <button onclick="closeEditKodeTindakanModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <form id="editKodeTindakanForm" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Kode</label>
            <input type="text" name="kode" id="edit_kode" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <select name="idkategori" id="edit_idkategori" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
              <option value="">Pilih Kategori</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->idkategori }}">{{ $kategori->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Klinis</label>
          <select name="idkategori_klinis" id="edit_idkategori_klinis" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue">
            <option value="">Pilih Kategori Klinis</option>
            @foreach($kategoriKlinises as $kategoriKlinis)
              <option value="{{ $kategoriKlinis->idkategori_klinis }}">{{ $kategoriKlinis->nama_kategori_klinis }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Tindakan Terapi</label>
          <textarea name="deskripsi_tindakan_terapi" id="edit_deskripsi" rows="3" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-rshp-blue"></textarea>
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="closeEditKodeTindakanModal()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-rshp-blue text-white rounded hover:bg-blue-700 transition-colors">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Kategori Modals
    function openAddKategoriModal() {
      document.getElementById('addKategoriModal').classList.remove('hidden');
    }

    function closeAddKategoriModal() {
      document.getElementById('addKategoriModal').classList.add('hidden');
    }

    function openEditKategoriModal(id, nama) {
      document.getElementById('edit_kategori_nama').value = nama;
      document.getElementById('editKategoriForm').action = `/admin/kategori/${id}`;
      document.getElementById('editKategoriModal').classList.remove('hidden');
    }

    function closeEditKategoriModal() {
      document.getElementById('editKategoriModal').classList.add('hidden');
    }

    // Kategori Klinis Modals
    function openAddKategoriKlinisModal() {
      document.getElementById('addKategoriKlinisModal').classList.remove('hidden');
    }

    function closeAddKategoriKlinisModal() {
      document.getElementById('addKategoriKlinisModal').classList.add('hidden');
    }

    function openEditKategoriKlinisModal(id, nama) {
      document.getElementById('edit_kategori_klinis_nama').value = nama;
      document.getElementById('editKategoriKlinisForm').action = `/admin/kategori-klinis/${id}`;
      document.getElementById('editKategoriKlinisModal').classList.remove('hidden');
    }

    function closeEditKategoriKlinisModal() {
      document.getElementById('editKategoriKlinisModal').classList.add('hidden');
    }

    // Kode Tindakan Modals
    function openAddKodeTindakanModal() {
      document.getElementById('addKodeTindakanModal').classList.remove('hidden');
    }

    function closeAddKodeTindakanModal() {
      document.getElementById('addKodeTindakanModal').classList.add('hidden');
    }

    function editKodeTindakan(id) {
      fetch(`/admin/kode-tindakan/${id}/edit`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('edit_kode').value = data.kode;
          document.getElementById('edit_deskripsi').value = data.deskripsi_tindakan_terapi;
          document.getElementById('edit_idkategori').value = data.idkategori;
          document.getElementById('edit_idkategori_klinis').value = data.idkategori_klinis;
          document.getElementById('editKodeTindakanForm').action = `/admin/kode-tindakan/${id}`;
          document.getElementById('editKodeTindakanModal').classList.remove('hidden');
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Gagal memuat data');
        });
    }

    function closeEditKodeTindakanModal() {
      document.getElementById('editKodeTindakanModal').classList.add('hidden');
    }

    // Close modals on outside click
    window.onclick = function (event) {
      const modals = [
        'addKategoriModal', 'editKategoriModal',
        'addKategoriKlinisModal', 'editKategoriKlinisModal',
        'addKodeTindakanModal', 'editKodeTindakanModal'
      ];

      modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
          modal.classList.add('hidden');
        }
      });
    }
  </script>
@endsection