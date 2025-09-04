@extends('layouts.main')

@section('title', 'Detail Surat')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center gap-4">
            <a href="{{ route('warga.surat.list') }}" 
               class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Surat</h1>
                <p class="text-gray-600">{{ $surat->nomor_surat }}</p>
            </div>
        </div>
    </div>

<div class="space-y-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Surat Information -->
            <div class="bg-white rounded-xl p-6 card-shadow mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Surat</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                        <p class="text-gray-900 font-mono">{{ $surat->nomor_surat }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $surat->jenis_surat }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        @if($surat->status == 'Pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Pending
                            </span>
                        @elseif($surat->status == 'Diproses')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                Diproses
                            </span>
                        @elseif($surat->status == 'Selesai')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Ditolak
                            </span>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                        <p class="text-gray-900">{{ $surat->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    
                    @if($surat->tanggal_selesai)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <p class="text-gray-900">{{ $surat->tanggal_selesai->format('d F Y, H:i') }}</p>
                    </div>
                    @endif
                    
                    @if($surat->processor)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Diproses Oleh</label>
                        <p class="text-gray-900">{{ $surat->processor->name }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Keperluan -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Keperluan</h2>
                <p class="text-gray-700 leading-relaxed">{{ $surat->keperluan }}</p>
            </div>
            
            <!-- Data Pemohon -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Data Pemohon</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <p class="text-gray-900">{{ $surat->nama_pemohon }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                        <p class="text-gray-900 font-mono">{{ $surat->nik_pemohon }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <p class="text-gray-900">{{ $surat->alamat_pemohon }}</p>
                    </div>
                    
                    @if($surat->phone_pemohon)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <p class="text-gray-900">{{ $surat->phone_pemohon }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Data Tambahan -->
            @if($surat->data_tambahan)
            <div class="bg-white rounded-xl p-6 card-shadow mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Data Tambahan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($surat->data_tambahan as $key => $value)
                        @if($value)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ ucwords(str_replace('_', ' ', $key)) }}
                            </label>
                            <p class="text-gray-900">{{ $value }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Catatan -->
            @if($surat->catatan)
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 leading-relaxed">{{ $surat->catatan }}</p>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Actions -->
            <div class="bg-white rounded-xl p-6 card-shadow mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h2>
                
                <div class="space-y-3">
                    @if($surat->status == 'Selesai' && $surat->file_surat)
                        <a href="{{ route('warga.surat.download', $surat) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download Surat
                        </a>
                    @endif
                    
                    <a href="{{ route('warga.surat.list') }}" 
                       class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Riwayat
                    </a>
                </div>
            </div>
            
            <!-- Status Timeline -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Timeline Status</h2>
                
                <div class="space-y-4">
                    <!-- Pengajuan -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">Surat Diajukan</h3>
                            <p class="text-sm text-gray-500">{{ $surat->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    <!-- Pending/Diproses -->
                    @if($surat->status != 'Pending')
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 {{ $surat->status == 'Ditolak' ? 'bg-red-100' : 'bg-blue-100' }} rounded-full flex items-center justify-center">
                            @if($surat->status == 'Ditolak')
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">
                                @if($surat->status == 'Ditolak')
                                    Surat Ditolak
                                @else
                                    Surat Diproses
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500">{{ $surat->updated_at->format('d F Y, H:i') }}</p>
                            @if($surat->processor)
                                <p class="text-sm text-gray-500">oleh {{ $surat->processor->name }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Selesai -->
                    @if($surat->status == 'Selesai')
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">Surat Selesai</h3>
                            <p class="text-sm text-gray-500">{{ $surat->tanggal_selesai ? $surat->tanggal_selesai->format('d F Y, H:i') : $surat->updated_at->format('d F Y, H:i') }}</p>
                            @if($surat->file_surat)
                                <p class="text-sm text-green-600">File surat tersedia untuk diunduh</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Pending Status -->
                    @if($surat->status == 'Pending')
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">Menunggu Verifikasi</h3>
                            <p class="text-sm text-gray-500">Surat sedang menunggu untuk diproses</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection