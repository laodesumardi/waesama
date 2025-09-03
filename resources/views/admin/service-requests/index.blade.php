<x-admin-layout>
    <x-slot name="header">
        Manajemen Permohonan Surat
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Permintaan Layanan</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Kelola semua permintaan layanan surat dari masyarakat dengan mudah dan efisien</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
            <!-- Total Requests -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Permintaan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $serviceRequests->total() }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">Semua permintaan</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                        <i class="fas fa-file-alt text-xl" style="color: #003566;"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Menunggu</p>
                        <p class="text-2xl font-bold mt-2" style="color: #d97706;">{{ $serviceRequests->where('status', 'pending')->count() }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">Perlu ditindaklanjuti</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #fef3c7;">
                        <i class="fas fa-clock text-xl" style="color: #d97706;"></i>
                    </div>
                </div>
            </div>

            <!-- Processing Requests -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Diproses</p>
                        <p class="text-2xl font-bold mt-2" style="color: #2563eb;">{{ $serviceRequests->where('status', 'processing')->count() }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">Sedang dikerjakan</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #dbeafe;">
                        <i class="fas fa-cog text-xl" style="color: #2563eb;"></i>
                    </div>
                </div>
            </div>

            <!-- Completed Requests -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Selesai</p>
                        <p class="text-2xl font-bold mt-2" style="color: #16a34a;">{{ $serviceRequests->where('status', 'completed')->count() }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">Telah diselesaikan</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #f0fdf4;">
                        <i class="fas fa-check-circle text-xl" style="color: #16a34a;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <!-- Add Service Request -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tambah Permintaan</h3>
                        <p class="text-sm text-gray-600 mb-4">Buat permintaan layanan surat baru untuk masyarakat</p>
                        <a href="{{ route('admin.service-requests.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #003566; color: white;" onmouseover="this.style.backgroundColor='#002347'" onmouseout="this.style.backgroundColor='#003566'">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Permintaan
                        </a>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                        <i class="fas fa-file-alt text-xl" style="color: #003566;"></i>
                    </div>
                </div>
            </div>

            <!-- Manage Reports -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Laporan</h3>
                        <p class="text-sm text-gray-600 mb-4">Lihat dan unduh laporan permintaan layanan</p>
                        <button onclick="showExportLoading(this)" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #16a34a; color: white;" onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                            <i class="fas fa-download mr-2"></i>
                            Export Excel
                        </button>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #f0fdf4;">
                        <i class="fas fa-chart-bar text-xl" style="color: #16a34a;"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Statistik Cepat</h3>
                        <p class="text-sm text-gray-600 mb-4">Ringkasan data permintaan layanan hari ini</p>
                        <div class="text-2xl font-bold" style="color: #003566;">{{ $serviceRequests->where('created_at', '>=', today())->count() }}</div>
                        <div class="text-xs text-gray-500">Permintaan hari ini</div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #fef3c7;">
                        <i class="fas fa-clock text-xl" style="color: #d97706;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                    <span class="text-red-800">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="p-4 sm:p-6">
                <form method="GET" action="{{ route('admin.service-requests.index') }}" class="space-y-4">
                    <!-- Search and Basic Filters -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="lg:col-span-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian Umum</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       placeholder="Cari nomor, nama, atau keperluan..." 
                                       class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <!-- Priority Filter -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                            <select name="priority" id="priority" class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200">
                                <option value="">Semua Prioritas</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Advanced Filters Toggle -->
                    <div class="pt-4 border-t border-gray-200">
                        <button type="button" id="toggleAdvanced" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200" aria-expanded="false">
                            <i id="filterChevron" class="fas fa-chevron-down mr-2 transition-transform duration-200"></i>
                            Filter Lanjutan
                        </button>
                    </div>

                    <!-- Advanced Filters (Hidden by default) -->
                    <div id="advancedFilters" class="hidden pt-4 border-t border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Service Type Filter -->
                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                                <select name="service_type" id="service_type" class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200">
                                    <option value="">Semua Jenis</option>
                                    <option value="surat_keterangan_domisili" {{ request('service_type') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                    <option value="surat_keterangan_usaha" {{ request('service_type') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                    <option value="surat_keterangan_tidak_mampu" {{ request('service_type') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                    <option value="surat_pengantar_nikah" {{ request('service_type') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                    <option value="surat_keterangan_kelahiran" {{ request('service_type') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                    <option value="surat_keterangan_kematian" {{ request('service_type') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200">
                            </div>

                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                                       class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200">
                            </div>

                            <!-- Sort Options -->
                            <div>
                                <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-2">Urutkan Berdasarkan</label>
                                <select name="sort_by" id="sort_by" class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors duration-200">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                    <option value="request_number" {{ request('sort_by') == 'request_number' ? 'selected' : '' }}>Nomor Permintaan</option>
                                    <option value="applicant_name" {{ request('sort_by') == 'applicant_name' ? 'selected' : '' }}>Nama Pemohon</option>
                                    <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Prioritas</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #003566; color: white;" onmouseover="this.style.backgroundColor='#002347'" onmouseout="this.style.backgroundColor='#003566'">
                            <i class="fas fa-search mr-2"></i>
                            Cari Data
                        </button>
                        <a href="{{ route('admin.service-requests.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-refresh mr-2"></i>
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Desktop Table (Hidden on mobile, shown on desktop) -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Permintaan</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Layanan</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($serviceRequests as $request)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->request_number }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #e6f3ff;">
                                            <i class="fas fa-user text-sm" style="color: #003566;"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $request->applicant_name }}</div>
                                            <div class="text-xs text-gray-500">NIK: {{ $request->applicant_nik }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->service_type_display }}</div>
                                    @if($request->priority)
                                        @php
                                            $priorityConfig = [
                                                'low' => ['color' => '#6b7280', 'bg' => '#f3f4f6', 'label' => 'Rendah'],
                                                'medium' => ['color' => '#2563eb', 'bg' => '#dbeafe', 'label' => 'Sedang'],
                                                'high' => ['color' => '#d97706', 'bg' => '#fef3c7', 'label' => 'Tinggi'],
                                                'urgent' => ['color' => '#ef4444', 'bg' => '#fef2f2', 'label' => 'Mendesak']
                                            ];
                                            $priorityConf = $priorityConfig[$request->priority] ?? $priorityConfig['medium'];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-1" style="background-color: {{ $priorityConf['bg'] }}; color: {{ $priorityConf['color'] }};">
                                            {{ $priorityConf['label'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    @if($request->status == 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: #fef3c7; color: #d97706;">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu
                                        </span>
                                    @elseif($request->status == 'processing')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: #dbeafe; color: #2563eb;">
                                            <i class="fas fa-cog mr-1"></i>
                                            Diproses
                                        </span>
                                    @elseif($request->status == 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: #ecfdf5; color: #10b981;">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: #fef2f2; color: #ef4444;">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.service-requests.show', $request) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200 hover:scale-110" style="background-color: #e6f3ff; color: #003566;" title="Lihat Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('admin.service-requests.edit', $request) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200 hover:scale-110" style="background-color: #fef3c7; color: #d97706;" title="Edit Data">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.service-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200 hover:scale-110" style="background-color: #fef2f2; color: #ef4444;" title="Hapus Data">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 sm:px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" style="background-color: #f3f4f6;">
                                            <i class="fas fa-file-alt text-2xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada permintaan layanan</h3>
                                        <p class="text-sm text-gray-500 mb-4">Belum ada permintaan layanan yang tersedia atau sesuai dengan filter yang dipilih.</p>
                                        <a href="{{ route('admin.service-requests.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Permintaan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (Hidden on desktop, shown on mobile) -->
            <div class="admin-mobile-cards block sm:hidden">
                @forelse($serviceRequests as $request)
                    <div class="p-4 border-b border-gray-200 last:border-b-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #e6f3ff;">
                                    <i class="fas fa-file-alt text-sm" style="color: #003566;"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $request->request_number }}</h4>
                                    <p class="text-xs text-gray-500">{{ $request->applicant_name }}</p>
                                </div>
                            </div>
                            @if($request->status == 'pending')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: #fef3c7; color: #d97706;">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu
                                </span>
                            @elseif($request->status == 'processing')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: #dbeafe; color: #2563eb;">
                                    <i class="fas fa-cog mr-1"></i>
                                    Diproses
                                </span>
                            @elseif($request->status == 'completed')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: #ecfdf5; color: #10b981;">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: #fef2f2; color: #ef4444;">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Ditolak
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                            <div>
                                <span class="text-gray-500 text-xs">Jenis Layanan</span>
                                <p class="text-gray-900 text-sm mt-1">{{ $request->service_type_display }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-xs">NIK Pemohon</span>
                                <p class="text-gray-900 text-sm mt-1">{{ $request->applicant_nik }}</p>
                            </div>
                        </div>
                        
                        @if($request->purpose)
                            <div class="mb-4">
                                <span class="text-gray-500 text-xs">Keperluan</span>
                                <p class="text-gray-900 text-sm mt-1">{{ $request->purpose }}</p>
                            </div>
                        @endif
                        
                        <div class="mb-4">
                            <span class="text-gray-500 text-xs">Tanggal Dibuat</span>
                            <p class="text-gray-900 text-sm mt-1">{{ $request->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100">
                            <a href="{{ route('admin.service-requests.show', $request) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200" style="background-color: #e6f3ff; color: #003566;" title="Lihat Detail">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <a href="{{ route('admin.service-requests.edit', $request) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200" style="background-color: #fef3c7; color: #d97706;" title="Edit Data">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('admin.service-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200" style="background-color: #fef2f2; color: #ef4444;" title="Hapus Data">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto" style="background-color: #f3f4f6;">
                            <i class="fas fa-file-alt text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada permintaan layanan</h3>
                        <p class="text-sm text-gray-500 mb-4">Belum ada permintaan layanan yang tersedia atau sesuai dengan filter yang dipilih.</p>
                        <a href="{{ route('admin.service-requests.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Permintaan Pertama
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="p-4 sm:p-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $serviceRequests->firstItem() ?? 0 }} - {{ $serviceRequests->lastItem() ?? 0 }} dari {{ $serviceRequests->total() }} data
                    </div>
                    <div>
                        {{ $serviceRequests->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle advanced filters
        function toggleAdvancedFilters() {
            const advancedFilters = document.getElementById('advanced-filters');
            const toggleIcon = document.getElementById('toggle-icon');
            
            if (advancedFilters.classList.contains('hidden')) {
                advancedFilters.classList.remove('hidden');
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-up');
            } else {
                advancedFilters.classList.add('hidden');
                toggleIcon.classList.remove('fa-chevron-up');
                toggleIcon.classList.add('fa-chevron-down');
            }
        }

        // Auto submit form when dropdown changes
        document.addEventListener('DOMContentLoaded', function() {
            const autoSubmitSelects = document.querySelectorAll('select[data-auto-submit]');
            autoSubmitSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipElements = document.querySelectorAll('[title]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    // Simple tooltip implementation
                    const title = this.getAttribute('title');
                    if (title) {
                        this.setAttribute('data-original-title', title);
                        this.removeAttribute('title');
                    }
                });
            });
        });

        // Auto refresh setiap 60 detik untuk update status (hanya jika tidak ada filter aktif)
        @if(!request()->hasAny(['search', 'status', 'service_type']))
        setInterval(function() {
            if (!document.hidden && !document.querySelector('input:focus, select:focus')) {
                location.reload();
            }
        }, 60000);
        @endif

        // Advanced filters toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleAdvanced');
            const advancedFilters = document.getElementById('advancedFilters');
            const chevron = document.getElementById('filterChevron');

            if (toggleButton && advancedFilters && chevron) {
                toggleButton.addEventListener('click', function() {
                    const isHidden = advancedFilters.classList.contains('hidden');
                    
                    if (isHidden) {
                        advancedFilters.classList.remove('hidden');
                        chevron.classList.remove('fa-chevron-down');
                        chevron.classList.add('fa-chevron-up');
                        toggleButton.setAttribute('aria-expanded', 'true');
                    } else {
                        advancedFilters.classList.add('hidden');
                        chevron.classList.remove('fa-chevron-up');
                        chevron.classList.add('fa-chevron-down');
                        toggleButton.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Show advanced filters if any advanced filter is active
            const hasAdvancedFilters = {{ request()->hasAny(['service_type', 'date_from', 'date_to', 'sort_by']) ? 'true' : 'false' }};
            if (hasAdvancedFilters && advancedFilters && chevron) {
                advancedFilters.classList.remove('hidden');
                chevron.classList.remove('fa-chevron-down');
                chevron.classList.add('fa-chevron-up');
                toggleButton.setAttribute('aria-expanded', 'true');
            }
        });

        // Smooth scroll untuk mobile cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-gray-50');
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    if (!e.target.closest('a, button, form')) {
                        const viewButton = this.querySelector('a[href*="show"]');
                        if (viewButton) {
                            viewButton.click();
                        }
                    }
                });
            });
        });

        // Enhanced confirmation dialogs
        function confirmAction(message, element) {
            if (confirm(message)) {
                element.closest('form').submit();
            }
        }

        // Export functionality
        function showExportLoading(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengunduh...';
            button.disabled = true;
            
            // Simulate export process
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                alert('Export berhasil! File akan segera diunduh.');
            }, 2000);
        }
    </script>
    @endpush
</x-admin-layout>