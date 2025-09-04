<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Pengaduan Masyarakat</h3>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Pengaduan</p>
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
                    <i class="fas fa-cog text-white"></i>
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
                    <p class="text-2xl font-bold text-green-900">{{ number_format($data['resolved'] ?? 0) }}</p>
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
        <!-- Daily Complaints Trend -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Harian Pengaduan</h4>
            <div class="h-64">
                <canvas id="complaintsDailyChart"></canvas>
            </div>
        </div>
        
        <!-- Status Distribution -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Status Pengaduan</h4>
            <div class="h-64">
                <canvas id="complaintsStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Categories and Response Times -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Complaint Categories -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Kategori Pengaduan Terbanyak</h4>
            <div class="space-y-3">
                @foreach($data['categories'] ?? [] as $category)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $category['name'] }}</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ number_format($category['count']) }} ({{ $category['percentage'] }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Response Times -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Waktu Respons</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Waktu Respons</span>
                    <span class="text-lg font-semibold text-gray-800">{{ $data['avg_response_time'] ?? '0' }} hari</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Respons Tercepat</span>
                    <span class="text-lg font-semibold text-green-600">{{ $data['min_response_time'] ?? '0' }} hari</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Respons Terlama</span>
                    <span class="text-lg font-semibold text-red-600">{{ $data['max_response_time'] ?? '0' }} hari</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Waktu Penyelesaian</span>
                    <span class="text-lg font-semibold text-blue-600">{{ $data['avg_resolution_time'] ?? '0' }} hari</span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Distribusi Waktu Respons:</div>
                    @foreach($data['response_time_distribution'] ?? [] as $range)
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-gray-500">{{ $range['label'] }}</span>
                        <span class="text-xs font-medium">{{ $range['count'] }} pengaduan</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Priority and Satisfaction Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Priority Distribution -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Prioritas</h4>
            <div class="space-y-3">
                @foreach($data['priorities'] ?? [] as $priority)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $priority['color'] }}"></span>
                        <span class="text-sm text-gray-600">{{ $priority['name'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="h-2 rounded-full" style="width: {{ $priority['percentage'] }}%; background-color: {{ $priority['color'] }}"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ number_format($priority['count']) }} ({{ $priority['percentage'] }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Performance Metrics -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Metrik Kinerja</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tingkat Penyelesaian</span>
                    <span class="text-lg font-semibold text-green-600">{{ $data['resolution_rate'] ?? '0' }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tingkat Kepuasan</span>
                    <span class="text-lg font-semibold text-blue-600">{{ $data['satisfaction_rate'] ?? '0' }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pengaduan Berulang</span>
                    <span class="text-lg font-semibold text-orange-600">{{ $data['repeat_complaints'] ?? '0' }}%</span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Efektivitas Penanganan:</div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ $data['handling_effectiveness'] ?? 0 }}%"></div>
                    </div>
                    <div class="text-center text-sm font-medium text-gray-800 mt-1">{{ $data['handling_effectiveness'] ?? '0' }}%</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Monthly Trend -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Bulanan Pengaduan</h4>
        <div class="h-64">
            <canvas id="complaintsMonthlyChart"></canvas>
        </div>
    </div>
</div>

<script>
// Daily Complaints Trend Chart
if (document.getElementById('complaintsDailyChart')) {
    const ctx = document.getElementById('complaintsDailyChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($data['daily_stats'] ?? [], 'date')) !!},
            datasets: [{
                label: 'Pengaduan Harian',
                data: {!! json_encode(array_column($data['daily_stats'] ?? [], 'count')) !!},
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
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
if (document.getElementById('complaintsStatusChart')) {
    const ctx = document.getElementById('complaintsStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $data['pending'] ?? 0 }},
                    {{ $data['processing'] ?? 0 }},
                    {{ $data['resolved'] ?? 0 }},
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

// Monthly Trend Chart
if (document.getElementById('complaintsMonthlyChart')) {
    const ctx = document.getElementById('complaintsMonthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($data['monthly_stats'] ?? [], 'month')) !!},
            datasets: [{
                label: 'Pengaduan Bulanan',
                data: {!! json_encode(array_column($data['monthly_stats'] ?? [], 'count')) !!},
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: 'rgb(239, 68, 68)',
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