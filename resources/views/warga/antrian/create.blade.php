@extends('layouts.main')

@section('title', 'Ambil Antrian')

@push('styles')
<style>
    .time-slot {
        transition: all 0.2s ease;
    }
    .time-slot:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .time-slot.selected {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    .time-slot.unavailable {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('warga.antrian.index') }}" 
               class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Ambil Antrian</h1>
                <p class="text-gray-600">Pilih waktu kunjungan yang sesuai dengan kebutuhan Anda</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <form action="{{ route('warga.antrian.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Jenis Layanan -->
            <div class="mb-6">
                <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Layanan <span class="text-red-500">*</span>
                </label>
                <select id="jenis_layanan" name="jenis_layanan" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_layanan') border-red-500 @enderror">
                    <option value="">Pilih Jenis Layanan</option>
                    <option value="Surat Domisili" {{ old('jenis_layanan') == 'Surat Domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                    <option value="SKTM" {{ old('jenis_layanan') == 'SKTM' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                    <option value="Surat Usaha" {{ old('jenis_layanan') == 'Surat Usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                    <option value="Surat Pengantar" {{ old('jenis_layanan') == 'Surat Pengantar' ? 'selected' : '' }}>Surat Pengantar</option>
                    <option value="Konsultasi" {{ old('jenis_layanan') == 'Konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                    <option value="Lainnya" {{ old('jenis_layanan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis_layanan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keperluan -->
            <div class="mb-6">
                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">
                    Keperluan <span class="text-red-500">*</span>
                </label>
                <textarea id="keperluan" name="keperluan" rows="4" required
                          placeholder="Jelaskan keperluan kunjungan Anda..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('keperluan') border-red-500 @enderror">{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pilih Tanggal dan Waktu -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-4">
                    Pilih Tanggal dan Waktu Kunjungan <span class="text-red-500">*</span>
                </label>
                
                @foreach($availableSlots as $dateSlot)
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ $dateSlot['date_formatted'] }}</h3>
                        
                        <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
                            @foreach($dateSlot['slots'] as $slot)
                                <label class="time-slot cursor-pointer border-2 border-gray-200 rounded-lg p-3 text-center {{ !$slot['available'] ? 'unavailable' : '' }}">
                                    <input type="radio" name="slot" value="{{ $dateSlot['date'] }}|{{ $slot['time'] }}" 
                                           class="hidden" {{ !$slot['available'] ? 'disabled' : '' }}
                                           {{ old('slot') == $dateSlot['date'].'|'.$slot['time'] ? 'checked' : '' }}>
                                    <div class="text-sm font-medium">{{ $slot['time'] }}</div>
                                    @if($slot['available'])
                                        <div class="text-xs text-gray-500 mt-1">{{ $slot['remaining'] }} slot</div>
                                    @else
                                        <div class="text-xs text-red-500 mt-1">Penuh</div>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                @error('slot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('tanggal_kunjungan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('jam_kunjungan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Information Box -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Informasi Penting:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Jam pelayanan: 08:00 - 16:00 WIB (Senin - Jumat)</li>
                            <li>Istirahat: 12:00 - 13:00 WIB</li>
                            <li>Setiap slot waktu maksimal 3 orang</li>
                            <li>Harap datang 15 menit sebelum waktu yang dipilih</li>
                            <li>Bawa dokumen yang diperlukan sesuai jenis layanan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Ambil Antrian
                </button>
                <a href="{{ route('warga.antrian.index') }}" 
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slots = document.querySelectorAll('input[name="slot"]');
        const form = document.querySelector('form');
        
        slots.forEach(slot => {
            slot.addEventListener('change', function() {
                // Remove selected class from all slots
                document.querySelectorAll('.time-slot').forEach(label => {
                    label.classList.remove('selected');
                });
                
                // Add selected class to current slot
                this.closest('.time-slot').classList.add('selected');
            });
        });
        
        // Set initial selection if there's old input
        const checkedSlot = document.querySelector('input[name="slot"]:checked');
        if (checkedSlot) {
            checkedSlot.closest('.time-slot').classList.add('selected');
        }
        
        // Form validation
        form.addEventListener('submit', function(e) {
            const selectedSlot = document.querySelector('input[name="slot"]:checked');
            if (!selectedSlot) {
                e.preventDefault();
                alert('Silakan pilih tanggal dan waktu kunjungan terlebih dahulu.');
                return false;
            }
        });
    });
</script>
@endpush