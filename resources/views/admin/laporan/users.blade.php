<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Manajemen User</h3>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total User</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($data['total'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <i class="fas fa-user-check text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">User Aktif</p>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($data['active'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <div class="flex items-center">
                <div class="p-2 bg-red-500 rounded-lg">
                    <i class="fas fa-user-times text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-red-600">User Nonaktif</p>
                    <p class="text-2xl font-bold text-red-900">{{ number_format($data['inactive'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">User Baru (Bulan Ini)</p>
                    <p class="text-2xl font-bold text-purple-900">{{ number_format($data['new_this_month'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- User Registration Trend -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Registrasi User</h4>
            <div class="h-64">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
        
        <!-- Role Distribution -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Role User</h4>
            <div class="h-64">
                <canvas id="userRoleChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Role Analysis and Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Role Breakdown -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Breakdown Role User</h4>
            <div class="space-y-3">
                @foreach($data['roles'] ?? [] as $role)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $role['color'] }}"></span>
                        <span class="text-sm text-gray-600">{{ $role['name'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="h-2 rounded-full" style="width: {{ $role['percentage'] }}%; background-color: {{ $role['color'] }}"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ number_format($role['count']) }} ({{ $role['percentage'] }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- User Activity -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Aktivitas User</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">User Login Hari Ini</span>
                    <span class="text-lg font-semibold text-green-600">{{ number_format($data['logged_in_today'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">User Login Minggu Ini</span>
                    <span class="text-lg font-semibold text-blue-600">{{ number_format($data['logged_in_this_week'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">User Login Bulan Ini</span>
                    <span class="text-lg font-semibold text-purple-600">{{ number_format($data['logged_in_this_month'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Login per Hari</span>
                    <span class="text-lg font-semibold text-gray-800">{{ number_format($data['avg_daily_logins'] ?? 0) }}</span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Tingkat Aktivitas User:</div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ $data['activity_rate'] ?? 0 }}%"></div>
                    </div>
                    <div class="text-center text-sm font-medium text-gray-800 mt-1">{{ $data['activity_rate'] ?? '0' }}%</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Demographics and Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Age Demographics -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Demografi Umur User</h4>
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
        
        <!-- Gender Distribution -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Gender</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Laki-laki</span>
                    <span class="text-lg font-semibold text-blue-600">{{ number_format($data['male_users'] ?? 0) }} ({{ $data['male_percentage'] ?? '0' }}%)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Perempuan</span>
                    <span class="text-lg font-semibold text-pink-600">{{ number_format($data['female_users'] ?? 0) }} ({{ $data['female_percentage'] ?? '0' }}%)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tidak Diketahui</span>
                    <span class="text-lg font-semibold text-gray-600">{{ number_format($data['unknown_gender'] ?? 0) }} ({{ $data['unknown_percentage'] ?? '0' }}%)</span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Rasio Gender (L:P):</div>
                    <div class="text-center text-lg font-semibold text-gray-800">
                        @if(($data['female_users'] ?? 0) > 0)
                            {{ number_format(($data['male_users'] ?? 0) / ($data['female_users'] ?? 1), 2) }} : 1
                        @else
                            N/A
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Most Active Users -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <h4 class="text-md font-semibold text-gray-800 mb-4">User Paling Aktif</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-600">Nama</th>
                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-600">Role</th>
                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-600">Login Terakhir</th>
                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-600">Total Login</th>
                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-600">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['most_active_users'] ?? [] as $user)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 px-3 text-sm text-gray-800">{{ $user['name'] }}</td>
                        <td class="py-2 px-3 text-sm text-gray-600">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $user['role'] }}</span>
                        </td>
                        <td class="py-2 px-3 text-sm text-gray-600">{{ $user['last_login'] }}</td>
                        <td class="py-2 px-3 text-sm text-gray-600">{{ number_format($user['login_count']) }}</td>
                        <td class="py-2 px-3 text-sm">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $user['activity_score'] }}%"></div>
                                </div>
                                <span class="text-xs text-gray-600">{{ $user['activity_score'] }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Monthly Registration Trend -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Registrasi Bulanan</h4>
        <div class="h-64">
            <canvas id="userMonthlyChart"></canvas>
        </div>
    </div>
</div>

<script>
// User Registration Trend Chart
if (document.getElementById('userRegistrationChart')) {
    const ctx = document.getElementById('userRegistrationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($data['daily_registrations'] ?? [], 'date')) !!},
            datasets: [{
                label: 'Registrasi Harian',
                data: {!! json_encode(array_column($data['daily_registrations'] ?? [], 'count')) !!},
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
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

// Role Distribution Chart
if (document.getElementById('userRoleChart')) {
    const ctx = document.getElementById('userRoleChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_column($data['roles'] ?? [], 'name')) !!},
            datasets: [{
                data: {!! json_encode(array_column($data['roles'] ?? [], 'count')) !!},
                backgroundColor: {!! json_encode(array_column($data['roles'] ?? [], 'color')) !!}
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

// Monthly Registration Chart
if (document.getElementById('userMonthlyChart')) {
    const ctx = document.getElementById('userMonthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($data['monthly_registrations'] ?? [], 'month')) !!},
            datasets: [{
                label: 'Registrasi Bulanan',
                data: {!! json_encode(array_column($data['monthly_registrations'] ?? [], 'count')) !!},
                backgroundColor: 'rgba(147, 51, 234, 0.8)',
                borderColor: 'rgb(147, 51, 234)',
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