@extends('layouts.main')

@section('title', 'Detail Pengaduan')

@section('content')
<!-- Page Header -->
<div class="bg-[#003f88] rounded-xl p-6 text-white mb-6">
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-blue-200 mb-2">
                <a href="{{ route('pegawai.dashboard') }}" class="hover:text-white">Dashboard</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('pegawai.pengaduan.index') }}" class="hover:text-white">Pengaduan</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white">Detail</span>
            </nav>
            <h2 class="text-2xl font-bold mb-2">Detail Pengaduan</h2>
            <p class="text-blue-100">{{ $pengaduan->nomor_pengaduan }}</p>
        </div>
        <div class="hidden md:block">
            <i class="fas fa-comments text-6xl text-blue-200"></i>
        </div>
    </div>
</div>

<div class="space-y-6">
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Pengaduan -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-comments text-blue-600 mr-2"></i>
                    Informasi Pengaduan
                </h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Pengaduan</label>
                            <p class="text-gray-900 font-mono">{{ $pengaduan->nomor_pengaduan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengaduan</label>
                            <p class="text-gray-900">{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Pengaduan</label>
                        <p class="text-gray-900 text-lg font-medium">{{ $pengaduan->judul_pengaduan }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($pengaduan->kategori === 'Pelayanan') bg-blue-100 text-blue-800
                                @elseif($pengaduan->kategori === 'Infrastruktur') bg-green-100 text-green-800
                                @elseif($pengaduan->kategori === 'Keamanan') bg-red-100 text-red-800
                                @elseif($pengaduan->kategori === 'Kebersihan') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $pengaduan->kategori }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($pengaduan->prioritas === 'Urgent') bg-red-100 text-red-800
                                @elseif($pengaduan->prioritas === 'Tinggi') bg-orange-100 text-orange-800
                                @elseif($pengaduan->prioritas === 'Sedang') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ $pengaduan->prioritas }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengaduan</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-line">{{ $pengaduan->isi_pengaduan }}</p>
                        </div>
                    </div>
                    
                    @if($pengaduan->lampiran)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-paperclip text-gray-400"></i>
                            <a href="{{ route('pegawai.pengaduan.download', $pengaduan) }}" class="text-blue-600 hover:text-blue-800 underline">
                                {{ basename($pengaduan->lampiran) }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Data Pengadu -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Data Pengadu
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <p class="text-gray-900">{{ $pengaduan->nama_pengadu }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">{{ $pengaduan->email_pengadu }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <p class="text-gray-900">{{ $pengaduan->phone_pengadu }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <p class="text-gray-900">{{ $pengaduan->alamat_pengadu }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Tanggapan -->
            @if($pengaduan->tanggapan)
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-reply text-blue-600 mr-2"></i>
                    Tanggapan
                </h3>
                
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-line">{{ $pengaduan->tanggapan }}</p>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Actions -->
            @if($pengaduan->handler_id === auth()->id())
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-tasks text-blue-600 mr-2"></i>
                    Aksi Status
                </h3>
                
                <div class="space-y-3">
                    @if($pengaduan->status === 'Diterima')
                        <form action="{{ route('pegawai.pengaduan.process', $pengaduan) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-play mr-2"></i>Proses Pengaduan
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($pengaduan->status, ['Diterima', 'Diproses']))
                        <form action="{{ route('pegawai.pengaduan.followup', $pengaduan) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                <i class="fas fa-arrow-up mr-2"></i>Tindak Lanjuti
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($pengaduan->status, ['Diproses', 'Ditindaklanjuti']))
                        <form action="{{ route('pegawai.pengaduan.complete', $pengaduan) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-check mr-2"></i>Selesaikan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Status Info -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Status Pengaduan
                </h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Saat Ini</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($pengaduan->status === 'Diterima') bg-blue-100 text-blue-800
                            @elseif($pengaduan->status === 'Diproses') bg-yellow-100 text-yellow-800
                            @elseif($pengaduan->status === 'Ditindaklanjuti') bg-purple-100 text-purple-800
                            @elseif($pengaduan->status === 'Selesai') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $pengaduan->status }}
                        </span>
                    </div>
                    
                    @if($pengaduan->handler)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ditangani Oleh</label>
                        <p class="text-gray-900">{{ $pengaduan->handler->name }}</p>
                    </div>
                    @endif
                    
                    @if($pengaduan->tanggal_ditangani)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Ditangani</label>
                        <p class="text-gray-900">{{ $pengaduan->tanggal_ditangani->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @endif
                    
                    @if($pengaduan->tanggal_selesai)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <p class="text-gray-900">{{ $pengaduan->tanggal_selesai->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-blue-600 mr-2"></i>
                    Aksi Cepat
                </h3>
                
                <div class="space-y-2">
                    <a href="{{ route('pegawai.pengaduan.index') }}" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-list mr-2"></i>Daftar Pengaduan
                    </a>
                    @if($pengaduan->lampiran)
                    <a href="{{ route('pegawai.pengaduan.download', $pengaduan) }}" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-download mr-2"></i>Unduh Lampiran
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection