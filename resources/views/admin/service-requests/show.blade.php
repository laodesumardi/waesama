@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detail Permohonan Surat</h3>
                    <div>
                        @if($serviceRequest->canBeProcessed())
                        <a href="{{ route('admin.service-requests.edit', $serviceRequest) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('admin.service-requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Permohonan -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Permohonan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nomor Permohonan:</strong></td>
                                    <td>{{ $serviceRequest->request_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Layanan:</strong></td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ str_replace('_', ' ', ucwords($serviceRequest->service_type, '_')) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>{!! $serviceRequest->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Prioritas:</strong></td>
                                    <td>{!! $serviceRequest->priority_badge !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Dibuat:</strong></td>
                                    <td>{{ $serviceRequest->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($serviceRequest->required_date)
                                <tr>
                                    <td><strong>Tanggal Dibutuhkan:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($serviceRequest->required_date)->format('d/m/Y') }}</td>
                                </tr>
                                @endif
                                @if($serviceRequest->processed_at)
                                <tr>
                                    <td><strong>Tanggal Diproses:</strong></td>
                                    <td>{{ $serviceRequest->processed_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endif
                                @if($serviceRequest->approved_at)
                                <tr>
                                    <td><strong>Tanggal Disetujui:</strong></td>
                                    <td>{{ $serviceRequest->approved_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endif
                                @if($serviceRequest->completed_at)
                                <tr>
                                    <td><strong>Tanggal Selesai:</strong></td>
                                    <td>{{ $serviceRequest->completed_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <!-- Informasi Pemohon -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Pemohon</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nama:</strong></td>
                                    <td>{{ $serviceRequest->citizen->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>NIK:</strong></td>
                                    <td>{{ $serviceRequest->citizen->nik }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tempat, Tanggal Lahir:</strong></td>
                                    <td>{{ $serviceRequest->citizen->place_of_birth }}, {{ \Carbon\Carbon::parse($serviceRequest->citizen->date_of_birth)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin:</strong></td>
                                    <td>{{ $serviceRequest->citizen->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td>{{ $serviceRequest->citizen->address }}</td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telepon:</strong></td>
                                    <td>{{ $serviceRequest->citizen->phone ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Keperluan dan Catatan -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Keperluan</h5>
                            <p class="text-justify">{{ $serviceRequest->purpose }}</p>
                        </div>
                        @if($serviceRequest->notes)
                        <div class="col-md-6">
                            <h5 class="mb-3">Catatan</h5>
                            <p class="text-justify">{{ $serviceRequest->notes }}</p>
                        </div>
                        @endif
                    </div>

                    @if($serviceRequest->template_variables)
                    <hr>
                    <!-- Template Variables -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Tambahan</h5>
                            <div class="row">
                                @foreach($serviceRequest->template_variables as $key => $value)
                                <div class="col-md-6 mb-2">
                                    <strong>{{ str_replace('_', ' ', ucwords($key, '_')) }}:</strong>
                                    <span>{{ $value }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($serviceRequest->required_documents && count($serviceRequest->required_documents) > 0)
                    <hr>
                    <!-- Dokumen Pendukung -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Dokumen Pendukung</h5>
                            <div class="row">
                                @foreach($serviceRequest->required_documents as $document)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-alt fa-3x text-primary mb-2"></i>
                                            <p class="card-text small">{{ basename($document) }}</p>
                                            <a href="{{ Storage::url($document) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($serviceRequest->processedBy || $serviceRequest->approvedBy)
                    <hr>
                    <!-- Informasi Pemrosesan -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Pemrosesan</h5>
                            <div class="row">
                                @if($serviceRequest->processedBy)
                                <div class="col-md-6">
                                    <strong>Diproses oleh:</strong>
                                    <span>{{ $serviceRequest->processedBy->name }}</span>
                                </div>
                                @endif
                                @if($serviceRequest->approvedBy)
                                <div class="col-md-6">
                                    <strong>Disetujui oleh:</strong>
                                    <span>{{ $serviceRequest->approvedBy->name }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($serviceRequest->documents->count() > 0)
                    <hr>
                    <!-- Dokumen yang Dihasilkan -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Dokumen yang Dihasilkan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nomor Dokumen</th>
                                            <th>Template</th>
                                            <th>Status</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($serviceRequest->documents as $document)
                                        <tr>
                                            <td>{{ $document->document_number }}</td>
                                            <td>{{ str_replace('_', ' ', ucwords($document->template_name, '_')) }}</td>
                                            <td>
                                                @if($document->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                                @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-sm btn-info" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-sm btn-success" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="{{ route('admin.documents.preview', $document) }}" target="_blank" class="btn btn-sm btn-primary" title="Preview">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            @if($serviceRequest->status === 'pending')
                            <form action="{{ route('admin.service-requests.process', $serviceRequest) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin ingin memproses permohonan ini?')">
                                    <i class="fas fa-play"></i> Proses Permohonan
                                </button>
                            </form>
                            @endif

                            @if($serviceRequest->status === 'processing')
                            <form action="{{ route('admin.service-requests.approve', $serviceRequest) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin menyetujui permohonan ini?')">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.service-requests.reject', $serviceRequest) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menolak permohonan ini?')">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </form>
                            @endif

                            @if($serviceRequest->status === 'approved')
                            <a href="{{ route('admin.documents.create', ['service_request_id' => $serviceRequest->id]) }}" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i> Generate Dokumen
                            </a>
                            <form action="{{ route('admin.service-requests.complete', $serviceRequest) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin menyelesaikan permohonan ini?')">
                                    <i class="fas fa-check-double"></i> Selesaikan
                                </button>
                            </form>
                            @endif
                        </div>
                        <div class="col-md-6 text-end">
                            @if($serviceRequest->canBeProcessed())
                            <form action="{{ route('admin.service-requests.destroy', $serviceRequest) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus permohonan ini? Data yang terkait juga akan dihapus.')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection