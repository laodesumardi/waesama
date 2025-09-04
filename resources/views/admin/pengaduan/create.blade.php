@extends('layouts.main')

@section('title', 'Tambah Pengaduan')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Tambah Pengaduan</h2>
                <p class="text-blue-100">Tambah pengaduan baru ke dalam sistem dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-plus-circle text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>
            <form action="{{ route('admin.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Data Pengadu -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-2"></i>
                        Data Pengadu
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Nama Pengadu *</label>
                            <input type="text" name="nama_pengadu" id="nama_pengadu" value="{{ old('nama_pengadu') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_pengadu') border-red-500 @enderror">
                            @error('nama_pengadu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_pengadu" id="email_pengadu" value="{{ old('email_pengadu') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email_pengadu') border-red-500 @enderror">
                            @error('email_pengadu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon *</label>
                            <input type="text" name="phone_pengadu" id="phone_pengadu" value="{{ old('phone_pengadu') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone_pengadu') border-red-500 @enderror">
                            @error('phone_pengadu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="alamat_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                            <textarea name="alamat_pengadu" id="alamat_pengadu" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alamat_pengadu') border-red-500 @enderror">{{ old('alamat_pengadu') }}</textarea>
                            @error('alamat_pengadu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Detail Pengaduan -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-comments text-blue-600 mr-2"></i>
                        Detail Pengaduan
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="judul_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengaduan *</label>
                            <input type="text" name="judul_pengaduan" id="judul_pengaduan" value="{{ old('judul_pengaduan') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('judul_pengaduan') border-red-500 @enderror">
                            @error('judul_pengaduan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                                <select name="kategori" id="kategori" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kategori') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pelayanan" {{ old('kategori') == 'Pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                                    <option value="Infrastruktur" {{ old('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                    <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                    <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kategori')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-2">Prioritas *</label>
                                <select name="prioritas" id="prioritas" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('prioritas') border-red-500 @enderror">
                                    <option value="">Pilih Prioritas</option>
                                    <option value="Rendah" {{ old('prioritas') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="Sedang" {{ old('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="Tinggi" {{ old('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="Urgent" {{ old('prioritas') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('prioritas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="isi_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">Isi Pengaduan *</label>
                            <textarea name="isi_pengaduan" id="isi_pengaduan" rows="6" required placeholder="Jelaskan detail pengaduan Anda..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('isi_pengaduan') border-red-500 @enderror">{{ old('isi_pengaduan') }}</textarea>
                            @error('isi_pengaduan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">Lampiran</label>
                            <input type="file" name="lampiran" id="lampiran" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lampiran') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, PNG, PDF, DOC, DOCX (Maksimal 5MB)</p>
                            @error('lampiran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Penanganan -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-cog text-blue-600 mr-2"></i>
                        Penanganan (Opsional)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                <option value="Diterima" {{ old('status', 'Diterima') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Ditindaklanjuti" {{ old('status') == 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                                <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="ditangani_oleh" class="block text-sm font-medium text-gray-700 mb-2">Ditangani Oleh</label>
                            <select name="ditangani_oleh" id="ditangani_oleh" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ditangani_oleh') border-red-500 @enderror">
                                <option value="">Pilih Petugas</option>
                                @foreach($pegawaiUsers as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ old('ditangani_oleh') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->name }}</option>
                                @endforeach
                            </select>
                            @error('ditangani_oleh')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label for="tanggapan" class="block text-sm font-medium text-gray-700 mb-2">Tanggapan</label>
                        <textarea name="tanggapan" id="tanggapan" rows="4" placeholder="Tanggapan atau tindak lanjut dari petugas..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggapan') border-red-500 @enderror">{{ old('tanggapan') }}</textarea>
                        @error('tanggapan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.pengaduan.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <div class="space-x-3">
                        <button type="reset" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Simpan Pengaduan
                        </button>
                    </div>
                </div>
            </form>
</div>

<script>
// Auto-generate nomor pengaduan preview
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    
    // Show preview of auto-generated number
    const previewElement = document.createElement('p');
    previewElement.className = 'mt-1 text-sm text-blue-600';
    previewElement.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Nomor pengaduan akan dibuat otomatis';
    
    const form = document.querySelector('form');
    if (form) {
        form.insertBefore(previewElement, form.firstChild);
    }
});
</script>
@endsection