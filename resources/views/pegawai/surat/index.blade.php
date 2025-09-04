@extends('layouts.main')

@section('title', 'Layanan Surat')

@section('content')
<div class="p-6">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-6 text-white">
            <h1 class="text-2xl font-bold mb-2">Layanan Surat</h1>
            <p class="text-blue-100">Kelola dan proses permohonan surat-menyurat dari masyarakat</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Surat Saya Proses -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Surat Saya Proses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['surat_diproses'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Hari ini</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Selesai -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Surat Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['surat_selesai'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Hari ini</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Surat Pending -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Surat Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['surat_pending'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">Menunggu proses</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Tugas Hari Ini -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tugas Hari Ini</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-yellow-100 rounded-full">
                            <i class="fas fa-file-alt text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Proses Surat Baru</p>
                            <p class="text-sm text-gray-600">{{ $stats['surat_pending'] ?? 0 }} surat menunggu</p>
                        </div>
                    </div>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Urgent</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 rounded-full">
                            <i class="fas fa-edit text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Review Surat</p>
                            <p class="text-sm text-gray-600">{{ $stats['surat_diproses'] ?? 0 }} surat dalam proses</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Normal</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="#" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                    <div class="text-center">
                        <div class="p-3 bg-blue-100 rounded-full inline-flex mb-2 group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Proses Surat</p>
                    </div>
                </a>
                
                <a href="#" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-200 group">
                    <div class="text-center">
                        <div class="p-3 bg-green-100 rounded-full inline-flex mb-2 group-hover:bg-green-200 transition-colors">
                            <i class="fas fa-search text-green-600 text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-green-700">Cari Surat</p>
                    </div>
                </a>
                
                <a href="{{ route('pegawai.penduduk.index') }}" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group">
                    <div class="text-center">
                        <div class="p-3 bg-purple-100 rounded-full inline-flex mb-2 group-hover:bg-purple-200 transition-colors">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Cari Data</p>
                    </div>
                </a>
                
                <a href="{{ route('pegawai.laporan.index') }}" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-all duration-200 group">
                    <div class="text-center">
                        <div class="p-3 bg-orange-100 rounded-full inline-flex mb-2 group-hover:bg-orange-200 transition-colors">
                            <i class="fas fa-chart-bar text-orange-600 text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-orange-700">Laporan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Service Progress & Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Service Progress -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Progress Layanan</h3>
                <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700">Surat Diproses</span>
                        <span class="text-sm text-gray-500">{{ $stats['progress_surat'] ?? 75 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stats['progress_surat'] ?? 75 }}%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700">Kepuasan Layanan</span>
                        <span class="text-sm text-gray-500">{{ $stats['kepuasan'] ?? 92 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $stats['kepuasan'] ?? 92 }}%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700">Efisiensi Waktu</span>
                        <span class="text-sm text-gray-500">{{ $stats['efisiensi'] ?? 88 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $stats['efisiensi'] ?? 88 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-blue-100 rounded-full">
                        <i class="fas fa-file-alt text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Memproses surat domisili</p>
                        <p class="text-xs text-gray-500">Atas nama Ahmad Fauzi - 2 menit lalu</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-green-100 rounded-full">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Menyelesaikan surat SKTM</p>
                        <p class="text-xs text-gray-500">Atas nama Siti Aminah - 15 menit lalu</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-yellow-100 rounded-full">
                        <i class="fas fa-edit text-yellow-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Merevisi surat usaha</p>
                        <p class="text-xs text-gray-500">Atas nama Budi Santoso - 30 menit lalu</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-purple-100 rounded-full">
                        <i class="fas fa-download text-purple-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">Mengunduh surat pengantar</p>
                        <p class="text-xs text-gray-500">Atas nama Dewi Lestari - 1 jam lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection