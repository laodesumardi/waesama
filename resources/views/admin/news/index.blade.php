<x-admin-layout>
    <x-slot name="header">
        Manajemen Berita
    </x-slot>

    <!-- Welcome Section -->
    <div class="mb-6 md:mb-8">
        <div class="admin-card admin-welcome-card rounded-xl shadow-lg p-4 sm:p-6 lg:p-8 bg-[#001d3d]">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-white text-center sm:text-left">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">Manajemen Berita</h2>
                    <p class="text-blue-100 text-base sm:text-lg lg:text-xl">Kelola berita dan informasi untuk website</p>
                    <p class="text-blue-200 text-xs sm:text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
                </div>
                <div class="text-white">
                    <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 sm:p-4 text-center">
                        <i class="fas fa-newspaper text-2xl sm:text-3xl mb-2 block"></i>
                        <p class="text-xs sm:text-sm font-medium">Berita</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold" style="color: #003566;">Daftar Berita</h3>
                        <p class="text-gray-600 text-sm sm:text-base mt-1">Kelola semua berita dan artikel</p>
                    </div>
                    <a href="{{ route('admin.news.create') }}" 
                       class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                       style="background-color: #001d3d;" 
                       onmouseover="this.style.backgroundColor='#003366'" 
                       onmouseout="this.style.backgroundColor='#001d3d'">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Berita
                    </a>
                </div>
            @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Total Berita -->
            <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wider">Total Berita</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mt-1" style="color: #003566;">{{ $news->total() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Semua artikel</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                        <i class="fas fa-newspaper text-sm sm:text-base" style="color: #003566;"></i>
                    </div>
                </div>
            </div>

            <!-- Berita Published -->
            <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wider">Published</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mt-1" style="color: #059669;">{{ $news->where('status', 'published')->count() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Berita aktif</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #ecfdf5;">
                        <i class="fas fa-check-circle text-sm sm:text-base" style="color: #059669;"></i>
                    </div>
                </div>
            </div>

            <!-- Berita Draft -->
            <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wider">Draft</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mt-1" style="color: #d97706;">{{ $news->where('status', 'draft')->count() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Belum publish</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #fef3c7;">
                        <i class="fas fa-edit text-sm sm:text-base" style="color: #d97706;"></i>
                    </div>
                </div>
            </div>

            <!-- Total Views -->
            <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wider">Total Views</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold mt-1" style="color: #7c3aed;">{{ number_format($news->sum('views') ?? 0) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Pembaca aktif</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center" style="background-color: #faf5ff;">
                        <i class="fas fa-eye text-sm sm:text-base" style="color: #7c3aed;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($news->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Publikasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($news as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item->image)
                                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-16 w-16 object-cover rounded">
                                                @else
                                                    <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="text-gray-400 text-xs">No Image</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($item->title, 50) }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit(strip_tags($item->content), 100) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->author }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item->status === 'published')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Published
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Draft
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.news.show', $item) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                    <a href="{{ route('admin.news.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $news->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 text-lg mb-4">Belum ada berita</div>
                            <a href="{{ route('admin.news.create') }}" 
                               class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                               style="background-color: #001d3d;" 
                               onmouseover="this.style.backgroundColor='#003366'" 
                               onmouseout="this.style.backgroundColor='#001d3d'">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Berita Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
            <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Aksi Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <a href="{{ route('admin.news.create') }}" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #e6f3ff;">
                        <i class="fas fa-plus text-sm sm:text-base" style="color: #003566;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Buat Berita</p>
                        <p class="text-xs sm:text-sm text-gray-500">Artikel baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.news.index') }}?status=draft" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #fef3c7;">
                        <i class="fas fa-edit text-sm sm:text-base" style="color: #d97706;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Kelola Draft</p>
                        <p class="text-xs sm:text-sm text-gray-500">Edit artikel</p>
                    </div>
                </a>

                <a href="{{ route('admin.news.index') }}?status=published" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-green-300 hover:bg-green-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #ecfdf5;">
                        <i class="fas fa-check-circle text-sm sm:text-base" style="color: #059669;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Berita Published</p>
                        <p class="text-xs sm:text-sm text-gray-500">Artikel aktif</p>
                    </div>
                </a>

                <a href="#" class="admin-action-btn flex items-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #faf5ff;">
                        <i class="fas fa-chart-bar text-sm sm:text-base" style="color: #9333ea;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Statistik</p>
                        <p class="text-xs sm:text-sm text-gray-500">Analisis data</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
            <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Aktivitas Terbaru</h3>
            <div class="space-y-3 sm:space-y-4">
                @php
                    $recentNews = $news->take(4);
                @endphp
                @forelse($recentNews as $item)
                    <div class="flex items-center p-3 sm:p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center mr-3 sm:mr-4" style="background-color: {{ $item->status === 'published' ? '#ecfdf5' : '#fef3c7' }};">
                            <i class="fas {{ $item->status === 'published' ? 'fa-check-circle' : 'fa-edit' }} text-xs sm:text-sm" style="color: {{ $item->status === 'published' ? '#059669' : '#d97706' }};"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm sm:text-base font-medium text-gray-900 truncate">{{ $item->title }}</p>
                            <p class="text-xs sm:text-sm text-gray-500">{{ $item->status === 'published' ? 'Berita dipublikasi' : 'Draft dibuat' }} • {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="text-xs sm:text-sm text-gray-400">
                            {{ $item->created_at->format('H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-newspaper text-2xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500 text-sm">Belum ada aktivitas berita</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- System Status -->
        <div class="admin-card bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 p-4 sm:p-6 transition-all duration-300">
            <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6" style="color: #003566;">Status Sistem</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                <div class="flex items-center p-3 sm:p-4 rounded-lg" style="background-color: #ecfdf5;">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #059669;">
                        <i class="fas fa-server text-white text-xs sm:text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm sm:text-base font-medium text-gray-900">Server</p>
                        <p class="text-xs sm:text-sm text-green-600">Online</p>
                    </div>
                </div>

                <div class="flex items-center p-3 sm:p-4 rounded-lg" style="background-color: #ecfdf5;">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #059669;">
                        <i class="fas fa-database text-white text-xs sm:text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm sm:text-base font-medium text-gray-900">Database</p>
                        <p class="text-xs sm:text-sm text-green-600">Connected</p>
                    </div>
                </div>

                <div class="flex items-center p-3 sm:p-4 rounded-lg" style="background-color: #ecfdf5;">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #059669;">
                        <i class="fas fa-shield-alt text-white text-xs sm:text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm sm:text-base font-medium text-gray-900">Backup</p>
                        <p class="text-xs sm:text-sm text-green-600">Updated</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>