@extends('layouts.main')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100">Kelola layanan masyarakat dengan efisien dan profesional.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-tie text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- My Surat -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Surat Saya Proses</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['my_surat']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-signature text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Pending: {{ number_format($stats['pending_surat']) }} surat</span>
            </div>
        </div>

        <!-- My Antrian -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Antrian Saya Layani</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['my_antrian']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Aktif: {{ number_format($stats['active_antrian']) }} antrian</span>
            </div>
        </div>

        <!-- My Pengaduan -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pengaduan Saya Tangani</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['my_pengaduan']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-headset text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Pending: {{ number_format($stats['pending_pengaduan']) }} pengaduan</span>
            </div>
        </div>
    </div>

    <!-- Recent Service Requests -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Pengajuan Surat Terbaru</h3>
            <a href="{{ route('pegawai.surat.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
        </div>
        @if(isset($recentServiceRequests) && $recentServiceRequests->count() > 0)
            <div class="space-y-4">
                @foreach($recentServiceRequests as $request)
                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">{{ $request->request_number }}</p>
                                <p class="text-gray-600 text-sm">{{ $request->citizen->name ?? 'N/A' }}</p>
                                <p class="text-gray-500 text-xs">{{ $request->service_type }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if($request->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Pending</span>
                            @elseif($request->status === 'in_progress')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Diproses</span>
                            @elseif($request->status === 'completed')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Ditolak</span>
                            @endif
                            <span class="text-gray-400 text-xs">{{ $request->created_at->diffForHumans() }}</span>
                            <a href="{{ route('pegawai.surat.show', $request->id) }}" class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500">Belum ada pengajuan surat terbaru</p>
            </div>
        @endif
    </div>

    <!-- Today's Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tugas Hari Ini -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Tugas Hari Ini</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ date('d M Y') }}</span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center space-x-4 p-3 rounded-lg bg-yellow-50 border border-yellow-200">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt text-yellow-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">Proses 5 Surat Keterangan</p>
                        <p class="text-gray-500 text-sm">Deadline: Hari ini, 16:00</p>
                    </div>
                    <span class="bg-yellow-200 text-yellow-800 text-xs font-medium px-2 py-1 rounded">Urgent</span>
                </div>
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">Layani Antrian Pagi</p>
                        <p class="text-gray-500 text-sm">08:00 - 12:00</p>
                    </div>
                    <span class="bg-green-200 text-green-800 text-xs font-medium px-2 py-1 rounded">Normal</span>
                </div>
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-comments text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">Respon Pengaduan</p>
                        <p class="text-gray-500 text-sm">3 pengaduan menunggu</p>
                    </div>
                    <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2 py-1 rounded">Normal</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Aksi Cepat</h3>
                <i class="fas fa-bolt text-gray-400"></i>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('pegawai.surat.index') }}" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                    <div class="text-center">
                        <i class="fas fa-file-plus text-2xl text-gray-400 group-hover:text-blue-600 mb-2"></i>
                        <p class="text-gray-600 group-hover:text-blue-600 font-medium">Proses Surat</p>
                    </div>
                </a>
                <a href="{{ route('pegawai.antrian.index') }}" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-200 group">
                    <div class="text-center">
                        <i class="fas fa-user-plus text-2xl text-gray-400 group-hover:text-green-600 mb-2"></i>
                        <p class="text-gray-600 group-hover:text-green-600 font-medium">Panggil Antrian</p>
                    </div>
                </a>
                <a href="{{ route('pegawai.pengaduan.index') }}" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group">
                    <div class="text-center">
                        <i class="fas fa-reply text-2xl text-gray-400 group-hover:text-purple-600 mb-2"></i>
                        <p class="text-gray-600 group-hover:text-purple-600 font-medium">Balas Pengaduan</p>
                    </div>
                </a>
                <a href="{{ route('pegawai.penduduk.index') }}" class="p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-200 group">
                    <div class="text-center">
                        <i class="fas fa-search text-2xl text-gray-400 group-hover:text-yellow-600 mb-2"></i>
                        <p class="text-gray-600 group-hover:text-yellow-600 font-medium">Cari Data</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Performance & Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Performance This Month -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Performa Bulan Ini</h3>
                <span class="text-gray-400 text-sm">{{ date('F Y') }}</span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Surat Diproses</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">75%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Antrian Dilayani</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">85%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Pengaduan Ditangani</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">90%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Kepuasan Layanan</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 88%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">88%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                <a href="{{ route('pegawai.surat.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 text-sm font-medium">Surat Keterangan Usaha selesai diproses</p>
                        <p class="text-gray-500 text-xs">2 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 text-sm font-medium">Melayani antrian nomor A-025</p>
                        <p class="text-gray-500 text-xs">15 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-reply text-purple-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 text-sm font-medium">Merespon pengaduan tentang pelayanan</p>
                        <p class="text-gray-500 text-xs">1 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-file text-yellow-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 text-sm font-medium">Memproses Surat Keterangan Domisili</p>
                        <p class="text-gray-500 text-xs">2 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection