@extends('layouts.main')

@section('title', 'Pengaduan Saya')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Pengaduan Saya</h1>
            <p class="text-gray-600 mt-2">Kelola dan pantau status pengaduan Anda</p>
        </div>
        <a href="{{ route('warga.pengaduan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Ajukan Pengaduan
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengaduan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pengaduan'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Baru</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pengaduan_baru'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-cog text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pengaduan_proses'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pengaduan_selesai'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pengaduan</h2>
        </div>
        
        @if($pengaduanList->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pengaduanList as $pengaduan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pengaduan->nomor_pengaduan }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs truncate">{{ $pengaduan->judul_pengaduan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pengaduan->kategori }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $prioritasColors = [
                                            'Rendah' => 'bg-gray-100 text-gray-800',
                                            'Sedang' => 'bg-yellow-100 text-yellow-800',
                                            'Tinggi' => 'bg-orange-100 text-orange-800',
                                            'Mendesak' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $prioritasColors[$pengaduan->prioritas] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $pengaduan->prioritas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'Baru' => 'bg-blue-100 text-blue-800',
                                            'Sedang Diproses' => 'bg-yellow-100 text-yellow-800',
                                            'Selesai' => 'bg-green-100 text-green-800',
                                            'Ditolak' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$pengaduan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $pengaduan->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pengaduan->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pengaduanList->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-exclamation-triangle text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengaduan</h3>
                <p class="text-gray-500 mb-6">Anda belum mengajukan pengaduan apapun.</p>
                <a href="{{ route('warga.pengaduan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 inline-flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Ajukan Pengaduan Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection