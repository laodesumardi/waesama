<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <!-- Sidebar Overlay -->
        <div id="sidebar-overlay" class="sidebar-overlay hidden lg:hidden"></div>
        
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div id="sidebar" class="admin-sidebar text-white w-64 min-h-screen flex flex-col lg:relative lg:translate-x-0 fixed -translate-x-full z-50 transition-transform duration-300 ease-in-out">
                <!-- Logo - Sticky Header -->
                <div class="flex items-center justify-center h-16 sticky top-0 z-10" style="background-color: #002347;">
                    <h1 class="text-xl font-bold">Admin Panel</h1>
                </div>

                <!-- Navigation Menu - Scrollable -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-800">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <!-- Data Penduduk -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.citizens.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.citizens.*') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        <span class="font-medium">Data Penduduk</span>
                    </a>
                    @endif

                    <!-- Service Requests -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.service-requests.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.service-requests.*') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        <span class="font-medium">Layanan Surat</span>
                    </a>
                    @endif



                    <!-- News Management -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.news.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.news.*') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                        <span class="font-medium">Berita</span>
                    </a>
                    @endif

                    <!-- Gallery Management -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.galleries.index') }}"
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.galleries.*') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-images w-5 h-5 mr-3"></i>
                        <span class="font-medium">Galeri</span>
                    </a>
                    @endif

                    <!-- User Management -->
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-user-cog w-5 h-5 mr-3"></i>
                        <span class="font-medium">Manajemen Pengguna</span>
                    </a>
                    @endif

                    <!-- Activity Logs -->
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.activity-logs') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('admin.activity-logs') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-history w-5 h-5 mr-3"></i>
                        <span class="font-medium">Log Aktivitas</span>
                    </a>
                    @endif

                    <!-- Divider -->
                    <div class="border-t border-gray-600 my-4"></div>

                    <!-- Profile Menu -->
                    <a href="{{ route('profile.edit') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white rounded-lg transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-white/20 border-r-4 border-white text-white' : '' }}">
                        <i class="fas fa-user-edit w-5 h-5 mr-3"></i>
                        <span class="font-medium">Profil Saya</span>
                    </a>
                </nav>


            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
                <!-- Top Header -->
                <header class="admin-header shadow-sm border-b border-gray-200 relative z-30">
                    <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                        <!-- Mobile menu button -->
                        <button id="sidebar-toggle" class="admin-mobile-menu-btn lg:hidden p-2 rounded-lg">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <!-- Page Title -->
                        @isset($header)
                            <div class="flex-1 ml-4 lg:ml-0">
                                <h1 class="text-xl lg:text-2xl font-semibold" style="color: white;">{{ $header }}</h1>
                            </div>
                        @endisset

                        <!-- Notification & Logout -->
                        <div class="flex items-center space-x-2 lg:space-x-3">
                            <button class="p-2 rounded-lg text-white hover:bg-white/10 transition-colors hidden sm:block">
                                <i class="fas fa-bell text-lg"></i>
                            </button>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="p-2 rounded-lg text-white hover:bg-red-500/20 transition-colors" title="Logout">
                                    <i class="fas fa-sign-out-alt text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="admin-content flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-6">
                    <div class="fade-in">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>



        <script>
            class SidebarManager {
                constructor() {
                    this.sidebar = document.getElementById('sidebar');
                    this.overlay = document.getElementById('sidebar-overlay');
                    this.toggleBtn = document.getElementById('sidebar-toggle');
                    this.isOpen = false;
                    
                    this.init();
                }
                
                init() {
                    this.toggleBtn?.addEventListener('click', () => this.toggle());
                    this.overlay?.addEventListener('click', () => this.close());
                    window.addEventListener('resize', () => this.handleResize());
                    
                    // Handle escape key
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && this.isOpen && window.innerWidth < 1024) {
                            this.close();
                        }
                    });
                }
                
                toggle() {
                    this.isOpen ? this.close() : this.open();
                }
                
                open() {
                    this.sidebar.classList.remove('-translate-x-full');
                    this.sidebar.classList.add('open');
                    this.overlay.classList.remove('hidden');
                    this.overlay.classList.add('show');
                    this.isOpen = true;
                    
                    // Prevent body scroll
                    document.body.style.overflow = 'hidden';
                    
                    // Focus trap for accessibility
                    this.trapFocus();
                }
                
                close() {
                    this.sidebar.classList.add('-translate-x-full');
                    this.sidebar.classList.remove('open');
                    this.overlay.classList.remove('show');
                    this.overlay.classList.add('hide');
                    
                    // Restore body scroll
                    document.body.style.overflow = '';
                    
                    setTimeout(() => {
                        this.overlay.classList.add('hidden');
                        this.overlay.classList.remove('hide');
                    }, 300);
                    
                    this.isOpen = false;
                }
                
                handleResize() {
                    if (window.innerWidth >= 1024) {
                        this.sidebar.classList.remove('-translate-x-full', 'open');
                        this.overlay.classList.add('hidden');
                        this.overlay.classList.remove('show', 'hide');
                        document.body.style.overflow = '';
                        this.isOpen = false;
                    } else if (!this.isOpen) {
                        this.sidebar.classList.add('-translate-x-full');
                    }
                }
                
                trapFocus() {
                    const focusableElements = this.sidebar.querySelectorAll(
                        'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
                    );
                    const firstElement = focusableElements[0];
                    const lastElement = focusableElements[focusableElements.length - 1];
                    
                    firstElement?.focus();
                    
                    const handleTabKey = (e) => {
                        if (e.key === 'Tab') {
                            if (e.shiftKey) {
                                if (document.activeElement === firstElement) {
                                    lastElement?.focus();
                                    e.preventDefault();
                                }
                            } else {
                                if (document.activeElement === lastElement) {
                                    firstElement?.focus();
                                    e.preventDefault();
                                }
                            }
                        }
                    };
                    
                    this.sidebar.addEventListener('keydown', handleTabKey);
                }
            }
            
            // Initialize sidebar manager when DOM is loaded
            document.addEventListener('DOMContentLoaded', () => {
                new SidebarManager();
            });
        </script>
    </body>
</html>