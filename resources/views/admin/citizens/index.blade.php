<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Penduduk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header dengan tombol tambah -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Penduduk</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.citizens.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-plus"></i> Tambah Penduduk
                            </a>
                            <div class="relative inline-block text-left">
                                <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                    <a class="dropdown-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.citizens.export', request()->query()) }}">
                                        <i class="fas fa-download"></i> Export Data
                                    </a>
                                    <a class="dropdown-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="#" data-toggle="modal" data-target="#importModal">
                                        <i class="fas fa-upload"></i> Import Data
                                    </a>
                                    <hr class="border-gray-200">
                                    <a class="dropdown-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.citizens.template') }}">
                                        <i class="fas fa-file-download"></i> Download Template
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                        <div class="bg-blue-500 text-white p-4 rounded-lg">
                            <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
                            <div class="text-sm">Total Penduduk</div>
                        </div>
                        <div class="bg-green-500 text-white p-4 rounded-lg">
                            <div class="text-2xl font-bold">{{ $stats['male'] }}</div>
                            <div class="text-sm">Laki-laki</div>
                        </div>
                        <div class="bg-pink-500 text-white p-4 rounded-lg">
                            <div class="text-2xl font-bold">{{ $stats['female'] }}</div>
                            <div class="text-sm">Perempuan</div>
                        </div>
                        <div class="bg-emerald-500 text-white p-4 rounded-lg">
                            <div class="text-2xl font-bold">{{ $stats['active'] }}</div>
                            <div class="text-sm">Aktif</div>
                        </div>
                        <div class="bg-red-500 text-white p-4 rounded-lg">
                            <div class="text-2xl font-bold">{{ $stats['inactive'] }}</div>
                            <div class="text-sm">Tidak Aktif</div>
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
                    <div class="mb-6">
                        <form method="GET" action="{{ route('admin.citizens.index') }}" class="space-y-4">
                            <!-- Basic Search -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           placeholder="Cari berdasarkan nama, NIK, alamat, telepon..." 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <select name="village_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Semua Desa</option>
                                        @foreach($villages as $village)
                                            <option value="{{ $village->id }}" {{ request('village_id') == $village->id ? 'selected' : '' }}>
                                                {{ $village->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    <button type="button" id="toggleAdvanced" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.citizens.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Advanced Filters -->
                            <div id="advancedFilters" class="{{ request()->hasAny(['gender', 'marital_status', 'religion', 'age_from', 'age_to', 'sort_by']) ? '' : 'hidden' }} bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-medium mb-3">Filter Lanjutan</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Semua</option>
                                            <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan</label>
                                        <select name="marital_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Semua</option>
                                            <option value="Belum Kawin" {{ request('marital_status') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                            <option value="Kawin" {{ request('marital_status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                            <option value="Cerai Hidup" {{ request('marital_status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                            <option value="Cerai Mati" {{ request('marital_status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                                        <select name="religion" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Semua</option>
                                            <option value="Islam" {{ request('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ request('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ request('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ request('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ request('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ request('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Usia</label>
                                        <div class="flex space-x-2">
                                            <input type="number" name="age_from" value="{{ request('age_from') }}" placeholder="Dari" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <input type="number" name="age_to" value="{{ request('age_to') }}" placeholder="Sampai" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                        <div class="flex space-x-2">
                                            <select name="sort_by" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                                                <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                                                <option value="birth_date" {{ request('sort_by') == 'birth_date' ? 'selected' : '' }}>Tanggal Lahir</option>
                                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                            </select>
                                            <select name="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z</option>
                                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Data -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($citizens as $citizen)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $citizen->nik }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $citizen->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $citizen->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $citizen->village->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $citizen->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $citizen->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.citizens.show', $citizen) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat</a>
                                <a href="{{ route('admin.citizens.edit', $citizen) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                <form action="{{ route('admin.citizens.destroy', $citizen) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data penduduk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $citizens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Penduduk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.citizens.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Pilih File Excel/CSV:</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                            <small class="form-text text-muted">
                                Format yang didukung: .xlsx, .xls, .csv (Maksimal 2MB)
                            </small>
                        </div>
                        <div class="alert alert-info">
                            <strong>Petunjuk:</strong>
                            <ul class="mb-0">
                                <li>Download template terlebih dahulu untuk format yang benar</li>
                                <li>Pastikan kolom NIK tidak duplikat dengan data yang sudah ada</li>
                                <li>Format tanggal: YYYY-MM-DD (contoh: 1990-01-01)</li>
                                <li>Jenis kelamin: Laki-laki atau Perempuan</li>
                                <li>Nama desa harus sesuai dengan data yang ada di sistem</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import Data
                        </button>
                    </div>
                </form>
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
             advancedFilters.classList.toggle('hidden');
             
             const icon = this.querySelector('i');
             if (advancedFilters.classList.contains('hidden')) {
                 icon.className = 'fas fa-filter';
             } else {
                 icon.className = 'fas fa-filter-circle-xmark';
             }
         });

         // Auto-submit form when dropdown changes
         document.querySelectorAll('select[name="village_id"], select[name="status"], select[name="gender"], select[name="marital_status"], select[name="religion"], select[name="sort_by"], select[name="sort_order"]').forEach(function(select) {
             select.addEventListener('change', function() {
                 this.form.submit();
             });
         });
     </script>
 </x-app-layout>