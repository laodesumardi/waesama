<!-- Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- My Surat Statistics -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Surat Saya Proses</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($data['my_surat_total'] ?? 0) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-signature text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 space-y-1">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Pending:</span>
                <span class="font-medium">{{ number_format($data['my_surat_pending'] ?? 0) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Diproses:</span>
                <span class="font-medium">{{ number_format($data['my_surat_processing'] ?? 0) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Selesai:</span>
                <span class="font-medium text-green-600">{{ number_format($data['my_surat_completed'] ?? 0) }}</span>
            </div>
        </div>
    </div>

    <!-- My Antrian Statistics -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Antrian Saya Layani</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ number_format($data['my_antrian_total'] ?? 0) }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-check text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 space-y-1">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Dilayani:</span>
                <span class="font-medium">{{ number_format($data['my_antrian_served'] ?? 0) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Selesai:</span>
                <span class="font-medium text-green-600">{{ number_format($data['my_antrian_completed'] ?? 0) }}</span>
            </div>
        </div>
    </div>

    <!-- My Pengaduan Statistics -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Pengaduan Saya Tangani</p>
                <p class="text-3xl font-bold text-purple-600 mt-1">{{ number_format($data['my_pengaduan_total'] ?? 0) }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-headset text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 space-y-1">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Diproses:</span>
                <span class="font-medium">{{ number_format($data['my_pengaduan_processing'] ?? 0) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Selesai:</span>
                <span class="font-medium text-green-600">{{ number_format($data['my_pengaduan_completed'] ?? 0) }}</span>
            </div>
        </div>
    </div>

    <!-- General Statistics -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Data Umum</p>
                <p class="text-3xl font-bold text-gray-600 mt-1">{{ number_format($data['total_penduduk'] ?? 0) }}</p>
                <p class="text-xs text-gray-400">Total Penduduk</p>
            </div>
            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-gray-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 space-y-1">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Total Surat:</span>
                <span class="font-medium">{{ number_format($data['surat_total'] ?? 0) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Total Antrian:</span>
                <span class="font-medium">{{ number_format($data['antrian_total'] ?? 0) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Total Pengaduan:</span>
                <span class="font-medium">{{ number_format($data['pengaduan_total'] ?? 0) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Performance Chart Section -->
<div class="bg-white rounded-xl p-6 card-shadow mt-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Kinerja Saya</h3>
        <p class="text-gray-600">Ringkasan kinerja Anda dalam periode yang dipilih</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Surat Performance -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-file-signature text-blue-600 text-2xl"></i>
            </div>
            <h4 class="font-semibold text-gray-800">Layanan Surat</h4>
            <p class="text-2xl font-bold text-blue-600">{{ number_format($data['my_surat_total'] ?? 0) }}</p>
            <p class="text-sm text-gray-500">Surat diproses</p>
            @if(($data['my_surat_total'] ?? 0) > 0)
                <div class="mt-2">
                    <div class="text-xs text-green-600">
                        {{ number_format((($data['my_surat_completed'] ?? 0) / $data['my_surat_total']) * 100, 1) }}% selesai
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Antrian Performance -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-user-check text-green-600 text-2xl"></i>
            </div>
            <h4 class="font-semibold text-gray-800">Layanan Antrian</h4>
            <p class="text-2xl font-bold text-green-600">{{ number_format($data['my_antrian_total'] ?? 0) }}</p>
            <p class="text-sm text-gray-500">Antrian dilayani</p>
            @if(($data['my_antrian_total'] ?? 0) > 0)
                <div class="mt-2">
                    <div class="text-xs text-green-600">
                        {{ number_format((($data['my_antrian_completed'] ?? 0) / $data['my_antrian_total']) * 100, 1) }}% selesai
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Pengaduan Performance -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-headset text-purple-600 text-2xl"></i>
            </div>
            <h4 class="font-semibold text-gray-800">Penanganan Pengaduan</h4>
            <p class="text-2xl font-bold text-purple-600">{{ number_format($data['my_pengaduan_total'] ?? 0) }}</p>
            <p class="text-sm text-gray-500">Pengaduan ditangani</p>
            @if(($data['my_pengaduan_total'] ?? 0) > 0)
                <div class="mt-2">
                    <div class="text-xs text-green-600">
                        {{ number_format((($data['my_pengaduan_completed'] ?? 0) / $data['my_pengaduan_total']) * 100, 1) }}% selesai
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>