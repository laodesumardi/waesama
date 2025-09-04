@extends('layouts.main')

@section('title', 'Ajukan Pengaduan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('warga.pengaduan.index') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Ajukan Pengaduan</h1>
                <p class="text-gray-600 mt-2">Sampaikan keluhan atau saran Anda kepada kami</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('warga.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Judul Pengaduan -->
            <div class="mb-6">
                <label for="judul_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Pengaduan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul_pengaduan" name="judul_pengaduan" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Masukkan judul pengaduan"
                       value="{{ old('judul_pengaduan') }}" required>
                @error('judul_pengaduan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-6">
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="kategori" name="kategori" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Infrastruktur" {{ old('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="Pelayanan Publik" {{ old('kategori') == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                    <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                    <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                    <option value="Administrasi" {{ old('kategori') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prioritas -->
            <div class="mb-6">
                <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-2">
                    Prioritas <span class="text-red-500">*</span>
                </label>
                <select id="prioritas" name="prioritas" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Pilih Prioritas</option>
                    <option value="Rendah" {{ old('prioritas') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="Sedang" {{ old('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Tinggi" {{ old('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="Mendesak" {{ old('prioritas') == 'Mendesak' ? 'selected' : '' }}>Mendesak</option>
                </select>
                @error('prioritas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi Pengaduan -->
            <div class="mb-6">
                <label for="isi_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">
                    Isi Pengaduan <span class="text-red-500">*</span>
                </label>
                <textarea id="isi_pengaduan" name="isi_pengaduan" rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Jelaskan detail pengaduan Anda..." required>{{ old('isi_pengaduan') }}</textarea>
                @error('isi_pengaduan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lampiran -->
            <div class="mb-6">
                <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran (Opsional)
                </label>
                <input type="file" id="lampiran" name="lampiran" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, PNG, PDF, DOC, DOCX. Maksimal 2MB.</p>
                @error('lampiran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Information Box -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">Informasi Penting:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pengaduan akan diproses dalam 1-3 hari kerja</li>
                            <li>Anda akan mendapat notifikasi melalui email untuk setiap update status</li>
                            <li>Pastikan data yang diisi sudah benar dan lengkap</li>
                            <li>Untuk pengaduan mendesak, silakan hubungi kantor langsung</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Pengaduan
                </button>
                <a href="{{ route('warga.pengaduan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection