@extends('layouts.main')

@section('title', 'Antrian')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Antrian Layanan</h2>
                <p class="text-blue-100">Kelola antrian yang Anda layani dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-clock text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>
    
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl p-4 md:p-6 card-shadow">
        <form method="GET" action="{{ route('pegawai.antrian.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nomor antrian, nama, NIK, atau telepon..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                    <select name="jenis_layanan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Layanan</option>
                        @foreach($jenisLayananOptions as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis_layanan') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-end space-y-2 sm:space-y-0 sm:space-x-2 lg:col-span-1">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('pegawai.antrian.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-center">
                        <i class="fas fa-times mr-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Antrian</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $antrians->total() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-list text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $antrians->where('status', 'Menunggu')->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sedang Dilayani</p>
                    <p class="text-2xl font-bold text-green-600">{{ $antrians->where('status', 'Dilayani')->count() }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-check text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $antrians->where('status', 'Selesai')->count() }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <i class="fas fa-check text-gray-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrian Table -->
    <div class="bg-white rounded-xl card-shadow overflow-hidden">
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Antrian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($antrians as $antrian)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $antrian->nomor_antrian }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $antrian->nama_pengunjung }}</div>
                                <div class="text-sm text-gray-500">{{ $antrian->phone_pengunjung }}</div>
                                @if($antrian->nik_pengunjung)
                                    <div class="text-xs text-gray-400">NIK: {{ $antrian->nik_pengunjung }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $antrian->jenis_layanan }}</div>
                                @if($antrian->keperluan)
                                    <div class="text-xs text-gray-500">{{ Str::limit($antrian->keperluan, 30) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $antrian->tanggal_kunjungan->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $antrian->jam_kunjungan->format('H:i') }}</div>
                                @if($antrian->estimasi_waktu)
                                    <div class="text-xs text-gray-400">~{{ $antrian->estimasi_waktu }} menit</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'Dipanggil' => 'bg-blue-100 text-blue-800',
                                        'Dilayani' => 'bg-green-100 text-green-800',
                                        'Selesai' => 'bg-gray-100 text-gray-800',
                                        'Batal' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$antrian->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $antrian->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('pegawai.antrian.show', $antrian) }}" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Quick Actions for Pegawai -->
                                    @if($antrian->status === 'Menunggu')
                                        <form action="{{ route('pegawai.antrian.call', $antrian) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-900" title="Panggil">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($antrian->status, ['Menunggu', 'Dipanggil']))
                                        <form action="{{ route('pegawai.antrian.serve', $antrian) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Mulai Layani">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($antrian->status === 'Dilayani')
                                        <form action="{{ route('pegawai.antrian.complete', $antrian) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-purple-600 hover:text-purple-900" title="Selesaikan">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($antrian->status, ['Menunggu', 'Dipanggil']))
                                        <form action="{{ route('pegawai.antrian.cancel', $antrian) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Batalkan" onclick="return confirm('Yakin ingin membatalkan antrian ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-clock text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada data antrian</p>
                                    <p class="text-sm">Antrian akan muncul ketika ada pengunjung yang mendaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden divide-y divide-gray-200">
            @forelse($antrians as $antrian)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-lg font-bold text-gray-900">{{ $antrian->nomor_antrian }}</span>
                                @php
                                    $statusColors = [
                                        'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'Dipanggil' => 'bg-blue-100 text-blue-800',
                                        'Dilayani' => 'bg-green-100 text-green-800',
                                        'Selesai' => 'bg-gray-100 text-gray-800',
                                        'Batal' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$antrian->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $antrian->status }}
                                </span>
                            </div>
                            <div class="text-sm font-medium text-gray-900 mb-1">{{ $antrian->nama_pengunjung }}</div>
                            <div class="text-sm text-gray-500 mb-1">{{ $antrian->phone_pengunjung }}</div>
                            @if($antrian->nik_pengunjung)
                                <div class="text-xs text-gray-400 mb-2">NIK: {{ $antrian->nik_pengunjung }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-3 text-sm">
                        <div>
                            <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Layanan</div>
                            <div class="text-gray-900">{{ $antrian->jenis_layanan }}</div>
                            @if($antrian->keperluan)
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($antrian->keperluan, 40) }}</div>
                            @endif
                        </div>
                        <div>
                            <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Jadwal</div>
                            <div class="text-gray-900">{{ $antrian->tanggal_kunjungan->format('d/m/Y') }}</div>
                            <div class="text-gray-500">{{ $antrian->jam_kunjungan->format('H:i') }}</div>
                            @if($antrian->estimasi_waktu)
                                <div class="text-xs text-gray-400">~{{ $antrian->estimasi_waktu }} menit</div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Mobile Actions -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('pegawai.antrian.show', $antrian) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-200">
                            <i class="fas fa-eye mr-1"></i>Detail
                        </a>
                        
                        @if($antrian->status === 'Menunggu')
                            <form action="{{ route('pegawai.antrian.call', $antrian) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-200">
                                    <i class="fas fa-phone mr-1"></i>Panggil
                                </button>
                            </form>
                        @endif
                        
                        @if(in_array($antrian->status, ['Menunggu', 'Dipanggil']))
                            <form action="{{ route('pegawai.antrian.serve', $antrian) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 text-xs font-medium rounded-lg hover:bg-green-200">
                                    <i class="fas fa-play mr-1"></i>Layani
                                </button>
                            </form>
                        @endif
                        
                        @if($antrian->status === 'Dilayani')
                            <form action="{{ route('pegawai.antrian.complete', $antrian) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-700 text-xs font-medium rounded-lg hover:bg-purple-200">
                                    <i class="fas fa-check mr-1"></i>Selesai
                                </button>
                            </form>
                        @endif
                        
                        @if(in_array($antrian->status, ['Menunggu', 'Dipanggil']))
                            <form action="{{ route('pegawai.antrian.cancel', $antrian) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-medium rounded-lg hover:bg-red-200" onclick="return confirm('Yakin ingin membatalkan antrian ini?')">
                                    <i class="fas fa-times mr-1"></i>Batal
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fas fa-clock text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium">Belum ada data antrian</p>
                        <p class="text-sm">Antrian akan muncul ketika ada pengunjung yang mendaftar</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($antrians->hasPages())
            <div class="px-4 md:px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $antrians->links() }}
            </div>
        @endif
    </div>
</div>
@endsection