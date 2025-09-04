@extends('layouts.admin')

@section('title', 'Detail Dokumen')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Dokumen</h1>
            <p class="text-muted">Informasi lengkap dokumen {{ $document->document_number }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success">
                <i class="fas fa-download me-2"></i>Download
            </a>
            <a href="{{ route('admin.documents.preview', $document) }}" target="_blank" class="btn btn-info">
                <i class="fas fa-external-link-alt me-2"></i>Preview
            </a>
            <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Document Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Dokumen</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Dokumen</label>
                                <div class="p-2 bg-light rounded">{{ $document->document_number }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Template</label>
                                <div class="p-2 bg-light rounded">
                                    <span class="badge bg-info">{{ $document->template_name }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama File</label>
                                <div class="p-2 bg-light rounded">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>{{ $document->file_name }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ukuran File</label>
                                <div class="p-2 bg-light rounded">{{ $document->getFormattedFileSize() }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipe File</label>
                                <div class="p-2 bg-light rounded">{{ $document->mime_type }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div class="p-2 bg-light rounded">
                                    @if($document->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Dibuat Oleh</label>
                                <div class="p-2 bg-light rounded">
                                    @if($document->generatedBy)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $document->generatedBy->name }}</div>
                                                <small class="text-muted">{{ $document->generatedBy->role }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Dibuat</label>
                                <div class="p-2 bg-light rounded">
                                    <i class="fas fa-calendar me-2"></i>{{ $document->generated_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Service Request Information -->
            @if($document->serviceRequest)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Informasi Permohonan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Layanan</label>
                                <div class="p-2 bg-light rounded">{{ $document->serviceRequest->service_type }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pemohon</label>
                                <div class="p-2 bg-light rounded">
                                    @if($document->serviceRequest->citizen)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $document->serviceRequest->citizen->name }}</div>
                                                <small class="text-muted">NIK: {{ $document->serviceRequest->citizen->nik }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Permohonan</label>
                                <div class="p-2 bg-light rounded">
                                    @php
                                        $statusClass = match($document->serviceRequest->status) {
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                            'completed' => 'primary',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($document->serviceRequest->status) }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Permohonan</label>
                                <div class="p-2 bg-light rounded">
                                    <i class="fas fa-calendar me-2"></i>{{ $document->serviceRequest->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.service-requests.show', $document->serviceRequest) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Detail Permohonan
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Actions Panel -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success">
                            <i class="fas fa-download me-2"></i>Download Dokumen
                        </a>
                        
                        <a href="{{ route('admin.documents.preview', $document) }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-external-link-alt me-2"></i>Preview Dokumen
                        </a>
                        
                        <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Dokumen
                        </a>
                        
                        <hr>
                        
                        <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Hapus Dokumen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- File Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Informasi File</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
                            <i class="fas fa-file-pdf text-white fa-2x"></i>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Nama:</strong><br>
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
                    
                    <div class="mb-2">
                        <strong>Dibuat:</strong><br>
                        <small class="text-muted">{{ $document->generated_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection