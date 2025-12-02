@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <x-admin-header title="Multi-Role Profiles" subtitle="Kelola pengguna dengan multiple role"
        :backRoute="route('data.dashboard')" backText="Kembali ke Dashboard" />

    <div class="mx-auto my-6 max-w-7xl w-full flex-1">
        <!-- Info Card -->
        {{-- <div class="mb-6 p-6 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-medium text-blue-800 mb-2">Multi-Role Profile Management</h3>
                    <p class="text-blue-700">
                        Halaman ini menampilkan users yang memiliki lebih dari satu role (misalnya: seorang user yang sekaligus Dokter dan Administrator).
                        Klik "Lihat Profile" untuk melihat semua profile role dalam tampilan tab.
                    </p>
                </div>
            </div>
        </div> --}}

        <!-- Users List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if($usersWithMultipleRoles->isEmpty())
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 119.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Multi-Role Users</h3>
                <p class="text-gray-600">Belum ada user yang memiliki lebih dari satu role.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Roles
                            </th>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th> --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($usersWithMultipleRoles as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-medium text-sm">
                                        {{ strtoupper(substr($user->nama, 0, 2)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-rshp-dark-gray">{{ $user->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach(explode(',', $user->roles) as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($role == 'Administrator') bg-purple-100 text-purple-800
                                            @elseif($role == 'Dokter') bg-green-100 text-green-800
                                            @elseif($role == 'Perawat') bg-blue-100 text-blue-800
                                            @elseif($role == 'Resepsionis') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $role }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $user->role_count }} roles</div>
                            </td>
                            {{--                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- User table doesn't have status column, so we'll show as active by default -->
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Aktif
                                </span>
                            </td>--}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('data.profiles.show', $user->iduser) }}"
                                    class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Lihat Profile
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Statistics Cards -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Multi-Role Users</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $usersWithMultipleRoles->count() }}</p>
                    </div>
                    <div class="h-12 w-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 119.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Multi-Role</p>
                                <p class="text-2xl font-bold text-green-600">{{ $usersWithMultipleRoles->count() }}</p>
                            </div>
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Max Roles per User</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $usersWithMultipleRoles->max('role_count') ?? 0 }}</p>
                    </div>
                    <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
