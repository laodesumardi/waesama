<x-admin-layout>
    <x-slot name="header">
        Gallery Management
    </x-slot>

   <!-- Welcome Section -->
<div class="mb-6 md:mb-8">
    <div class="admin-card admin-welcome-card rounded-xl shadow-lg p-4 sm:p-6 lg:p-8 bg-[#001d3d]">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-white text-center sm:text-left">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">Kelola Gallery, {{ Auth::user()->name }}!</h2>
                <p class="text-blue-100 text-base sm:text-lg lg:text-xl">Sistem Manajemen Gallery</p>
                <p class="text-blue-200 text-xs sm:text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="text-white">
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 sm:p-4 text-center">
                    <i class="fas fa-images text-2xl sm:text-3xl mb-2 block"></i>
                    <p class="text-xs sm:text-sm font-medium">Gallery Manager</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 md:mb-8">
        <!-- Total Gallery -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Gallery</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">{{ $galleries->total() }}</p>
                    <p class="text-xs sm:text-sm text-blue-600 mt-1 flex items-center">
                        <i class="fas fa-images mr-1"></i> Item gallery
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #e6f3ff;">
                    <i class="fas fa-images text-lg sm:text-xl" style="color: #003566;"></i>
                </div>
            </div>
        </div>

        <!-- Gallery Aktif -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Gallery Aktif</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">{{ $galleries->where('status', 'active')->count() }}</p>
                    <p class="text-xs sm:text-sm text-green-600 mt-1 flex items-center">
                        <i class="fas fa-check-circle mr-1"></i> Dipublikasikan
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0fdf4;">
                    <i class="fas fa-check-circle text-lg sm:text-xl" style="color: #16a34a;"></i>
                </div>
            </div>
        </div>

        <!-- Gallery Tidak Aktif -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Gallery Tidak Aktif</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">{{ $galleries->where('status', 'inactive')->count() }}</p>
                    <p class="text-xs sm:text-sm text-red-600 mt-1 flex items-center">
                        <i class="fas fa-times-circle mr-1"></i> Draft
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #fef2f2;">
                    <i class="fas fa-times-circle text-lg sm:text-xl" style="color: #dc2626;"></i>
                </div>
            </div>
        </div>

        <!-- Total Views -->
        <div class="admin-card admin-stat-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Views</p>
                    <p class="text-2xl sm:text-3xl font-bold" style="color: #003566;">2,456</p>
                    <p class="text-xs sm:text-sm text-purple-600 mt-1 flex items-center">
                        <i class="fas fa-eye mr-1"></i> Pengunjung
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #faf5ff;">
                    <i class="fas fa-eye text-lg sm:text-xl" style="color: #9333ea;"></i>
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
                <a href="{{ route('admin.galleries.create') }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #e6f3ff;">
                        <i class="fas fa-plus text-sm sm:text-base" style="color: #003566;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Tambah Gallery</p>
                        <p class="text-xs sm:text-sm text-gray-500">Item baru</p>
                    </div>
                </a>

                <a href="#" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-green-300 hover:bg-green-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #f0fdf4;">
                        <i class="fas fa-upload text-sm sm:text-base" style="color: #16a34a;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Upload Batch</p>
                        <p class="text-xs sm:text-sm text-gray-500">Multiple foto</p>
                    </div>
                </a>

                <a href="#" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #faf5ff;">
                        <i class="fas fa-cog text-sm sm:text-base" style="color: #9333ea;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Pengaturan</p>
                        <p class="text-xs sm:text-sm text-gray-500">Gallery</p>
                    </div>
                </a>

                <a href="#" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #fffbeb;">
                        <i class="fas fa-chart-bar text-sm sm:text-base" style="color: #f59e0b;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Statistik</p>
                        <p class="text-xs sm:text-sm text-gray-500">Views & likes</p>
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
                        <i class="fas fa-plus text-xs sm:text-sm" style="color: #003566;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Gallery baru ditambahkan</p>
                        <p class="text-xs text-gray-500 mt-1">Kegiatan Pramuka - 2 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #f0fdf4;">
                        <i class="fas fa-check text-xs sm:text-sm" style="color: #16a34a;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Gallery dipublikasikan</p>
                        <p class="text-xs text-gray-500 mt-1">Rapat Koordinasi - 4 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #faf5ff;">
                        <i class="fas fa-edit text-xs sm:text-sm" style="color: #9333ea;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Gallery diperbarui</p>
                        <p class="text-xs text-gray-500 mt-1">Gotong Royong - 6 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: #fef2f2;">
                        <i class="fas fa-trash text-xs sm:text-sm" style="color: #dc2626;"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Gallery dihapus</p>
                        <p class="text-xs text-gray-500 mt-1">Foto duplikat - 8 jam yang lalu</p>
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
    <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300 mb-6 md:mb-8">
        <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Status Sistem Gallery</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
            <div class="text-center p-3 sm:p-4 rounded-xl hover:scale-105 transition-transform duration-300" style="background-color: #f0fdf4;">
                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto mb-2 sm:mb-3 rounded-full flex items-center justify-center" style="background-color: #16a34a;">
                    <i class="fas fa-cloud text-white text-xs sm:text-sm"></i>
                </div>
                <p class="text-xs sm:text-sm font-medium text-gray-900">Storage</p>
                <p class="text-xs text-green-600 mt-1">Available</p>
            </div>

            <div class="text-center p-3 sm:p-4 rounded-xl hover:scale-105 transition-transform duration-300" style="background-color: #f0fdf4;">
                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto mb-2 sm:mb-3 rounded-full flex items-center justify-center" style="background-color: #16a34a;">
                    <i class="fas fa-compress text-white text-xs sm:text-sm"></i>
                </div>
                <p class="text-xs sm:text-sm font-medium text-gray-900">Compression</p>
                <p class="text-xs text-green-600 mt-1">Active</p>
            </div>

            <div class="text-center p-3 sm:p-4 rounded-xl hover:scale-105 transition-transform duration-300" style="background-color: #fff7ed;">
                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto mb-2 sm:mb-3 rounded-full flex items-center justify-center" style="background-color: #f59e0b;">
                    <i class="fas fa-sync text-white text-xs sm:text-sm"></i>
                </div>
                <p class="text-xs sm:text-sm font-medium text-gray-900">Sync</p>
                <p class="text-xs text-yellow-600 mt-1">Processing</p>
            </div>
        </div>
    </div>

    <!-- Gallery Items Section -->
    <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg sm:text-xl font-semibold" style="color: #003566;">Daftar Gallery</h3>
            <a href="{{ route('admin.galleries.create') }}" 
               class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
               style="background-color: #001d3d;" 
               onmouseover="this.style.backgroundColor='#003366'" 
               onmouseout="this.style.backgroundColor='#001d3d'">
                <i class="fas fa-plus mr-2"></i>
                Tambah Gallery
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Gallery Items Table -->
        <div class="overflow-hidden">
                @if($galleries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background-color: #f8fafc;">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Image
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($galleries as $gallery)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($gallery->image)
                                                <img src="{{ asset('storage/' . $gallery->image) }}" 
                                                     alt="{{ $gallery->title }}" 
                                                     class="h-16 w-16 object-cover rounded-lg">
                                            @else
                                                <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $gallery->title }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($gallery->description, 50) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($gallery->status === 'active')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $gallery->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.galleries.show', $gallery) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this gallery item?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $galleries->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-images text-gray-400 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Gallery Items</h3>
                        <p class="text-gray-500 mb-4">Get started by creating your first gallery item.</p>
                        <a href="{{ route('admin.galleries.create') }}" 
                           class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                           style="background-color: #001d3d;" 
                           onmouseover="this.style.backgroundColor='#003366'" 
                           onmouseout="this.style.backgroundColor='#001d3d'">
                            <i class="fas fa-plus mr-2"></i>
                            Add Gallery Item
                        </a>
                    </div>
                @endif
            </div>
    </div>
</x-admin-layout>