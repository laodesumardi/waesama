<x-admin-layout>
    <x-slot name="header">
        Manajemen Dokumen
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                    <!-- Header dengan tombol tambah -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Dokumen</h3>
                        <a href="{{ route('admin.documents.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-plus"></i> Buat Dokumen
                        </a>
                    </div>

                    <!-- Filter dan Search -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('admin.documents.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nomor dokumen, template..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.documents.index') }}">
                                <select name="template" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Template</option>
                                    <option value="surat_keterangan_domisili" {{ request('template') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                    <option value="surat_keterangan_usaha" {{ request('template') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                    <option value="surat_keterangan_tidak_mampu" {{ request('template') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                    <option value="surat_pengantar_nikah" {{ request('template') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                    <option value="surat_keterangan_kelahiran" {{ request('template') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                    <option value="surat_keterangan_kematian" {{ request('template') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.documents.index') }}">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>

                    <!-- Statistik -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $stats['total'] ?? 0 }}</h4>
                                            <p class="mb-0">Total Dokumen</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-file-alt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $stats['active'] ?? 0 }}</h4>
                                            <p class="mb-0">Dokumen Aktif</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $stats['this_month'] ?? 0 }}</h4>
                                            <p class="mb-0">Bulan Ini</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $stats['downloads'] ?? 0 }}</h4>
                                            <p class="mb-0">Total Download</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-download fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Dokumen</th>
                                    <th>Template</th>
                                    <th>Permohonan</th>
                                    <th>Pemohon</th>
                                    <th>Status</th>
                                    <th>Ukuran File</th>
                                    <th>Download</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $index => $document)
                                <tr>
                                    <td>{{ $documents->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $document->document_number }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ str_replace('_', ' ', ucwords($document->template_name, '_')) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($document->serviceRequest)
                                        <a href="{{ route('admin.service-requests.show', $document->serviceRequest) }}" class="text-decoration-none">
                                            {{ $document->serviceRequest->request_number }}
                                        </a>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($document->serviceRequest && $document->serviceRequest->citizen)
                                        <div>
                                            <strong>{{ $document->serviceRequest->citizen->name }}</strong><br>
                                            <small class="text-muted">NIK: {{ $document->serviceRequest->citizen->nik }}</small>
                                        </div>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($document->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                        @if($document->valid_until && $document->valid_until < now())
                                        <br><span class="badge bg-danger mt-1">Kedaluwarsa</span>
                                        @endif
                                    </td>
                                    <td>{{ $document->formatted_file_size }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $document->download_count }}</span>
                                    </td>
                                    <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.documents.preview', $document) }}" target="_blank" class="btn btn-sm btn-primary" title="Preview">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-sm btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($document->is_active)
                                            <form action="{{ route('admin.documents.deactivate', $document) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-secondary" title="Nonaktifkan" onclick="return confirm('Yakin ingin menonaktifkan dokumen ini?')">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('admin.documents.activate', $document) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" title="Aktifkan" onclick="return confirm('Yakin ingin mengaktifkan dokumen ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus dokumen ini? File juga akan dihapus.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data dokumen</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $documents->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh setiap 60 detik untuk update statistik
        setInterval(function() {
            if (!document.hidden) {
                location.reload();
            }
        }, 60000);
    </script>
</x-admin-layout>