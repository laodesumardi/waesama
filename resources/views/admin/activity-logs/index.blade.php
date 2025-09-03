<x-admin-layout>
    <x-slot name="header">
        <span>Log Aktivitas</span>
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="rounded-xl shadow-md p-4 sm:p-6 text-white" style="background-color: #001d3d;">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-sm sm:text-base opacity-90">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-history text-2xl sm:text-3xl"></i>
                        <div>
                            <p class="text-xs sm:text-sm opacity-75">Log Aktivitas</p>
                            <p class="text-sm sm:text-base font-semibold">Sistem Monitoring</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
         @if(session('success'))
             <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                 {{ session('success') }}
             </div>
         @endif

         <!-- Statistics Cards -->
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
             <!-- Total Logs -->
             <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-xs sm:text-sm font-medium text-gray-600">Total Log</p>
                         <p class="text-xl sm:text-2xl font-bold" style="color: #003566;">{{ $activityLogs->total() }}</p>
                     </div>
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                         <i class="fas fa-list text-sm sm:text-base" style="color: #003566;"></i>
                     </div>
                 </div>
             </div>

             <!-- Today's Logs -->
             <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-xs sm:text-sm font-medium text-gray-600">Log Hari Ini</p>
                         <p class="text-xl sm:text-2xl font-bold" style="color: #003566;">{{ $activityLogs->where('created_at', '>=', today())->count() }}</p>
                     </div>
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                         <i class="fas fa-calendar-day text-sm sm:text-base" style="color: #003566;"></i>
                     </div>
                 </div>
             </div>

             <!-- User Actions -->
             <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-xs sm:text-sm font-medium text-gray-600">Aksi Pengguna</p>
                         <p class="text-xl sm:text-2xl font-bold" style="color: #003566;">{{ $activityLogs->whereIn('action', ['user_login', 'user_logout', 'user_created', 'user_updated'])->count() }}</p>
                     </div>
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                         <i class="fas fa-users text-sm sm:text-base" style="color: #003566;"></i>
                     </div>
                 </div>
             </div>

             <!-- System Actions -->
             <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-xs sm:text-sm font-medium text-gray-600">Aksi Sistem</p>
                         <p class="text-xl sm:text-2xl font-bold" style="color: #003566;">{{ $activityLogs->whereIn('action', ['citizen_created', 'citizen_updated', 'citizen_deleted', 'citizens_imported'])->count() }}</p>
                     </div>
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                         <i class="fas fa-cogs text-sm sm:text-base" style="color: #003566;"></i>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Quick Actions -->
         <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
             <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Aksi Cepat</h3>
             <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                 <a href="{{ route('admin.activity-logs', ['action' => 'user_login']) }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #e6f3ff;">
                         <i class="fas fa-sign-in-alt text-sm sm:text-base" style="color: #003566;"></i>
                     </div>
                     <div>
                         <p class="font-medium text-gray-900 text-sm sm:text-base">Login Logs</p>
                         <p class="text-xs sm:text-sm text-gray-500">Filter login</p>
                     </div>
                 </a>

                 <a href="{{ route('admin.activity-logs', ['action' => 'user_created']) }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-green-300 hover:bg-green-50 transition-all duration-300 group">
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #f0fdf4;">
                         <i class="fas fa-user-plus text-sm sm:text-base" style="color: #16a34a;"></i>
                     </div>
                     <div>
                         <p class="font-medium text-gray-900 text-sm sm:text-base">User Created</p>
                         <p class="text-xs sm:text-sm text-gray-500">Filter buat user</p>
                     </div>
                 </a>

                 <a href="{{ route('admin.activity-logs', ['action' => 'citizen_created']) }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 group">
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #faf5ff;">
                         <i class="fas fa-users text-sm sm:text-base" style="color: #9333ea;"></i>
                     </div>
                     <div>
                         <p class="font-medium text-gray-900 text-sm sm:text-base">Citizen Created</p>
                         <p class="text-xs sm:text-sm text-gray-500">Filter buat warga</p>
                     </div>
                 </a>

                 <a href="{{ route('admin.activity-logs', ['date_from' => today()->format('Y-m-d')]) }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-orange-300 hover:bg-orange-50 transition-all duration-300 group">
                     <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #fff7ed;">
                         <i class="fas fa-calendar-day text-sm sm:text-base" style="color: #ea580c;"></i>
                     </div>
                     <div>
                         <p class="font-medium text-gray-900 text-sm sm:text-base">Hari Ini</p>
                         <p class="text-xs sm:text-sm text-gray-500">Filter hari ini</p>
                     </div>
                 </a>
             </div>
         </div>

         <!-- Activity Logs Section -->
         <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
             <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Log Aktivitas</h3>
                    <!-- Filter -->
                    <form method="GET" action="{{ route('admin.activity-logs') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                                    <option value="">Semua Aksi</option>
                                    <option value="user_login" {{ request('action') == 'user_login' ? 'selected' : '' }}>Login</option>
                                    <option value="user_logout" {{ request('action') == 'user_logout' ? 'selected' : '' }}>Logout</option>
                                    <option value="user_created" {{ request('action') == 'user_created' ? 'selected' : '' }}>Buat Pengguna</option>
                                    <option value="user_updated" {{ request('action') == 'user_updated' ? 'selected' : '' }}>Update Pengguna</option>
                                    <option value="user_deleted" {{ request('action') == 'user_deleted' ? 'selected' : '' }}>Hapus Pengguna</option>
                                    <option value="citizen_created" {{ request('action') == 'citizen_created' ? 'selected' : '' }}>Buat Penduduk</option>
                                    <option value="citizen_updated" {{ request('action') == 'citizen_updated' ? 'selected' : '' }}>Update Penduduk</option>
                                    <option value="citizen_deleted" {{ request('action') == 'citizen_deleted' ? 'selected' : '' }}>Hapus Penduduk</option>
                                    <option value="citizens_imported" {{ request('action') == 'citizens_imported' ? 'selected' : '' }}>Import Penduduk</option>
                                </select>
                            </div>
                            <div>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                            </div>
                            <div>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Cari
                            </button>
                            <a href="{{ route('admin.activity-logs') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                Reset
                            </a>
                        </div>
                    </form>

                    <!-- Activity Logs Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengguna
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        IP Address
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($activityLogs as $log)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-xs font-medium text-gray-700">
                                                            {{ $log->user ? strtoupper(substr($log->user->name, 0, 2)) : 'SY' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $log->user ? $log->user->name : 'System' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $log->user ? $log->user->role : 'system' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $actionColors = [
                                                    'user_login' => 'bg-green-100 text-green-800',
                                                    'user_logout' => 'bg-gray-100 text-gray-800',
                                                    'user_created' => 'bg-blue-100 text-blue-800',
                                                    'user_updated' => 'bg-yellow-100 text-yellow-800',
                                                    'user_deleted' => 'bg-red-100 text-red-800',
                                                    'citizen_created' => 'bg-blue-100 text-blue-800',
                                                    'citizen_updated' => 'bg-yellow-100 text-yellow-800',
                                                    'citizen_deleted' => 'bg-red-100 text-red-800',
                                                    'citizens_imported' => 'bg-purple-100 text-purple-800',
                                                ];
                                                $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $log->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->ip_address }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada log aktivitas ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $activityLogs->links() }}
                    </div>
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
    </div>
</x-admin-layout>