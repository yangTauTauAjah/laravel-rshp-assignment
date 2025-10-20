<!-- Header Navigation -->
<nav class="bg-rshp-blue text-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center h-16">
            <!-- Left side - Main navigation -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('home') ? 'text-rshp-yellow' : '' }}">Home</a>
                <a href="{{ route('layanan') }}" class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('layanan') ? 'text-rshp-yellow' : '' }}">Layanan</a>
                <a href="{{ route('kontak') }}" class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('kontak') ? 'text-rshp-yellow' : '' }}">Kontak</a>
                <a href="{{ route('struktur-organisasi') }}" class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('struktur-organisasi') ? 'text-rshp-yellow' : '' }}">Struktur Organisasi</a>
                
                @auth
                    <!-- Admin Dashboard link for authenticated users -->
                    <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('admin.*') ? 'text-rshp-yellow font-bold' : '' }}">
                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Admin Dashboard
                    </a>
                @endauth
            </div>

            <!-- Right side - Auth buttons -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Logged in user -->
                    <div class="flex items-center space-x-3">
                        <span class="text-white text-sm">
                            Halo, {{ Auth::user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-red-600 text-white hover:bg-red-700 transition-colors px-4 py-2 rounded-md text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Not logged in -->
                    <a href="{{ route('login') }}" 
                       class="text-white hover:text-rshp-yellow transition-colors px-3 py-2 rounded-md text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-rshp-orange text-white hover:bg-orange-600 transition-colors px-4 py-2 rounded-md text-sm font-medium">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>