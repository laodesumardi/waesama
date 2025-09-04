<x-admin-layout>
    <x-slot name="header">
        Detail Permohonan Surat
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Permohonan</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Informasi lengkap permohonan layanan surat - {{ $serviceRequest->request_number }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($serviceRequest->canBeProcessed())
                    <a href="{{ route('admin.service-requests.edit', $serviceRequest) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #d97706; color: white;" onmouseover="this.style.backgroundColor='#b45309'" onmouseout="this.style.backgroundColor='#d97706'">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    @endif
                    <button type="button" onclick="printDetail()" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #2563eb; color: white;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                        <i class="fas fa-print mr-2"></i> Print Detail
                    </button>
                    <a href="{{ route('admin.service-requests.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #6b7280; color: white;" onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status Permohonan</p>
                        @if($serviceRequest->status == 'pending')
                            <p class="text-2xl font-bold mt-2" style="color: #d97706;">Menunggu</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-gray-500">Perlu ditindaklanjuti</span>
                            </div>
                        @elseif($serviceRequest->status == 'processing')
                            <p class="text-2xl font-bold mt-2" style="color: #2563eb;">Diproses</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-gray-500">Sedang dikerjakan</span>
                            </div>
                        @elseif($serviceRequest->status == 'completed')
                            <p class="text-2xl font-bold mt-2" style="color: #16a34a;">Selesai</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-gray-500">Telah diselesaikan</span>
                            </div>
                        @else
                            <p class="text-2xl font-bold mt-2" style="color: #ef4444;">Ditolak</p>
                            <div class="flex items-center mt-2">
                                <span class="text-xs text-gray-500">Permohonan ditolak</span>
                            </div>
                        @endif
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center"
                         @if($serviceRequest->status == 'pending') style="background-color: #fef3c7;"
                         @elseif($serviceRequest->status == 'processing') style="background-color: #dbeafe;"
                         @elseif($serviceRequest->status == 'completed') style="background-color: #f0fdf4;"
                         @else style="background-color: #fef2f2;" @endif>
                        @if($serviceRequest->status == 'pending')
                            <i class="fas fa-clock text-xl" style="color: #d97706;"></i>
                        @elseif($serviceRequest->status == 'processing')
                            <i class="fas fa-cog text-xl" style="color: #2563eb;"></i>
                        @elseif($serviceRequest->status == 'completed')
                            <i class="fas fa-check-circle text-xl" style="color: #16a34a;"></i>
                        @else
                            <i class="fas fa-times-circle text-xl" style="color: #ef4444;"></i>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Priority Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Prioritas</p>
                        @php
                            $priorityConfig = [
                                'low' => ['color' => '#6b7280', 'bg' => '#f3f4f6', 'label' => 'Rendah', 'desc' => 'Prioritas rendah'],
                                'normal' => ['color' => '#2563eb', 'bg' => '#dbeafe', 'label' => 'Normal', 'desc' => 'Prioritas normal'],
                                'high' => ['color' => '#d97706', 'bg' => '#fef3c7', 'label' => 'Tinggi', 'desc' => 'Prioritas tinggi'],
                                'urgent' => ['color' => '#ef4444', 'bg' => '#fef2f2', 'label' => 'Mendesak', 'desc' => 'Sangat mendesak']
                            ];
                            $priorityConf = $priorityConfig[$serviceRequest->priority] ?? $priorityConfig['normal'];
                        @endphp
                        <p class="text-2xl font-bold mt-2" style="color: {{ $priorityConf['color'] }};">{{ $priorityConf['label'] }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">{{ $priorityConf['desc'] }}</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: {{ $priorityConf['bg'] }};">
                        <i class="fas fa-exclamation-triangle text-xl" style="color: {{ $priorityConf['color'] }};"></i>
                    </div>
                </div>
            </div>

            <!-- Service Type Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Jenis Layanan</p>
                        <p class="text-lg font-bold text-gray-900 mt-2">{{ $serviceRequest->service_type }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">Layanan yang diminta</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #e6f3ff;">
                        <i class="fas fa-file-alt text-xl" style="color: #003566;"></i>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tanggal Dibuat</p>
                        <p class="text-lg font-bold text-gray-900 mt-2">{{ $serviceRequest->created_at->format('d/m/Y') }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-gray-500">{{ $serviceRequest->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #fef3c7;">
                        <i class="fas fa-calendar text-xl" style="color: #d97706;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Permohonan</h2>
                        <p class="text-sm text-gray-600">Detail lengkap permohonan layanan surat</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Informasi Permohonan -->
                    <div class="space-y-4">
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Nomor Permohonan:</span>
                                <span class="text-gray-900 font-mono">{{ $serviceRequest->request_number }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Jenis Layanan:</span>
                                <div>{!! $serviceRequest->service_type_badge !!}</div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Status:</span>
                                <div>{!! $serviceRequest->status_badge !!}</div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Prioritas:</span>
                                <div>{!! $serviceRequest->priority_badge !!}</div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Tanggal Dibuat:</span>
                                <span class="text-gray-900">{{ $serviceRequest->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($serviceRequest->required_date)
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Tanggal Dibutuhkan:</span>
                                <span class="text-gray-900">{{ \Carbon\Carbon::parse($serviceRequest->required_date)->format('d/m/Y') }}</span>
                            </div>
                            @endif
                            @if($serviceRequest->processed_at)
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Tanggal Diproses:</span>
                                <span class="text-gray-900">{{ $serviceRequest->processed_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                            @if($serviceRequest->approved_at)
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Tanggal Disetujui:</span>
                                <span class="text-gray-900">{{ $serviceRequest->approved_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                            @if($serviceRequest->completed_at)
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Tanggal Selesai:</span>
                                <span class="text-gray-900">{{ $serviceRequest->completed_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi Pemohon -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 mb-4 p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-100">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Informasi Pemohon</h3>
                                <p class="text-sm text-gray-600">Data lengkap pemohon layanan</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Nama:</span>
                                <span class="text-gray-900">{{ $serviceRequest->citizen->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">NIK:</span>
                                <span class="text-gray-900 font-mono">{{ $serviceRequest->citizen->nik ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Tempat, Tanggal Lahir:</span>
                                <span class="text-gray-900">
                                    @if($serviceRequest->citizen && $serviceRequest->citizen->place_of_birth && $serviceRequest->citizen->date_of_birth)
                                        {{ $serviceRequest->citizen->place_of_birth }}, {{ \Carbon\Carbon::parse($serviceRequest->citizen->date_of_birth)->format('d/m/Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Jenis Kelamin:</span>
                                <span class="text-gray-900">
                                    @if($serviceRequest->citizen && $serviceRequest->citizen->gender)
                                        {{ $serviceRequest->citizen->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Alamat:</span>
                                <span class="text-gray-900">{{ $serviceRequest->citizen->address ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between py-2">
                                <span class="font-medium text-gray-700">No. Telepon:</span>
                                <span class="text-gray-900">{{ $serviceRequest->citizen->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keperluan dan Catatan -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.3);">
                        <i class="fas fa-clipboard-list text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Keperluan & Catatan</h2>
                        <p class="text-sm text-gray-600">Tujuan dan catatan tambahan permohonan</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-100">
                                <i class="fas fa-clipboard-list text-blue-600 text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Keperluan</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed text-justify">{{ $serviceRequest->purpose ?? 'Tidak ada keperluan yang disebutkan' }}</p>
                    </div>
                    @if($serviceRequest->notes)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-yellow-100">
                                <i class="fas fa-sticky-note text-yellow-600 text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Catatan</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed text-justify">{{ $serviceRequest->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($serviceRequest->template_variables)
        <!-- Informasi Tambahan -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Tambahan</h2>
                        <p class="text-sm text-gray-600">Data spesifik untuk jenis layanan ini</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-3">
                    @foreach($serviceRequest->template_variables as $key => $value)
                    <div class="flex flex-col sm:flex-row sm:justify-between py-3 px-4 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="font-medium text-gray-700">{{ str_replace('_', ' ', ucwords($key, '_')) }}:</span>
                        <span class="text-gray-900 font-semibold">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($serviceRequest->required_documents && count($serviceRequest->required_documents) > 0)
        <!-- Dokumen Pendukung -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Dokumen Pendukung</h2>
                        <p class="text-sm text-gray-600">File yang dilampirkan untuk permohonan</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($serviceRequest->required_documents as $document)
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 p-4 text-center hover:shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-file-alt text-xl text-blue-600"></i>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 break-words font-medium">{{ basename($document) }}</p>
                        <a href="{{ Storage::url($document) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-eye mr-2"></i> Lihat
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($serviceRequest->processedBy || $serviceRequest->approvedBy)
        <!-- Informasi Pemrosesan -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);">
                        <i class="fas fa-cogs text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Pemrosesan</h2>
                        <p class="text-sm text-gray-600">Detail petugas yang menangani permohonan</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($serviceRequest->processedBy)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user-cog text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Diproses oleh:</span>
                                <div class="text-lg font-semibold text-gray-900">{{ $serviceRequest->processedBy->name }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($serviceRequest->approvedBy)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-user-check text-green-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Disetujui oleh:</span>
                                <div class="text-lg font-semibold text-gray-900">{{ $serviceRequest->approvedBy->name }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        @if(isset($serviceRequest->documents) && $serviceRequest->documents->count() > 0)
        <!-- Dokumen yang Dihasilkan -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-file-pdf text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Dokumen yang Dihasilkan</h2>
                        <p class="text-sm text-gray-600">Dokumen resmi yang telah dibuat</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Dokumen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Template</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($serviceRequest->documents as $document)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">{{ $document->document_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ str_replace('_', ' ', ucwords($document->template_name ?? 'Unknown', '_')) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($document->is_active) && $document->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <span class="text-gray-500 text-xs">Aksi dinonaktifkan</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <!-- Dokumen yang Dihasilkan - Empty State -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-file-pdf text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Dokumen yang Dihasilkan</h2>
                        <p class="text-sm text-gray-600">Dokumen resmi yang telah dibuat</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-file-pdf text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada dokumen</h3>
                    <p class="text-sm text-gray-500">Dokumen akan muncul setelah permohonan diproses dan disetujui</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); box-shadow: 0 4px 6px -1px rgba(100, 116, 139, 0.3);">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Aksi Permohonan</h2>
                        <p class="text-sm text-gray-600">Tindakan yang dapat dilakukan untuk permohonan ini</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:justify-between gap-4">
                    <div class="flex flex-wrap gap-3">
                        @if($serviceRequest->status === 'pending')
                        <form action="{{ route('admin.service-requests.process', $serviceRequest) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200" onclick="return confirm('Yakin ingin memproses permohonan ini?')">
                                <i class="fas fa-play mr-2"></i> Proses Permohonan
                            </button>
                        </form>
                        @endif

                        @if($serviceRequest->status === 'processing')
                        <form action="{{ route('admin.service-requests.approve', $serviceRequest) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200" onclick="return confirm('Yakin ingin menyetujui permohonan ini?')">
                                <i class="fas fa-check mr-2"></i> Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.service-requests.reject', $serviceRequest) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200" onclick="return confirm('Yakin ingin menolak permohonan ini?')">
                                <i class="fas fa-times mr-2"></i> Tolak
                            </button>
                        </form>
                        @endif

                        @if($serviceRequest->status === 'approved')
                        <span class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed">
                            <i class="fas fa-file-pdf mr-2"></i> Generate Dokumen (Dinonaktifkan)
                        </span>
                        <form action="{{ route('admin.service-requests.complete', $serviceRequest) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200" onclick="return confirm('Yakin ingin menyelesaikan permohonan ini?')">
                                <i class="fas fa-check-double mr-2"></i> Selesaikan
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="flex justify-end">
                        @if($serviceRequest->canBeProcessed())
                        <form action="{{ route('admin.service-requests.destroy', $serviceRequest) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg" onclick="return confirm('Yakin ingin menghapus permohonan ini? Data yang terkait juga akan dihapus.')">
                                <i class="fas fa-trash mr-2"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printDetail() {
            // Hide elements that shouldn't be printed
            const elementsToHide = [
                'button',
                '.flex.flex-wrap.gap-2',
                'a[href*="edit"]',
                'a[href*="index"]',
                'form[method="POST"]',
                '.shadow-lg',
                '.hover\\:shadow-md'
            ];

            elementsToHide.forEach(selector => {
                document.querySelectorAll(selector).forEach(el => {
                    el.style.display = 'none';
                });
            });

            // Add print styles
            const printStyles = `
                <style media="print">
                    @page {
                        margin: 1.5cm;
                        size: A4;
                    }
                    body {
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        line-height: 1.5;
                        color: #000;
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 30px;
                        border-bottom: 3px solid #000;
                        padding-bottom: 15px;
                    }
                    .print-header h1 {
                        font-size: 20px;
                        margin: 0;
                        font-weight: bold;
                        text-transform: uppercase;
                    }
                    .print-header p {
                        margin: 8px 0;
                        font-size: 14px;
                    }
                    .bg-white {
                        background: white !important;
                        box-shadow: none !important;
                        border: 1px solid #ddd !important;
                        margin-bottom: 15px;
                    }
                    .rounded-xl {
                        border-radius: 0 !important;
                    }
                    .shadow-lg, .shadow-sm {
                        box-shadow: none !important;
                    }
                    .text-2xl, .text-3xl {
                        font-size: 16px !important;
                        font-weight: bold;
                    }
                    .text-xl {
                        font-size: 14px !important;
                        font-weight: bold;
                    }
                    .text-lg {
                        font-size: 13px !important;
                        font-weight: bold;
                    }
                    .text-sm {
                        font-size: 11px !important;
                    }
                    .text-xs {
                        font-size: 10px !important;
                    }
                    .bg-gradient-to-r {
                        background: #f8f9fa !important;
                        border-bottom: 2px solid #ddd !important;
                    }
                    .bg-gray-50 {
                        background: #f8f9fa !important;
                    }
                    .border-gray-200, .border-gray-100 {
                        border-color: #ddd !important;
                    }
                    .space-y-6 > * + * {
                        margin-top: 15px !important;
                    }
                    .grid {
                        display: block !important;
                    }
                    .grid > div {
                        margin-bottom: 10px !important;
                    }
                    .status-badge {
                        padding: 3px 8px;
                        border-radius: 4px;
                        font-size: 10px;
                        font-weight: bold;
                        border: 1px solid #ddd;
                    }
                    .print-footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 10px;
                        border-top: 1px solid #ddd;
                        padding-top: 10px;
                    }
                    .no-print {
                        display: none !important;
                    }
                </style>
            `;

            // Add print header
            const printHeader = document.createElement('div');
            printHeader.className = 'print-header';
            printHeader.innerHTML = `
                <h1>Detail Permohonan Layanan</h1>
                <p>Kantor Camat</p>
                <p>Nomor Permohonan: {{ $serviceRequest->request_number }}</p>
                <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })}</p>
            `;

            // Add print footer
            const printFooter = document.createElement('div');
            printFooter.className = 'print-footer';
            printFooter.innerHTML = `
                <p>Dokumen ini dicetak pada: ${new Date().toLocaleString('id-ID')}</p>
                <p>Halaman ini adalah salinan resmi dari sistem manajemen kantor camat</p>
            `;

            // Insert print styles and elements
            document.head.insertAdjacentHTML('beforeend', printStyles);
            document.body.insertBefore(printHeader, document.body.firstChild);
            document.body.appendChild(printFooter);

            // Print the page
            window.print();

            // Restore hidden elements after printing
            setTimeout(() => {
                elementsToHide.forEach(selector => {
                    document.querySelectorAll(selector).forEach(el => {
                        el.style.display = '';
                    });
                });

                // Remove print elements
                printHeader.remove();
                printFooter.remove();
                document.querySelector('style[media="print"]')?.remove();
            }, 1000);
        }
    </script>
</x-admin-layout>
