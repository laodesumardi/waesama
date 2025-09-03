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
            <div id="sidebar" class="text-white w-64 min-h-screen flex flex-col transition-all duration-300 ease-in-out" style="background-color: #003566;">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16" style="background-color: #002347;">
                    <h1 class="text-xl font-bold">Admin Panel</h1>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-white' : '' }}" 
                       style="{{ request()->routeIs('dashboard') ? 'background-color: #004080;' : '' }}" 
                       onmouseover="this.style.backgroundColor='#004080'" 
                       onmouseout="this.style.backgroundColor='{{ request()->routeIs('dashboard') ? '#004080' : 'transparent' }}'">
                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Data Penduduk -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.citizens.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.citizens.*') ? 'text-white' : '' }}" 
                       style="{{ request()->routeIs('admin.citizens.*') ? 'background-color: #004080;' : '' }}" 
                       onmouseover="this.style.backgroundColor='#004080'" 
                       onmouseout="this.style.backgroundColor='{{ request()->routeIs('admin.citizens.*') ? '#004080' : 'transparent' }}'">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        <span>Data Penduduk</span>
                    </a>
                    @endif

                    <!-- Service Requests -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.service-requests.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.service-requests.*') ? 'text-white' : '' }}" 
                       style="{{ request()->routeIs('admin.service-requests.*') ? 'background-color: #004080;' : '' }}" 
                       onmouseover="this.style.backgroundColor='#004080'" 
                       onmouseout="this.style.backgroundColor='{{ request()->routeIs('admin.service-requests.*') ? '#004080' : 'transparent' }}'">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        <span>Layanan Surat</span>
                    </a>
                    @endif

                    <!-- Documents -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pegawai')
                    <a href="{{ route('admin.documents.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.documents.*') ? 'text-white' : '' }}" 
                       style="{{ request()->routeIs('admin.documents.*') ? 'background-color: #004080;' : '' }}" 
                       onmouseover="this.style.backgroundColor='#004080'" 
                       onmouseout="this.style.backgroundColor='{{ request()->routeIs('admin.documents.*') ? '#004080' : 'transparent' }}'">
                        <i class="fas fa-folder w-5 h-5 mr-3"></i>
                        <span>Dokumen</span>
                    </a>
                    @endif

                    <!-- User Management -->
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.users*') ? 'text-white' : '' }}" 
                       style="{{ request()->routeIs('admin.users*') ? 'background-color: #004080;' : '' }}" 
                       onmouseover="this.style.backgroundColor='#004080'" 
                       onmouseout="this.style.backgroundColor='{{ request()->routeIs('admin.users*') ? '#004080' : 'transparent' }}'">
                        <i class="fas fa-user-cog w-5 h-5 mr-3"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                    @endif

                    <!-- Activity Logs -->
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.activity-logs') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.activity-logs') ? 'text-white' : '' }}" 
                       style="{{ request()->routeIs('admin.activity-logs') ? 'background-color: #004080;' : '' }}" 
                       onmouseover="this.style.backgroundColor='#004080'" 
                       onmouseout="this.style.backgroundColor='{{ request()->routeIs('admin.activity-logs') ? '#004080' : 'transparent' }}'">
                        <i class="fas fa-history w-5 h-5 mr-3"></i>
                        <span>Log Aktivitas</span>
                    </a>
                    @endif
                </nav>


            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white shadow-sm border-b" style="border-color: #e5e7eb; background-color: #003566;">
                    <div class="flex items-center justify-between px-6 py-4">
                        <!-- Mobile menu button -->
                        <button id="sidebar-toggle" class="lg:hidden hover:text-white" style="color: white;">
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
                             <button id="profile-dropdown" class="flex items-center hover:text-white p-2 rounded-lg transition-colors duration-200" style="color: white;">
                                 <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background-color: #004080;">
                                     <i class="fas fa-user text-sm"></i>
                                 </div>
                                 <div class="text-left mr-2">
                                     <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                                     <div class="text-xs opacity-75">{{ ucfirst(Auth::user()->role) }}</div>
                                 </div>
                                 <i class="fas fa-chevron-down text-sm"></i>
                             </button>
                             
                             <div id="profile-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-2 z-50">
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
                                     <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm hover:text-white" style="color: #003566;" onmouseover="this.style.backgroundColor='#004080'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#003566'">
                                         <i class="fas fa-user-edit w-4 h-4 mr-3"></i>
                                         <span>Edit Profile</span>
                                     </a>
                                     
                                     <div class="border-t border-gray-200 my-1"></div>
                                     
                                     <form method="POST" action="{{ route('logout') }}">
                                         @csrf
                                         <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm hover:text-white" style="color: #dc2626;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626'">
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
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6" style="background-color: #f8fafc;">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

        <script>
            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            });

            // Close sidebar when clicking overlay
            document.getElementById('sidebar-overlay').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });

            // Profile dropdown toggle
            document.getElementById('profile-dropdown').addEventListener('click', function() {
                document.getElementById('profile-menu').classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('profile-dropdown');
                const menu = document.getElementById('profile-menu');
                
                if (!dropdown.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });

            // Make sidebar responsive
            function handleResize() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Call on load
        </script>
    </body>
</html>