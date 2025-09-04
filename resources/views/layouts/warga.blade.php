<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        
        .nav-item {
            @apply flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200;
        }
        
        .nav-item.active {
            @apply bg-[#003f88] text-white shadow-md;
        }
        
        .nav-item:hover:not(.active):not(.cursor-not-allowed) {
            @apply bg-blue-50 text-blue-600 transform scale-105;
        }
        
        .nav-item.cursor-not-allowed {
            @apply pointer-events-none;
        }
        
        .nav-text {
            @apply sidebar-transition;
        }
        
        /* Sidebar States */
        .sidebar-collapsed {
            width: 80px;
        }
        
        .sidebar-expanded {
            width: 280px;
        }
        
        .main-content-collapsed {
            margin-left: 80px;
        }
        
        .main-content-expanded {
            margin-left: 280px;
        }
        
        /* Mobile Styles */
        @media (max-width: 768px) {
            .sidebar-collapsed,
            .sidebar-expanded {
                width: 280px;
                transform: translateX(-100%);
            }
            
            .sidebar-collapsed.mobile-open,
            .sidebar-expanded.mobile-open {
                transform: translateX(0);
            }
            
            .main-content-collapsed,
            .main-content-expanded {
                margin-left: 0;
            }
            
            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            
            .mobile-overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }
        
        .main-content-area {
            min-height: calc(100vh - 80px);
            overflow-y: auto;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay"></div>
    
    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-0 left-0 h-full bg-white shadow-lg z-50 sidebar-transition sidebar-expanded">
        <div class="flex flex-col h-full">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-[#003f88] rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-white text-lg"></i>
                    </div>
                    <div id="logo-text" class="sidebar-transition">
                        <h1 class="font-bold text-gray-800 text-lg">Kantor Camat</h1>
                        <p class="text-xs text-gray-500">Waesama</p>
                    </div>
                </div>
                <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
            </div>

            <!-- User Info -->
            <div id="user-info" class="p-4 border-b border-gray-200 sidebar-transition">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-[#003f88] rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ auth()->user()->role->display_name }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                @yield('sidebar-menu')
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span id="logout-text" class="sidebar-transition">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="flex flex-col transition-all duration-300 h-screen main-content-expanded">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200 py-4">
            <div class="flex items-center justify-between px-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                    @hasSection('subtitle')
                        <p class="text-gray-600 text-sm mt-1">@yield('subtitle')</p>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button id="notification-btn" class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span id="notification-badge" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full hidden"></span>
                            <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1 min-w-[16px] h-4 flex items-center justify-center hidden"></span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                                    <button id="mark-all-read" class="text-sm text-blue-600 hover:text-blue-800">Tandai Semua Dibaca</button>
                                </div>
                            </div>
                            <div id="notification-list" class="max-h-96 overflow-y-auto">
                                <div class="p-4 text-center text-gray-500">
                                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                    <p>Tidak ada notifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profile-btn" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-[#003f88] rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>
                        
                        <!-- Profile Dropdown Menu -->
                        <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                            <div class="p-2">
                                <div class="px-3 py-2 border-b border-gray-100">
                                    <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                    <p class="text-xs text-gray-400">{{ auth()->user()->role->display_name }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                    <i class="fas fa-user mr-2"></i>
                                    Profil Saya
                                </a>
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                    <i class="fas fa-cog mr-2"></i>
                                    Pengaturan
                                </a>
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="main-content-area p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const logoText = document.getElementById('logo-text');
            const userInfo = document.getElementById('user-info');
            const logoutText = document.getElementById('logout-text');
            const mobileOverlay = document.getElementById('mobile-overlay');

            let isCollapsed = false;
            let isMobile = window.innerWidth <= 768;

            // Ensure sidebar starts in expanded state
            sidebar.classList.add('sidebar-expanded');
            sidebar.classList.remove('sidebar-collapsed');
            mainContent.classList.add('main-content-expanded');
            mainContent.classList.remove('main-content-collapsed');

            // Check if mobile on resize
            window.addEventListener('resize', function() {
                const wasMobile = isMobile;
                isMobile = window.innerWidth <= 768;

                if (wasMobile !== isMobile) {
                    // Reset sidebar state when switching between mobile/desktop
                    if (isMobile) {
                        sidebar.classList.remove('mobile-open');
                        mobileOverlay.classList.remove('active');
                    } else {
                        sidebar.classList.remove('mobile-open');
                        mobileOverlay.classList.remove('active');
                    }
                }
            });

            sidebarToggle.addEventListener('click', function() {
                if (isMobile) {
                    // Mobile behavior - toggle sidebar overlay
                    sidebar.classList.toggle('mobile-open');
                    mobileOverlay.classList.toggle('active');
                } else {
                    // Desktop behavior - collapse/expand sidebar
                    isCollapsed = !isCollapsed;

                    if (isCollapsed) {
                        sidebar.classList.remove('sidebar-expanded');
                        sidebar.classList.add('sidebar-collapsed');
                        mainContent.classList.remove('main-content-expanded');
                        mainContent.classList.add('main-content-collapsed');

                        logoText.style.display = 'none';
                        userInfo.style.display = 'none';
                        logoutText.style.display = 'none';
                    } else {
                        sidebar.classList.remove('sidebar-collapsed');
                        sidebar.classList.add('sidebar-expanded');
                        mainContent.classList.remove('main-content-collapsed');
                        mainContent.classList.add('main-content-expanded');

                        logoText.style.display = 'block';
                        userInfo.style.display = 'block';
                        logoutText.style.display = 'inline';
                    }
                }
            });

            // Close mobile sidebar when clicking overlay
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('active');
            });
            
            // Notification and Profile Dropdown functionality
            const notificationBtn = document.getElementById('notification-btn');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const profileBtn = document.getElementById('profile-btn');
            const profileDropdown = document.getElementById('profile-dropdown');
            const markAllReadBtn = document.getElementById('mark-all-read');
            
            // Toggle notification dropdown
            notificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
                profileDropdown.classList.add('hidden');
                loadNotifications();
            });
            
            // Toggle profile dropdown
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
                notificationDropdown.classList.add('hidden');
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                notificationDropdown.classList.add('hidden');
                profileDropdown.classList.add('hidden');
            });
            
            // Prevent dropdown from closing when clicking inside
            notificationDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Mark all notifications as read
            markAllReadBtn.addEventListener('click', function() {
                fetch('/notifications/mark-all-read', {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadNotifications();
                        updateNotificationCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            });
            
            // Load notifications
            function loadNotifications() {
                fetch('/notifications')
                    .then(response => response.json())
                    .then(data => {
                        const notificationList = document.getElementById('notification-list');
                        
                        if (data.notifications.length === 0) {
                            notificationList.innerHTML = `
                                <div class="p-4 text-center text-gray-500">
                                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                    <p>Tidak ada notifikasi</p>
                                </div>
                            `;
                        } else {
                            notificationList.innerHTML = data.notifications.map(notification => `
                                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 ${notification.read_at ? 'opacity-60' : ''}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800 text-sm">${notification.title}</h4>
                                            <p class="text-gray-600 text-sm mt-1">${notification.message}</p>
                                            <p class="text-gray-400 text-xs mt-2">${formatDate(notification.created_at)}</p>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-2">
                                            ${!notification.read_at ? `
                                                <button onclick="markAsRead(${notification.id})" class="text-blue-600 hover:text-blue-800 text-xs">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            ` : ''}
                                            <button onclick="deleteNotification(${notification.id})" class="text-red-600 hover:text-red-800 text-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            
            // Update notification count
            function updateNotificationCount() {
                fetch('/notifications/unread-count')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('notification-badge');
                        const count = document.getElementById('notification-count');
                        
                        if (data.unread_count > 0) {
                            if (data.unread_count > 9) {
                                count.textContent = '9+';
                                count.classList.remove('hidden');
                                badge.classList.add('hidden');
                            } else {
                                count.textContent = data.unread_count;
                                count.classList.remove('hidden');
                                badge.classList.add('hidden');
                            }
                        } else {
                            count.classList.add('hidden');
                            badge.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            
            // Mark single notification as read
            window.markAsRead = function(notificationId) {
                fetch(`/notifications/${notificationId}/read`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadNotifications();
                        updateNotificationCount();
                    }
                })
                .catch(error => console.error('Error:', error));
            };
            
            // Delete notification
            window.deleteNotification = function(notificationId) {
                if (confirm('Hapus notifikasi ini?')) {
                    fetch(`/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadNotifications();
                            updateNotificationCount();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            };
            
            // Format date
            function formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diff = now - date;
                const minutes = Math.floor(diff / 60000);
                const hours = Math.floor(diff / 3600000);
                const days = Math.floor(diff / 86400000);
                
                if (minutes < 1) return 'Baru saja';
                if (minutes < 60) return `${minutes} menit yang lalu`;
                if (hours < 24) return `${hours} jam yang lalu`;
                if (days < 7) return `${days} hari yang lalu`;
                
                return date.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            }
            
            // Load notification count on page load
            updateNotificationCount();
            
            // Auto-refresh notification count every 30 seconds
            setInterval(updateNotificationCount, 30000);
        });
    </script>
</body>
</html>