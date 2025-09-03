<x-admin-layout>
    <x-slot name="header">
        Manajemen Pengguna
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="mb-6 md:mb-8">
            <div class="admin-card admin-welcome-card rounded-xl shadow-lg p-4 sm:p-6 lg:p-8 bg-[#001d3d]">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-white text-center sm:text-left">
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">Manajemen Pengguna</h2>
                        <p class="text-blue-100 text-base sm:text-lg lg:text-xl">Kelola pengguna sistem dengan mudah dan efisien</p>
                        <p class="text-blue-200 text-xs sm:text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
                    </div>
                    <div class="text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 sm:p-4 text-center">
                            <i class="fas fa-users text-2xl sm:text-3xl mb-2 block"></i>
                            <p class="text-xs sm:text-sm font-medium">User Management</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 md:mb-8">
                <!-- Total Pengguna -->
                <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Pengguna</p>
                            <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">{{ $userStats['total'] ?? 0 }}</p>
                            <p class="text-xs sm:text-sm text-blue-600 mt-1 flex items-center">
                                <i class="fas fa-users mr-1"></i> Semua pengguna
                            </p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #e6f3ff;">
                            <i class="fas fa-users text-lg sm:text-xl" style="color: #003566;"></i>
                        </div>
                    </div>
                </div>

                <!-- Pengguna Aktif -->
                <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Pengguna Aktif</p>
                            <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">{{ $userStats['active'] ?? 0 }}</p>
                            <p class="text-xs sm:text-sm text-green-600 mt-1 flex items-center">
                                <i class="fas fa-user-check mr-1"></i> Status aktif
                            </p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0fdf4;">
                            <i class="fas fa-user-check text-lg sm:text-xl" style="color: #16a34a;"></i>
                        </div>
                    </div>
                </div>

                <!-- Admin -->
                <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Admin</p>
                            <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">{{ $userStats['admin'] ?? 0 }}</p>
                            <p class="text-xs sm:text-sm text-yellow-600 mt-1 flex items-center">
                                <i class="fas fa-user-shield mr-1"></i> Role admin
                            </p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #fefce8;">
                            <i class="fas fa-user-shield text-lg sm:text-xl" style="color: #ca8a04;"></i>
                        </div>
                    </div>
                </div>

                <!-- Login Hari Ini -->
                <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Login Hari Ini</p>
                            <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">{{ $userStats['today_logins'] ?? 0 }}</p>
                            <p class="text-xs sm:text-sm text-purple-600 mt-1 flex items-center">
                                <i class="fas fa-sign-in-alt mr-1"></i> Hari ini
                            </p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #faf5ff;">
                            <i class="fas fa-sign-in-alt text-lg sm:text-xl" style="color: #9333ea;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 md:mb-8">
                <!-- Quick Actions -->
                <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                    <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <a href="{{ route('register') }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #e6f3ff;">
                                <i class="fas fa-user-plus text-sm sm:text-base" style="color: #003566;"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm sm:text-base">Tambah Pengguna</p>
                                <p class="text-xs sm:text-sm text-gray-500">Buat akun baru</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-300 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #fefce8;">
                                <i class="fas fa-user-shield text-sm sm:text-base" style="color: #ca8a04;"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm sm:text-base">Lihat Admin</p>
                                <p class="text-xs sm:text-sm text-gray-500">Filter admin</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users', ['role' => 'pegawai']) }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-green-300 hover:bg-green-50 transition-all duration-300 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #f0fdf4;">
                                <i class="fas fa-users text-sm sm:text-base" style="color: #16a34a;"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm sm:text-base">Lihat Pegawai</p>
                                <p class="text-xs sm:text-sm text-gray-500">Filter pegawai</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users', ['status' => 'active']) }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 group">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #faf5ff;">
                                <i class="fas fa-user-check text-sm sm:text-base" style="color: #9333ea;"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm sm:text-base">Pengguna Aktif</p>
                                <p class="text-xs sm:text-sm text-gray-500">Filter aktif</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                    <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Aktivitas Terbaru</h3>
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #e6f3ff;">
                                <i class="fas fa-user-plus text-xs sm:text-sm" style="color: #003566;"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Pengguna baru ditambahkan</p>
                                <p class="text-xs text-gray-500 truncate">Admin menambahkan pengguna baru</p>
                                <p class="text-xs text-gray-400">2 jam yang lalu</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #fefce8;">
                                <i class="fas fa-user-edit text-xs sm:text-sm" style="color: #ca8a04;"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Data pengguna diperbarui</p>
                                <p class="text-xs text-gray-500 truncate">Profil pengguna telah diperbarui</p>
                                <p class="text-xs text-gray-400">4 jam yang lalu</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0fdf4;">
                                <i class="fas fa-sign-in-alt text-xs sm:text-sm" style="color: #16a34a;"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Login pengguna</p>
                                <p class="text-xs text-gray-500 truncate">Pengguna berhasil login</p>
                                <p class="text-xs text-gray-400">6 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-6">
                        <a href="#" class="text-xs sm:text-sm font-medium hover:underline" style="color: #003566;">Lihat semua aktivitas →</a>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 mb-6 md:mb-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Status Sistem</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div class="flex items-center space-x-3 p-3 sm:p-4 rounded-xl bg-green-50 border border-green-200">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center" style="background-color: #f0fdf4;">
                            <i class="fas fa-server text-sm sm:text-base" style="color: #16a34a;"></i>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-gray-900">Server</p>
                            <p class="text-xs text-green-600 flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Online
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 sm:p-4 rounded-xl bg-green-50 border border-green-200">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center" style="background-color: #f0fdf4;">
                            <i class="fas fa-database text-sm sm:text-base" style="color: #16a34a;"></i>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-gray-900">Database</p>
                            <p class="text-xs text-green-600 flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Connected
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 sm:p-4 rounded-xl bg-green-50 border border-green-200">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center" style="background-color: #f0fdf4;">
                            <i class="fas fa-shield-alt text-sm sm:text-base" style="color: #16a34a;"></i>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-gray-900">Backup</p>
                            <p class="text-xs text-green-600 flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Updated
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management Section -->
            <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                <!-- Header dengan tombol tambah -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
                    <h3 class="text-lg sm:text-xl font-semibold" style="color: #003566;">Daftar Pengguna</h3>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-medium transition-all duration-300 hover:scale-105" style="background-color: #003566; hover:background-color: #001d3d;">
                        <i class="fas fa-plus mr-2"></i> Tambah Pengguna
                    </a>
                </div>

                            <!-- Search and Filter -->
                            <form method="GET" action="{{ route('admin.users') }}" class="mb-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex-1">
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="flex gap-2">
                                        <select name="role" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                                            <option value="">Semua Role</option>
                                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="pegawai" {{ request('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                            <option value="masyarakat" {{ request('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                                        </select>
                                        <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                                            <option value="">Semua Status</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </form>

                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengguna
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jabatan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bergabung
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $user->email }}
                                                    </div>
                                                    @if($user->phone)
                                                        <div class="text-sm text-gray-500">
                                                            {{ $user->phone }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($user->role === 'admin') bg-red-100 text-red-800
                                                @elseif($user->role === 'pegawai') bg-green-100 text-green-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>
                                                {{ $user->position ?? '-' }}
                                            </div>
                                            @if($user->department)
                                                <div class="text-xs text-gray-500">
                                                    {{ $user->department }}
                                                </div>
                                            @endif
                                            @if($user->employee_id)
                                                <div class="text-xs text-gray-500">
                                                    ID: {{ $user->employee_id }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->format('d M Y') }}
                                            @if($user->last_login_at)
                                                <div class="text-xs">
                                                    Login: {{ $user->last_login_at->diffForHumans() }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                @if($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" 
                                                          class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada pengguna ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- Grid untuk Activity dan System Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Activity Logs Panel -->
                <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                    <h3 class="text-lg font-semibold mb-4" style="color: #003566;">Aktivitas Terbaru</h3>
                            
                            @if(isset($recentActivities) && $recentActivities->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentActivities as $activity)
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                @if($activity->action == 'user_created')
                                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($activity->action == 'user_updated')
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($activity->action == 'user_deleted')
                                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L7.586 12l-1.293 1.293a1 1 0 101.414 1.414L9 13.414l1.293 1.293a1 1 0 001.414-1.414L10.414 12l1.293-1.293z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                                <div class="flex items-center mt-1 text-xs text-gray-500">
                                                    <span>{{ $activity->user ? $activity->user->name : 'System' }}</span>
                                                    <span class="mx-1">•</span>
                                                    <span>{{ $activity->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Belum ada aktivitas</p>
                                </div>
                            @endif
                        </div>
                    </div>

                <!-- System Status -->
                <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                    <h3 class="text-lg font-semibold mb-4" style="color: #003566;">Status Sistem</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center p-4 bg-green-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Server</p>
                            <p class="text-xs text-green-600">Online</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-green-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Database</p>
                            <p class="text-xs text-green-600">Terhubung</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Backup</p>
                            <p class="text-xs text-yellow-600">Terjadwal</p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>