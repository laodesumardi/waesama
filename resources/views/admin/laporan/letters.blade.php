<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Layanan Surat</h3>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <i class="fas fa-file-alt text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Surat</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($data['total'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-lg">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Pending</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ number_format($data['pending'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
            <div class="flex items-center">
                <div class="p-2 bg-orange-500 rounded-lg">
                    <i class="fas fa-spinner text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-orange-600">Diproses</p>
                    <p class="text-2xl font-bold text-orange-900">{{ number_format($data['processing'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Selesai</p>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($data['completed'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <div class="flex items-center">
                <div class="p-2 bg-red-500 rounded-lg">
                    <i class="fas fa-times text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-red-600">Ditolak</p>
                    <p class="text-2xl font-bold text-red-900">{{ number_format($data['rejected'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Daily Trend Chart -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Harian Pengajuan Surat</h4>
            <div class="h-64">
                <canvas id="lettersDailyChart"></canvas>
            </div>
        </div>
        
        <!-- Status Distribution Chart -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Status Surat</h4>
            <div class="h-64">
                <canvas id="lettersStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Letter Types and Processing Times -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Letter Types -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Jenis Surat Terpopuler</h4>
            <div class="space-y-3">
                @foreach($data['letter_types'] ?? [] as $type)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $type['name'] }}</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $type['percentage'] }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ number_format($type['count']) }} ({{ $type['percentage'] }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Processing Times -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Waktu Pemrosesan</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Waktu Proses</span>
                    <span class="text-lg font-semibold text-gray-800">{{ $data['avg_processing_time'] ?? '0' }} hari</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Waktu Tercepat</span>
                    <span class="text-lg font-semibold text-green-600">{{ $data['min_processing_time'] ?? '0' }} hari</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Waktu Terlama</span>
                    <span class="text-lg font-semibold text-red-600">{{ $data['max_processing_time'] ?? '0' }} hari</span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Distribusi Waktu Proses:</div>
                    @foreach($data['processing_time_distribution'] ?? [] as $range)
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-gray-500">{{ $range['label'] }}</span>
                        <span class="text-xs font-medium">{{ $range['count'] }} surat</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Peak Hours Analysis -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-md font-semibold text-gray-800 mb-4">Analisis Jam Sibuk Pengajuan</h4>
        <div class="h-64">
            <canvas id="lettersPeakHoursChart"></canvas>
        </div>
    </div>
</div>

<script>
// Daily Trend Chart
if (document.getElementById('lettersDailyChart')) {
    const ctx = document.getElementById('lettersDailyChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($data['daily_stats'] ?? [], 'date')) !!},
            datasets: [{
                label: 'Pengajuan Harian',
                data: {!! json_encode(array_column($data['daily_stats'] ?? [], 'count')) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

// Status Distribution Chart
if (document.getElementById('lettersStatusChart')) {
    const ctx = document.getElementById('lettersStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $data['pending'] ?? 0 }},
                    {{ $data['processing'] ?? 0 }},
                    {{ $data['completed'] ?? 0 }},
                    {{ $data['rejected'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgb(251, 191, 36)',
                    'rgb(249, 115, 22)',
                    'rgb(34, 197, 94)',
                    'rgb(239, 68, 68)'
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
}

// Peak Hours Chart
if (document.getElementById('lettersPeakHoursChart')) {
    const ctx = document.getElementById('lettersPeakHoursChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($data['peak_hours'] ?? [], 'hour')) !!},
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: {!! json_encode(array_column($data['peak_hours'] ?? [], 'count')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>