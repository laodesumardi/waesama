@extends('layouts.main')

@section('title', 'Detail Data Penduduk')

@section('content')
<!-- Page Header -->
<div class="bg-[#003f88] rounded-xl p-6 text-white mb-6">
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-blue-200 mb-2">
                <a href="{{ route('pegawai.dashboard') }}" class="hover:text-white">Dashboard</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('pegawai.penduduk.index') }}" class="hover:text-white">Data Penduduk</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white">Detail</span>
            </nav>
            <h2 class="text-2xl font-bold mb-2">Detail Data Penduduk</h2>
            <p class="text-blue-100">Informasi lengkap data penduduk {{ $penduduk->nama_lengkap }}</p>
        </div>
        <div class="hidden md:block">
            <i class="fas fa-user text-6xl text-blue-200"></i>
        </div>
    </div>
</div>

<!-- Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Data Identitas -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i class="fas fa-id-card text-blue-600"></i>
                Data Identitas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                    <p class="text-gray-900 font-medium">{{ $penduduk->nik }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-medium">{{ $penduduk->nama_lengkap }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tempat Lahir</label>
                    <p class="text-gray-900">{{ $penduduk->tempat_lahir }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                    <p class="text-gray-900">{{ $penduduk->tanggal_lahir->format('d F Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                    <p class="text-gray-900">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : ($penduduk->jenis_kelamin == 'P' ? 'Perempuan' : $penduduk->jenis_kelamin) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Agama</label>
                    <p class="text-gray-900">{{ $penduduk->agama }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kewarganegaraan</label>
                    <p class="text-gray-900">{{ $penduduk->kewarganegaraan }}</p>
                </div>
            </div>
        </div>
        
        <!-- Data Sosial -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i class="fas fa-graduation-cap text-blue-600"></i>
                Data Sosial
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Pendidikan</label>
                    <p class="text-gray-900">{{ $penduduk->pendidikan }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Pekerjaan</label>
                    <p class="text-gray-900">{{ $penduduk->pekerjaan }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status Perkawinan</label>
                    <p class="text-gray-900">{{ $penduduk->status_perkawinan }}</p>
                </div>
            </div>
        </div>
        
        <!-- Data Keluarga -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i class="fas fa-home text-blue-600"></i>
                Data Keluarga
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">No. KK</label>
                    <p class="text-gray-900 font-medium">{{ $penduduk->no_kk }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Hubungan Keluarga</label>
                    <p class="text-gray-900">{{ $penduduk->hubungan_keluarga }}</p>
                </div>
            </div>
        </div>
        
        <!-- Data Alamat -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-blue-600"></i>
                Data Alamat
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                    <p class="text-gray-900">{{ $penduduk->alamat }}</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">RT</label>
                        <p class="text-gray-900">{{ $penduduk->rt }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">RW</label>
                        <p class="text-gray-900">{{ $penduduk->rw }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Desa/Kelurahan</label>
                        <p class="text-gray-900">{{ $penduduk->desa_kelurahan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kode Pos</label>
                        <p class="text-gray-900">{{ $penduduk->kode_pos }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kecamatan</label>
                        <p class="text-gray-900">{{ $penduduk->kecamatan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kabupaten/Kota</label>
                        <p class="text-gray-900">{{ $penduduk->kabupaten_kota }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Provinsi</label>
                        <p class="text-gray-900">{{ $penduduk->provinsi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-600"></i>
                Status Penduduk
            </h3>
            <div class="text-center">
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full 
                    @if($penduduk->status_penduduk == 'Tetap') bg-green-100 text-green-800
                    @elseif($penduduk->status_penduduk == 'Pindah') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ $penduduk->status_penduduk }}
                </span>
            </div>
            
            @if($penduduk->status_penduduk == 'Pindah' && $penduduk->tanggal_pindah)
                <div class="mt-4 pt-4 border-t">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pindah</label>
                    <p class="text-gray-900">{{ $penduduk->tanggal_pindah->format('d F Y') }}</p>
                    @if($penduduk->alamat_pindah)
                        <label class="block text-sm font-medium text-gray-500 mb-1 mt-3">Alamat Pindah</label>
                        <p class="text-gray-900">{{ $penduduk->alamat_pindah }}</p>
                    @endif
                </div>
            @endif
            
            @if($penduduk->status_penduduk == 'Meninggal' && $penduduk->tanggal_meninggal)
                <div class="mt-4 pt-4 border-t">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Meninggal</label>
                    <p class="text-gray-900">{{ $penduduk->tanggal_meninggal->format('d F Y') }}</p>
                </div>
            @endif
        </div>
        
        <!-- Metadata -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-clock text-blue-600"></i>
                Informasi Sistem
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat</label>
                    <p class="text-gray-900 text-sm">{{ $penduduk->created_at->format('d F Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diperbarui</label>
                    <p class="text-gray-900 text-sm">{{ $penduduk->updated_at->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-bolt text-blue-600"></i>
                Aksi Cepat
            </h3>
            <div class="space-y-2">
                <a href="{{ route('pegawai.penduduk.index') }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 justify-center">
                    <i class="fas fa-list"></i>
                    Daftar Penduduk
                </a>
                <button onclick="window.print()" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2 justify-center">
                    <i class="fas fa-print"></i>
                    Cetak Data
                </button>
            </div>
        </div>
    </div>
</div>
@endsection