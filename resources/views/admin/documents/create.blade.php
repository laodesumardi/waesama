@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buat Dokumen Baru</h3>
                </div>
                <form action="{{ route('admin.documents.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Pilih Permohonan (Opsional) -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service_request_id" class="form-label">Permohonan Terkait (Opsional)</label>
                                    <select name="service_request_id" id="service_request_id" class="form-select @error('service_request_id') is-invalid @enderror">
                                        <option value="">Pilih Permohonan (Opsional)</option>
                                        @foreach($serviceRequests as $request)
                                        <option value="{{ $request->id }}" {{ (old('service_request_id') ?? request('service_request_id')) == $request->id ? 'selected' : '' }}>
                                            {{ $request->request_number }} - {{ $request->citizen->name }} ({{ str_replace('_', ' ', ucwords($request->service_type, '_')) }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('service_request_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Jika dipilih, data akan otomatis terisi dari permohonan</div>
                                </div>
                            </div>

                            <!-- Template -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="template_name" class="form-label">Template Dokumen <span class="text-danger">*</span></label>
                                    <select name="template_name" id="template_name" class="form-select @error('template_name') is-invalid @enderror" required>
                                        <option value="">Pilih Template</option>
                                        <option value="surat_keterangan_domisili" {{ old('template_name') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                        <option value="surat_keterangan_usaha" {{ old('template_name') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                        <option value="surat_keterangan_tidak_mampu" {{ old('template_name') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                        <option value="surat_pengantar_nikah" {{ old('template_name') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                        <option value="surat_keterangan_kelahiran" {{ old('template_name') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                        <option value="surat_keterangan_kematian" {{ old('template_name') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                    </select>
                                    @error('template_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Masa Berlaku -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="valid_until" class="form-label">Berlaku Sampai (Opsional)</label>
                                    <input type="date" name="valid_until" id="valid_until" class="form-control @error('valid_until') is-invalid @enderror" value="{{ old('valid_until') }}" min="{{ date('Y-m-d') }}">
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
                                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan tambahan untuk dokumen...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Template Variables (Dynamic based on template) -->
                        <div id="template-variables" class="row" style="display: none;">
                            <div class="col-12">
                                <h5 class="mb-3">Data Dokumen</h5>
                                <div id="variables-container"></div>
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div id="preview-area" class="row" style="display: none;">
                            <div class="col-12">
                                <h5 class="mb-3">Preview Dokumen</h5>
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
                            <i class="fas fa-file-pdf"></i> Generate Dokumen
                        </button>
                        <button type="button" id="preview-btn" class="btn btn-info" style="display: none;">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
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

    // Handle service request change
    $('#service_request_id').change(function() {
        const serviceRequestId = $(this).val();
        
        if (serviceRequestId) {
            // Auto-fill template based on service request
            const selectedOption = $(this).find('option:selected');
            const text = selectedOption.text();
            
            // Extract service type from option text
            if (text.includes('Surat Keterangan Domisili')) {
                $('#template_name').val('surat_keterangan_domisili').trigger('change');
            } else if (text.includes('Surat Keterangan Usaha')) {
                $('#template_name').val('surat_keterangan_usaha').trigger('change');
            } else if (text.includes('Surat Keterangan Tidak Mampu')) {
                $('#template_name').val('surat_keterangan_tidak_mampu').trigger('change');
            } else if (text.includes('Surat Pengantar Nikah')) {
                $('#template_name').val('surat_pengantar_nikah').trigger('change');
            } else if (text.includes('Surat Keterangan Kelahiran')) {
                $('#template_name').val('surat_keterangan_kelahiran').trigger('change');
            } else if (text.includes('Surat Keterangan Kematian')) {
                $('#template_name').val('surat_keterangan_kematian').trigger('change');
            }
        }
    });

    // Handle template change
    $('#template_name').change(function() {
        const templateName = $(this).val();
        const container = $('#variables-container');
        const templateDiv = $('#template-variables');
        const previewBtn = $('#preview-btn');
        
        container.empty();
        
        if (templateName && templateVariables[templateName]) {
            const variables = templateVariables[templateName];
            
            variables.forEach(function(variable) {
                let inputHtml = '';
                
                if (variable.type === 'select') {
                    inputHtml = `<select name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}">`;
                    inputHtml += '<option value="">Pilih...</option>';
                    variable.options.forEach(function(option) {
                        inputHtml += `<option value="${option}">${option}</option>`;
                    });
                    inputHtml += '</select>';
                } else if (variable.type === 'textarea') {
                    inputHtml = `<textarea name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}" rows="3"></textarea>`;
                } else {
                    inputHtml = `<input type="${variable.type}" name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}">`;
                }
                
                const fieldHtml = `
                    <div class="col-md-6 mb-3">
                        <label class="form-label">${variable.label} ${variable.required ? '<span class="text-danger">*</span>' : ''}</label>
                        ${inputHtml}
                    </div>
                `;
                
                container.append(fieldHtml);
            });
            
            templateDiv.show();
            previewBtn.show();
        } else {
            templateDiv.hide();
            previewBtn.hide();
            $('#preview-area').hide();
        }
    });

    // Handle preview button
    $('#preview-btn').click(function() {
        const templateName = $('#template_name').val();
        const formData = new FormData($('form')[0]);
        
        if (!templateName) {
            alert('Pilih template terlebih dahulu');
            return;
        }
        
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
                    <h5><u>${$('#template_name option:selected').text().toUpperCase()}</u></h5>
                    <p>Nomor: [NOMOR DOKUMEN]</p>
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

    // Trigger change event if template is already selected
    if ($('#template_name').val()) {
        $('#template_name').trigger('change');
    }
    
    // Trigger change event if service request is already selected
    if ($('#service_request_id').val()) {
        $('#service_request_id').trigger('change');
    }
});
</script>
@endpush