@extends('layouts.public')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section relative overflow-hidden">
        <!-- Hero Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-bg.svg') }}" alt="Hero Background" class="w-full h-full object-cover opacity-80">
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="text-center fade-in">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 drop-shadow-lg">
                    Selamat Datang di<br>
                    <span class="text-gradient">Kantor Camat</span>
                </h1>
                <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto drop-shadow-md">
                    Melayani masyarakat dengan profesional, transparan, dan akuntabel untuk kemajuan daerah
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('news.index') }}" class="btn-secondary btn-ripple smooth-link shadow-lg hover:shadow-xl transition-all duration-300">Lihat Berita Terbaru</a>
                    <a href="{{ route('gallery.index') }}" class="btn-outline btn-ripple smooth-link shadow-lg hover:shadow-xl transition-all duration-300">Galeri Kegiatan</a>
                </div>
                
                @guest
                <div class="mt-8 text-center">
                    <p class="text-white/80 mb-4">Ingin bergabung dengan sistem kami?</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-lg hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </section>

    <!-- Service Request Form Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-4xl md:text-5xl font-bold mb-6" style="color: #001d3d;">Ajukan Surat Online</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Ajukan permohonan surat secara online tanpa perlu datang ke kantor</p>
                <div class="w-24 h-1 mx-auto mt-6 rounded-full" style="background-color: #001d3d;"></div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl p-8 card-hover">
                <form action="{{ route('public.service-request.store') }}" method="POST" enctype="multipart/form-data" id="serviceRequestForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">NIK *</label>
                            <input type="text" id="nik" name="nik" required maxlength="16" pattern="[0-9]{16}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Masukkan 16 digit NIK">
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Masukkan email">
                        </div>
                        
                        <!-- No. Telepon -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon *</label>
                            <input type="tel" id="phone" name="phone" required maxlength="20"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Masukkan nomor telepon">
                        </div>
                        
                        <!-- Tempat Lahir -->
                        <div>
                            <label for="birth_place" class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir *</label>
                            <input type="text" id="birth_place" name="birth_place" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Masukkan tempat lahir">
                        </div>
                        
                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir *</label>
                            <input type="date" id="birth_date" name="birth_date" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>
                        
                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin *</label>
                            <select id="gender" name="gender" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        
                        <!-- Agama -->
                        <div>
                            <label for="religion" class="block text-sm font-semibold text-gray-700 mb-2">Agama *</label>
                            <select id="religion" name="religion" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
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
                            <label for="marital_status" class="block text-sm font-semibold text-gray-700 mb-2">Status Perkawinan *</label>
                            <select id="marital_status" name="marital_status" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="">Pilih Status Perkawinan</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>
                        
                        <!-- Pekerjaan -->
                        <div>
                            <label for="occupation" class="block text-sm font-semibold text-gray-700 mb-2">Pekerjaan</label>
                            <input type="text" id="occupation" name="occupation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Masukkan pekerjaan">
                        </div>
                        
                        <!-- RT -->
                        <div>
                            <label for="rt" class="block text-sm font-semibold text-gray-700 mb-2">RT</label>
                            <input type="text" id="rt" name="rt" maxlength="3"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Contoh: 001">
                        </div>
                        
                        <!-- RW -->
                        <div>
                            <label for="rw" class="block text-sm font-semibold text-gray-700 mb-2">RW</label>
                            <input type="text" id="rw" name="rw" maxlength="3"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Contoh: 001">
                        </div>
                        
                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap *</label>
                            <textarea id="address" name="address" required rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Masukkan alamat lengkap (Jalan, Nomor Rumah, Kelurahan/Desa)"></textarea>
                        </div>
                        
                        <!-- Jenis Layanan -->
                        <div class="md:col-span-2">
                            <label for="service_type" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan *</label>
                            <select id="service_type" name="service_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
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
                        <div class="md:col-span-2">
                            <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-2">Keperluan/Keterangan *</label>
                            <textarea id="purpose" name="purpose" required rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Jelaskan keperluan atau keterangan tambahan"></textarea>
                        </div>
                        
                        <!-- Upload Dokumen -->
                        <div class="md:col-span-2">
                            <label for="uploaded_files" class="block text-sm font-semibold text-gray-700 mb-2">Dokumen Pendukung</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200">
                                <input type="file" id="uploaded_files" name="uploaded_files[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                                       class="hidden" onchange="updateFileList(this)">
                                <label for="uploaded_files" class="cursor-pointer">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="text-gray-600">Klik untuk upload dokumen pendukung</p>
                                    <p class="text-sm text-gray-500 mt-2">PDF, JPG, JPEG, PNG (Max 5MB per file)</p>
                                </label>
                                <div id="fileList" class="mt-4 text-left hidden"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 text-center">
                        <button type="submit" class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white rounded-xl transition-all duration-300 hover:shadow-lg transform hover:scale-105" style="background-color: #001d3d;">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Permohonan
                        </button>
                    </div>
                    
                    <div class="mt-6 text-center text-sm text-gray-500">
                        <p>* Wajib diisi | Permohonan akan diproses dalam 1-3 hari kerja</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    @if($latestNews->count() > 0)
    <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-4xl md:text-5xl font-bold mb-6" style="color: #001d3d;">Berita Terbaru</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Informasi dan update terkini dari Kantor Camat untuk masyarakat</p>
                <div class="w-24 h-1 mx-auto mt-6 rounded-full" style="background-color: #001d3d;"></div>
            </div>
            
            <!-- Featured News (First News) -->
            @if($latestNews->first())
            <div class="mb-16 fade-in">
                <article class="news-card bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        <div class="relative">
                            @if($latestNews->first()->image)
                                <img src="{{ asset('storage/' . $latestNews->first()->image) }}" alt="{{ $latestNews->first()->title }}" class="w-full h-64 lg:h-full object-cover">
                            @else
                                <img src="{{ asset('images/news-1.svg') }}" alt="Pelayanan Publik" class="w-full h-64 lg:h-full object-cover">
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white bg-blue-50 relative z-10" style="background-color: #001d3d;">
                                    <i class="fas fa-star mr-1"></i> Berita Utama
                                </span>
                            </div>
                        </div>
                        <div class="p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-calendar-alt mr-2" style="color: #001d3d;"></i>
                                <span class="text-gray-500 font-medium">{{ $latestNews->first()->published_at->format('d F Y') }}</span>
                            </div>
                            <h3 class="text-2xl lg:text-3xl font-bold mb-4 leading-tight" style="color: #001d3d;">{{ $latestNews->first()->title }}</h3>
                            <p class="text-gray-600 text-lg mb-6 leading-relaxed">{{ Str::limit(strip_tags($latestNews->first()->content), 200) }}</p>
                            <a href="{{ route('news.show', $latestNews->first()->id) }}" class="inline-flex items-center px-6 py-3 rounded-lg font-semibold text-white transition-all duration-300 hover:shadow-lg transform hover:scale-105" style="background-color: #001d3d;">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @endif
            
            <!-- Other News Grid -->
            @if($latestNews->count() > 1)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16" data-stagger="150">
                @foreach($latestNews->skip(1) as $index => $news)
                <article class="news-card bg-white rounded-xl shadow-lg overflow-hidden card-hover stagger-item">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-56 object-cover">
                    @else
                        @if($loop->index == 0)
                            <img src="{{ asset('images/news-2.svg') }}" alt="Pemberdayaan Masyarakat" class="w-full h-56 object-cover">
                        @else
                            <img src="{{ asset('images/news-3.svg') }}" alt="Pembangunan Infrastruktur" class="w-full h-56 object-cover">
                        @endif
                    @endif
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                            <span class="text-sm text-gray-500">{{ $news->published_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 leading-tight hover:underline" style="color: #001d3d;">
                            <a href="{{ route('news.show', $news->id) }}">{{ $news->title }}</a>
                        </h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit(strip_tags($news->content), 150) }}</p>
                        <a href="{{ route('news.show', $news->id) }}" class="inline-flex items-center text-sm font-semibold hover:underline transition-colors duration-200" style="color: #001d3d;">
                            Baca Selengkapnya
                            <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
            
            <div class="text-center fade-in">
                <a href="{{ route('news.index') }}" class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white rounded-xl btn-ripple smooth-link" style="background-color: #001d3d;">
                    <i class="fas fa-newspaper mr-3"></i>
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Gallery Section -->
    @if($latestGallery->count() > 0)
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold mb-4" style="color: #001d3d;">Galeri Kegiatan</h2>
                <p class="text-gray-600">Dokumentasi kegiatan dan program Kantor Camat</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger="100">
                @if($latestGallery->count() > 0)
                    @foreach($latestGallery as $index => $gallery)
                    <div class="gallery-item group cursor-pointer stagger-item bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 text-base mb-2">{{ $gallery->title }}</h4>
                            <p class="text-sm text-gray-600">{{ Str::limit($gallery->description ?? 'Dokumentasi kegiatan', 80) }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Default Gallery Items with SVG Images -->
                    <div class="gallery-item group cursor-pointer stagger-item bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('images/gallery-1.svg') }}" alt="Rapat Koordinasi" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 text-base mb-2">Rapat Koordinasi</h4>
                            <p class="text-sm text-gray-600">Rapat koordinasi rutin dengan seluruh staff untuk membahas program kerja</p>
                        </div>
                    </div>
                    <div class="gallery-item group cursor-pointer stagger-item bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('images/gallery-2.svg') }}" alt="Sosialisasi Program" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 text-base mb-2">Sosialisasi Program</h4>
                            <p class="text-sm text-gray-600">Kegiatan sosialisasi program pemerintah kepada masyarakat kecamatan</p>
                        </div>
                    </div>
                    <div class="gallery-item group cursor-pointer stagger-item bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('images/gallery-3.svg') }}" alt="Pelayanan Masyarakat" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 text-base mb-2">Pelayanan Masyarakat</h4>
                            <p class="text-sm text-gray-600">Pelayanan administrasi kepada masyarakat di loket pelayanan</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="text-center mt-12 fade-in">
                <a href="{{ route('gallery.index') }}" class="btn-primary btn-ripple smooth-link">Lihat Semua Galeri</a>
            </div>
        </div>
    </section>
    @endif



@endsection
