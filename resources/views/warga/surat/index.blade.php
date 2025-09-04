@extends('layouts.warga')

@section('title', 'Dashboard Warga')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100">Kelola pengajuan surat dan pantau status layanan Anda dengan mudah.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Surat -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Surat</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Semua pengajuan surat Anda</span>
            </div>
        </div>

        <!-- Surat Pending -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Surat Pending</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Menunggu verifikasi</span>
            </div>
        </div>

        <!-- Surat Diproses -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Surat Diproses</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['diproses']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cog text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Sedang dalam proses</span>
            </div>
        </div>

        <!-- Surat Selesai -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Surat Selesai</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['selesai']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-500 font-medium">Siap diunduh</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('warga.surat.create') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Ajukan Surat Baru</p>
                    <p class="text-sm text-gray-500">Buat pengajuan surat</p>
                </div>
            </a>
            
            <a href="{{ route('warga.surat.list') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Riwayat Surat</p>
                    <p class="text-sm text-gray-500">Lihat semua surat</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bell text-white"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Notifikasi</p>
                    <p class="text-sm text-gray-500">Lihat pemberitahuan</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
            <a href="{{ route('warga.surat.list') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        
        <div class="space-y-4">
            @forelse($recentSurat as $item)
                <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center
                            @switch($item->status)
                                @case('Pending')
                                    bg-yellow-100
                                    @break
                                @case('Diproses')
                                    bg-blue-100
                                    @break
                                @case('Selesai')
                                    bg-green-100
                                    @break
                                @case('Ditolak')
                                    bg-red-100
                                    @break
                                @default
                                    bg-gray-100
                            @endswitch">
                            <i class="fas fa-file-alt text-sm
                                @switch($item->status)
                                    @case('Pending')
                                        text-yellow-600
                                        @break
                                    @case('Diproses')
                                        text-blue-600
                                        @break
                                    @case('Selesai')
                                        text-green-600
                                        @break
                                    @case('Ditolak')
                                        text-red-600
                                        @break
                                    @default
                                        text-gray-600
                                @endswitch"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                Surat {{ $item->jenis_surat }} - {{ $item->nomor_surat }}
                            </p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @switch($item->status)
                                    @case('Pending')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @case('Diproses')
                                        bg-blue-100 text-blue-800
                                        @break
                                    @case('Selesai')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('Ditolak')
                                        bg-red-100 text-red-800
                                        @break
                                    @default
                                        bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $item->status }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">{{ Str::limit($item->keperluan, 60) }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('warga.surat.show', $item) }}" 
                           class="text-gray-400 hover:text-gray-600" title="Lihat Detail">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-file-alt text-gray-300 text-3xl mb-3"></i>
                    <p class="text-sm text-gray-500">Belum ada aktivitas surat</p>
                    <a href="{{ route('warga.surat.create') }}" class="text-sm text-blue-600 hover:text-blue-800 mt-2 inline-block">
                        Ajukan surat pertama Anda
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection