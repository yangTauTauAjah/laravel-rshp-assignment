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