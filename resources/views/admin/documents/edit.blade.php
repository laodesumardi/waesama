@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Dokumen</h3>
                </div>
                <form action="{{ route('admin.documents.update', $document) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Informasi Dokumen Saat Ini -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Informasi Dokumen Saat Ini</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Nomor Dokumen:</strong> {{ $document->document_number }}<br>
                                            <strong>Template:</strong> {{ str_replace('_', ' ', ucwords($document->template_name, '_')) }}<br>
                                            <strong>Status:</strong> 
                                            @if($document->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Dibuat:</strong> {{ $document->created_at->format('d/m/Y H:i') }}<br>
                                            <strong>Download:</strong> {{ number_format($document->download_count) }} kali<br>
                                            <strong>Ukuran:</strong> {{ $document->formatted_file_size }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Permohonan Terkait (Read-only) -->
                            @if($document->serviceRequest)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Permohonan Terkait</label>
                                    <div class="form-control-plaintext border rounded p-2 bg-light">
                                        <a href="{{ route('admin.service-requests.show', $document->serviceRequest) }}" class="text-decoration-none">
                                            {{ $document->serviceRequest->request_number }} - {{ $document->serviceRequest->citizen->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Template (Read-only) -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Template Dokumen</label>
                                    <div class="form-control-plaintext border rounded p-2 bg-light">
                                        {{ str_replace('_', ' ', ucwords($document->template_name, '_')) }}
                                    </div>
                                    <div class="form-text">Template tidak dapat diubah. Buat dokumen baru jika perlu menggunakan template lain.</div>
                                </div>
                            </div>

                            <!-- Masa Berlaku -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="valid_until" class="form-label">Berlaku Sampai</label>
                                    <input type="date" name="valid_until" id="valid_until" class="form-control @error('valid_until') is-invalid @enderror" value="{{ old('valid_until', $document->valid_until?->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
                                    @error('valid_until')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kosongkan jika dokumen tidak memiliki masa berlaku</div>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan</label>
                                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan tambahan untuk dokumen...">{{ old('notes', $document->notes) }}</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Template Variables -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Data Template</h5>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    <strong>Perhatian:</strong> Mengubah data template akan menghasilkan dokumen PDF baru dan menggantikan file yang sudah ada.
                                </div>
                                <div id="variables-container" class="row">
                                    <!-- Variables will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div id="preview-area" class="row" style="display: none;">
                            <div class="col-12">
                                <h5 class="mb-3">Preview Dokumen Baru</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="preview-content" class="border p-3" style="min-height: 400px; background: white;">
                                            <!-- Preview content will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Dokumen
                        </button>
                        <button type="button" id="preview-btn" class="btn btn-info">
                            <i class="fas fa-eye"></i> Preview Perubahan
                        </button>
                        <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                        @if($document->is_active)
                        <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Download Versi Saat Ini
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Template variables untuk setiap jenis surat
    const templateVariables = {
        'surat_keterangan_domisili': [
            { name: 'nama', label: 'Nama Lengkap', type: 'text', required: true },
            { name: 'nik', label: 'NIK', type: 'text', required: true },
            { name: 'tempat_lahir', label: 'Tempat Lahir', type: 'text', required: true },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date', required: true },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: ['Laki-laki', 'Perempuan'], required: true },
            { name: 'alamat_lengkap', label: 'Alamat Lengkap', type: 'textarea', required: true },
            { name: 'rt_rw', label: 'RT/RW', type: 'text', required: true },
            { name: 'kelurahan', label: 'Kelurahan/Desa', type: 'text', required: true },
            { name: 'kecamatan', label: 'Kecamatan', type: 'text', required: true },
            { name: 'lama_tinggal', label: 'Lama Tinggal', type: 'text', required: true },
            { name: 'keperluan', label: 'Keperluan', type: 'textarea', required: true }
        ],
        'surat_keterangan_usaha': [
            { name: 'nama', label: 'Nama Lengkap', type: 'text', required: true },
            { name: 'nik', label: 'NIK', type: 'text', required: true },
            { name: 'tempat_lahir', label: 'Tempat Lahir', type: 'text', required: true },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date', required: true },
            { name: 'alamat', label: 'Alamat', type: 'textarea', required: true },
            { name: 'nama_usaha', label: 'Nama Usaha', type: 'text', required: true },
            { name: 'jenis_usaha', label: 'Jenis Usaha', type: 'text', required: true },
            { name: 'alamat_usaha', label: 'Alamat Usaha', type: 'textarea', required: true },
            { name: 'modal_usaha', label: 'Modal Usaha', type: 'text', required: false },
            { name: 'lama_usaha', label: 'Lama Usaha', type: 'text', required: true },
            { name: 'keperluan', label: 'Keperluan', type: 'textarea', required: true }
        ],
        'surat_keterangan_tidak_mampu': [
            { name: 'nama', label: 'Nama Lengkap', type: 'text', required: true },
            { name: 'nik', label: 'NIK', type: 'text', required: true },
            { name: 'tempat_lahir', label: 'Tempat Lahir', type: 'text', required: true },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date', required: true },
            { name: 'alamat', label: 'Alamat', type: 'textarea', required: true },
            { name: 'penghasilan_perbulan', label: 'Penghasilan Per Bulan', type: 'text', required: true },
            { name: 'jumlah_tanggungan', label: 'Jumlah Tanggungan', type: 'number', required: true },
            { name: 'pekerjaan', label: 'Pekerjaan', type: 'text', required: true },
            { name: 'keperluan_bantuan', label: 'Keperluan Bantuan', type: 'textarea', required: true }
        ],
        'surat_pengantar_nikah': [
            { name: 'nama', label: 'Nama Lengkap', type: 'text', required: true },
            { name: 'nik', label: 'NIK', type: 'text', required: true },
            { name: 'tempat_lahir', label: 'Tempat Lahir', type: 'text', required: true },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date', required: true },
            { name: 'alamat', label: 'Alamat', type: 'textarea', required: true },
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
            { name: 'nik_ayah', label: 'NIK Ayah', type: 'text', required: true },
            { name: 'nama_ibu', label: 'Nama Ibu', type: 'text', required: true },
            { name: 'nik_ibu', label: 'NIK Ibu', type: 'text', required: true },
            { name: 'alamat_orangtua', label: 'Alamat Orang Tua', type: 'textarea', required: true }
        ],
        'surat_keterangan_kematian': [
            { name: 'nama_almarhum', label: 'Nama Almarhum/Almarhumah', type: 'text', required: true },
            { name: 'nik_almarhum', label: 'NIK Almarhum/Almarhumah', type: 'text', required: true },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: ['Laki-laki', 'Perempuan'], required: true },
            { name: 'umur', label: 'Umur', type: 'number', required: true },
            { name: 'tanggal_kematian', label: 'Tanggal Kematian', type: 'datetime-local', required: true },
            { name: 'tempat_kematian', label: 'Tempat Kematian', type: 'text', required: true },
            { name: 'sebab_kematian', label: 'Sebab Kematian', type: 'text', required: true },
            { name: 'nama_pelapor', label: 'Nama Pelapor', type: 'text', required: true },
            { name: 'hubungan_pelapor', label: 'Hubungan dengan Almarhum', type: 'text', required: true }
        ]
    };

    // Current document data
    const currentDocument = @json($document);
    const templateName = currentDocument.template_name;
    const existingVariables = currentDocument.template_variables || {};

    // Populate template variables
    function populateTemplateVariables() {
        const container = $('#variables-container');
        container.empty();
        
        if (templateName && templateVariables[templateName]) {
            const variables = templateVariables[templateName];
            
            variables.forEach(function(variable) {
                let inputHtml = '';
                const existingValue = existingVariables[variable.name] || '';
                
                if (variable.type === 'select') {
                    inputHtml = `<select name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}">`;
                    inputHtml += '<option value="">Pilih...</option>';
                    variable.options.forEach(function(option) {
                        const selected = existingValue === option ? 'selected' : '';
                        inputHtml += `<option value="${option}" ${selected}>${option}</option>`;
                    });
                    inputHtml += '</select>';
                } else if (variable.type === 'textarea') {
                    inputHtml = `<textarea name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}" rows="3">${existingValue}</textarea>`;
                } else {
                    inputHtml = `<input type="${variable.type}" name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}" value="${existingValue}">`;
                }
                
                const fieldHtml = `
                    <div class="col-md-6 mb-3">
                        <label class="form-label">${variable.label} ${variable.required ? '<span class="text-danger">*</span>' : ''}</label>
                        ${inputHtml}
                    </div>
                `;
                
                container.append(fieldHtml);
            });
        }
    }

    // Handle preview button
    $('#preview-btn').click(function() {
        // Validate required fields
        let isValid = true;
        $('.required').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Lengkapi semua field yang wajib diisi');
            return;
        }
        
        // Show loading
        $('#preview-content').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Memuat preview...</div>');
        $('#preview-area').show();
        
        // Simulate preview content (in real implementation, this would be an AJAX call)
        setTimeout(function() {
            let previewHtml = `
                <div class="text-center mb-4">
                    <h4>PEMERINTAH KABUPATEN/KOTA</h4>
                    <h4>KECAMATAN [NAMA KECAMATAN]</h4>
                    <hr>
                </div>
                <div class="text-center mb-4">
                    <h5><u>${templateName.replace(/_/g, ' ').toUpperCase()}</u></h5>
                    <p>Nomor: ${currentDocument.document_number}</p>
                </div>
                <div class="mb-4">
                    <p>Yang bertanda tangan di bawah ini, Camat [NAMA KECAMATAN], menerangkan bahwa:</p>
                </div>
            `;
            
            // Add template-specific content
            const variables = templateVariables[templateName];
            if (variables) {
                previewHtml += '<table class="table table-borderless">';
                variables.forEach(function(variable) {
                    const value = $(`[name="template_variables[${variable.name}]"]`).val() || '[' + variable.label.toUpperCase() + ']';
                    previewHtml += `<tr><td width="30%">${variable.label}</td><td>: ${value}</td></tr>`;
                });
                previewHtml += '</table>';
            }
            
            previewHtml += `
                <div class="mt-4">
                    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
                </div>
                <div class="row mt-5">
                    <div class="col-6"></div>
                    <div class="col-6 text-center">
                        <p>[TEMPAT], ${new Date().toLocaleDateString('id-ID')}</p>
                        <p>Camat [NAMA KECAMATAN]</p>
                        <br><br><br>
                        <p><u>[NAMA CAMAT]</u></p>
                        <p>NIP. [NIP CAMAT]</p>
                    </div>
                </div>
            `;
            
            $('#preview-content').html(previewHtml);
        }, 1000);
    });

    // Initialize template variables
    populateTemplateVariables();

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        $('.required').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Lengkapi semua field yang wajib diisi');
            return false;
        }
        
        // Confirm if user wants to regenerate document
        if (!confirm('Apakah Anda yakin ingin mengupdate dokumen ini? File PDF akan dibuat ulang dan menggantikan file yang sudah ada.')) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endpush