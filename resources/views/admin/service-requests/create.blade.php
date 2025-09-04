<x-admin-layout>
    <x-slot name="header">
        Tambah Permohonan Surat
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tambah Permohonan Surat</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Buat permohonan layanan surat baru untuk masyarakat dengan mudah dan efisien</p>
                </div>
            </div>
        </div>
        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Informasi Permohonan</h2>
                <p class="text-sm text-gray-600 mt-1">Lengkapi form di bawah ini untuk membuat permohonan surat</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.service-requests.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Section 1: Data Pemohon -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-md font-medium text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Data Pemohon
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pilih Pemohon -->
                            <div>
                                <label for="citizen_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pemohon <span class="text-red-500">*</span>
                                </label>
                                <select name="citizen_id" id="citizen_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('citizen_id') border-red-500 @enderror" required>
                                    <option value="">Pilih Pemohon</option>
                                    @foreach($citizens as $citizen)
                                    <option value="{{ $citizen->id }}" {{ old('citizen_id') == $citizen->id ? 'selected' : '' }}>
                                        {{ $citizen->name }} - NIK: {{ $citizen->nik }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('citizen_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Layanan -->
                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Layanan <span class="text-red-500">*</span>
                                </label>
                                <select name="service_type" id="service_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('service_type') border-red-500 @enderror" required>
                                    <option value="">Pilih Jenis Layanan</option>
                                    <option value="surat_keterangan_domisili" {{ old('service_type') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                    <option value="surat_keterangan_usaha" {{ old('service_type') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                    <option value="surat_keterangan_tidak_mampu" {{ old('service_type') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                    <option value="surat_pengantar_nikah" {{ old('service_type') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                    <option value="surat_keterangan_kelahiran" {{ old('service_type') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                    <option value="surat_keterangan_kematian" {{ old('service_type') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                </select>
                                @error('service_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Detail Permohonan -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-md font-medium text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Detail Permohonan
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Keperluan -->
                            <div>
                                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keperluan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="purpose" id="purpose" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('purpose') border-red-500 @enderror" rows="3" placeholder="Jelaskan keperluan surat ini..." required>{{ old('purpose') }}</textarea>
                                @error('purpose')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Prioritas -->
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                                    <select name="priority" id="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('priority') border-red-500 @enderror">
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                        <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                                    </select>
                                    @error('priority')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Dibutuhkan -->
                                <div>
                                    <label for="required_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dibutuhkan</label>
                                    <input type="date" name="required_date" id="required_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('required_date') border-red-500 @enderror" value="{{ old('required_date') }}" min="{{ date('Y-m-d') }}">
                                    @error('required_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Dokumen & Catatan -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-md font-medium text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            Dokumen & Catatan
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Dokumen Pendukung -->
                            <div>
                                <label for="required_documents" class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-4">
                                        <label for="required_documents" class="cursor-pointer">
                                            <span class="mt-2 block text-sm font-medium text-gray-900">Upload dokumen pendukung</span>
                                            <span class="mt-1 block text-sm text-gray-500">PDF, JPG, PNG hingga 2MB per file (maksimal 5 file)</span>
                                        </label>
                                        <input type="file" name="required_documents[]" id="required_documents" class="sr-only @error('required_documents') border-red-500 @enderror" multiple accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                                @error('required_documents')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Catatan -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                                <textarea name="notes" id="notes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('notes') border-red-500 @enderror" rows="3" placeholder="Catatan atau informasi tambahan...">{{ old('notes') }}</textarea>
                                @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Template Variables (Dynamic based on service type) -->
                    <div id="template-variables" class="bg-gray-50 rounded-lg p-4" style="display: none;">
                        <h3 class="text-md font-medium text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informasi Tambahan
                        </h3>
                        <div id="variables-container" class="grid grid-cols-1 md:grid-cols-2 gap-6"></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #003566; color: white;" onmouseover="this.style.backgroundColor='#002347'" onmouseout="this.style.backgroundColor='#003566'">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Permohonan
                        </button>
                        <a href="{{ route('admin.service-requests.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200" style="background-color: #6b7280; color: white;" onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                
                if (variable.type === 'select') {
                    inputHtml = `<select name="template_variables[${variable.name}]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors ${variable.required ? 'required' : ''}">`;
                    inputHtml += '<option value="">Pilih...</option>';
                    variable.options.forEach(function(option) {
                        inputHtml += `<option value="${option}">${option}</option>`;
                    });
                    inputHtml += '</select>';
                } else if (variable.type === 'textarea') {
                    inputHtml = `<textarea name="template_variables[${variable.name}]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors ${variable.required ? 'required' : ''}" rows="3"></textarea>`;
                } else {
                    inputHtml = `<input type="${variable.type}" name="template_variables[${variable.name}]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors ${variable.required ? 'required' : ''}">`;
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

    // Trigger change event if service type is already selected (for edit mode)
    if ($('#service_type').val()) {
        $('#service_type').trigger('change');
    }
    
    // File upload preview
    $('#required_documents').on('change', function() {
        const files = this.files;
        const fileList = $(this).closest('.border-dashed').find('.file-list');
        
        if (fileList.length === 0) {
            $(this).closest('.border-dashed').append('<div class="file-list mt-4 space-y-2"></div>');
        }
        
        $('.file-list').empty();
        
        if (files.length > 0) {
            Array.from(files).forEach(function(file, index) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileItem = `
                    <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">${file.name}</p>
                                <p class="text-xs text-gray-500">${fileSize} MB</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Siap upload
                            </span>
                        </div>
                    </div>
                `;
                $('.file-list').append(fileItem);
            });
        }
    });
    
    // Smooth animations for template variables
    $('#service_type').on('change', function() {
        const templateDiv = $('#template-variables');
        if ($(this).val() && templateVariables[$(this).val()]) {
            templateDiv.slideDown(300);
        } else {
            templateDiv.slideUp(300);
        }
    });
});
</script>
@endpush
</x-admin-layout>