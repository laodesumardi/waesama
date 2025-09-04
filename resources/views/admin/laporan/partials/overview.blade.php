<!-- Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Penduduk -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Penduduk</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($data['total_penduduk']) }}</p>
            </div>
        </div>
    </div>
    
    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-user-cog text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($data['total_users']) }}</p>
            </div>
        </div>
    </div>
    
    <!-- Total Berita -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-newspaper text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Berita</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($data['total_berita']) }}</p>
            </div>
        </div>
    </div>
    
    <!-- Period Info -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 bg-orange-100 rounded-full">
                <i class="fas fa-calendar text-orange-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Periode</h3>
                <p class="text-sm font-bold text-gray-900">{{ date('d M Y', strtotime($startDate)) }}</p>
                <p class="text-sm text-gray-600">s/d {{ date('d M Y', strtotime($endDate)) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Service Statistics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Surat Statistics -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-file-alt mr-2 text-blue-600"></i>
            Layanan Surat
        </h3>
        
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total</span>
                <span class="font-semibold text-gray-900">{{ number_format($data['surat_total']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Pending</span>
                <span class="font-semibold text-yellow-600">{{ number_format($data['surat_pending']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Diproses</span>
                <span class="font-semibold text-blue-600">{{ number_format($data['surat_processing']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Selesai</span>
                <span class="font-semibold text-green-600">{{ number_format($data['surat_completed']) }}</span>
            </div>
        </div>
        
        @if($data['surat_total'] > 0)
            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($data['surat_completed'] / $data['surat_total']) * 100 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ number_format(($data['surat_completed'] / $data['surat_total']) * 100, 1) }}% selesai</p>
            </div>
        @endif
    </div>
    
    <!-- Antrian Statistics -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-clock mr-2 text-green-600"></i>
            Antrian
        </h3>
        
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total</span>
                <span class="font-semibold text-gray-900">{{ number_format($data['antrian_total']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Menunggu</span>
                <span class="font-semibold text-yellow-600">{{ number_format($data['antrian_waiting']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Dipanggil</span>
                <span class="font-semibold text-blue-600">{{ number_format($data['antrian_called']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Dilayani</span>
                <span class="font-semibold text-orange-600">{{ number_format($data['antrian_served']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Selesai</span>
                <span class="font-semibold text-green-600">{{ number_format($data['antrian_completed']) }}</span>
            </div>
        </div>
        
        @if($data['antrian_total'] > 0)
            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($data['antrian_completed'] / $data['antrian_total']) * 100 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ number_format(($data['antrian_completed'] / $data['antrian_total']) * 100, 1) }}% selesai</p>
            </div>
        @endif
    </div>
    
    <!-- Pengaduan Statistics -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-comments mr-2 text-purple-600"></i>
            Pengaduan
        </h3>
        
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total</span>
                <span class="font-semibold text-gray-900">{{ number_format($data['pengaduan_total']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Pending</span>
                <span class="font-semibold text-yellow-600">{{ number_format($data['pengaduan_pending']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Diproses</span>
                <span class="font-semibold text-blue-600">{{ number_format($data['pengaduan_processing']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Selesai</span>
                <span class="font-semibold text-green-600">{{ number_format($data['pengaduan_completed']) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Ditolak</span>
                <span class="font-semibold text-red-600">{{ number_format($data['pengaduan_rejected']) }}</span>
            </div>
        </div>
        
        @if($data['pengaduan_total'] > 0)
            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ (($data['pengaduan_completed'] + $data['pengaduan_rejected']) / $data['pengaduan_total']) * 100 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ number_format((($data['pengaduan_completed'] + $data['pengaduan_rejected']) / $data['pengaduan_total']) * 100, 1) }}% selesai</p>
            </div>
        @endif
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Daily Surat Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-chart-line mr-2 text-blue-600"></i>
            Trend Harian Surat
        </h3>
        
        @if($data['daily_surat']->isNotEmpty())
            <div class="h-64">
                <canvas id="dailySuratChart"></canvas>
            </div>
        @else
            <div class="h-64 flex items-center justify-center text-gray-500">
                <div class="text-center">
                    <i class="fas fa-chart-line text-4xl mb-2"></i>
                    <p>Tidak ada data untuk periode ini</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Daily Antrian Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-chart-line mr-2 text-green-600"></i>
            Trend Harian Antrian
        </h3>
        
        @if($data['daily_antrian']->isNotEmpty())
            <div class="h-64">
                <canvas id="dailyAntrianChart"></canvas>
            </div>
        @else
            <div class="h-64 flex items-center justify-center text-gray-500">
                <div class="text-center">
                    <i class="fas fa-chart-line text-4xl mb-2"></i>
                    <p>Tidak ada data untuk periode ini</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Daily Pengaduan Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-chart-line mr-2 text-purple-600"></i>
            Trend Harian Pengaduan
        </h3>
        
        @if($data['daily_pengaduan']->isNotEmpty())
            <div class="h-64">
                <canvas id="dailyPengaduanChart"></canvas>
            </div>
        @else
            <div class="h-64 flex items-center justify-center text-gray-500">
                <div class="text-center">
                    <i class="fas fa-chart-line text-4xl mb-2"></i>
                    <p>Tidak ada data untuk periode ini</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Summary Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-chart-pie mr-2 text-orange-600"></i>
            Ringkasan Layanan
        </h3>
        
        <div class="h-64">
            <canvas id="summaryChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily Surat Chart
@if($data['daily_surat']->isNotEmpty())
const dailySuratCtx = document.getElementById('dailySuratChart').getContext('2d');
new Chart(dailySuratCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($data['daily_surat']->pluck('date')->map(function($date) { return date('d/m', strtotime($date)); })) !!},
        datasets: [{
            label: 'Surat',
            data: {!! json_encode($data['daily_surat']->pluck('total')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
@endif

// Daily Antrian Chart
@if($data['daily_antrian']->isNotEmpty())
const dailyAntrianCtx = document.getElementById('dailyAntrianChart').getContext('2d');
new Chart(dailyAntrianCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($data['daily_antrian']->pluck('date')->map(function($date) { return date('d/m', strtotime($date)); })) !!},
        datasets: [{
            label: 'Antrian',
            data: {!! json_encode($data['daily_antrian']->pluck('total')) !!},
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
@endif

// Daily Pengaduan Chart
@if($data['daily_pengaduan']->isNotEmpty())
const dailyPengaduanCtx = document.getElementById('dailyPengaduanChart').getContext('2d');
new Chart(dailyPengaduanCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($data['daily_pengaduan']->pluck('date')->map(function($date) { return date('d/m', strtotime($date)); })) !!},
        datasets: [{
            label: 'Pengaduan',
            data: {!! json_encode($data['daily_pengaduan']->pluck('total')) !!},
            borderColor: 'rgb(147, 51, 234)',
            backgroundColor: 'rgba(147, 51, 234, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
@endif

// Summary Chart
const summaryCtx = document.getElementById('summaryChart').getContext('2d');
new Chart(summaryCtx, {
    type: 'doughnut',
    data: {
        labels: ['Surat', 'Antrian', 'Pengaduan'],
        datasets: [{
            data: [{{ $data['surat_total'] }}, {{ $data['antrian_total'] }}, {{ $data['pengaduan_total'] }}],
            backgroundColor: [
                'rgb(59, 130, 246)',
                'rgb(34, 197, 94)',
                'rgb(147, 51, 234)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>