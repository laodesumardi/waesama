<x-admin-layout>
    <x-slot name="header">
        Data Penduduk
    </x-slot>

    <!-- Welcome Section -->
    <div class="mb-6 md:mb-8">
        <div class="admin-card admin-welcome-card rounded-xl shadow-lg p-4 sm:p-6 lg:p-8 bg-[#001d3d]">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-white text-center sm:text-left">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">Data Penduduk</h2>
                    <p class="text-blue-100 text-base sm:text-lg lg:text-xl">Kelola data penduduk dengan mudah dan efisien</p>
                    <p class="text-blue-200 text-xs sm:text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
                </div>
                <div class="text-white">
                    <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-3 sm:p-4 text-center">
                        <i class="fas fa-users text-2xl sm:text-3xl mb-2 block"></i>
                        <p class="text-xs sm:text-sm font-medium">Manajemen Warga</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row gap-4 justify-center sm:justify-start">
            <a href="{{ route('admin.citizens.create') }}" class="admin-action-btn flex items-center justify-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group bg-white">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #e6f3ff;">
                    <i class="fas fa-user-plus text-sm sm:text-base" style="color: #003566;"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900 text-sm sm:text-base">Tambah Penduduk</p>
                    <p class="text-xs sm:text-sm text-gray-500">Data baru</p>
                </div>
            </a>
            
            <div class="relative">
                <button type="button" class="admin-action-btn flex items-center justify-center p-3 sm:p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-green-300 hover:bg-green-50 transition-all duration-300 group bg-white dropdown-toggle w-full" data-toggle="dropdown">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300" style="background-color: #f0fdf4;">
                        <i class="fas fa-file-excel text-sm sm:text-base" style="color: #16a34a;"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm sm:text-base">Kelola Excel</p>
                        <p class="text-xs sm:text-sm text-gray-500">Import/Export</p>
                    </div>
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-2 bg-white/95 backdrop-blur-sm border border-gray-200/50 rounded-xl shadow-xl">
                    <a class="dropdown-item hover:bg-blue-50 transition-colors duration-200 rounded-lg mx-2 my-1" href="{{ route('admin.citizens.export', request()->query()) }}" onclick="showExportLoading(this)">
                        <i class="fas fa-download mr-3 text-blue-600"></i>Export Data
                    </a>
                    <a class="dropdown-item hover:bg-green-50 transition-colors duration-200 rounded-lg mx-2 my-1" href="#" onclick="openImportModal()">
                        <i class="fas fa-upload mr-3 text-green-600"></i>Import Data
                    </a>
                    <hr class="border-gray-200 mx-2">
                    <a class="dropdown-item hover:bg-purple-50 transition-colors duration-200 rounded-lg mx-2 my-1" href="{{ route('admin.citizens.template') }}">
                        <i class="fas fa-file-download mr-3 text-purple-600"></i>Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="mb-6 md:mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 md:gap-6">
            <div class="admin-card admin-stat-card bg-white rounded-xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center mr-3 sm:mr-4" style="background-color: #e6f3ff;">
                        <i class="fas fa-users text-lg sm:text-xl" style="color: #003566;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Penduduk</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold" style="color: #003566;">{{ number_format($stats['total']) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="admin-card admin-stat-card bg-white rounded-xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center mr-3 sm:mr-4" style="background-color: #f0fdf4;">
                        <i class="fas fa-male text-lg sm:text-xl" style="color: #16a34a;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Laki-laki</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold" style="color: #16a34a;">{{ number_format($stats['male']) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="admin-card admin-stat-card bg-white rounded-xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center mr-3 sm:mr-4" style="background-color: #fdf2f8;">
                        <i class="fas fa-female text-lg sm:text-xl" style="color: #ec4899;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Perempuan</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold" style="color: #ec4899;">{{ number_format($stats['female']) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="admin-card admin-stat-card bg-white rounded-xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center mr-3 sm:mr-4" style="background-color: #ecfdf5;">
                        <i class="fas fa-check-circle text-lg sm:text-xl" style="color: #10b981;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Aktif</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold" style="color: #10b981;">{{ number_format($stats['active']) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="admin-card admin-stat-card bg-white rounded-xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center mr-3 sm:mr-4" style="background-color: #fef2f2;">
                        <i class="fas fa-times-circle text-lg sm:text-xl" style="color: #ef4444;"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Tidak Aktif</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold" style="color: #ef4444;">{{ number_format($stats['inactive']) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Charts -->
    <div class="mb-6 md:mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Age Distribution Chart -->
            <div class="admin-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Usia</h3>
                    <i class="fas fa-chart-bar text-blue-600"></i>
                </div>
                <div class="h-64">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>

            <!-- Gender Distribution Chart -->
            <div class="admin-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Jenis Kelamin</h3>
                    <i class="fas fa-chart-pie text-pink-600"></i>
                </div>
                <div class="h-64">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Religion Distribution Chart -->
            <div class="admin-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Agama</h3>
                    <i class="fas fa-chart-doughnut text-purple-600"></i>
                </div>
                <div class="h-64">
                    <canvas id="religionChart"></canvas>
                </div>
            </div>

            <!-- Village Distribution Chart -->
            <div class="admin-card bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi per Desa</h3>
                    <i class="fas fa-chart-bar text-green-600"></i>
                </div>
                <div class="h-64">
                    <canvas id="villageChart"></canvas>
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

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter dan Pencarian -->
    <div class="admin-card bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 md:mb-8">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Filter & Pencarian Data</h3>
            <p class="text-sm text-gray-600">Gunakan filter di bawah untuk mencari data penduduk</p>
        </div>
        
        <form method="GET" action="{{ route('admin.citizens.index') }}" class="space-y-6">
            <!-- Basic Search -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian Umum</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama, NIK, Alamat, Telepon..." class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="village_id" class="block text-sm font-medium text-gray-700 mb-2">Desa</label>
                    <select name="village_id" id="village_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Desa</option>
                        @foreach($villages as $village)
                            <option value="{{ $village->id }}" {{ request('village_id') == $village->id ? 'selected' : '' }}>
                                {{ $village->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-all duration-200 font-medium">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    <a href="{{ route('admin.citizens.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition-all duration-200" title="Reset Filter">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="border-t border-gray-200 pt-6">
                <button type="button" id="toggleAdvanced" class="flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium mb-4 transition-colors duration-200">
                    <i class="fas fa-filter mr-2"></i>Filter Lanjutan
                    <i class="fas fa-chevron-down ml-2 transition-transform duration-200" id="filterChevron"></i>
                </button>
                
                <div id="advancedFilters" class="{{ request()->hasAny(['gender', 'marital_status', 'religion', 'age_from', 'age_to', 'sort_by']) ? '' : 'hidden' }} space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan</label>
                            <select name="marital_status" id="marital_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="Belum Kawin" {{ request('marital_status') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ request('marital_status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ request('marital_status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ request('marital_status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                            <select name="religion" id="religion" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="Islam" {{ request('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ request('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ request('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ request('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ request('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ request('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Usia</label>
                            <div class="flex space-x-3">
                                <input type="number" name="age_from" placeholder="Usia minimum" value="{{ request('age_from') }}" min="0" max="100" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="flex items-center text-gray-500">-</span>
                                <input type="number" name="age_to" placeholder="Usia maksimum" value="{{ request('age_to') }}" min="0" max="100" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-2">Urutkan Berdasarkan</label>
                            <div class="flex space-x-2">
                                <select name="sort_by" id="sort_by" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                                    <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                                    <option value="birth_date" {{ request('sort_by') == 'birth_date' ? 'selected' : '' }}>Tanggal Lahir</option>
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                </select>
                                <select name="sort_order" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z</option>
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions Bar -->
    <div id="bulkActionsBar" class="admin-card bg-blue-50 border border-blue-200 rounded-xl shadow-lg p-4 mb-4 hidden">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center">
                <i class="fas fa-check-square text-blue-600 mr-2"></i>
                <span class="text-sm font-medium text-blue-900">
                    <span id="selectedCount">0</span> data terpilih
                </span>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="bulkActivate()" class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-check-circle mr-2"></i>
                    Aktifkan
                </button>
                <button type="button" onclick="bulkDeactivate()" class="inline-flex items-center px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-pause-circle mr-2"></i>
                    Nonaktifkan
                </button>
                <button type="button" onclick="bulkExport()" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
                <button type="button" onclick="bulkDelete()" class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus
                </button>
                <button type="button" onclick="clearSelection()" class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="admin-card bg-white rounded-xl shadow-lg overflow-hidden mb-6 md:mb-8">
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Data Penduduk</h3>
                    <p class="text-sm text-gray-600 mt-1">Menampilkan {{ $citizens->count() }} dari {{ $citizens->total() }} data</p>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-table"></i>
                    <span>Tabel Data</span>
                </div>
            </div>
        </div>
        
        <div class="admin-table-responsive overflow-x-auto">
            <table class="admin-table min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" onchange="toggleSelectAll()">
                                <label for="selectAll" class="ml-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">Pilih</label>
                            </div>
                        </th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIK</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Desa</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 sm:px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($citizens as $citizen)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="citizen-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $citizen->id }}" onchange="updateBulkActions()">
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $citizen->nik }}</div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #e6f3ff;">
                                        <i class="fas fa-user text-sm" style="color: #003566;"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $citizen->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $citizen->birth_place }}, {{ $citizen->birth_date ? $citizen->birth_date->format('d/m/Y') : '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($citizen->gender == 'L')
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-2" style="background-color: #f0fdf4;">
                                            <i class="fas fa-male text-xs" style="color: #16a34a;"></i>
                                        </div>
                                        <span class="text-sm text-gray-900">Laki-laki</span>
                                    @else
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-2" style="background-color: #fdf2f8;">
                                            <i class="fas fa-female text-xs" style="color: #ec4899;"></i>
                                        </div>
                                        <span class="text-sm text-gray-900">Perempuan</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $citizen->village->name }}</div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if($citizen->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: #ecfdf5; color: #10b981;">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" style="background-color: #fef2f2; color: #ef4444;">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.citizens.show', $citizen) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200 hover:scale-110" style="background-color: #e6f3ff; color: #003566;" title="Lihat Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.citizens.edit', $citizen) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200 hover:scale-110" style="background-color: #fef3c7; color: #d97706;" title="Edit Data">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.citizens.destroy', $citizen) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                            <td colspan="7" class="px-4 sm:px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" style="background-color: #f3f4f6;">
                                        <i class="fas fa-users text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data penduduk</h3>
                                    <p class="text-sm text-gray-500 mb-4">Belum ada data penduduk yang tersedia atau sesuai dengan filter yang dipilih.</p>
                                    <a href="{{ route('admin.citizens.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Penduduk Pertama
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
            @forelse($citizens as $citizen)
                <div class="p-4 border-b border-gray-200 last:border-b-0">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <input type="checkbox" class="citizen-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-3" value="{{ $citizen->id }}" onchange="updateBulkActions()">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #e6f3ff;">
                                <i class="fas fa-user text-sm" style="color: #003566;"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $citizen->name }}</h4>
                                <p class="text-xs text-gray-500">NIK: {{ $citizen->nik }}</p>
                            </div>
                        </div>
                        @if($citizen->is_active)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: #ecfdf5; color: #10b981;">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: #fef2f2; color: #ef4444;">
                                <i class="fas fa-times-circle mr-1"></i>
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                        <div>
                            <span class="text-gray-500 text-xs">Jenis Kelamin</span>
                            <div class="flex items-center mt-1">
                                @if($citizen->gender == 'L')
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2" style="background-color: #f0fdf4;">
                                        <i class="fas fa-male text-xs" style="color: #16a34a;"></i>
                                    </div>
                                    <span class="text-gray-900 text-sm">Laki-laki</span>
                                @else
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2" style="background-color: #fdf2f8;">
                                        <i class="fas fa-female text-xs" style="color: #ec4899;"></i>
                                    </div>
                                    <span class="text-gray-900 text-sm">Perempuan</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs">Desa</span>
                            <p class="text-gray-900 text-sm mt-1">{{ $citizen->village->name }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-gray-500 text-xs">Tempat, Tanggal Lahir</span>
                        <p class="text-gray-900 text-sm mt-1">{{ $citizen->birth_place }}, {{ $citizen->birth_date ? $citizen->birth_date->format('d/m/Y') : '-' }}</p>
                    </div>
                    
                    <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100">
                        <a href="{{ route('admin.citizens.show', $citizen) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200" style="background-color: #e6f3ff; color: #003566;" title="Lihat Detail">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('admin.citizens.edit', $citizen) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200" style="background-color: #fef3c7; color: #d97706;" title="Edit Data">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <form action="{{ route('admin.citizens.destroy', $citizen) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                        <i class="fas fa-users text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data penduduk</h3>
                    <p class="text-sm text-gray-500 mb-4">Belum ada data penduduk yang tersedia atau sesuai dengan filter yang dipilih.</p>
                    <a href="{{ route('admin.citizens.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Penduduk Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-4 sm:p-6 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $citizens->firstItem() ?? 0 }} - {{ $citizens->lastItem() ?? 0 }} dari {{ $citizens->total() }} data
                </div>
                <div>
                    {{ $citizens->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="relative mx-auto p-0 border-0 shadow-2xl rounded-xl bg-white max-w-md w-full mx-4">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: #e6f3ff;">
                        <i class="fas fa-file-import text-lg" style="color: #003566;"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Import Data Penduduk</h3>
                </div>
                <button type="button" onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="importForm" action="{{ route('admin.citizens.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- File Upload Section -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih File Excel/CSV</label>
                        <div class="relative">
                            <input type="file" id="fileInput" name="file" accept=".xlsx,.xls,.csv" class="hidden" required onchange="updateFileName()">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors duration-200 cursor-pointer" onclick="document.getElementById('fileInput').click()">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 mb-1">Klik untuk memilih file atau drag & drop</p>
                                    <p class="text-xs text-gray-500">Format: .xlsx, .xls, .csv (Maks. 2MB)</p>
                                </div>
                            </div>
                            <div id="fileName" class="mt-2 text-sm text-gray-600 hidden">
                                <i class="fas fa-file-excel mr-2 text-green-600"></i>
                                <span id="fileNameText"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Download Template Section -->
                    <div class="mb-6 p-4 rounded-lg" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-download text-blue-600 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Template Excel</span>
                            </div>
                            <a href="{{ route('admin.citizens.template') }}" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200" style="background-color: #e6f3ff; color: #003566;" onmouseover="this.style.backgroundColor='#cce7ff'" onmouseout="this.style.backgroundColor='#e6f3ff'">
                                <i class="fas fa-download mr-1"></i>
                                Download
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Download template untuk format yang benar</p>
                    </div>

                    <!-- Instructions Section -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Petunjuk Import
                        </h4>
                        <div class="space-y-2">
                            <div class="flex items-start">
                                <div class="w-2 h-2 rounded-full mt-2 mr-3" style="background-color: #10b981;"></div>
                                <p class="text-sm text-gray-600">Pastikan kolom NIK tidak duplikat dengan data yang sudah ada</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 rounded-full mt-2 mr-3" style="background-color: #10b981;"></div>
                                <p class="text-sm text-gray-600">Format tanggal: <code class="bg-gray-100 px-1 rounded text-xs">YYYY-MM-DD</code> (contoh: 1990-01-01)</p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 rounded-full mt-2 mr-3" style="background-color: #10b981;"></div>
                                <p class="text-sm text-gray-600">Jenis kelamin: <code class="bg-gray-100 px-1 rounded text-xs">Laki-laki</code> atau <code class="bg-gray-100 px-1 rounded text-xs">Perempuan</code></p>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 rounded-full mt-2 mr-3" style="background-color: #10b981;"></div>
                                <p class="text-sm text-gray-600">Nama desa harus sesuai dengan data yang ada di sistem</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
                <button type="submit" form="importForm" class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors duration-200" style="background-color: #003566;" onmouseover="this.style.backgroundColor='#002347'" onmouseout="this.style.backgroundColor='#003566'">
                    <i class="fas fa-upload mr-2"></i>
                    Import Data
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.fixed.top-4').remove();
            }, 3000);
        </script>
    @endif

    @if(session('error'))
         <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
             {{ session('error') }}
         </div>
         <script>
             setTimeout(function() {
                 document.querySelector('.fixed.top-4').remove();
             }, 3000);
         </script>
     @endif

     <script>
         // Toggle advanced filters
         document.getElementById('toggleAdvanced').addEventListener('click', function() {
              const advancedFilters = document.getElementById('advancedFilters');
              const filterChevron = document.getElementById('filterChevron');
              
              advancedFilters.classList.toggle('hidden');
              
              if (advancedFilters.classList.contains('hidden')) {
                  filterChevron.classList.remove('fa-chevron-up', 'rotate-180');
                  filterChevron.classList.add('fa-chevron-down');
                  this.setAttribute('aria-expanded', 'false');
              } else {
                  filterChevron.classList.remove('fa-chevron-down');
                  filterChevron.classList.add('fa-chevron-up', 'rotate-180');
                  this.setAttribute('aria-expanded', 'true');
              }
          });

         // Auto-submit form when dropdown changes
         document.querySelectorAll('select[name="village_id"], select[name="status"], select[name="gender"], select[name="marital_status"], select[name="religion"], select[name="sort_by"], select[name="sort_order"]').forEach(function(select) {
             select.addEventListener('change', function() {
                 this.form.submit();
             });
         });

         // Show advanced filters if any advanced filter is active
          document.addEventListener('DOMContentLoaded', function() {
              const hasAdvancedFilters = {{ request()->hasAny(['gender', 'marital_status', 'religion', 'age_from', 'age_to', 'sort_by']) ? 'true' : 'false' }};
              if (hasAdvancedFilters) {
                  const advancedFilters = document.getElementById('advancedFilters');
                  const filterChevron = document.getElementById('filterChevron');
                  const toggleButton = document.getElementById('toggleAdvanced');
                  
                  advancedFilters.classList.remove('hidden');
                  filterChevron.classList.remove('fa-chevron-down');
                  filterChevron.classList.add('fa-chevron-up', 'rotate-180');
                  toggleButton.setAttribute('aria-expanded', 'true');
              }
              
              // Initialize tooltips for action buttons
              const actionButtons = document.querySelectorAll('[title]');
              actionButtons.forEach(button => {
                  button.addEventListener('mouseenter', function() {
                      this.style.transform = 'scale(1.05)';
                  });
                  button.addEventListener('mouseleave', function() {
                      this.style.transform = 'scale(1)';
                  });
              });
          });

         // Modal functions
         function openImportModal() {
             document.getElementById('importModal').classList.remove('hidden');
         }

         function closeImportModal() {
             document.getElementById('importModal').classList.add('hidden');
             // Reset form
             document.getElementById('importForm').reset();
             document.getElementById('fileName').classList.add('hidden');
         }

         function updateFileName() {
             const fileInput = document.getElementById('fileInput');
             const fileName = document.getElementById('fileName');
             const fileNameText = document.getElementById('fileNameText');
             
             if (fileInput.files.length > 0) {
                 fileNameText.textContent = fileInput.files[0].name;
                 fileName.classList.remove('hidden');
             } else {
                 fileName.classList.add('hidden');
             }
         }

         // Close modal when clicking outside
         document.getElementById('importModal').addEventListener('click', function(e) {
             if (e.target === this) {
                 closeImportModal();
             }
         });

         // Export loading function
         function showExportLoading(element) {
             const originalText = element.innerHTML;
             element.innerHTML = '<i class="fas fa-spinner fa-spin mr-3 text-blue-600"></i>Mengunduh...';
             element.style.pointerEvents = 'none';
             
             setTimeout(function() {
                 element.innerHTML = originalText;
                 element.style.pointerEvents = 'auto';
             }, 3000);
         }

         // Bulk Actions Functions
         function toggleSelectAll() {
             const selectAllCheckbox = document.getElementById('selectAll');
             const citizenCheckboxes = document.querySelectorAll('.citizen-checkbox');
             
             citizenCheckboxes.forEach(checkbox => {
                 checkbox.checked = selectAllCheckbox.checked;
             });
             
             updateBulkActions();
         }

         function updateBulkActions() {
             const citizenCheckboxes = document.querySelectorAll('.citizen-checkbox');
             const checkedBoxes = document.querySelectorAll('.citizen-checkbox:checked');
             const bulkActionsBar = document.getElementById('bulkActionsBar');
             const selectedCount = document.getElementById('selectedCount');
             const selectAllCheckbox = document.getElementById('selectAll');
             
             selectedCount.textContent = checkedBoxes.length;
             
             if (checkedBoxes.length > 0) {
                 bulkActionsBar.classList.remove('hidden');
             } else {
                 bulkActionsBar.classList.add('hidden');
             }
             
             // Update select all checkbox state
             if (checkedBoxes.length === citizenCheckboxes.length) {
                 selectAllCheckbox.checked = true;
                 selectAllCheckbox.indeterminate = false;
             } else if (checkedBoxes.length > 0) {
                 selectAllCheckbox.checked = false;
                 selectAllCheckbox.indeterminate = true;
             } else {
                 selectAllCheckbox.checked = false;
                 selectAllCheckbox.indeterminate = false;
             }
         }

         function getSelectedIds() {
             const checkedBoxes = document.querySelectorAll('.citizen-checkbox:checked');
             return Array.from(checkedBoxes).map(checkbox => checkbox.value);
         }

         function clearSelection() {
             const citizenCheckboxes = document.querySelectorAll('.citizen-checkbox');
             const selectAllCheckbox = document.getElementById('selectAll');
             
             citizenCheckboxes.forEach(checkbox => {
                 checkbox.checked = false;
             });
             selectAllCheckbox.checked = false;
             selectAllCheckbox.indeterminate = false;
             
             updateBulkActions();
         }

         function bulkActivate() {
             const selectedIds = getSelectedIds();
             if (selectedIds.length === 0) {
                 alert('Pilih minimal satu data untuk diaktifkan.');
                 return;
             }
             
             if (confirm(`Apakah Anda yakin ingin mengaktifkan ${selectedIds.length} data penduduk?`)) {
                 performBulkAction('activate', selectedIds);
             }
         }

         function bulkDeactivate() {
             const selectedIds = getSelectedIds();
             if (selectedIds.length === 0) {
                 alert('Pilih minimal satu data untuk dinonaktifkan.');
                 return;
             }
             
             if (confirm(`Apakah Anda yakin ingin menonaktifkan ${selectedIds.length} data penduduk?`)) {
                 performBulkAction('deactivate', selectedIds);
             }
         }

         function bulkDelete() {
             const selectedIds = getSelectedIds();
             if (selectedIds.length === 0) {
                 alert('Pilih minimal satu data untuk dihapus.');
                 return;
             }
             
             if (confirm(`PERINGATAN: Apakah Anda yakin ingin menghapus ${selectedIds.length} data penduduk? Tindakan ini tidak dapat dibatalkan!`)) {
                 performBulkAction('delete', selectedIds);
             }
         }

         function bulkExport() {
             const selectedIds = getSelectedIds();
             if (selectedIds.length === 0) {
                 alert('Pilih minimal satu data untuk diekspor.');
                 return;
             }
             
             // Create form and submit for export
             const form = document.createElement('form');
             form.method = 'POST';
             form.action = '{{ route("admin.citizens.bulk-export") }}';
             
             const csrfToken = document.createElement('input');
             csrfToken.type = 'hidden';
             csrfToken.name = '_token';
             csrfToken.value = '{{ csrf_token() }}';
             form.appendChild(csrfToken);
             
             selectedIds.forEach(id => {
                 const input = document.createElement('input');
                 input.type = 'hidden';
                 input.name = 'ids[]';
                 input.value = id;
                 form.appendChild(input);
             });
             
             document.body.appendChild(form);
             form.submit();
             document.body.removeChild(form);
         }

         function performBulkAction(action, ids) {
             const form = document.createElement('form');
             form.method = 'POST';
             form.action = '{{ route("admin.citizens.bulk-action") }}';
             
             const csrfToken = document.createElement('input');
             csrfToken.type = 'hidden';
             csrfToken.name = '_token';
             csrfToken.value = '{{ csrf_token() }}';
             form.appendChild(csrfToken);
             
             const actionInput = document.createElement('input');
             actionInput.type = 'hidden';
             actionInput.name = 'action';
             actionInput.value = action;
             form.appendChild(actionInput);
             
             ids.forEach(id => {
                 const input = document.createElement('input');
                 input.type = 'hidden';
                 input.name = 'ids[]';
                 input.value = id;
                 form.appendChild(input);
             });
             
             document.body.appendChild(form);
             form.submit();
         }

         // Chart.js initialization
         document.addEventListener('DOMContentLoaded', function() {
             // Age Distribution Chart
             const ageCtx = document.getElementById('ageChart').getContext('2d');
             new Chart(ageCtx, {
                 type: 'bar',
                 data: {
                     labels: ['0-17', '18-30', '31-45', '46-60', '60+'],
                     datasets: [{
                         label: 'Jumlah Penduduk',
                         data: @json($chartData['age'] ?? [0, 0, 0, 0, 0]),
                         backgroundColor: [
                             'rgba(59, 130, 246, 0.8)',
                             'rgba(16, 185, 129, 0.8)',
                             'rgba(245, 158, 11, 0.8)',
                             'rgba(239, 68, 68, 0.8)',
                             'rgba(139, 92, 246, 0.8)'
                         ],
                         borderColor: [
                             'rgba(59, 130, 246, 1)',
                             'rgba(16, 185, 129, 1)',
                             'rgba(245, 158, 11, 1)',
                             'rgba(239, 68, 68, 1)',
                             'rgba(139, 92, 246, 1)'
                         ],
                         borderWidth: 1
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: {
                             display: false
                         }
                     },
                     scales: {
                         y: {
                             beginAtZero: true,
                             ticks: {
                                 stepSize: 1
                             }
                         }
                     }
                 }
             });

             // Gender Distribution Chart
             const genderCtx = document.getElementById('genderChart').getContext('2d');
             new Chart(genderCtx, {
                 type: 'doughnut',
                 data: {
                     labels: ['Laki-laki', 'Perempuan'],
                     datasets: [{
                         data: @json($chartData['gender'] ?? [0, 0]),
                         backgroundColor: [
                             'rgba(16, 185, 129, 0.8)',
                             'rgba(236, 72, 153, 0.8)'
                         ],
                         borderColor: [
                             'rgba(16, 185, 129, 1)',
                             'rgba(236, 72, 153, 1)'
                         ],
                         borderWidth: 2
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: {
                             position: 'bottom'
                         }
                     }
                 }
             });

             // Religion Distribution Chart
             const religionCtx = document.getElementById('religionChart').getContext('2d');
             new Chart(religionCtx, {
                 type: 'doughnut',
                 data: {
                     labels: @json($chartData['religionLabels'] ?? []),
                     datasets: [{
                         data: @json($chartData['religion'] ?? []),
                         backgroundColor: [
                             'rgba(139, 92, 246, 0.8)',
                             'rgba(59, 130, 246, 0.8)',
                             'rgba(16, 185, 129, 0.8)',
                             'rgba(245, 158, 11, 0.8)',
                             'rgba(239, 68, 68, 0.8)',
                             'rgba(236, 72, 153, 0.8)'
                         ],
                         borderColor: [
                             'rgba(139, 92, 246, 1)',
                             'rgba(59, 130, 246, 1)',
                             'rgba(16, 185, 129, 1)',
                             'rgba(245, 158, 11, 1)',
                             'rgba(239, 68, 68, 1)',
                             'rgba(236, 72, 153, 1)'
                         ],
                         borderWidth: 2
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: {
                             position: 'bottom'
                         }
                     }
                 }
             });

             // Village Distribution Chart
             const villageCtx = document.getElementById('villageChart').getContext('2d');
             new Chart(villageCtx, {
                 type: 'bar',
                 data: {
                     labels: @json($chartData['villageLabels'] ?? []),
                     datasets: [{
                         label: 'Jumlah Penduduk',
                         data: @json($chartData['village'] ?? []),
                         backgroundColor: 'rgba(16, 185, 129, 0.8)',
                         borderColor: 'rgba(16, 185, 129, 1)',
                         borderWidth: 1
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: {
                             display: false
                         }
                     },
                     scales: {
                         y: {
                             beginAtZero: true,
                             ticks: {
                                 stepSize: 1
                             }
                         },
                         x: {
                             ticks: {
                                 maxRotation: 45
                             }
                         }
                     }
                 }
             });
         });
     </script>

     <!-- Chart.js CDN -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 </x-admin-layout>