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
                <div class="flex items-center space-x-3">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notificationBell" class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg transition-colors duration-200">
                            <i class="fas fa-bell text-xl"></i>
                            <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Notifikasi</h3>
                                    <button id="markAllRead" class="text-sm text-blue-600 hover:text-blue-800">Tandai Semua Dibaca</button>
                                </div>
                            </div>
                            <div id="notificationList" class="max-h-96 overflow-y-auto">
                                <div class="p-4 text-center text-gray-500">
                                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                    <p>Tidak ada notifikasi baru</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Real-time Status Indicator -->
                    <div class="flex items-center space-x-2">
                        <div id="connectionStatus" class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-sm text-gray-600">Real-time</span>
                    </div>
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


            <!-- Manage Reports -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Laporan</h3>
                        <p class="text-sm text-gray-600 mb-4">Lihat dan unduh laporan permintaan layanan</p>
                        <a href="{{ route('admin.service-requests.export', request()->query()) }}" onclick="showExportLoading(this)" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 mr-3" style="background-color: #16a34a; color: white;" onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                            <i class="fas fa-download mr-2"></i>
                            Export Excel
                        </a>

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
                <!-- Bulk Actions Bar -->
                <div id="bulkActionsBar" class="hidden bg-blue-50 border-b border-blue-200 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span id="selectedCount" class="text-sm font-medium text-blue-900">0 item dipilih</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="bulkAction('approve')" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                <i class="fas fa-check mr-1"></i>
                                Setujui
                            </button>
                            <button type="button" onclick="bulkAction('process')" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                <i class="fas fa-cog mr-1"></i>
                                Proses
                            </button>
                            <button type="button" onclick="bulkAction('reject')" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                <i class="fas fa-times mr-1"></i>
                                Tolak
                            </button>
                            <button type="button" onclick="bulkAction('delete')" class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" onchange="toggleSelectAll()">
                            </th>
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
                                    <input type="checkbox" class="request-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $request->id }}" onchange="updateBulkActions()">
                                </td>
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
                                        <button type="button" onclick="openStatusModal({{ $request->id }}, '{{ $request->status }}', '{{ $request->request_number }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200 hover:scale-110" style="background-color: #e0f2fe; color: #0277bd;" title="Ubah Status">
                                            <i class="fas fa-exchange-alt text-xs"></i>
                                        </button>
                                        @if($request->status === 'approved' || $request->status === 'completed')
                                        <button type="button" onclick="openDocumentModal({{ $request->id }}, '{{ $request->request_number }}', '{{ $request->citizen->name }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200 hover:scale-110" style="background-color: #f0f9ff; color: #0369a1;" title="Generate Dokumen">
                                            <i class="fas fa-file-pdf text-xs"></i>
                                        </button>
                                        @endif
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
                                <td colspan="6" class="px-4 sm:px-6 py-12 text-center">
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
                    <div class="mobile-card-container" data-request-id="{{ $request->id }}">
                        <!-- Swipe Actions (Hidden behind card) -->
                        <div class="mobile-card-actions">
                            <a href="{{ route('admin.service-requests.show', $request) }}" class="mobile-action-btn mobile-action-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.service-requests.edit', $request) }}" class="mobile-action-btn mobile-action-edit" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($request->status == 'pending')
                                <button onclick="approveRequest({{ $request->id }})" class="mobile-action-btn mobile-action-approve" title="Setujui">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button onclick="rejectRequest({{ $request->id }})" class="mobile-action-btn mobile-action-reject" title="Tolak">
                                    <i class="fas fa-times"></i>
                                </button>
                            @else
                                <form action="{{ route('admin.service-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mobile-action-btn mobile-action-delete" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Swipe Indicator -->
                        <div class="swipe-indicator">
                            <i class="fas fa-chevron-left text-gray-400"></i>
                        </div>

                        <!-- Card Content -->
                        <div class="mobile-card-content mobile-touch-target">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3" style="background-color: #e6f3ff;">
                                        <i class="fas fa-file-alt text-lg" style="color: #003566;"></i>
                                    </div>
                                    <div>
                                        <h4 class="mobile-card-title">{{ $request->request_number }}</h4>
                                        <p class="mobile-card-subtitle">{{ $request->applicant_name }}</p>
                                    </div>
                                </div>
                                @if($request->status == 'pending')
                                    <span class="mobile-status-badge" style="background-color: #fef3c7; color: #d97706;">
                                        <i class="fas fa-clock"></i>
                                        Menunggu
                                    </span>
                                @elseif($request->status == 'processing')
                                    <span class="mobile-status-badge" style="background-color: #dbeafe; color: #2563eb;">
                                        <i class="fas fa-cog"></i>
                                        Diproses
                                    </span>
                                @elseif($request->status == 'completed')
                                    <span class="mobile-status-badge" style="background-color: #ecfdf5; color: #10b981;">
                                        <i class="fas fa-check-circle"></i>
                                        Selesai
                                    </span>
                                @else
                                    <span class="mobile-status-badge" style="background-color: #fef2f2; color: #ef4444;">
                                        <i class="fas fa-times-circle"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <span class="mobile-card-label">Jenis Layanan</span>
                                    <p class="mobile-card-info font-medium">{{ $request->service_type_display }}</p>
                                </div>
                                <div>
                                    <span class="mobile-card-label">NIK Pemohon</span>
                                    <p class="mobile-card-info font-medium">{{ $request->applicant_nik }}</p>
                                </div>
                            </div>

                            @if($request->purpose)
                                <div class="mb-4">
                                    <span class="mobile-card-label">Keperluan</span>
                                    <p class="mobile-card-info">{{ $request->purpose }}</p>
                                </div>
                            @endif

                            <div class="mb-2">
                                <span class="mobile-card-label">Tanggal Dibuat</span>
                                <p class="mobile-card-info">{{ $request->created_at->format('d/m/Y H:i') }}</p>
                            </div>
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

    <!-- Status Change Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Ubah Status Permintaan</h3>
                    <button type="button" onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="statusForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Permintaan</label>
                        <input type="text" id="requestNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="newStatus" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                        <select name="status" id="newStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="pending">Menunggu</option>
                            <option value="processing">Diproses</option>
                            <option value="approved">Disetujui</option>
                            <option value="completed">Selesai</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="statusNotes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" id="statusNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan catatan untuk perubahan status..."></textarea>
                    </div>

                    <div id="rejectionReasonDiv" class="mb-4 hidden">
                        <label for="rejectionReason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea name="rejection_reason" id="rejectionReason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
     </div>

     <!-- Document Generation Modal -->
     <div id="documentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
         <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
             <div class="mt-3">
                 <div class="flex items-center justify-between mb-4">
                     <h3 class="text-lg font-medium text-gray-900">Generate Dokumen</h3>
                     <button type="button" onclick="closeDocumentModal()" class="text-gray-400 hover:text-gray-600">
                         <i class="fas fa-times"></i>
                     </button>
                 </div>

                 <form id="documentForm" method="POST">
                     @csrf
                     <div class="mb-4">
                         <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Permintaan</label>
                         <input type="text" id="docRequestNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                     </div>

                     <div class="mb-4">
                         <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemohon</label>
                         <input type="text" id="docCitizenName" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                     </div>

                     <div class="mb-4">
                         <label for="templateSelect" class="block text-sm font-medium text-gray-700 mb-2">Template Dokumen <span class="text-red-500">*</span></label>
                         <select name="template_name" id="templateSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                             <option value="">Pilih Template</option>
                             <option value="surat_keterangan_domisili">Surat Keterangan Domisili</option>
                             <option value="surat_keterangan_usaha">Surat Keterangan Usaha</option>
                             <option value="surat_keterangan_tidak_mampu">Surat Keterangan Tidak Mampu</option>
                             <option value="surat_keterangan_kelahiran">Surat Keterangan Kelahiran</option>
                             <option value="surat_keterangan_kematian">Surat Keterangan Kematian</option>
                             <option value="surat_pengantar_nikah">Surat Pengantar Nikah</option>
                             <option value="surat_keterangan_beda_nama">Surat Keterangan Beda Nama</option>
                             <option value="surat_keterangan_penghasilan">Surat Keterangan Penghasilan</option>
                             <option value="surat_rekomendasi">Surat Rekomendasi</option>
                         </select>
                     </div>

                     <div class="mb-4">
                         <label for="documentTitle" class="block text-sm font-medium text-gray-700 mb-2">Judul Dokumen</label>
                         <input type="text" name="document_title" id="documentTitle" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul dokumen...">
                     </div>

                     <div class="mb-4">
                         <label for="validUntil" class="block text-sm font-medium text-gray-700 mb-2">Berlaku Sampai</label>
                         <input type="date" name="valid_until" id="validUntil" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="{{ date('Y-m-d') }}">
                     </div>

                     <div class="mb-4">
                         <label for="documentNotes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                         <textarea name="notes" id="documentNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan catatan untuk dokumen..."></textarea>
                     </div>

                     <div class="flex justify-end space-x-3">
                         <button type="button" onclick="closeDocumentModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md transition-colors duration-200">
                             Batal
                         </button>
                         <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                             <i class="fas fa-file-pdf mr-2"></i>Generate Dokumen
                         </button>
                     </div>
                 </form>
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
        function showExportLoading(element) {
            const originalText = element.innerHTML;
            element.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengunduh...';
            element.style.pointerEvents = 'none';

            // Reset after 3 seconds
            setTimeout(() => {
                element.innerHTML = originalText;
                element.style.pointerEvents = 'auto';
            }, 3000);
        }

        // Bulk Actions functionality
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.request-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            updateBulkActions();
        }

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.request-checkbox:checked');
            const bulkActionsBar = document.getElementById('bulkActionsBar');
            const selectedCount = document.getElementById('selectedCount');
            const selectAllCheckbox = document.getElementById('selectAll');

            const count = checkboxes.length;

            if (count > 0) {
                bulkActionsBar.classList.remove('hidden');
                selectedCount.textContent = `${count} item dipilih`;
            } else {
                bulkActionsBar.classList.add('hidden');
            }

            // Update select all checkbox state
            const allCheckboxes = document.querySelectorAll('.request-checkbox');
            if (count === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (count === allCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }

        function bulkAction(action) {
            const checkboxes = document.querySelectorAll('.request-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) {
                alert('Pilih minimal satu item untuk diproses.');
                return;
            }

            let message = '';
            let url = '';

            switch(action) {
                case 'approve':
                    message = `Apakah Anda yakin ingin menyetujui ${ids.length} permintaan?`;
                    url = '{{ route("admin.service-requests.bulk-approve") }}';
                    break;
                case 'process':
                    message = `Apakah Anda yakin ingin memproses ${ids.length} permintaan?`;
                    url = '{{ route("admin.service-requests.bulk-process") }}';
                    break;
                case 'reject':
                    const reason = prompt('Masukkan alasan penolakan:');
                    if (!reason) return;
                    message = `Apakah Anda yakin ingin menolak ${ids.length} permintaan?`;
                    url = '{{ route("admin.service-requests.bulk-reject") }}';
                    break;
                case 'delete':
                    message = `Apakah Anda yakin ingin menghapus ${ids.length} permintaan? Tindakan ini tidak dapat dibatalkan.`;
                    url = '{{ route("admin.service-requests.bulk-delete") }}';
                    break;
            }

            if (confirm(message)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add IDs
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                // Add reason for reject action
                if (action === 'reject' && reason) {
                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reason';
                    reasonInput.value = reason;
                    form.appendChild(reasonInput);
                }

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Status Modal Functions
        function openStatusModal(requestId, currentStatus, requestNumber) {
            document.getElementById('statusModal').classList.remove('hidden');
            document.getElementById('requestNumber').value = requestNumber;
            document.getElementById('newStatus').value = currentStatus;
            document.getElementById('statusForm').action = `/admin/service-requests/${requestId}/update-status`;

            // Reset form
            document.getElementById('statusNotes').value = '';
            document.getElementById('rejectionReason').value = '';
            document.getElementById('rejectionReasonDiv').classList.add('hidden');

            // Show/hide rejection reason based on current status
            toggleRejectionReason();
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function toggleRejectionReason() {
            const status = document.getElementById('newStatus').value;
            const rejectionDiv = document.getElementById('rejectionReasonDiv');
            const rejectionTextarea = document.getElementById('rejectionReason');

            if (status === 'rejected') {
                rejectionDiv.classList.remove('hidden');
                rejectionTextarea.required = true;
            } else {
                rejectionDiv.classList.add('hidden');
                rejectionTextarea.required = false;
                rejectionTextarea.value = '';
            }
        }

        // Event listeners for status modal
        document.addEventListener('DOMContentLoaded', function() {
            const newStatusSelect = document.getElementById('newStatus');
            const statusModal = document.getElementById('statusModal');
            const statusForm = document.getElementById('statusForm');

            if (newStatusSelect) {
                newStatusSelect.addEventListener('change', toggleRejectionReason);
            }

            // Close modal when clicking outside
            if (statusModal) {
                statusModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeStatusModal();
                    }
                });
            }

            // Handle form submission
            if (statusForm) {
                statusForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const url = this.action;

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            closeStatusModal();
                            location.reload();
                        } else {
                            alert(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status');
                    });
                });
            }
         });

         // Document Modal Functions
         function openDocumentModal(requestId, requestNumber, citizenName) {
             document.getElementById('documentModal').classList.remove('hidden');
             document.getElementById('docRequestNumber').value = requestNumber;
             document.getElementById('docCitizenName').value = citizenName;
             document.getElementById('documentForm').action = `/admin/service-requests/${requestId}/generate-document`;

             // Reset form
             document.getElementById('templateSelect').value = '';
             document.getElementById('documentTitle').value = '';
             document.getElementById('validUntil').value = '';
             document.getElementById('documentNotes').value = '';
         }

         function closeDocumentModal() {
             document.getElementById('documentModal').classList.add('hidden');
         }

         // Auto-fill document title based on template selection
         document.addEventListener('DOMContentLoaded', function() {
             const templateSelect = document.getElementById('templateSelect');
             const documentTitleInput = document.getElementById('documentTitle');
             const documentModal = document.getElementById('documentModal');
             const documentForm = document.getElementById('documentForm');

             if (templateSelect && documentTitleInput) {
                 templateSelect.addEventListener('change', function() {
                     const selectedOption = this.options[this.selectedIndex];
                     if (selectedOption.value) {
                         documentTitleInput.value = selectedOption.text;
                     } else {
                         documentTitleInput.value = '';
                     }
                 });
             }

             // Close modal when clicking outside
             if (documentModal) {
                 documentModal.addEventListener('click', function(e) {
                     if (e.target === this) {
                         closeDocumentModal();
                     }
                 });
             }

             // Handle document form submission
             if (documentForm) {
                 documentForm.addEventListener('submit', function(e) {
                     e.preventDefault();

                     const formData = new FormData(this);
                     const url = this.action;

                     // Show loading state
                     const submitButton = this.querySelector('button[type="submit"]');
                     const originalText = submitButton.innerHTML;
                     submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';
                     submitButton.disabled = true;

                     fetch(url, {
                         method: 'POST',
                         body: formData,
                         headers: {
                             'X-Requested-With': 'XMLHttpRequest'
                         }
                     })
                     .then(response => {
                         if (response.ok) {
                             return response.blob();
                         }
                         throw new Error('Network response was not ok');
                     })
                     .then(blob => {
                         // Create download link
                         const url = window.URL.createObjectURL(blob);
                         const a = document.createElement('a');
                         a.style.display = 'none';
                         a.href = url;
                         a.download = 'dokumen.pdf';
                         document.body.appendChild(a);
                         a.click();
                         window.URL.revokeObjectURL(url);

                         closeDocumentModal();
                         alert('Dokumen berhasil dibuat dan diunduh!');
                     })
                     .catch(error => {
                         console.error('Error:', error);
                         alert('Terjadi kesalahan saat membuat dokumen');
                     })
                     .finally(() => {
                         // Reset button state
                         submitButton.innerHTML = originalText;
                         submitButton.disabled = false;
                     });
                 });
             }
         });


         // Notification System
         let notificationInterval = null;
         let isNotificationDropdownOpen = false;

         function loadNotifications() {
             fetch('/notifications')
                 .then(response => response.json())
                 .then(data => {
                     updateNotificationBadge(data.unread_count);
                     updateNotificationList(data.notifications);
                 })
                 .catch(error => {
                     console.error('Error loading notifications:', error);
                     updateConnectionStatus(false);
                 });
         }

         function updateNotificationBadge(count) {
             const badge = document.getElementById('notificationBadge');
             if (count > 0) {
                 badge.textContent = count > 99 ? '99+' : count;
                 badge.classList.remove('hidden');
             } else {
                 badge.classList.add('hidden');
             }
         }

         function updateNotificationList(notifications) {
             const list = document.getElementById('notificationList');

             if (notifications.length === 0) {
                 list.innerHTML = `
                     <div class="p-4 text-center text-gray-500">
                         <i class="fas fa-bell-slash text-2xl mb-2"></i>
                         <p>Tidak ada notifikasi baru</p>
                     </div>
                 `;
                 return;
             }

             list.innerHTML = notifications.map(notification => {
                 const priorityColor = {
                     'high': 'text-red-600',
                     'medium': 'text-yellow-600',
                     'low': 'text-green-600'
                 }[notification.priority] || 'text-gray-600';

                 const typeIcon = {
                     'service_request': 'fa-file-alt',
                     'status_change': 'fa-exchange-alt',
                     'document_ready': 'fa-file-pdf',
                     'system': 'fa-cog'
                 }[notification.type] || 'fa-bell';

                 return `
                     <div class="notification-item p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer ${
                         notification.is_read ? 'opacity-60' : ''
                     }" data-notification-id="${notification.id}" data-action-url="${notification.action_url || ''}">
                         <div class="flex items-start space-x-3">
                             <div class="flex-shrink-0">
                                 <i class="fas ${typeIcon} ${priorityColor}"></i>
                             </div>
                             <div class="flex-1 min-w-0">
                                 <p class="text-sm font-medium text-gray-900 truncate">
                                     ${notification.title}
                                 </p>
                                 <p class="text-sm text-gray-600 mt-1">
                                     ${notification.message}
                                 </p>
                                 <p class="text-xs text-gray-400 mt-1">
                                     ${notification.created_at}
                                 </p>
                             </div>
                             ${!notification.is_read ? '<div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>' : ''}
                         </div>
                     </div>
                 `;
             }).join('');

             // Add click handlers for notifications
             document.querySelectorAll('.notification-item').forEach(item => {
                 item.addEventListener('click', function() {
                     const notificationId = this.dataset.notificationId;
                     const actionUrl = this.dataset.actionUrl;

                     markNotificationAsRead(notificationId);

                     if (actionUrl) {
                         window.location.href = actionUrl;
                     }
                 });
             });
         }

         function markNotificationAsRead(notificationId) {
             fetch(`/notifications/${notificationId}/read`, {
                 method: 'POST',
                 headers: {
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                     'Content-Type': 'application/json'
                 }
             })
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     loadNotifications(); // Refresh notifications
                 }
             })
             .catch(error => {
                 console.error('Error marking notification as read:', error);
             });
         }

         function markAllNotificationsAsRead() {
             fetch('/notifications/mark-all-read', {
                 method: 'POST',
                 headers: {
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                     'Content-Type': 'application/json'
                 }
             })
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     loadNotifications(); // Refresh notifications
                 }
             })
             .catch(error => {
                 console.error('Error marking all notifications as read:', error);
             });
         }

         function updateConnectionStatus(isConnected) {
             const status = document.getElementById('connectionStatus');
             if (isConnected) {
                 status.className = 'w-3 h-3 rounded-full bg-green-500';
             } else {
                 status.className = 'w-3 h-3 rounded-full bg-red-500';
             }
         }

         // Notification bell click handler
         document.getElementById('notificationBell').addEventListener('click', function() {
             const dropdown = document.getElementById('notificationDropdown');
             isNotificationDropdownOpen = !isNotificationDropdownOpen;

             if (isNotificationDropdownOpen) {
                 dropdown.classList.remove('hidden');
                 loadNotifications(); // Refresh when opening
             } else {
                 dropdown.classList.add('hidden');
             }
         });

         // Mark all read button handler
         document.getElementById('markAllRead').addEventListener('click', function() {
             markAllNotificationsAsRead();
         });

         // Close dropdown when clicking outside
         document.addEventListener('click', function(e) {
             const bell = document.getElementById('notificationBell');
             const dropdown = document.getElementById('notificationDropdown');

             if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
                 dropdown.classList.add('hidden');
                 isNotificationDropdownOpen = false;
             }
         });

         // Start real-time notification polling
         function startNotificationPolling() {
             loadNotifications(); // Initial load
             notificationInterval = setInterval(() => {
                 if (!isNotificationDropdownOpen) {
                     loadNotifications();
                 }
             }, 30000); // Poll every 30 seconds
         }

         // Stop polling when page is hidden
         document.addEventListener('visibilitychange', function() {
             if (document.hidden) {
                 if (notificationInterval) {
                     clearInterval(notificationInterval);
                 }
             } else {
                 startNotificationPolling();
             }
         });

         // Start notification system
         startNotificationPolling();



         // Mobile Swipe Functionality
         let startX = 0;
         let currentX = 0;
         let cardBeingDragged = null;
         let isDragging = false;
         let pullToRefreshTriggered = false;
         let startY = 0;
         let currentY = 0;

         // Touch event handlers for swipe actions
         document.addEventListener('touchstart', handleTouchStart, { passive: false });
         document.addEventListener('touchmove', handleTouchMove, { passive: false });
         document.addEventListener('touchend', handleTouchEnd, { passive: false });

         function handleTouchStart(e) {
             const card = e.target.closest('.mobile-card-container');
             if (!card) return;

             startX = e.touches[0].clientX;
             startY = e.touches[0].clientY;
             cardBeingDragged = card;
             isDragging = false;
         }

         function handleTouchMove(e) {
             if (!cardBeingDragged) {
                 // Check for pull to refresh
                 if (window.scrollY === 0 && e.touches[0].clientY > startY + 50) {
                     e.preventDefault();
                     showPullToRefresh();
                 }
                 return;
             }

             currentX = e.touches[0].clientX;
             currentY = e.touches[0].clientY;
             const deltaX = currentX - startX;
             const deltaY = currentY - startY;

             // Only start dragging if horizontal movement is greater than vertical
             if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 10) {
                 isDragging = true;
                 e.preventDefault();

                 // Only allow left swipe (negative deltaX)
                 if (deltaX < 0) {
                     const cardContent = cardBeingDragged.querySelector('.mobile-card-content');
                     const maxSwipe = -120; // Maximum swipe distance
                     const swipeDistance = Math.max(deltaX, maxSwipe);

                     cardContent.style.transform = `translateX(${swipeDistance}px)`;

                     // Show actions when swiped enough
                     if (swipeDistance < -60) {
                         cardBeingDragged.classList.add('actions-visible');
                     } else {
                         cardBeingDragged.classList.remove('actions-visible');
                     }
                 }
             }
         }

         function handleTouchEnd(e) {
             if (!cardBeingDragged) {
                 hidePullToRefresh();
                 return;
             }

             const deltaX = currentX - startX;
             const cardContent = cardBeingDragged.querySelector('.mobile-card-content');

             if (isDragging) {
                 // Snap to position based on swipe distance
                 if (deltaX < -60) {
                     // Snap to show actions
                     cardContent.style.transform = 'translateX(-120px)';
                     cardBeingDragged.classList.add('actions-visible');
                 } else {
                     // Snap back to original position
                     cardContent.style.transform = 'translateX(0)';
                     cardBeingDragged.classList.remove('actions-visible');
                 }
             } else if (Math.abs(deltaX) < 10 && Math.abs(currentY - startY) < 10) {
                 // This was a tap, not a swipe - navigate to detail page
                 const requestId = cardBeingDragged.dataset.requestId;
                 if (requestId) {
                     window.location.href = `/admin/service-requests/${requestId}`;
                 }
             }

             // Reset
             cardBeingDragged = null;
             isDragging = false;
             startX = 0;
             currentX = 0;
         }

         // Close any open swipe actions when tapping elsewhere
         document.addEventListener('click', function(e) {
             if (!e.target.closest('.mobile-card-container')) {
                 document.querySelectorAll('.mobile-card-container.actions-visible').forEach(card => {
                     const cardContent = card.querySelector('.mobile-card-content');
                     cardContent.style.transform = 'translateX(0)';
                     card.classList.remove('actions-visible');
                 });
             }
         });

         // Pull to refresh functionality
         function showPullToRefresh() {
             if (pullToRefreshTriggered) return;

             let refreshIndicator = document.querySelector('.pull-to-refresh');
             if (!refreshIndicator) {
                 refreshIndicator = document.createElement('div');
                 refreshIndicator.className = 'pull-to-refresh';
                 refreshIndicator.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Tarik untuk memperbarui';
                 document.body.appendChild(refreshIndicator);
             }

             refreshIndicator.classList.add('active');
             pullToRefreshTriggered = true;

             // Auto refresh after 1 second
             setTimeout(() => {
                 refreshIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';
                 setTimeout(() => {
                     window.location.reload();
                 }, 1000);
             }, 1000);
         }

         function hidePullToRefresh() {
             const refreshIndicator = document.querySelector('.pull-to-refresh');
             if (refreshIndicator && !pullToRefreshTriggered) {
                 refreshIndicator.classList.remove('active');
             }
         }

         // Quick action functions
         function approveRequest(requestId) {
             if (confirm('Apakah Anda yakin ingin menyetujui permintaan ini?')) {
                 // Create and submit form
                 const form = document.createElement('form');
                 form.method = 'POST';
                 form.action = `/admin/service-requests/${requestId}/approve`;

                 const csrfToken = document.createElement('input');
                 csrfToken.type = 'hidden';
                 csrfToken.name = '_token';
                 csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                 form.appendChild(csrfToken);
                 document.body.appendChild(form);
                 form.submit();
             }
         }

         function rejectRequest(requestId) {
             const reason = prompt('Masukkan alasan penolakan:');
             if (reason && reason.trim()) {
                 // Create and submit form
                 const form = document.createElement('form');
                 form.method = 'POST';
                 form.action = `/admin/service-requests/${requestId}/reject`;

                 const csrfToken = document.createElement('input');
                 csrfToken.type = 'hidden';
                 csrfToken.name = '_token';
                 csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                 const reasonInput = document.createElement('input');
                 reasonInput.type = 'hidden';
                 reasonInput.name = 'rejection_reason';
                 reasonInput.value = reason;

                 form.appendChild(csrfToken);
                 form.appendChild(reasonInput);
                 document.body.appendChild(form);
                 form.submit();
             }
         }

         // Add haptic feedback for supported devices
         function triggerHapticFeedback() {
             if ('vibrate' in navigator) {
                 navigator.vibrate(50);
             }
         }

         // Add haptic feedback to action buttons
         document.addEventListener('touchstart', function(e) {
             if (e.target.closest('.mobile-action-btn')) {
                 triggerHapticFeedback();
             }
         });
     </script>

     <!-- Chart.js CDN -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     @endpush
</x-admin-layout>
