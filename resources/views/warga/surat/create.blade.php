@extends('layouts.main')

@section('title', 'Ajukan Surat Baru')

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('warga.dashboard') }}" 
               class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Ajukan Surat Baru</h1>
                <p class="text-gray-600">Isi formulir di bawah untuk mengajukan surat</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <form id="surat-form" action="{{ route('warga.surat.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Jenis Surat -->
            <div class="mb-6">
                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Surat <span class="text-red-500">*</span>
                </label>
                <select id="service_type" name="service_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('service_type') border-red-500 @enderror">
                    <option value="">Pilih Jenis Surat</option>
                    <option value="Domisili" {{ (old('service_type') == 'Domisili' || $jenisSurat == 'Domisili') ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                    <option value="SKTM" {{ (old('service_type') == 'SKTM' || $jenisSurat == 'SKTM') ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                    <option value="Usaha" {{ (old('service_type') == 'Usaha' || $jenisSurat == 'Usaha') ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                    <option value="Pengantar" {{ (old('service_type') == 'Pengantar' || $jenisSurat == 'Pengantar') ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                    <option value="Kelahiran" {{ (old('service_type') == 'Kelahiran' || $jenisSurat == 'Kelahiran') ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                    <option value="Kematian" {{ (old('service_type') == 'Kematian' || $jenisSurat == 'Kematian') ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                    <option value="Pindah" {{ (old('service_type') == 'Pindah' || $jenisSurat == 'Pindah') ? 'selected' : '' }}>Surat Keterangan Pindah</option>
                </select>
                @error('service_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keperluan -->
            <div class="mb-6">
                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">
                    Keperluan <span class="text-red-500">*</span>
                </label>
                <textarea id="purpose" name="purpose" rows="4" required
                          placeholder="Jelaskan keperluan surat ini..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('purpose') border-red-500 @enderror">{{ old('purpose') }}</textarea>
                @error('purpose')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter</p>
            </div>

            <!-- Dynamic Fields -->
            <div id="dynamic-fields" class="space-y-4 mb-6">
                <!-- Fields will be populated by JavaScript based on selected letter type -->
            </div>

            <!-- Data Pemohon (Read-only) -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Data Pemohon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                        <input type="text" value="{{ Auth::user()->nik }}" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" value="{{ Auth::user()->alamat ?? 'Belum diisi' }}" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" value="{{ Auth::user()->phone ?? 'Belum diisi' }}" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Data pemohon diambil dari profil Anda. Jika ada yang perlu diubah, silakan update profil terlebih dahulu.
                </p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Ajukan Surat
                </button>
                <a href="{{ route('warga.dashboard') }}" 
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

<!-- User Data Script -->
<script id="user-data" type="application/json">
{!! json_encode([
    'name' => auth()->user()->name ?? '',
    'nik' => auth()->user()->nik ?? '',
    'alamat' => auth()->user()->alamat ?? '',
    'phone' => auth()->user()->phone ?? ''
]) !!}
</script>
@endsection

@push('scripts')
<script src="{{ asset('js/surat-form.js') }}"></script>
@endpush