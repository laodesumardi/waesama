<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

   <!-- Welcome Section -->
<div class="mb-8">
    <div class="admin-card admin-welcome-card rounded-lg shadow-sm p-6 bg-[#001d3d]">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-white mb-4 md:mb-0">
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-blue-100 text-lg">Sistem Manajemen Kantor Camat</p>
                <p class="text-blue-200 text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="text-white text-right">
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <i class="fas fa-building text-3xl mb-2"></i>
                    <p class="text-sm font-medium">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Warga -->
        <div class="admin-card admin-stat-card bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Warga</p>
                    <p class="text-3xl font-bold" style="color: #003566;">1,234</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up"></i> +5.2% dari bulan lalu
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                    <i class="fas fa-users text-xl" style="color: #003566;"></i>
                </div>
            </div>
        </div>

        <!-- Permohonan Layanan -->
        <div class="admin-card admin-stat-card bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Permohonan Layanan</p>
                    <p class="text-3xl font-bold" style="color: #003566;">89</p>
                    <p class="text-sm text-blue-600 mt-1">
                        <i class="fas fa-clock"></i> 12 menunggu proses
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #fff2e6;">
                    <i class="fas fa-file-alt text-xl" style="color: #ff8c00;"></i>
                </div>
            </div>
        </div>

        <!-- Dokumen -->
        <div class="admin-card admin-stat-card bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Dokumen</p>
                    <p class="text-3xl font-bold" style="color: #003566;">456</p>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-folder"></i> 23 kategori
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #f0f9ff;">
                    <i class="fas fa-folder-open text-xl" style="color: #0ea5e9;"></i>
                </div>
            </div>
        </div>

        <!-- Pengguna Aktif -->
        <div class="admin-card admin-stat-card bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pengguna Aktif</p>
                    <p class="text-3xl font-bold" style="color: #003566;">24</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-user-check"></i> Online hari ini
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #f0fdf4;">
                    <i class="fas fa-user-friends text-xl" style="color: #16a34a;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="admin-card bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold mb-4" style="color: #003566;">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.citizens.create') }}" class="admin-action-btn flex items-center p-4 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #e6f3ff;">
                        <i class="fas fa-user-plus" style="color: #003566;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Tambah Warga</p>
                        <p class="text-sm text-gray-500">Data baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.service-requests.index') }}" class="admin-action-btn flex items-center p-4 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #fff2e6;">
                        <i class="fas fa-clipboard-list" style="color: #ff8c00;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Kelola Layanan</p>
                        <p class="text-sm text-gray-500">Permohonan</p>
                    </div>
                </a>

                <a href="{{ route('admin.documents.create') }}" class="admin-action-btn flex items-center p-4 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #f0f9ff;">
                        <i class="fas fa-file-upload" style="color: #0ea5e9;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Upload Dokumen</p>
                        <p class="text-sm text-gray-500">File baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.users') }}" class="admin-action-btn flex items-center p-4 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #f0fdf4;">
                        <i class="fas fa-user-cog" style="color: #16a34a;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Kelola User</p>
                        <p class="text-sm text-gray-500">Pengguna</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="admin-card bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold mb-4" style="color: #003566;">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                        <i class="fas fa-user-plus text-sm" style="color: #003566;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Warga baru ditambahkan</p>
                        <p class="text-xs text-gray-500">Ahmad Rizki - 2 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: #fff2e6;">
                        <i class="fas fa-file-alt text-sm" style="color: #ff8c00;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Permohonan KTP diproses</p>
                        <p class="text-xs text-gray-500">Siti Aminah - 4 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: #f0f9ff;">
                        <i class="fas fa-folder text-sm" style="color: #0ea5e9;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Dokumen baru diupload</p>
                        <p class="text-xs text-gray-500">Surat Keterangan - 6 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: #f0fdf4;">
                        <i class="fas fa-user-check text-sm" style="color: #16a34a;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">User baru login</p>
                        <p class="text-xs text-gray-500">Staff Pelayanan - 8 jam yang lalu</p>
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
    <div class="admin-card bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold mb-4" style="color: #003566;">Status Sistem</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="admin-status-item flex items-center justify-between p-4 rounded-lg" style="background-color: #f0fdf4;">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                    <span class="font-medium text-gray-900">Server Status</span>
                </div>
                <span class="admin-badge admin-badge-success text-sm font-medium text-green-600">Online</span>
            </div>

            <div class="admin-status-item flex items-center justify-between p-4 rounded-lg" style="background-color: #f0fdf4;">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                    <span class="font-medium text-gray-900">Database</span>
                </div>
                <span class="admin-badge admin-badge-success text-sm font-medium text-green-600">Connected</span>
            </div>

            <div class="admin-status-item flex items-center justify-between p-4 rounded-lg" style="background-color: #fff7ed;">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-3"></div>
                    <span class="font-medium text-gray-900">Backup</span>
                </div>
                <span class="admin-badge admin-badge-warning text-sm font-medium text-yellow-600">Scheduled</span>
            </div>
        </div>
    </div>
</x-admin-layout>
