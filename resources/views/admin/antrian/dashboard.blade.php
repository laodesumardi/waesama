@extends('layouts.main')

@section('title', 'Dashboard Antrian')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 mb-6">
    <h1 class="text-2xl font-bold text-white mb-2">Dashboard Antrian</h1>
    <p class="text-blue-100">Kelola dan pantau antrian secara real-time</p>
</div>

<div class="space-y-6">

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl card-shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.antrian.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-xl text-center transition duration-200">
                <i class="fas fa-list mr-2"></i>
                Kelola Antrian
            </a>
            <a href="{{ route('admin.antrian.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-xl text-center transition duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Antrian
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Antrian Hari Ini -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Antrian Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_antrian_today']) }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-calendar-day text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Menunggu -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($stats['menunggu']) }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-hourglass-half text-yellow-600"></i>
                </div>
            </div>
        </div>

        <!-- Sedang Dilayani -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sedang Dilayani</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['dilayani']) }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-user-clock text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($stats['selesai']) }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Batal -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Batal</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($stats['batal']) }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Antrians -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Antrian Terbaru Hari Ini</h3>
                <a href="{{ route('admin.antrian.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-4">
                @forelse($recentAntrians as $antrian)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-sm">{{ $antrian->nomor_antrian }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $antrian->nama_pengunjung }}</p>
                                <p class="text-sm text-gray-500">{{ $antrian->jenis_layanan }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($antrian->status == 'Menunggu') bg-yellow-100 text-yellow-800
                                @elseif($antrian->status == 'Dipanggil') bg-blue-100 text-blue-800
                                @elseif($antrian->status == 'Dilayani') bg-purple-100 text-purple-800
                                @elseif($antrian->status == 'Selesai') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $antrian->status }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $antrian->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-clock text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada antrian hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Layanan Statistics -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Statistik Layanan Hari Ini</h3>
                <i class="fas fa-chart-pie text-gray-400"></i>
            </div>
            <div class="space-y-4">
                @forelse($layananStats as $layanan)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-gray-700">{{ $layanan->jenis_layanan }}</span>
                        </div>
                        <div class="text-right">
                            <span class="font-semibold text-gray-800">{{ $layanan->total }}</span>
                            <span class="text-sm text-gray-500 ml-1">antrian</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-chart-pie text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada data layanan hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Status Overview -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Status Antrian Hari Ini</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center p-4 bg-yellow-50 rounded-xl">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['menunggu'] }}</p>
                <p class="text-sm text-gray-600">Menunggu</p>
            </div>
            <div class="text-center p-4 bg-blue-50 rounded-xl">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-phone text-blue-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['dipanggil'] }}</p>
                <p class="text-sm text-gray-600">Dipanggil</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-xl">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-user-clock text-purple-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-purple-600">{{ $stats['dilayani'] }}</p>
                <p class="text-sm text-gray-600">Dilayani</p>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-xl">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-green-600">{{ $stats['selesai'] }}</p>
                <p class="text-sm text-gray-600">Selesai</p>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-xl">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-red-600">{{ $stats['batal'] }}</p>
                <p class="text-sm text-gray-600">Batal</p>
            </div>
        </div>
    </div>
</div>

<script>
// Auto refresh every 30 seconds
setInterval(function() {
    location.reload();
}, 30000);
</script>
@endsection