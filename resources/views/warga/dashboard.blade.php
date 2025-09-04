@extends('layouts.main')

@section('title', 'Dashboard Warga')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="rounded-xl p-6 text-white" style="background: #003f88;">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-emerald-100">Akses layanan Kantor Camat Waesama dengan mudah dan cepat.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-circle text-6xl text-emerald-200"></i>
            </div>
        </div>
    </div>

    <!-- Data Pribadi Section -->
    <div class="bg-white rounded-xl p-6 card-shadow mb-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Data Pribadi</h3>
            <a href="{{ route('warga.profil') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                <i class="fas fa-edit mr-1"></i>Edit Profil
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Profile Picture -->
            <div class="lg:col-span-1">
                <div class="text-center">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        @if($citizen && $citizen->photo_path)
                            <img src="{{ asset('storage/' . $citizen->photo_path) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover">
                        @else
                            <i class="fas fa-user text-blue-600 text-3xl"></i>
                        @endif
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">{{ $citizen->name ?? auth()->user()->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $citizen->nik ?? auth()->user()->nik ?? 'NIK belum diisi' }}</p>
                </div>
            </div>
            
            <!-- Personal Info -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-gray-800">{{ $citizen->email ?? auth()->user()->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">No. Telepon</label>
                            <p class="text-gray-800">{{ $citizen->phone ?? auth()->user()->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</label>
                            <p class="text-gray-800">
                                @if($citizen && $citizen->birth_place && $citizen->birth_date)
                                    {{ $citizen->birth_place }}, {{ $citizen->birth_date->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                            <p class="text-gray-800">
                                @if($citizen && $citizen->gender)
                                    {{ $citizen->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Agama</label>
                            <p class="text-gray-800">{{ $citizen->religion ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status Perkawinan</label>
                            <p class="text-gray-800">{{ $citizen->marital_status ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Pekerjaan</label>
                            <p class="text-gray-800">{{ $citizen->occupation ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">RT/RW</label>
                            <p class="text-gray-800">
                                @if($citizen && ($citizen->rt || $citizen->rw))
                                    {{ $citizen->rt ? 'RT ' . $citizen->rt : '' }}{{ $citizen->rt && $citizen->rw ? '/' : '' }}{{ $citizen->rw ? 'RW ' . $citizen->rw : '' }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @if($citizen && $citizen->address)
                <div class="mt-4">
                    <label class="text-sm font-medium text-gray-500">Alamat Lengkap</label>
                    <p class="text-gray-800">{{ $citizen->address }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- My Surat -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Surat Saya</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['my_surat']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('warga.surat.list') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Riwayat →</a>
            </div>
        </div>

        <!-- My Service Requests -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Layanan Saya</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['my_service_requests']) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-emerald-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('warga.surat.list') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Lihat Riwayat →</a>
            </div>
        </div>

        <!-- My Antrian -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Antrian Saya</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['my_antrian']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-gray-500 cursor-not-allowed text-sm font-medium" title="Fitur dalam pengembangan">Ambil Antrian →</a>
            </div>
        </div>

        <!-- My Pengaduan -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pengaduan Saya</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['my_pengaduan']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-gray-500 cursor-not-allowed text-sm font-medium" title="Fitur dalam pengembangan">Buat Pengaduan →</a>
            </div>
        </div>
    </div>

    <!-- Form Pengajuan Surat -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Ajukan Surat Baru</h3>
            <i class="fas fa-plus-circle text-gray-400"></i>
        </div>
        
        <form id="suratForm" action="{{ route('warga.surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nama lengkap" value="{{ auth()->user()->name ?? '' }}">
                </div>
                
                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK *</label>
                    <input type="text" id="nik" name="nik" required maxlength="16" pattern="[0-9]{16}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan 16 digit NIK">
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan email" value="{{ auth()->user()->email ?? '' }}">
                </div>
                
                <!-- No. Telepon -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                    <input type="tel" id="phone" name="phone" required maxlength="20"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nomor telepon">
                </div>
                
                <!-- Tempat Lahir -->
                <div>
                    <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                    <input type="text" id="birth_place" name="birth_place" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan tempat lahir">
                </div>
                
                <!-- Tanggal Lahir -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                    <input type="date" id="birth_date" name="birth_date" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Jenis Kelamin -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                    <select id="gender" name="gender" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                
                <!-- Agama -->
                <div>
                    <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama *</label>
                    <select id="religion" name="religion" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
                
                <!-- Status Perkawinan -->
                <div>
                    <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan *</label>
                    <select id="marital_status" name="marital_status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Status Perkawinan</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>
                
                <!-- Pekerjaan -->
                <div>
                    <label for="occupation" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                    <input type="text" id="occupation" name="occupation"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan pekerjaan">
                </div>
                
                <!-- RT -->
                <div>
                    <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">RT</label>
                    <input type="text" id="rt" name="rt" maxlength="3"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: 001">
                </div>
                
                <!-- RW -->
                <div>
                    <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">RW</label>
                    <input type="text" id="rw" name="rw" maxlength="3"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: 001">
                </div>
            </div>
            
            <!-- Alamat -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                <textarea id="address" name="address" required rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Masukkan alamat lengkap (Jalan, Nomor Rumah, Kelurahan/Desa)"></textarea>
            </div>
            
            <!-- Jenis Layanan -->
            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan *</label>
                <select id="service_type" name="service_type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Pilih Jenis Layanan</option>
                    <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                    <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                    <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                    <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                    <option value="Surat Pengantar KTP">Surat Pengantar KTP</option>
                    <option value="Surat Pengantar KK">Surat Pengantar Kartu Keluarga</option>
                    <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
                    <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            
            <!-- Keperluan -->
            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">Keperluan/Keterangan *</label>
                <textarea id="purpose" name="purpose" required rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Jelaskan keperluan atau keterangan tambahan"></textarea>
            </div>
            
            <!-- Keterangan Tambahan -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Keterangan Tambahan</label>
                <textarea name="notes" id="notes" rows="3" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
            </div>
            
            <!-- Upload Dokumen Pendukung -->
            <div>
                <label for="uploaded_files" class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung (Opsional)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                    <input type="file" name="uploaded_files[]" id="uploaded_files" multiple accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                    <label for="uploaded_files" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600">Klik untuk upload dokumen pendukung</p>
                        <p class="text-sm text-gray-500 mt-1">Format: PDF, JPG, PNG (Max: 5MB per file)</p>
                    </label>
                    <div id="file-list" class="mt-3 text-left hidden"></div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="resetForm()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Reset
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Ajukan Surat
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Services -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Layanan Cepat</h3>
            <i class="fas fa-rocket text-gray-400"></i>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <button onclick="fillQuickForm('Surat Keterangan Domisili')" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-id-card text-3xl text-gray-400 group-hover:text-blue-600 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-blue-600 font-medium text-sm">Surat Keterangan Domisili</p>
                </div>
            </button>
            <button onclick="fillQuickForm('Surat Keterangan Usaha')" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-briefcase text-3xl text-gray-400 group-hover:text-green-600 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-green-600 font-medium text-sm">Surat Keterangan Usaha</p>
                </div>
            </button>
            <button onclick="fillQuickForm('Surat Keterangan Belum Menikah')" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-heart text-3xl text-gray-400 group-hover:text-purple-600 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-purple-600 font-medium text-sm">Surat Keterangan Belum Menikah</p>
                </div>
            </button>
            <button onclick="fillQuickForm('Surat Keterangan Sehat')" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-file-medical text-3xl text-gray-400 group-hover:text-yellow-600 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-yellow-600 font-medium text-sm">Surat Keterangan Sehat</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Service Requests -->
    <div class="bg-white rounded-xl p-6 card-shadow mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Layanan Terbaru</h3>
            <a href="{{ route('warga.surat.list') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua →</a>
        </div>
        
        @if($recentServiceRequests && $recentServiceRequests->count() > 0)
            <div class="space-y-4">
                @foreach($recentServiceRequests as $request)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $request->service_type }}</h4>
                                    <p class="text-sm text-gray-600">{{ $request->purpose }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $request->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'processing' => 'Diproses',
                                    'completed' => 'Selesai',
                                    'rejected' => 'Ditolak'
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$request->status] ?? ucfirst($request->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500">Belum ada riwayat layanan</p>
                <p class="text-sm text-gray-400 mt-1">Ajukan layanan pertama Anda menggunakan form di atas</p>
            </div>
        @endif
    </div>

    <!-- Notifications & News -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Notifications -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Notifikasi Terbaru</h3>
                <button onclick="markAllNotificationsAsRead()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Tandai Semua Dibaca</button>
            </div>
            <div id="dashboard-notifications" class="space-y-4">
                <div class="text-center py-8">
                    <i class="fas fa-bell text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Memuat notifikasi...</p>
                </div>
            </div>
        </div>

        <!-- Recent News -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Berita Terbaru</h3>
                <a href="{{ route('warga.berita.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($recentNews as $news)
                <div class="flex space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    @if($news->gambar)
                        <img src="{{ asset('storage/' . $news->gambar) }}" alt="{{ $news->judul }}" class="w-16 h-16 rounded-lg object-cover">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800 text-sm mb-1">{{ Str::limit($news->judul, 60) }}</h4>
                        <p class="text-gray-500 text-xs mb-2">{{ Str::limit($news->excerpt, 80) }}</p>
                        <p class="text-gray-400 text-xs">{{ $news->published_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-newspaper text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada berita terbaru</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Status & Information -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Status Terkini</h3>
                    <i class="fas fa-info-circle text-gray-400"></i>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="text-gray-700 text-sm">Surat Domisili</span>
                        </div>
                        <span class="bg-green-200 text-green-800 text-xs font-medium px-2 py-1 rounded">Selesai</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-yellow-600"></i>
                            <span class="text-gray-700 text-sm">Surat Usaha</span>
                        </div>
                        <span class="bg-yellow-200 text-yellow-800 text-xs font-medium px-2 py-1 rounded">Proses</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-user-clock text-blue-600"></i>
                            <span class="text-gray-700 text-sm">Antrian A-025</span>
                        </div>
                        <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2 py-1 rounded">Menunggu</span>
                    </div>
                </div>
            </div>

            <!-- Office Hours -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Jam Pelayanan</h3>
                    <i class="fas fa-clock text-gray-400"></i>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Senin - Kamis</span>
                        <span class="font-medium text-gray-800">08:00 - 16:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumat</span>
                        <span class="font-medium text-gray-800">08:00 - 11:30</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sabtu - Minggu</span>
                        <span class="font-medium text-red-600">Tutup</span>
                    </div>
                </div>
                <div class="mt-4 p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-green-700 text-sm font-medium">Kantor sedang buka</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help & Contact -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Bantuan & Kontak</h3>
            <i class="fas fa-question-circle text-gray-400"></i>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-phone text-2xl text-blue-600 mb-3"></i>
                <p class="text-gray-800 font-medium mb-1">Telepon</p>
                <p class="text-gray-500 text-sm">(0274) 123-4567</p>
            </div>
            <div class="text-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-envelope text-2xl text-green-600 mb-3"></i>
                <p class="text-gray-800 font-medium mb-1">Email</p>
                <p class="text-gray-500 text-sm">info@waesama.go.id</p>
            </div>
            <div class="text-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fab fa-whatsapp text-2xl text-green-500 mb-3"></i>
                <p class="text-gray-800 font-medium mb-1">WhatsApp</p>
                <p class="text-gray-500 text-sm">+62 812-3456-7890</p>
            </div>
        </div>
    </div>
</div>

<script>
// Load dashboard notifications
function loadDashboardNotifications() {
    fetch('/notifications')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('dashboard-notifications');
            
            if (data.notifications.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-bell text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }
            
            // Show only first 5 notifications
            const notifications = data.notifications.slice(0, 5);
            
            container.innerHTML = notifications.map(notification => {
                const isUnread = !notification.read_at;
                const priorityColor = {
                    'urgent': 'border-red-500 bg-red-50',
                    'high': 'border-orange-500 bg-orange-50',
                    'medium': 'border-blue-500 bg-blue-50',
                    'low': 'border-gray-500 bg-gray-50'
                }[notification.priority] || 'border-gray-500 bg-gray-50';
                
                return `
                    <div class="p-4 rounded-lg border-l-4 ${priorityColor} ${isUnread ? '' : 'opacity-60'}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 text-sm mb-1">
                                    ${isUnread ? '<span class="w-2 h-2 bg-blue-500 rounded-full inline-block mr-2"></span>' : ''}
                                    ${notification.title}
                                </h4>
                                <p class="text-gray-600 text-sm mb-2">${notification.message}</p>
                                <p class="text-gray-400 text-xs">${formatDate(notification.created_at)}</p>
                            </div>
                            ${isUnread ? `
                                <button onclick="markNotificationAsRead(${notification.id})" 
                                        class="text-blue-600 hover:text-blue-800 text-xs ml-2">
                                    Tandai Dibaca
                                </button>
                            ` : ''}
                        </div>
                    </div>
                `;
            }).join('');
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('dashboard-notifications').innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-300 mb-3"></i>
                    <p class="text-red-500">Gagal memuat notifikasi</p>
                </div>
            `;
        });
}

// Mark single notification as read
function markNotificationAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadDashboardNotifications();
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

// Mark all notifications as read
function markAllNotificationsAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadDashboardNotifications();
        }
    })
    .catch(error => console.error('Error marking all notifications as read:', error));
}

// Format date helper
function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) {
        return 'Baru saja';
    } else if (diffInSeconds < 3600) {
        const minutes = Math.floor(diffInSeconds / 60);
        return `${minutes} menit yang lalu`;
    } else if (diffInSeconds < 86400) {
        const hours = Math.floor(diffInSeconds / 3600);
        return `${hours} jam yang lalu`;
    } else {
        const days = Math.floor(diffInSeconds / 86400);
        return `${days} hari yang lalu`;
    }
}

// Form handling functions
function fillQuickForm(jenisSurat) {
    document.getElementById('jenis_surat').value = jenisSurat;
    document.getElementById('suratForm').scrollIntoView({ behavior: 'smooth' });
    
    // Auto-fill keperluan based on jenis surat
    const keperluanField = document.getElementById('keperluan');
    const keperluanMap = {
        'Surat Keterangan Domisili': 'Keperluan administrasi kependudukan',
        'Surat Keterangan Usaha': 'Keperluan perizinan usaha',
        'Surat Keterangan Belum Menikah': 'Keperluan administrasi pernikahan',
        'Surat Keterangan Sehat': 'Keperluan kesehatan',
        'Surat Keterangan Tidak Mampu': 'Keperluan bantuan sosial',
        'Surat Pengantar Nikah': 'Keperluan pernikahan',
        'Surat Keterangan Kelahiran': 'Keperluan administrasi kelahiran',
        'Surat Keterangan Kematian': 'Keperluan administrasi kematian'
    };
    
    if (keperluanMap[jenisSurat]) {
        keperluanField.value = keperluanMap[jenisSurat];
    }
}

function resetForm() {
    document.getElementById('suratForm').reset();
    document.getElementById('file-list').innerHTML = '';
    document.getElementById('file-list').classList.add('hidden');
}

// File upload handling
document.getElementById('uploaded_files').addEventListener('change', function(e) {
    const fileList = document.getElementById('file-list');
    const files = Array.from(e.target.files);
    
    if (files.length > 0) {
        fileList.classList.remove('hidden');
        fileList.innerHTML = '<h4 class="font-medium text-gray-700 mb-2">File yang dipilih:</h4>';
        
        files.forEach((file, index) => {
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 rounded mb-2';
            fileItem.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-file text-gray-500 mr-2"></i>
                    <span class="text-sm text-gray-700">${file.name} (${fileSize} MB)</span>
                </div>
                <button type="button" onclick="removeFile(${index})" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            `;
            fileList.appendChild(fileItem);
        });
    } else {
        fileList.classList.add('hidden');
    }
});

function removeFile(index) {
    const input = document.getElementById('uploaded_files');
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    files.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
}

// Form submission handling
document.getElementById('suratForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
    
    // Create FormData
    const formData = new FormData(this);
    
    // Submit form
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Surat berhasil diajukan! Anda akan menerima notifikasi ketika surat diproses.', 'success');
            resetForm();
            
            // Refresh notifications
            loadDashboardNotifications();
        } else {
            showNotification(data.message || 'Terjadi kesalahan saat mengajukan surat.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengajukan surat.', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Notification helper
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${
                type === 'success' ? 'fa-check-circle' : 
                type === 'error' ? 'fa-exclamation-circle' : 
                'fa-info-circle'
            } mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Load notifications when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardNotifications();
    
    // Auto-refresh notifications every 30 seconds
    setInterval(loadDashboardNotifications, 30000);
});
</script>

@endsection