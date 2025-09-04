<!-- Antrian Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Status Breakdown -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Antrian</h3>
        @if(isset($data['status_breakdown']) && $data['status_breakdown']->count() > 0)
            <div class="space-y-3">
                @foreach($data['status_breakdown'] as $status)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ $status->status }}</span>
                        <span class="font-semibold 
                            @if($status->status == 'Selesai') text-green-600
                            @elseif($status->status == 'Sedang Dilayani') text-blue-600
                            @elseif($status->status == 'Menunggu') text-yellow-600
                            @else text-gray-600
                            @endif
                        ">{{ number_format($status->total) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Tidak ada data status antrian</p>
        @endif
    </div>
    
    <!-- Layanan Breakdown -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Jenis Layanan</h3>
        @if(isset($data['layanan_breakdown']) && $data['layanan_breakdown']->count() > 0)
            <div class="space-y-3">
                @foreach($data['layanan_breakdown'] as $layanan)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">{{ $layanan->jenis_layanan }}</span>
                        <span class="font-semibold text-blue-600">{{ number_format($layanan->total) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Tidak ada data jenis layanan</p>
        @endif
    </div>
    
    <!-- Performance Summary -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kinerja Layanan</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Total Antrian</span>
                <span class="font-semibold text-blue-600">{{ number_format($data['my_antrian']->count() ?? 0) }}</span>
            </div>
            @php
                $completed = $data['status_breakdown']->where('status', 'Selesai')->first()->total ?? 0;
                $total = $data['my_antrian']->count() ?? 0;
                $completionRate = $total > 0 ? ($completed / $total) * 100 : 0;
                $avgWaitTime = $data['my_antrian']->where('status', 'Selesai')->avg('waktu_tunggu') ?? 0;
            @endphp
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Tingkat Penyelesaian</span>
                <span class="font-semibold text-green-600">{{ number_format($completionRate, 1) }}%</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Rata-rata Waktu Tunggu</span>
                <span class="font-semibold text-orange-600">{{ number_format($avgWaitTime, 0) }} menit</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Antrian List -->
<div class="bg-white rounded-xl p-6 card-shadow">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Daftar Antrian yang Saya Layani</h3>
            <p class="text-gray-600">Detail antrian yang telah Anda layani dalam periode yang dipilih</p>
        </div>
    </div>
    
    @if(isset($data['my_antrian']) && $data['my_antrian']->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Antrian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Tunggu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($data['my_antrian'] as $antrian)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $antrian->nomor_antrian }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $antrian->jenis_layanan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $antrian->nama_pengunjung }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($antrian->status == 'Selesai') bg-green-100 text-green-800
                                    @elseif($antrian->status == 'Sedang Dilayani') bg-blue-100 text-blue-800
                                    @elseif($antrian->status == 'Menunggu') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">
                                    {{ $antrian->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($antrian->waktu_tunggu)
                                    {{ number_format($antrian->waktu_tunggu) }} menit
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $antrian->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data antrian</h3>
            <p class="text-gray-500">Belum ada antrian yang Anda layani dalam periode yang dipilih.</p>
        </div>
    @endif
</div>