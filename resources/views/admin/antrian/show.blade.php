@extends('layouts.main')

@section('title', 'Detail Antrian')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 mb-6">
    <h1 class="text-2xl font-bold text-white mb-2">Detail Antrian</h1>
    <p class="text-blue-100">Informasi lengkap antrian {{ $antrian->nomor_antrian }}</p>
</div>
<!-- Success Message -->
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>
@endif

<!-- Error Message -->
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Antrian -->
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>
                            Informasi Antrian
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Antrian</label>
                                <p class="text-lg font-bold text-blue-600">{{ $antrian->nomor_antrian }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                @php
                                    $statusColors = [
                                        'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'Dipanggil' => 'bg-blue-100 text-blue-800',
                                        'Dilayani' => 'bg-green-100 text-green-800',
                                        'Selesai' => 'bg-gray-100 text-gray-800',
                                        'Batal' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$antrian->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $antrian->status }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                                <p class="text-gray-900">{{ $antrian->jenis_layanan }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Waktu</label>
                                <p class="text-gray-900">{{ $antrian->estimasi_waktu ? $antrian->estimasi_waktu . ' menit' : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pengunjung -->
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user text-green-600 mr-2"></i>
                            Data Pengunjung
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <p class="text-gray-900 font-medium">{{ $antrian->nama_pengunjung }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                <p class="text-gray-900">{{ $antrian->nik_pengunjung ?: '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <p class="text-gray-900">{{ $antrian->phone_pengunjung }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Kunjungan -->
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-calendar text-purple-600 mr-2"></i>
                            Jadwal Kunjungan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan</label>
                                <p class="text-gray-900 font-medium">{{ $antrian->tanggal_kunjungan->format('d F Y') }}</p>
                                <p class="text-sm text-gray-500">{{ $antrian->tanggal_kunjungan->diffForHumans() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Kunjungan</label>
                                <p class="text-gray-900 font-medium">{{ $antrian->jam_kunjungan->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Keperluan dan Catatan -->
                    @if($antrian->keperluan || $antrian->catatan)
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-sticky-note text-orange-600 mr-2"></i>
                            Keperluan dan Catatan
                        </h3>
                        @if($antrian->keperluan)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
                            <p class="text-gray-900">{{ $antrian->keperluan }}</p>
                        </div>
                        @endif
                        @if($antrian->catatan)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <p class="text-gray-900">{{ $antrian->catatan }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Waktu Pelayanan -->
                    @if($antrian->waktu_mulai_layanan || $antrian->waktu_selesai_layanan)
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-stopwatch text-indigo-600 mr-2"></i>
                            Waktu Pelayanan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($antrian->waktu_mulai_layanan)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Layanan</label>
                                <p class="text-gray-900">{{ $antrian->waktu_mulai_layanan->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-500">{{ $antrian->waktu_mulai_layanan->diffForHumans() }}</p>
                            </div>
                            @endif
                            @if($antrian->waktu_selesai_layanan)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Selesai Layanan</label>
                                <p class="text-gray-900">{{ $antrian->waktu_selesai_layanan->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-500">{{ $antrian->waktu_selesai_layanan->diffForHumans() }}</p>
                            </div>
                            @endif
                        </div>
                        @if($antrian->waktu_mulai_layanan && $antrian->waktu_selesai_layanan)
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-clock mr-1"></i>
                                Durasi pelayanan: {{ $antrian->waktu_mulai_layanan->diffInMinutes($antrian->waktu_selesai_layanan) }} menit
                            </p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Actions -->
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-tasks text-blue-600 mr-2"></i>
                            Aksi Status
                        </h3>
                        <div class="space-y-3">
                            @if($antrian->status === 'Menunggu')
                                <form action="{{ route('admin.antrian.call', $antrian) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-phone mr-2"></i>Panggil Antrian
                                    </button>
                                </form>
                                <form action="{{ route('admin.antrian.serve', $antrian) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors">
                                        <i class="fas fa-play mr-2"></i>Mulai Layani
                                    </button>
                                </form>
                                <form action="{{ route('admin.antrian.cancel', $antrian) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors" onclick="return confirm('Yakin ingin membatalkan antrian ini?')">
                                        <i class="fas fa-times mr-2"></i>Batalkan
                                    </button>
                                </form>
                            @elseif($antrian->status === 'Dipanggil')
                                <form action="{{ route('admin.antrian.serve', $antrian) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors">
                                        <i class="fas fa-play mr-2"></i>Mulai Layani
                                    </button>
                                </form>
                                <form action="{{ route('admin.antrian.cancel', $antrian) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors" onclick="return confirm('Yakin ingin membatalkan antrian ini?')">
                                        <i class="fas fa-times mr-2"></i>Batalkan
                                    </button>
                                </form>
                            @elseif($antrian->status === 'Dilayani')
                                <form action="{{ route('admin.antrian.complete', $antrian) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                                        <i class="fas fa-check mr-2"></i>Selesaikan
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-gray-500">Tidak ada aksi yang tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Petugas Pelayanan -->
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-tie text-indigo-600 mr-2"></i>
                            Petugas Pelayanan
                        </h3>
                        @if($antrian->server)
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $antrian->server->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $antrian->server->email }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Belum ada petugas yang ditugaskan</p>
                        @endif
                    </div>

                    <!-- Informasi Sistem -->
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                            Informasi Sistem
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dibuat:</span>
                                <span class="text-gray-900">{{ $antrian->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diperbarui:</span>
                                <span class="text-gray-900">{{ $antrian->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl card-shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-bolt text-yellow-600 mr-2"></i>
                            Aksi Cepat
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.antrian.edit', $antrian) }}" class="w-full px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>Edit Antrian
                            </a>
                            <a href="{{ route('admin.antrian.index') }}" class="w-full px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-list mr-2"></i>Daftar Antrian
                            </a>
                            <a href="{{ route('admin.antrian.create') }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i>Tambah Antrian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
}
</script>
@endsection