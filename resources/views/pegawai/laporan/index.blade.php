@extends('layouts.main')

@section('title', 'Laporan Pegawai')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Laporan Kinerja, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100">Analisis data dan statistik kinerja Anda sebagai pegawai Kantor Camat Waesama.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Filter Laporan</h3>
            <p class="text-gray-600">Pilih periode dan jenis laporan yang ingin Anda lihat</p>
        </div>
        
        <form method="GET" action="{{ route('pegawai.laporan.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <!-- Report Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Laporan</label>
                    <select id="type" name="type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="overview" {{ $type == 'overview' ? 'selected' : '' }}>Ringkasan</option>
                        <option value="surat" {{ $type == 'surat' ? 'selected' : '' }}>Layanan Surat</option>
                        <option value="antrian" {{ $type == 'antrian' ? 'selected' : '' }}>Antrian</option>
                        <option value="pengaduan" {{ $type == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                    </select>
                </div>
                
                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-search"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('pegawai.laporan.export', ['start_date' => $startDate, 'end_date' => $endDate, 'type' => $type]) }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
                        <i class="fas fa-download"></i>
                        <span>Export PDF</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Report Content -->
    @if($type == 'overview')
        @include('pegawai.laporan.partials.overview', ['data' => $data])
    @elseif($type == 'surat')
        @include('pegawai.laporan.partials.surat', ['data' => $data])
    @elseif($type == 'antrian')
        @include('pegawai.laporan.partials.antrian', ['data' => $data])
    @elseif($type == 'pengaduan')
        @include('pegawai.laporan.partials.pengaduan', ['data' => $data])
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Auto submit form when date changes
    document.getElementById('start_date').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('end_date').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('type').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endpush