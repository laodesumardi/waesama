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
                    <a href="{{ route('admin.gallery.index') }}" 
                       class="admin-nav-item flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.gallery.*') ? 'active text-white' : '' }}">
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

                        <!-- Profile Dropdown -->
                         <div class="relative">
                             <button id="profile-dropdown" class="admin-profile-btn flex items-center hover:text-white p-2 rounded-lg transition-colors duration-200">
                                 <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background-color: #004080;">
                                     <i class="fas fa-user text-sm"></i>
                                 </div>
                                 <div class="text-left mr-2">
                                     <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                                     <div class="text-xs opacity-75">{{ ucfirst(Auth::user()->role) }}</div>
                                 </div>
                                 <i class="fas fa-chevron-down text-sm"></i>
                             </button>
                             
                             <div id="profile-menu" class="admin-dropdown hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-2 z-50">
                                 <!-- User Info Header -->
                                 <div class="px-4 py-3 border-b border-gray-200">
                                     <div class="flex items-center">
                                         <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #003566;">
                                             <i class="fas fa-user text-white"></i>
                                         </div>
                                         <div>
                                             <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                             <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                             <div class="text-xs text-gray-400">{{ ucfirst(Auth::user()->role) }}</div>
                                         </div>
                                     </div>
                                 </div>
                                 
                                 <!-- Menu Items -->
                                 <div class="py-1">
                                     <a href="{{ route('profile.edit') }}" class="admin-dropdown-item flex items-center px-4 py-2 text-sm hover:text-white" style="color: #003566;" onmouseover="this.style.backgroundColor='#004080'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#003566'">
                                         <i class="fas fa-user-edit w-4 h-4 mr-3"></i>
                                         <span>Edit Profile</span>
                                     </a>
                                     
                                     <div class="border-t border-gray-200 my-1"></div>
                                     
                                     <form method="POST" action="{{ route('logout') }}">
                                         @csrf
                                         <button type="submit" class="admin-dropdown-item flex items-center w-full text-left px-4 py-2 text-sm hover:text-white" style="color: #dc2626;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626'">
                                             <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                                             <span>Logout</span>
                                         </button>
                                     </form>
                                 </div>
                             </div>
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
                        this.sidebar.classList.add('open');
                        this.sidebar.classList.remove('-translate-x-full');
                        this.overlay.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        this.isOpen = true;
                    }
                }

                close() {
                    this.sidebar.classList.remove('open');
                    this.sidebar.classList.add('-translate-x-full');
                    this.overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                    this.isOpen = false;
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

            // Profile dropdown management
            function initProfileDropdown() {
                const dropdown = document.getElementById('profile-dropdown');
                const menu = document.getElementById('profile-menu');

                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!dropdown.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                new SidebarManager();
                initProfileDropdown();
            });
        </script>
    </body>
</html>