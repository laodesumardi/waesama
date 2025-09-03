<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Count -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Admin</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalAdmin }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pegawai Count -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pegawai</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalPegawai }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Masyarakat Count -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Masyarakat</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalMasyarakat }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Population Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Citizens -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Penduduk</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalCitizens ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Male Population -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Laki-laki</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalMale ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Female Population -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Perempuan</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalFemale ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Villages -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Desa</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalVillages ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Additional Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Population by Gender -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Jenis Kelamin</h3>
                        <div class="space-y-3">
                            @if(isset($populationByGender))
                                @foreach($populationByGender as $gender => $count)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $gender }}</span>
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="{{ $gender === 'Laki-laki' ? 'bg-blue-500' : 'bg-pink-500' }} h-2 rounded-full" 
                                                 style="width: {{ $totalCitizens > 0 ? ($count / $totalCitizens) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium">{{ number_format($count) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Age Groups -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Kelompok Umur</h3>
                        <div class="space-y-3">
                            @if(isset($ageGroups))
                                @foreach($ageGroups as $ageRange => $count)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $ageRange }} tahun</span>
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-indigo-500 h-2 rounded-full" 
                                                 style="width: {{ $totalCitizens > 0 ? ($count / $totalCitizens) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium">{{ number_format($count) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Religion Statistics -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Agama</h3>
                        <div class="space-y-3">
                            @if(isset($religionStats))
                                @foreach($religionStats as $religion => $count)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ ucfirst($religion) }}</span>
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-orange-500 h-2 rounded-full" 
                                                 style="width: {{ $totalCitizens > 0 ? ($count / $totalCitizens) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium">{{ number_format($count) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management and Village Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- User Role Distribution -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Pengguna</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Admin</span>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($totalAdmin / $totalUsers) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium">{{ $totalAdmin }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Pegawai</span>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($totalPegawai / $totalUsers) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium">{{ $totalPegawai }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Masyarakat</span>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($totalMasyarakat / $totalUsers) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium">{{ $totalMasyarakat }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terkini</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Login Hari Ini</p>
                                    <p class="text-xs text-gray-500">{{ now()->format('d M Y') }}</p>
                                </div>
                                <span class="text-lg font-semibold text-blue-600">{{ $todayLogins }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pengguna Aktif</p>
                                    <p class="text-xs text-gray-500">Status aktif</p>
                                </div>
                                <span class="text-lg font-semibold text-green-600">{{ $activeUsers }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Village Statistics and Marital Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Top Villages by Population -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Desa dengan Populasi Terbanyak</h3>
                        <div class="space-y-3">
                            @if(isset($villageStats) && $villageStats->count() > 0)
                                @foreach($villageStats->take(5) as $village)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $village->name }}</p>
                                        <p class="text-xs text-gray-500">Kode: {{ $village->code }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-semibold text-purple-600">{{ number_format($village->active_citizens_count) }}</span>
                                        <p class="text-xs text-gray-500">penduduk</p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <p class="text-sm text-gray-500">Belum ada data desa</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Marital Status Distribution -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Perkawinan</h3>
                        <div class="space-y-3">
                            @if(isset($maritalStats))
                                @foreach($maritalStats as $status => $count)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ ucfirst($status) }}</span>
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-teal-500 h-2 rounded-full" 
                                                 style="width: {{ $totalCitizens > 0 ? ($count / $totalCitizens) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium">{{ number_format($count) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <p class="text-sm text-gray-500">Belum ada data status perkawinan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('admin.users') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-900">Kelola Pengguna</p>
                                    <p class="text-xs text-blue-700">Tambah, edit, hapus pengguna</p>
                                </div>
                            </a>
                            
                            <a href="#" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-900">Layanan Surat</p>
                                    <p class="text-xs text-green-700">Kelola template surat</p>
                                </div>
                            </a>
                            
                            <a href="#" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-yellow-900">Antrian Online</p>
                                    <p class="text-xs text-yellow-700">Kelola sistem antrian</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>