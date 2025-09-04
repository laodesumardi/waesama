@extends('layouts.admin')

@section('title', 'Tambah Dokumen')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tambah Dokumen</h1>
            <p class="text-muted">Buat dokumen baru untuk permohonan layanan</p>
        </div>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Dokumen</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Service Request Selection -->
                        <div class="mb-3">
                            <label for="service_request_id" class="form-label">Permohonan Layanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('service_request_id') is-invalid @enderror" id="service_request_id" name="service_request_id" required>
                                <option value="">Pilih Permohonan Layanan</option>
                                @foreach(\App\Models\ServiceRequest::with('citizen')->where('status', 'approved')->get() as $serviceRequest)
                                    <option value="{{ $serviceRequest->id }}" {{ old('service_request_id') == $serviceRequest->id ? 'selected' : '' }}>
                                        {{ $serviceRequest->service_type }} - {{ $serviceRequest->citizen->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_request_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Pilih permohonan layanan yang sudah disetujui</div>
                        </div>

                        <!-- Template Name -->
                        <div class="mb-3">
                            <label for="template_name" class="form-label">Nama Template <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('template_name') is-invalid @enderror" id="template_name" name="template_name" value="{{ old('template_name') }}" required placeholder="Contoh: Surat Keterangan Domisili">
                            @error('template_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Masukkan nama template dokumen</div>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="file" class="form-label">File Dokumen <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.doc,.docx" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload file dokumen (PDF, DOC, DOCX). Maksimal 10MB</div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Dokumen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Help Panel -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Panduan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary"><i class="fas fa-info-circle me-2"></i>Format File</h6>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-check text-success me-2"></i>PDF (.pdf)</li>
                            <li><i class="fas fa-check text-success me-2"></i>Microsoft Word (.doc, .docx)</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-primary"><i class="fas fa-exclamation-triangle me-2"></i>Persyaratan</h6>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-check text-success me-2"></i>Ukuran maksimal 10MB</li>
                            <li><i class="fas fa-check text-success me-2"></i>Permohonan harus sudah disetujui</li>
                            <li><i class="fas fa-check text-success me-2"></i>Nama template harus jelas</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tips:</strong> Pastikan dokumen sudah final dan siap untuk diserahkan kepada pemohon.
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
        // File upload preview
        $('#file').on('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileName = file.name;
                
                if (fileSize > 10) {
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                    $(this).val('');
                    return;
                }
                
                // Show file info
                const fileInfo = `<div class="mt-2 p-2 bg-light rounded"><i class="fas fa-file me-2"></i>${fileName} (${fileSize} MB)</div>`;
                $(this).parent().find('.file-info').remove();
                $(this).parent().append(`<div class="file-info">${fileInfo}</div>`);
            }
        });
        
        // Service request selection change
        $('#service_request_id').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            if (selectedOption.val()) {
                const serviceType = selectedOption.text().split(' - ')[0];
                $('#template_name').val(`Dokumen ${serviceType}`);
            }
        });
    });
</script>
@endpush