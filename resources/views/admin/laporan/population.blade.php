<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Data Penduduk</h3>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Penduduk</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($data['total_population'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <i class="fas fa-male text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Laki-laki</p>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($data['male_count'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-pink-50 p-4 rounded-lg border border-pink-200">
            <div class="flex items-center">
                <div class="p-2 bg-pink-500 rounded-lg">
                    <i class="fas fa-female text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-pink-600">Perempuan</p>
                    <p class="text-2xl font-bold text-pink-900">{{ number_format($data['female_count'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <i class="fas fa-chart-pie text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">Rasio L:P</p>
                    <p class="text-2xl font-bold text-purple-900">
                        @if(($data['female_count'] ?? 0) > 0)
                            {{ number_format(($data['male_count'] ?? 0) / ($data['female_count'] ?? 1), 2) }}
                        @else
                            0
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Age Group Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Kelompok Umur</h4>
            <div class="space-y-3">
                @foreach($data['age_groups'] ?? [] as $group)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $group['label'] }}</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $group['percentage'] }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ number_format($group['count']) }} ({{ $group['percentage'] }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Gender per Kelompok Umur</h4>
            <div class="space-y-3">
                @foreach($data['gender_by_age'] ?? [] as $group)
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">{{ $group['label'] }}</span>
                        <span class="text-sm text-gray-500">{{ number_format($group['total']) }}</span>
                    </div>
                    <div class="flex">
                        <div class="bg-blue-500 h-2 rounded-l" style="width: {{ $group['male_percentage'] }}%" title="Laki-laki: {{ $group['male'] }}"></div>
                        <div class="bg-pink-500 h-2 rounded-r" style="width: {{ $group['female_percentage'] }}%" title="Perempuan: {{ $group['female'] }}"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>L: {{ number_format($group['male']) }}</span>
                        <span>P: {{ number_format($group['female']) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Registration Trends -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Pendaftaran Penduduk</h4>
        <div class="h-64">
            <canvas id="populationTrendChart"></canvas>
        </div>
    </div>
</div>

<script>
// Population Trend Chart
if (document.getElementById('populationTrendChart')) {
    const ctx = document.getElementById('populationTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($data['daily_registrations'] ?? [], 'date')) !!},
            datasets: [{
                label: 'Pendaftaran Harian',
                data: {!! json_encode(array_column($data['daily_registrations'] ?? [], 'count')) !!},
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
</script>