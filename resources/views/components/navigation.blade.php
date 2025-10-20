<!-- Header Navigation -->
<nav class="bg-rshp-blue text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left side - Logo and Main navigation -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white hover:text-rshp-yellow transition-colors">
                        RSHP UNAIR
                    </a>
                </div>
                
                <!-- Main Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('home') ? 'text-rshp-yellow' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('layanan') }}" 
                       class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('layanan') ? 'text-rshp-yellow' : '' }}">
                        Layanan
                    </a>
                    <a href="{{ route('kontak') }}" 
                       class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('kontak') ? 'text-rshp-yellow' : '' }}">
                        Kontak
                    </a>
                    <a href="{{ route('struktur-organisasi') }}" 
                       class="text-white hover:text-rshp-yellow transition-colors {{ request()->routeIs('struktur-organisasi') ? 'text-rshp-yellow' : '' }}">
                        Struktur Organisasi
                    </a>
                </div>
            </div>            <!-- Right side - Auth buttons -->
            <div class="hidden md:flex items-center space-x-4">
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

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" 
                        class="text-white hover:text-rshp-yellow focus:outline-none focus:text-rshp-yellow"
                        aria-controls="mobile-menu" 
                        aria-expanded="false"
                        onclick="toggleMobileMenu()">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" 
                   class="block text-white hover:text-rshp-yellow px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-rshp-yellow' : '' }}">
                    Home
                </a>
                <a href="{{ route('layanan') }}" 
                   class="block text-white hover:text-rshp-yellow px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('layanan') ? 'text-rshp-yellow' : '' }}">
                    Layanan
                </a>
                <a href="{{ route('kontak') }}" 
                   class="block text-white hover:text-rshp-yellow px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('kontak') ? 'text-rshp-yellow' : '' }}">
                    Kontak
                </a>
                <a href="{{ route('struktur-organisasi') }}" 
                   class="block text-white hover:text-rshp-yellow px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('struktur-organisasi') ? 'text-rshp-yellow' : '' }}">
                    Struktur Organisasi
                </a>                <div class="border-t border-rshp-light-blue pt-4">
                    @auth
                        <div class="px-3 py-2">
                            <span class="text-white text-sm">Halo, {{ Auth::user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left bg-red-600 text-white hover:bg-red-700 px-3 py-2 rounded-md text-base font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block text-white hover:text-rshp-yellow px-3 py-2 rounded-md text-base font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block bg-rshp-orange text-white hover:bg-orange-600 px-3 py-2 rounded-md text-base font-medium mt-2">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}
</script>
