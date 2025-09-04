@extends('layouts.main')

@section('title', 'Tambah Antrian')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 mb-6">
    <h1 class="text-2xl font-bold text-white mb-2">Tambah Antrian Baru</h1>
    <p class="text-blue-100">Tambahkan antrian baru untuk layanan kantor camat</p>
</div>
<!-- Form Card -->
<div class="bg-white rounded-xl card-shadow p-6">
                    <form action="{{ route('admin.antrian.store') }}" method="POST">
                        @csrf
                        
                        <!-- Informasi Antrian -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-clock text-blue-600 mr-2"></i>
                                Informasi Antrian
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan <span class="text-red-500">*</span></label>
                                    <select name="jenis_layanan" id="jenis_layanan" required class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_layanan') border-red-500 @enderror">
                                        <option value="">Pilih Jenis Layanan</option>
                                        @foreach($jenisLayananOptions as $jenis)
                                            <option value="{{ $jenis }}" {{ old('jenis_layanan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_layanan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="estimasi_waktu" class="block text-sm font-medium text-gray-700 mb-2">Estimasi Waktu (menit)</label>
                                    <input type="number" name="estimasi_waktu" id="estimasi_waktu" value="{{ old('estimasi_waktu', 30) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('estimasi_waktu') border-red-500 @enderror">
                                    @error('estimasi_waktu')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Pengunjung -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user text-green-600 mr-2"></i>
                                Data Pengunjung
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nama_pengunjung" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_pengunjung" id="nama_pengunjung" value="{{ old('nama_pengunjung') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_pengunjung') border-red-500 @enderror">
                                    @error('nama_pengunjung')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="nik_pengunjung" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                    <input type="text" name="nik_pengunjung" id="nik_pengunjung" value="{{ old('nik_pengunjung') }}" maxlength="16" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik_pengunjung') border-red-500 @enderror">
                                    @error('nik_pengunjung')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone_pengunjung" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                                    <input type="text" name="phone_pengunjung" id="phone_pengunjung" value="{{ old('phone_pengunjung') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone_pengunjung') border-red-500 @enderror">
                                    @error('phone_pengunjung')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Jadwal Kunjungan -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-calendar text-purple-600 mr-2"></i>
                                Jadwal Kunjungan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_kunjungan') border-red-500 @enderror">
                                    @error('tanggal_kunjungan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="jam_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Jam Kunjungan <span class="text-red-500">*</span></label>
                                    <input type="time" name="jam_kunjungan" id="jam_kunjungan" value="{{ old('jam_kunjungan', '08:00') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jam_kunjungan') border-red-500 @enderror">
                                    @error('jam_kunjungan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Keperluan dan Catatan -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-sticky-note text-orange-600 mr-2"></i>
                                Keperluan dan Catatan
                            </h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                                    <textarea name="keperluan" id="keperluan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keperluan') border-red-500 @enderror" placeholder="Jelaskan keperluan kunjungan...">{{ old('keperluan') }}</textarea>
                                    @error('keperluan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                                    <textarea name="catatan" id="catatan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('catatan') border-red-500 @enderror" placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Petugas Pelayanan (Optional) -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-tie text-indigo-600 mr-2"></i>
                                Petugas Pelayanan (Opsional)
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="dilayani_oleh" class="block text-sm font-medium text-gray-700 mb-2">Ditugaskan Kepada</label>
                                    <select name="dilayani_oleh" id="dilayani_oleh" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('dilayani_oleh') border-red-500 @enderror">
                                        <option value="">Pilih Petugas (Opsional)</option>
                                        @foreach($pegawaiUsers as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('dilayani_oleh') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('dilayani_oleh')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-gray-500 mt-1">Kosongkan jika belum ada petugas yang ditugaskan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.antrian.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>Simpan Antrian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
}

// Set minimum date to today
document.getElementById('tanggal_kunjungan').min = new Date().toISOString().split('T')[0];

// Auto-set estimasi waktu based on jenis layanan
document.getElementById('jenis_layanan').addEventListener('change', function() {
    const estimasiWaktu = document.getElementById('estimasi_waktu');
    const jenisLayanan = this.value;
    
    const estimasiDefault = {
        'Surat Domisili': 30,
        'SKTM': 45,
        'Surat Usaha': 60,
        'Surat Pengantar': 20,
        'Konsultasi': 15,
        'Lainnya': 30
    };
    
    if (estimasiDefault[jenisLayanan]) {
        estimasiWaktu.value = estimasiDefault[jenisLayanan];
    }
});
</script>
@endsection