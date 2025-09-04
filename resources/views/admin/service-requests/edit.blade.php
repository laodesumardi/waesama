<x-admin-layout>
    <x-slot name="header">
        Edit Permohonan Surat
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Permohonan</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Perbarui informasi permohonan layanan surat - {{ $serviceRequest->request_number }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.service-requests.show', $serviceRequest) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #6b7280; color: white;" onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                    </a>
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
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Edit Permohonan</h2>
                        <p class="text-sm text-gray-600">Ubah informasi permohonan layanan surat</p>
                    </div>
                </div>
            </div>

            
            <div class="p-6">
                <form action="{{ route('admin.service-requests.update', $serviceRequest) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- Pemohon Card -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Pemohon</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="citizen_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pemohon <span class="text-red-500">*</span>
                                    </label>
                                    <select name="citizen_id" id="citizen_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('citizen_id') border-red-500 @enderror" required>
                                        <option value="">Pilih Pemohon</option>
                                        @foreach($citizens as $citizen)
                                        <option value="{{ $citizen->id }}" {{ (old('citizen_id') ?? $serviceRequest->citizen_id) == $citizen->id ? 'selected' : '' }}>
                                            {{ $citizen->name }} - NIK: {{ $citizen->nik }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('citizen_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Service Type Card -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-green-100 rounded-lg mr-3">
                                    <i class="fas fa-file-alt text-green-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Jenis Layanan</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jenis Layanan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="service_type" id="service_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('service_type') border-red-500 @enderror" required>
                                        <option value="">Pilih Jenis Layanan</option>
                                        <option value="surat_keterangan_domisili" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                        <option value="surat_keterangan_usaha" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                        <option value="surat_keterangan_tidak_mampu" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                        <option value="surat_pengantar_nikah" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                        <option value="surat_keterangan_kelahiran" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                        <option value="surat_keterangan_kematian" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                    </select>
                                    @error('service_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purpose and Details Section -->
                    <div class="mt-8">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-6">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                    <i class="fas fa-clipboard-list text-purple-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Keperluan & Detail</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Keperluan -->
                                <div class="lg:col-span-3">
                                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">
                                        Keperluan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="purpose" id="purpose" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('purpose') border-red-500 @enderror" rows="4" placeholder="Jelaskan keperluan surat ini..." required>{{ old('purpose') ?? $serviceRequest->purpose }}</textarea>
                                    @error('purpose')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Prioritas -->
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                                    <select name="priority" id="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('priority') border-red-500 @enderror">
                                        <option value="low" {{ (old('priority') ?? $serviceRequest->priority) == 'low' ? 'selected' : '' }}>Rendah</option>
                                        <option value="normal" {{ (old('priority') ?? $serviceRequest->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="high" {{ (old('priority') ?? $serviceRequest->priority) == 'high' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="urgent" {{ (old('priority') ?? $serviceRequest->priority) == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                                    </select>
                                    @error('priority')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Dibutuhkan -->
                                <div>
                                    <label for="required_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dibutuhkan</label>
                                    <input type="date" name="required_date" id="required_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('required_date') border-red-500 @enderror" value="{{ old('required_date') ?? ($serviceRequest->required_date ? \Carbon\Carbon::parse($serviceRequest->required_date)->format('Y-m-d') : '') }}" min="{{ date('Y-m-d') }}">
                                    @error('required_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div class="lg:col-span-3">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                                    <textarea name="notes" id="notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('notes') border-red-500 @enderror" rows="3" placeholder="Catatan atau informasi tambahan...">{{ old('notes') ?? $serviceRequest->notes }}</textarea>
                                    @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="mt-8">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-6">
                                <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                    <i class="fas fa-folder-open text-yellow-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Dokumen Pendukung</h3>
                            </div>

                            <!-- Dokumen Pendukung Existing -->
                            @if($serviceRequest->required_documents && count($serviceRequest->required_documents) > 0)
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-4">Dokumen Saat Ini</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @foreach($serviceRequest->required_documents as $index => $document)
                                    <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
                                        <div class="text-center">
                                            <i class="fas fa-file-alt text-3xl text-blue-600 mb-3"></i>
                                            <p class="text-sm font-medium text-gray-900 mb-2 truncate">{{ basename($document) }}</p>
                                            <div class="flex items-center justify-center mb-3">
                                                <input type="checkbox" name="remove_documents[]" value="{{ $index }}" id="remove_doc_{{ $index }}" class="mr-2">
                                                <label for="remove_doc_{{ $index }}" class="text-sm text-red-600">Hapus</label>
                                            </div>
                                            <a href="{{ Storage::url($document) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Upload Dokumen Baru -->
                            <div>
                                <label for="required_documents" class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen Baru (Opsional)</label>
                                <input type="file" name="required_documents[]" id="required_documents" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('required_documents') border-red-500 @enderror" multiple accept=".pdf,.jpg,.jpeg,.png">
                                <p class="mt-2 text-sm text-gray-500">Upload dokumen pendukung tambahan (PDF, JPG, PNG). Maksimal 5 file, masing-masing 2MB.</p>
                                @error('required_documents')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Template Variables (Dynamic based on service type) -->
                    <div id="template-variables" class="mt-8" style="{{ $serviceRequest->template_variables ? '' : 'display: none;' }}">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-6">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                    <i class="fas fa-list-alt text-purple-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Informasi Tambahan</h3>
                            </div>
                            <div id="variables-container" class="grid grid-cols-1 lg:grid-cols-2 gap-6"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>
                            Update Permohonan
                        </button>
                        <a href="{{ route('admin.service-requests.show', $serviceRequest) }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

@push('scripts')
<script>
$(document).ready(function() {
    // Template variables untuk setiap jenis surat
    const templateVariables = {
        'surat_keterangan_domisili': [
            { name: 'alamat_lengkap', label: 'Alamat Lengkap', type: 'textarea', required: true },
            { name: 'rt_rw', label: 'RT/RW', type: 'text', required: true },
            { name: 'kelurahan', label: 'Kelurahan/Desa', type: 'text', required: true },
            { name: 'kecamatan', label: 'Kecamatan', type: 'text', required: true },
            { name: 'lama_tinggal', label: 'Lama Tinggal', type: 'text', required: true }
        ],
        'surat_keterangan_usaha': [
            { name: 'nama_usaha', label: 'Nama Usaha', type: 'text', required: true },
            { name: 'jenis_usaha', label: 'Jenis Usaha', type: 'text', required: true },
            { name: 'alamat_usaha', label: 'Alamat Usaha', type: 'textarea', required: true },
            { name: 'modal_usaha', label: 'Modal Usaha', type: 'text', required: false },
            { name: 'lama_usaha', label: 'Lama Usaha', type: 'text', required: true }
        ],
        'surat_keterangan_tidak_mampu': [
            { name: 'penghasilan_perbulan', label: 'Penghasilan Per Bulan', type: 'text', required: true },
            { name: 'jumlah_tanggungan', label: 'Jumlah Tanggungan', type: 'number', required: true },
            { name: 'pekerjaan', label: 'Pekerjaan', type: 'text', required: true },
            { name: 'keperluan_bantuan', label: 'Keperluan Bantuan', type: 'textarea', required: true }
        ],
        'surat_pengantar_nikah': [
            { name: 'nama_calon_pasangan', label: 'Nama Calon Pasangan', type: 'text', required: true },
            { name: 'tempat_lahir_pasangan', label: 'Tempat Lahir Pasangan', type: 'text', required: true },
            { name: 'tanggal_lahir_pasangan', label: 'Tanggal Lahir Pasangan', type: 'date', required: true },
            { name: 'alamat_pasangan', label: 'Alamat Pasangan', type: 'textarea', required: true },
            { name: 'rencana_tanggal_nikah', label: 'Rencana Tanggal Nikah', type: 'date', required: true }
        ],
        'surat_keterangan_kelahiran': [
            { name: 'nama_bayi', label: 'Nama Bayi', type: 'text', required: true },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: ['Laki-laki', 'Perempuan'], required: true },
            { name: 'tempat_lahir', label: 'Tempat Lahir', type: 'text', required: true },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'datetime-local', required: true },
            { name: 'nama_ayah', label: 'Nama Ayah', type: 'text', required: true },
            { name: 'nama_ibu', label: 'Nama Ibu', type: 'text', required: true }
        ],
        'surat_keterangan_kematian': [
            { name: 'nama_almarhum', label: 'Nama Almarhum/Almarhumah', type: 'text', required: true },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: ['Laki-laki', 'Perempuan'], required: true },
            { name: 'umur', label: 'Umur', type: 'number', required: true },
            { name: 'tanggal_kematian', label: 'Tanggal Kematian', type: 'datetime-local', required: true },
            { name: 'tempat_kematian', label: 'Tempat Kematian', type: 'text', required: true },
            { name: 'sebab_kematian', label: 'Sebab Kematian', type: 'text', required: true }
        ]
    };

    // Existing template variables from database
    const existingVariables = @json($serviceRequest->template_variables ?? []);

    // Handle service type change
    $('#service_type').change(function() {
        const serviceType = $(this).val();
        const container = $('#variables-container');
        const templateDiv = $('#template-variables');
        
        container.empty();
        
        if (serviceType && templateVariables[serviceType]) {
            const variables = templateVariables[serviceType];
            
            variables.forEach(function(variable) {
                let inputHtml = '';
                const existingValue = existingVariables[variable.name] || '';
                
                if (variable.type === 'select') {
                    inputHtml = `<select name="template_variables[${variable.name}]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors ${variable.required ? 'required' : ''}">`;
                    inputHtml += '<option value="">Pilih...</option>';
                    variable.options.forEach(function(option) {
                        const selected = existingValue === option ? 'selected' : '';
                        inputHtml += `<option value="${option}" ${selected}>${option}</option>`;
                    });
                    inputHtml += '</select>';
                } else if (variable.type === 'textarea') {
                    inputHtml = `<textarea name="template_variables[${variable.name}]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors ${variable.required ? 'required' : ''}" rows="3">${existingValue}</textarea>`;
                } else {
                    inputHtml = `<input type="${variable.type}" name="template_variables[${variable.name}]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors ${variable.required ? 'required' : ''}" value="${existingValue}">`;
                }
                
                const fieldHtml = `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">${variable.label} ${variable.required ? '<span class="text-red-500">*</span>' : ''}</label>
                        ${inputHtml}
                    </div>
                `;
                
                container.append(fieldHtml);
            });
            
            templateDiv.show();
        } else {
            templateDiv.hide();
        }
    });

    // Trigger change event on page load
    $('#service_type').trigger('change');
});
</script>
@endpush