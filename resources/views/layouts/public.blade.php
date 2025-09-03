<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('welcome') }}" class="text-xl font-bold" style="color: #001d3d;">Sistem Manajemen Kantor Camat</a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="nav-link smooth-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('news.index') }}" class="nav-link smooth-link {{ request()->routeIs('news.*') ? 'active' : '' }}">Berita</a>
                    <a href="{{ route('gallery.index') }}" class="nav-link smooth-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}">Galeri</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary btn-ripple smooth-link">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary btn-ripple smooth-link">Login</a>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-btn" id="mobile-menu-btn">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="{{ route('welcome') }}" class="mobile-nav-link smooth-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Home</a>
                <a href="{{ route('news.index') }}" class="mobile-nav-link smooth-link {{ request()->routeIs('news.*') ? 'active' : '' }}">Berita</a>
                <a href="{{ route('gallery.index') }}" class="mobile-nav-link smooth-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}">Galeri</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="mobile-nav-link smooth-link">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link smooth-link">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="page-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4" style="color: #001d3d;">Kantor Camat</h3>
                    <p class="text-gray-600">Melayani masyarakat dengan profesional dan transparan untuk kemajuan daerah.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4" style="color: #001d3d;">Menu</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('welcome') }}" class="text-gray-600 hover:text-gray-900 smooth-link">Home</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-gray-600 hover:text-gray-900 smooth-link">Berita</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="text-gray-600 hover:text-gray-900 smooth-link">Galeri</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4" style="color: #001d3d;">Kontak</h3>
                    <p class="text-gray-600">Alamat: Jl. Contoh No. 123</p>
                    <p class="text-gray-600">Telepon: (021) 123-4567</p>
                    <p class="text-gray-600">Email: info@camat.go.id</p>
                </div>
            </div>
            <div class="border-t mt-8 pt-8 text-center">
                <p class="text-gray-600">&copy; {{ date('Y') }} Sistem Manajemen Kantor Camat. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>