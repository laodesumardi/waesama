<x-admin-layout>
    <x-slot name="header">
        Manajemen Dokumen
    </x-slot>

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Manajemen Dokumen</h1>
                        <p class="text-sm text-gray-600 mt-1">Kelola dokumen yang dihasilkan dari permohonan layanan</p>
                    </div>
                    <a href="{{ route('admin.documents.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Dokumen
                    </a>
                </div>

                <!-- Filter dan Search -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <form method="GET" action="{{ route('admin.documents.index') }}" class="flex">
                            @if(request('template'))
                                <input type="hidden" name="template" value="{{ request('template') }}">
                            @endif
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div class="flex-1 relative">
                                <input type="text" 
                                       name="search" 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                       placeholder="Cari nomor dokumen, template, atau pemohon..." 
                                       value="{{ request('search') }}">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <button type="submit" 
                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-r-lg transition-colors duration-200">
                                Cari
                            </button>
                        </form>
                    </div>

                    <!-- Template Filter -->
                    <div>
                        <form method="GET" action="{{ route('admin.documents.index') }}">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <select name="template" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                    onchange="this.form.submit()">
                                <option value="">Semua Template</option>
                                <option value="surat_keterangan_domisili" {{ request('template') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                <option value="surat_keterangan_usaha" {{ request('template') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                <option value="surat_keterangan_tidak_mampu" {{ request('template') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                <option value="surat_pengantar_nikah" {{ request('template') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                <option value="surat_keterangan_kelahiran" {{ request('template') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                <option value="surat_keterangan_kematian" {{ request('template') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                            </select>
                        </form>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <form method="GET" action="{{ route('admin.documents.index') }}">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('template'))
                                <input type="hidden" name="template" value="{{ request('template') }}">
                            @endif
                            <select name="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                    onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Reset Button -->
                @if(request()->hasAny(['search', 'template', 'status']))
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.documents.index') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Reset Filter
                    </a>
                </div>
                @endif

                <!-- Statistik -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Total Dokumen -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Dokumen</p>
                                <p class="text-3xl font-bold mt-1">{{ $documents->total() ?? 0 }}</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-file-alt text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Aktif -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Dokumen Aktif</p>
                                <p class="text-3xl font-bold mt-1">{{ $documents->where('is_active', true)->count() ?? 0 }}</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Bulan Ini -->
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm font-medium">Bulan Ini</p>
                                <p class="text-3xl font-bold mt-1">{{ $documents->where('created_at', '>=', now()->startOfMonth())->count() ?? 0 }}</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-calendar text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Download -->
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Total Download</p>
                                <p class="text-3xl font-bold mt-1">{{ $documents->sum('download_count') ?? 0 }}</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                <i class="fas fa-download text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6">

                <!-- Mobile Cards (Hidden on Desktop) -->
                <div class="block lg:hidden space-y-4">
                    @forelse($documents as $document)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $document->document_number }}</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ str_replace('_', ' ', ucwords($document->template_name, '_')) }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($document->is_active)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Tidak Aktif
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($document->serviceRequest && $document->serviceRequest->citizen)
                        <div class="mb-3">
                            <p class="text-sm font-medium text-gray-900">{{ $document->serviceRequest->citizen->name }}</p>
                            <p class="text-xs text-gray-500">NIK: {{ $document->serviceRequest->citizen->nik }}</p>
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4 text-sm mb-3">
                            <div>
                                <span class="text-gray-500">Ukuran:</span>
                                <span class="font-medium">{{ $document->formatted_file_size ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Download:</span>
                                <span class="font-medium">{{ $document->download_count ?? 0 }}x</span>
                            </div>
                        </div>
                        
                        <div class="text-xs text-gray-500 mb-3">
                            {{ $document->created_at->format('d/m/Y H:i') }}
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.documents.show', $document) }}" 
                               class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded hover:bg-blue-200">
                                <i class="fas fa-eye mr-1"></i> Lihat
                            </a>
                            <a href="{{ route('admin.documents.download', $document) }}" 
                               class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded hover:bg-green-200">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                            <a href="{{ route('admin.documents.edit', $document) }}" 
                               class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded hover:bg-yellow-200">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Tidak ada data dokumen</p>
                    </div>
                    @endforelse
                </div>

                <!-- Desktop Table (Hidden on Mobile) -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permohonan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($documents as $index => $document)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $documents->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $document->document_number }}</div>
                                        <div class="text-sm text-gray-500">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ str_replace('_', ' ', ucwords($document->template_name, '_')) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($document->serviceRequest)
                                    <a href="{{ route('admin.service-requests.show', $document->serviceRequest) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        {{ $document->serviceRequest->request_number }}
                                    </a>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($document->serviceRequest && $document->serviceRequest->citizen)
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $document->serviceRequest->citizen->name }}</div>
                                        <div class="text-sm text-gray-500">NIK: {{ $document->serviceRequest->citizen->nik }}</div>
                                    </div>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-1">
                                        @if($document->is_active)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Tidak Aktif
                                        </span>
                                        @endif
                                        @if($document->valid_until && $document->valid_until < now())
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Kedaluwarsa
                                        </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="space-y-1">
                                        <div>{{ $document->formatted_file_size ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-download mr-1"></i>{{ $document->download_count ?? 0 }}x
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $document->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.documents.show', $document) }}" 
                                           class="text-indigo-600 hover:text-indigo-900" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.documents.preview', $document) }}" 
                                           target="_blank" class="text-blue-600 hover:text-blue-900" title="Preview">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="{{ route('admin.documents.download', $document) }}" 
                                           class="text-green-600 hover:text-green-900" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ route('admin.documents.edit', $document) }}" 
                                           class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($document->is_active)
                                        <form action="{{ route('admin.documents.deactivate', $document) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-gray-600 hover:text-gray-900" title="Nonaktifkan" 
                                                    onclick="return confirm('Yakin ingin menonaktifkan dokumen ini?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.documents.activate', $document) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Aktifkan" 
                                                    onclick="return confirm('Yakin ingin mengaktifkan dokumen ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus" 
                                                    onclick="return confirmAction('Yakin ingin menghapus dokumen ini? File juga akan dihapus.', this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data dokumen</p>
                                        <p class="text-gray-400 text-sm mt-1">Dokumen akan muncul di sini setelah dibuat</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                    <!-- Pagination -->
                <div class="flex justify-center mt-6">
                    {{ $documents->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh setiap 60 detik (hanya jika tidak ada filter aktif)
        let autoRefreshInterval;
        
        function startAutoRefresh() {
            // Cek apakah ada filter aktif
            const hasActiveFilters = document.querySelector('input[name="search"]').value || 
                                    document.querySelector('select[name="template"]').value;
            
            if (!hasActiveFilters) {
                autoRefreshInterval = setInterval(function() {
                    // Hanya refresh jika user tidak sedang berinteraksi
                    if (document.hidden === false) {
                        location.reload();
                    }
                }, 60000);
            }
        }
        
        // Stop auto refresh ketika user berinteraksi dengan filter
        document.addEventListener('DOMContentLoaded', function() {
            startAutoRefresh();
            
            // Stop auto refresh saat user menggunakan filter
            const filterInputs = document.querySelectorAll('input[name="search"], select[name="template"]');
            filterInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    if (autoRefreshInterval) {
                        clearInterval(autoRefreshInterval);
                    }
                });
            });
            
            // Smooth scroll untuk mobile cards
            const mobileCards = document.querySelectorAll('.lg\\:hidden .bg-gray-50');
            mobileCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    if (!e.target.closest('a') && !e.target.closest('button')) {
                        this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            });
        });
        
        // Enhanced confirmation dialog
        function confirmAction(message, element) {
            const result = confirm(message);
            if (result && element) {
                // Add loading state
                element.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                element.disabled = true;
            }
            return result;
        }
        
        // Handle page visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Page is hidden, stop auto refresh
                if (autoRefreshInterval) {
                    clearInterval(autoRefreshInterval);
                }
            } else {
                // Page is visible again, restart auto refresh
                startAutoRefresh();
            }
        });
    </script>
</x-admin-layout>