<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Sistem Antrian</h3>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <i class="fas fa-list-ol text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Antrian</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($data['total'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-lg">
                    <i class="fas fa-hourglass-half text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ number_format($data['waiting'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
            <div class="flex items-center">
                <div class="p-2 bg-orange-500 rounded-lg">
                    <i class="fas fa-user-clock text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-orange-600">Dipanggil</p>
                    <p class="text-2xl font-bold text-orange-900">{{ number_format($data['called'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Dilayani</p>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($data['served'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <div class="flex items-center">
                <div class="p-2 bg-red-500 rounded-lg">
                    <i class="fas fa-ban text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-red-600">Batal</p>
                    <p class="text-2xl font-bold text-red-900">{{ number_format($data['cancelled'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Daily Queue Trend -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Harian Antrian</h4>
            <div class="h-64">
                <canvas id="queuesDailyChart"></canvas>
            </div>
        </div>
        
        <!-- Queue Status Distribution -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Status Antrian</h4>
            <div class="h-64">
                <canvas id="queuesStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Service Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Service Types -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Jenis Layanan Terpopuler</h4>
            <div class="space-y-3">
                @foreach($data['service_types'] ?? [] as $service)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $service['name'] }}</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $service['percentage'] }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ number_format($service['count']) }} ({{ $service['percentage'] }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Waiting Times -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Analisis Waktu Tunggu</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Waktu Tunggu</span>
                    <span class="text-lg font-semibold text-gray-800">{{ $data['avg_waiting_time'] ?? '0' }} menit</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Waktu Tunggu Tercepat</span>
                    <span class="text-lg font-semibold text-green-600">{{ $data['min_waiting_time'] ?? '0' }} menit</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Waktu Tunggu Terlama</span>
                    <span class="text-lg font-semibold text-red-600">{{ $data['max_waiting_time'] ?? '0' }} menit</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Waktu Layanan</span>
                    <span class="text-lg font-semibold text-blue-600">{{ $data['avg_service_time'] ?? '0' }} menit</span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Distribusi Waktu Tunggu:</div>
                    @foreach($data['waiting_time_distribution'] ?? [] as $range)
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-gray-500">{{ $range['label'] }}</span>
                        <span class="text-xs font-medium">{{ $range['count'] }} antrian</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Peak Hours and Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Peak Hours -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Jam Sibuk Layanan</h4>
            <div class="h-64">
                <canvas id="queuesPeakHoursChart"></canvas>
            </div>
        </div>
        
        <!-- Daily Performance -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Performa Harian</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Antrian per Hari</span>
                    <span class="text-lg font-semibold text-gray-800">{{ number_format($data['avg_daily_queues'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tingkat Penyelesaian</span>
                    <span class="text-lg font-semibold text-green-600">{{ $data['completion_rate'] ?? '0' }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tingkat Pembatalan</span>
                    <span class="text-lg font-semibold text-red-600">{{ $data['cancellation_rate'] ?? '0' }}%</span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Efisiensi Layanan:</div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ $data['service_efficiency'] ?? 0 }}%"></div>
                    </div>
                    <div class="text-center text-sm font-medium text-gray-800 mt-1">{{ $data['service_efficiency'] ?? '0' }}%</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Daily Queue Trend Chart
if (document.getElementById('queuesDailyChart')) {
    const ctx = document.getElementById('queuesDailyChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($data['daily_stats'] ?? [], 'date')) !!},
            datasets: [{
                label: 'Antrian Harian',
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

// Queue Status Distribution Chart
if (document.getElementById('queuesStatusChart')) {
    const ctx = document.getElementById('queuesStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Dipanggil', 'Dilayani', 'Batal'],
            datasets: [{
                data: [
                    {{ $data['waiting'] ?? 0 }},
                    {{ $data['called'] ?? 0 }},
                    {{ $data['served'] ?? 0 }},
                    {{ $data['cancelled'] ?? 0 }}
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
if (document.getElementById('queuesPeakHoursChart')) {
    const ctx = document.getElementById('queuesPeakHoursChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($data['peak_hours'] ?? [], 'hour')) !!},
            datasets: [{
                label: 'Jumlah Antrian',
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