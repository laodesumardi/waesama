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
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div id="sidebar" class="admin-sidebar text-white w-64 min-h-screen flex flex-col lg:relative lg:translate-x-0 fixed -translate-x-full z-50">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16" style="background-color: #002347;">
                    <h1 class="text-xl font-bold">Admin Panel</h1>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('dashboard') ? 'active text-white' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Data Penduduk -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.citizens.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.citizens.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        <span>Data Penduduk</span>
                    </a>
                    @endif

                    <!-- Service Requests -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.service-requests.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.service-requests.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        <span>Layanan Surat</span>
                    </a>
                    @endif

                    <!-- Documents -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.documents.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.documents.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-folder w-5 h-5 mr-3"></i>
                        <span>Dokumen</span>
                    </a>
                    @endif

                    <!-- News Management -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.news.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.news.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                        <span>Berita</span>
                    </a>
                    @endif

                    <!-- Gallery Management -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.galleries.index') }}"
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.galleries.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-images w-5 h-5 mr-3"></i>
                        <span>Galeri</span>
                    </a>
                    @endif

                    <!-- User Management -->
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.users*') ? 'active text-white' : '' }}">
                        <i class="fas fa-user-cog w-5 h-5 mr-3"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                    @endif

                    <!-- Activity Logs -->
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.activity-logs') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.activity-logs') ? 'active text-white' : '' }}">
                        <i class="fas fa-history w-5 h-5 mr-3"></i>
                        <span>Log Aktivitas</span>
                    </a>
                    @endif

                    <!-- Divider -->
                    <div class="border-t border-gray-600 my-4"></div>

                    <!-- Profile Menu -->
                    <a href="{{ route('profile.edit') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('profile.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-user-edit w-5 h-5 mr-3"></i>
                        <span>Profil Saya</span>
                    </a>
                </nav>


            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="admin-header shadow-sm border-b border-gray-200">
                    <div class="flex items-center justify-between px-6 py-4">
                        <!-- Mobile menu button -->
                        <button id="sidebar-toggle" class="admin-mobile-menu-btn lg:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <!-- Page Title -->
                        @isset($header)
                            <div class="flex-1">
                                <h1 class="text-2xl font-semibold" style="color: white;">{{ $header }}</h1>
                            </div>
                        @endisset

                        <!-- Notification & Logout -->
                        <div class="flex items-center space-x-3">
                            <button class="p-2 rounded-lg text-white hover:bg-white/10 transition-colors">
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
                <main class="admin-content flex-1 overflow-x-hidden overflow-y-auto p-6">
                    <div class="fade-in">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>



        <script>
            // Enhanced Sidebar Management
            class SidebarManager {
                constructor() {
                    this.sidebar = document.getElementById('sidebar');
                    this.overlay = document.getElementById('sidebar-overlay');
                    this.toggleBtn = document.getElementById('sidebar-toggle');
                    this.isOpen = false;
                    this.init();
                }

                init() {
                    this.setupEventListeners();
                    this.handleResize();
                    window.addEventListener('resize', () => this.handleResize());
                }

                setupEventListeners() {
                    // Toggle sidebar on button click
                    this.toggleBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.toggle();
                    });

                    // Close sidebar when clicking overlay
                    this.overlay.addEventListener('click', () => {
                        this.close();
                    });

                    // Close sidebar on escape key
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && this.isOpen) {
                            this.close();
                        }
                    });

                    // Prevent sidebar from closing when clicking inside it
                    this.sidebar.addEventListener('click', (e) => {
                        e.stopPropagation();
                    });
                }

                toggle() {
                    if (this.isOpen) {
                        this.close();
                    } else {
                        this.open();
                    }
                }

                open() {
                    if (window.innerWidth < 1024) {
                        // Add smooth opening animation
                        this.sidebar.classList.add('open');
                        this.sidebar.classList.remove('-translate-x-full');
                        this.overlay.classList.remove('hidden');
                        this.overlay.classList.add('show');
                        this.overlay.classList.remove('hide');
                        
                        // Prevent body scroll with smooth transition
                        document.body.style.overflow = 'hidden';
                        document.body.style.transition = 'all 0.3s ease';
                        
                        // Add focus trap for accessibility
                        this.trapFocus();
                        
                        this.isOpen = true;
                    }
                }

                close() {
                    // Add smooth closing animation
                    this.sidebar.classList.remove('open');
                    this.sidebar.classList.add('-translate-x-full');
                    this.overlay.classList.add('hide');
                    this.overlay.classList.remove('show');
                    
                    // Delay hiding overlay to allow animation
                    setTimeout(() => {
                        this.overlay.classList.add('hidden');
                    }, 300);
                    
                    // Restore body scroll
                    document.body.style.overflow = '';
                    document.body.style.transition = '';
                    
                    // Remove focus trap
                    this.removeFocusTrap();
                    
                    this.isOpen = false;
                }
                
                trapFocus() {
                    const focusableElements = this.sidebar.querySelectorAll(
                        'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
                    );
                    const firstElement = focusableElements[0];
                    const lastElement = focusableElements[focusableElements.length - 1];
                    
                    this.sidebar.addEventListener('keydown', this.handleTabKey = (e) => {
                        if (e.key === 'Tab') {
                            if (e.shiftKey) {
                                if (document.activeElement === firstElement) {
                                    lastElement.focus();
                                    e.preventDefault();
                                }
                            } else {
                                if (document.activeElement === lastElement) {
                                    firstElement.focus();
                                    e.preventDefault();
                                }
                            }
                        }
                    });
                    
                    if (firstElement) firstElement.focus();
                }
                
                removeFocusTrap() {
                    if (this.handleTabKey) {
                        this.sidebar.removeEventListener('keydown', this.handleTabKey);
                    }
                }

                handleResize() {
                    if (window.innerWidth >= 1024) {
                        // Desktop: Always show sidebar
                        this.sidebar.classList.remove('-translate-x-full', 'open');
                        this.overlay.classList.add('hidden');
                        document.body.style.overflow = '';
                        this.isOpen = false;
                    } else {
                        // Mobile/Tablet: Hide sidebar by default
                        if (!this.isOpen) {
                            this.sidebar.classList.add('-translate-x-full');
                            this.sidebar.classList.remove('open');
                            this.overlay.classList.add('hidden');
                        }
                    }
                }
            }

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                new SidebarManager();
            });
        </script>
    </body>
</html>