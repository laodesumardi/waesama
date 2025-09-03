@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detail Dokumen</h3>
                    <div class="btn-group">
                        @if($document->is_active)
                            <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                            <a href="{{ route('admin.documents.preview', $document) }}" class="btn btn-info btn-sm" target="_blank">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                        @endif
                        <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if($document->is_active)
                            <form action="{{ route('admin.documents.deactivate', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menonaktifkan dokumen ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-ban"></i> Nonaktifkan
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.documents.activate', $document) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Aktifkan
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini? Data yang sudah dihapus tidak dapat dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Dokumen -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Dokumen</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nomor Dokumen</strong></td>
                                    <td>: {{ $document->document_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Template</strong></td>
                                    <td>: {{ str_replace('_', ' ', ucwords($document->template_name, '_')) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: 
                                        @if($document->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Ukuran File</strong></td>
                                    <td>: {{ $document->formatted_file_size }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Download</strong></td>
                                    <td>: {{ number_format($document->download_count) }} kali</td>
                                </tr>
                                <tr>
                                    <td><strong>Masa Berlaku</strong></td>
                                    <td>: 
                                        @if($document->valid_until)
                                            {{ $document->valid_until->format('d/m/Y') }}
                                            @if($document->is_valid)
                                                <span class="badge bg-success ms-1">Valid</span>
                                            @else
                                                <span class="badge bg-danger ms-1">Kadaluarsa</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Tidak terbatas</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat Tanggal</strong></td>
                                    <td>: {{ $document->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate Tanggal</strong></td>
                                    <td>: {{ $document->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Permohonan Terkait -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Terkait</h5>
                            <table class="table table-borderless">
                                @if($document->serviceRequest)
                                <tr>
                                    <td width="40%"><strong>Permohonan</strong></td>
                                    <td>: 
                                        <a href="{{ route('admin.service-requests.show', $document->serviceRequest) }}" class="text-decoration-none">
                                            {{ $document->serviceRequest->request_number }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pemohon</strong></td>
                                    <td>: {{ $document->serviceRequest->citizen->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>NIK Pemohon</strong></td>
                                    <td>: {{ $document->serviceRequest->citizen->nik }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Layanan</strong></td>
                                    <td>: {{ str_replace('_', ' ', ucwords($document->serviceRequest->service_type, '_')) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status Permohonan</strong></td>
                                    <td>: {!! $document->serviceRequest->status_badge !!}</td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="2">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle"></i> Dokumen ini dibuat secara manual, tidak terkait dengan permohonan tertentu.
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Dibuat Oleh</strong></td>
                                    <td>: {{ $document->generatedBy->name ?? 'System' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Catatan -->
                    @if($document->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Catatan</h5>
                            <div class="alert alert-light">
                                {{ $document->notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Template Variables -->
                    @if($document->template_variables && count($document->template_variables) > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Data Template</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30%">Field</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($document->template_variables as $key => $value)
                                        <tr>
                                            <td><strong>{{ str_replace('_', ' ', ucwords($key, '_')) }}</strong></td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- File Preview (if PDF) -->
                    @if($document->is_active && $document->file_path)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Preview Dokumen</h5>
                            <div class="card">
                                <div class="card-body p-0">
                                    <iframe src="{{ route('admin.documents.preview', $document) }}" 
                                            width="100%" 
                                            height="600px" 
                                            style="border: none;">
                                        <p>Browser Anda tidak mendukung preview PDF. 
                                           <a href="{{ route('admin.documents.download', $document) }}">Download dokumen</a> untuk melihatnya.
                                        </p>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Download History (if needed) -->
                    @if($document->download_count > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Statistik Download</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($document->download_count) }}</h4>
                                            <p class="mb-0">Total Download</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4>{{ $document->formatted_file_size }}</h4>
                                            <p class="mb-0">Ukuran File</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4>{{ $document->created_at->diffForHumans() }}</h4>
                                            <p class="mb-0">Dibuat</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4>
                                                @if($document->valid_until)
                                                    {{ $document->valid_until->diffForHumans() }}
                                                @else
                                                    ∞
                                                @endif
                                            </h4>
                                            <p class="mb-0">Masa Berlaku</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    @if($document->serviceRequest)
                    <a href="{{ route('admin.service-requests.show', $document->serviceRequest) }}" class="btn btn-info">
                        <i class="fas fa-file-alt"></i> Lihat Permohonan
                    </a>
                    @endif
                    @if($document->is_active)
                    <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Download Dokumen
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto refresh download count every 30 seconds if document is being viewed
    setInterval(function() {
        // This could be implemented to refresh download statistics
        // via AJAX if needed
    }, 30000);
    
    // Handle iframe load errors
    $('iframe').on('error', function() {
        $(this).hide();
        $(this).after('<div class="alert alert-warning">Tidak dapat memuat preview dokumen. <a href="{{ route("admin.documents.download", $document) }}">Download dokumen</a> untuk melihatnya.</div>');
    });
});
</script>
@endpush