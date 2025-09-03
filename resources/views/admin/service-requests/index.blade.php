<x-admin-layout>
    <x-slot name="header">
        Manajemen Permohonan Surat
    </x-slot>

    <div class="space-y-6">
        <div class="admin-card bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                    <!-- Header dengan tombol tambah -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Permohonan Surat</h3>
                        <a href="{{ route('admin.service-requests.create') }}" class="admin-btn-primary">
                            <i class="fas fa-plus"></i> Tambah Permohonan
                        </a>
                    </div>

                    <!-- Filter dan Search -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('admin.service-requests.index') }}">
                                <div class="flex">
                                    <input type="text" name="search" class="admin-input flex-1" placeholder="Cari nomor permohonan, nama..." value="{{ request('search') }}">
                                    <button class="admin-btn-secondary ml-2" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.service-requests.index') }}">
                                <select name="status" class="admin-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.service-requests.index') }}">
                                <select name="service_type" class="admin-select" onchange="this.form.submit()">
                                    <option value="">Semua Jenis</option>
                                    <option value="surat_keterangan_domisili" {{ request('service_type') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                    <option value="surat_keterangan_usaha" {{ request('service_type') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                    <option value="surat_keterangan_tidak_mampu" {{ request('service_type') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                    <option value="surat_pengantar_nikah" {{ request('service_type') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                    <option value="surat_keterangan_kelahiran" {{ request('service_type') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                    <option value="surat_keterangan_kematian" {{ request('service_type') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.service-requests.index') }}" class="admin-btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>

                    <!-- Tabel Data -->
                    <div class="admin-table-responsive">
                        <table class="admin-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Permohonan</th>
                                    <th>Pemohon</th>
                                    <th>Jenis Layanan</th>
                                    <th>Keperluan</th>
                                    <th>Status</th>
                                    <th>Prioritas</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($serviceRequests as $index => $request)
                                <tr>
                                    <td>{{ $serviceRequests->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $request->request_number }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $request->citizen->name }}</strong><br>
                                            <small class="text-muted">NIK: {{ $request->citizen->nik }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="admin-badge admin-badge-info">
                                            {{ str_replace('_', ' ', ucwords($request->service_type, '_')) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($request->purpose, 50) }}</td>
                                    <td>{!! $request->status_badge !!}</td>
                                    <td>{!! $request->priority_badge !!}</td>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="flex space-x-1" role="group">
                                            <a href="{{ route('admin.service-requests.show', $request) }}" class="admin-btn-info text-xs px-2 py-1" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($request->canBeProcessed())
                                            <a href="{{ route('admin.service-requests.edit', $request) }}" class="admin-btn-warning text-xs px-2 py-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif
                                            @if($request->status === 'pending')
                                            <form action="{{ route('admin.service-requests.process', $request) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="admin-btn-primary text-xs px-2 py-1" title="Proses" onclick="return confirm('Yakin ingin memproses permohonan ini?')">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @if($request->status === 'processing')
                                            <form action="{{ route('admin.service-requests.approve', $request) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="admin-btn-success text-xs px-2 py-1" title="Setujui" onclick="return confirm('Yakin ingin menyetujui permohonan ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.service-requests.reject', $request) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="admin-btn-danger text-xs px-2 py-1" title="Tolak" onclick="return confirm('Yakin ingin menolak permohonan ini?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @if($request->canBeProcessed())
                                            <form action="{{ route('admin.service-requests.destroy', $request) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn-danger text-xs px-2 py-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus permohonan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data permohonan surat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $serviceRequests->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh setiap 30 detik untuk update status
        setInterval(function() {
            if (!document.hidden) {
                location.reload();
            }
        }, 30000);
    </script>
</x-admin-layout>