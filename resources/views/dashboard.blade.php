<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

   <!-- Welcome Section -->
<div class="mb-6 md:mb-8">
    <div class="admin-card admin-welcome-card rounded-xl shadow-lg p-4 sm:p-6 lg:p-8 bg-[#001d3d]">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-white text-center sm:text-left">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-blue-100 text-base sm:text-lg lg:text-xl">Sistem Manajemen Kantor Camat</p>
                <p class="text-blue-200 text-xs sm:text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="text-white">
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 sm:p-4 text-center">
                    <i class="fas fa-building text-2xl sm:text-3xl mb-2 block"></i>
                    <p class="text-xs sm:text-sm font-medium">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 md:mb-8">
        <!-- Total Warga -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Warga</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">1,234</p>
                    <p class="text-xs sm:text-sm text-green-600 mt-1 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> +5.2% dari bulan lalu
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #e6f3ff;">
                    <i class="fas fa-users text-lg sm:text-xl" style="color: #003566;"></i>
                </div>
            </div>
        </div>

        <!-- Permohonan Layanan -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Permohonan Layanan</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">89</p>
                    <p class="text-xs sm:text-sm text-blue-600 mt-1 flex items-center">
                        <i class="fas fa-clock mr-1"></i> 12 menunggu proses
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #fff2e6;">
                    <i class="fas fa-file-alt text-lg sm:text-xl" style="color: #ff8c00;"></i>
                </div>
            </div>
        </div>

        <!-- Dokumen -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Dokumen</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">456</p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1 flex items-center">
                        <i class="fas fa-folder mr-1"></i> 23 kategori
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0f9ff;">
                    <i class="fas fa-folder-open text-lg sm:text-xl" style="color: #0ea5e9;"></i>
                </div>
            </div>
        </div>

        <!-- Pengguna Aktif -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Pengguna Aktif</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">24</p>
                    <p class="text-xs sm:text-sm text-green-600 mt-1 flex items-center">
                        <i class="fas fa-user-check mr-1"></i> Online hari ini
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0fdf4;">
                    <i class="fas fa-user-friends text-lg sm:text-xl" style="color: #16a34a;"></i>
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
                <a href="{{ route('admin.citizens.create') }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #e6f3ff;">
                        <i class="fas fa-user-plus text-sm sm:text-base" style="color: #003566;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Tambah Warga</p>
                        <p class="text-xs sm:text-sm text-gray-500">Data baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.service-requests.index') }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-orange-300 hover:bg-orange-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #fff2e6;">
                        <i class="fas fa-clipboard-list text-sm sm:text-base" style="color: #ff8c00;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Kelola Layanan</p>
                        <p class="text-xs sm:text-sm text-gray-500">Permohonan</p>
                    </div>
                </a>



                <a href="{{ route('admin.users') }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-green-300 hover:bg-green-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #f0fdf4;">
                        <i class="fas fa-user-cog text-sm sm:text-base" style="color: #16a34a;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Kelola User</p>
                        <p class="text-xs sm:text-sm text-gray-500">Pengguna</p>
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
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Warga baru ditambahkan</p>
                        <p class="text-xs text-gray-500 mt-1">Ahmad Rizki - 2 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #fff2e6;">
                        <i class="fas fa-file-alt text-xs sm:text-sm" style="color: #ff8c00;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Permohonan KTP diproses</p>
                        <p class="text-xs text-gray-500 mt-1">Siti Aminah - 4 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0f9ff;">
                        <i class="fas fa-folder text-xs sm:text-sm" style="color: #0ea5e9;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Dokumen baru diupload</p>
                        <p class="text-xs text-gray-500 mt-1">Surat Keterangan - 6 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0fdf4;">
                        <i class="fas fa-user-check text-xs sm:text-sm" style="color: #16a34a;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">User baru login</p>
                        <p class="text-xs text-gray-500 mt-1">Staff Pelayanan - 8 jam yang lalu</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.activity-logs') }}" class="text-sm font-medium hover:underline" style="color: #003566;">
                    Lihat semua aktivitas <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
        <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Status Sistem</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
            <div class="text-center p-3 sm:p-4 rounded-xl hover:scale-105 transition-transform duration-300" style="background-color: #f0fdf4;">
                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto mb-2 sm:mb-3 rounded-full flex items-center justify-center" style="background-color: #16a34a;">
                    <i class="fas fa-check text-white text-xs sm:text-sm"></i>
                </div>
                <p class="text-xs sm:text-sm font-medium text-gray-900">Server</p>
                <p class="text-xs text-green-600 mt-1">Online</p>
            </div>

            <div class="text-center p-3 sm:p-4 rounded-xl hover:scale-105 transition-transform duration-300" style="background-color: #f0fdf4;">
                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto mb-2 sm:mb-3 rounded-full flex items-center justify-center" style="background-color: #16a34a;">
                    <i class="fas fa-database text-white text-xs sm:text-sm"></i>
                </div>
                <p class="text-xs sm:text-sm font-medium text-gray-900">Database</p>
                <p class="text-xs text-green-600 mt-1">Connected</p>
            </div>

            <div class="text-center p-3 sm:p-4 rounded-xl hover:scale-105 transition-transform duration-300" style="background-color: #fff7ed;">
                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto mb-2 sm:mb-3 rounded-full flex items-center justify-center" style="background-color: #f59e0b;">
                    <i class="fas fa-clock text-white text-xs sm:text-sm"></i>
                </div>
                <p class="text-xs sm:text-sm font-medium text-gray-900">Backup</p>
                <p class="text-xs text-yellow-600 mt-1">Scheduled</p>
            </div>
        </div>
    </div>
</x-admin-layout>
