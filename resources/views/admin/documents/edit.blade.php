@extends('layouts.admin')

@section('title', 'Edit Dokumen')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Dokumen</h1>
            <p class="text-muted">Ubah informasi dokumen {{ $document->document_number }}</p>
        </div>
        <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Dokumen</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service_request_id" class="form-label">Permohonan Layanan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('service_request_id') is-invalid @enderror" id="service_request_id" name="service_request_id" required>
                                        <option value="">Pilih Permohonan</option>
                                        @foreach($serviceRequests as $request)
                                            <option value="{{ $request->id }}" 
                                                {{ old('service_request_id', $document->service_request_id) == $request->id ? 'selected' : '' }}>
                                                {{ $request->service_type }} - {{ $request->citizen->name ?? 'Unknown' }}
                                                ({{ $request->created_at->format('d/m/Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_request_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="template_name" class="form-label">Nama Template <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('template_name') is-invalid @enderror" 
                                           id="template_name" name="template_name" 
                                           value="{{ old('template_name', $document->template_name) }}" 
                                           placeholder="Contoh: Surat Keterangan Domisili" required>
                                    @error('template_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="document_file" class="form-label">File Dokumen</label>
                            <input type="file" class="form-control @error('document_file') is-invalid @enderror" 
                                   id="document_file" name="document_file" accept=".pdf,.doc,.docx">
                            <div class="form-text">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Kosongkan jika tidak ingin mengubah file. Format yang didukung: PDF, DOC, DOCX. Maksimal 10MB.
                                </small>
                            </div>
                            @error('document_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $document->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Dokumen Aktif
                                </label>
                            </div>
                            <small class="text-muted">Centang untuk mengaktifkan dokumen</small>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Current Document Info -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Dokumen Saat Ini</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
                            <i class="fas fa-file-pdf text-white fa-2x"></i>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Nomor Dokumen:</strong><br>
                        <small class="text-muted">{{ $document->document_number }}</small>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Nama File:</strong><br>
                        <small class="text-muted">{{ $document->file_name }}</small>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Ukuran:</strong><br>
                        <small class="text-muted">{{ $document->getFormattedFileSize() }}</small>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Tipe:</strong><br>
                        <small class="text-muted">{{ $document->mime_type }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Status:</strong><br>
                        @if($document->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download me-2"></i>Download
                        </a>
                        
                        <a href="{{ route('admin.documents.preview', $document) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-external-link-alt me-2"></i>Preview
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Guidelines -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Panduan Edit</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Petunjuk:</h6>
                        <ul class="mb-0 small">
                            <li>Kosongkan field file jika tidak ingin mengubah dokumen</li>
                            <li>File baru akan menggantikan file lama</li>
                            <li>Pastikan format file sesuai (PDF, DOC, DOCX)</li>
                            <li>Ukuran file maksimal 10MB</li>
                            <li>Nomor dokumen akan tetap sama</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</h6>
                        <ul class="mb-0 small">
                            <li>Perubahan akan mempengaruhi dokumen yang sudah ada</li>
                            <li>Pastikan file yang diupload sudah benar</li>
                            <li>Backup file lama jika diperlukan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // File size validation
    $('#document_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            const fileSize = file.size / 1024 / 1024; // Convert to MB
            if (fileSize > 10) {
                alert('Ukuran file terlalu besar. Maksimal 10MB.');
                $(this).val('');
                return;
            }
            
            // Show file info
            const fileName = file.name;
            const fileSizeMB = fileSize.toFixed(2);
            $(this).next('.form-text').html(
                `<small class="text-success">
                    <i class="fas fa-check-circle me-1"></i>
                    File dipilih: ${fileName} (${fileSizeMB} MB)
                </small>`
            );
        }
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        const serviceRequest = $('#service_request_id').val();
        const templateName = $('#template_name').val().trim();
        
        if (!serviceRequest) {
            e.preventDefault();
            alert('Silakan pilih permohonan layanan.');
            $('#service_request_id').focus();
            return;
        }
        
        if (!templateName) {
            e.preventDefault();
            alert('Silakan masukkan nama template.');
            $('#template_name').focus();
            return;
        }
    });
});
</script>
@endpush