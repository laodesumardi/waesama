<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Kantor Camat Waesama</title>
    <meta name="description" content="Hubungi Kantor Camat Waesama - Alamat, telepon, email, dan informasi kontak lengkap">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background: #003f88;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .contact-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .contact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .text-gradient {
                color: #003f88;
            }

        .btn-primary {
            background: #003f88;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .map-container {
            height: 400px;
            background: #f3f4f6;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: #f3f4f6;
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }

        /* Standardized Public Navigation Menu */
        .public-nav-item {
            color: #666;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .public-nav-item:hover {
            color: #003f88;
            background: rgba(0, 63, 136, 0.1);
        }
        .public-nav-item.active {
            color: #003f88;
            font-weight: 600;
        }
        .public-nav-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .public-nav-btn.primary {
            background: #003f88;
            color: white;
        }
        .public-nav-btn.primary:hover {
            background: #002a5c;
        }
        .public-nav-btn.secondary {
            color: #003f88;
            border: 2px solid #003f88;
        }
        .public-nav-btn.secondary:hover {
            background: #003f88;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-building text-2xl text-blue-800"></i>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Kantor Camat Waesama</h1>
                        <p class="text-sm text-gray-600">Melayani dengan Sepenuh Hati</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <div class="flex space-x-2">
                        <a href="{{ route('welcome') }}" class="public-nav-item"><i class="fas fa-home mr-2"></i>Beranda</a>
                        <a href="{{ route('public.profil') }}" class="public-nav-item"><i class="fas fa-info-circle mr-2"></i>Profil</a>
                        <a href="{{ route('public.berita') }}" class="public-nav-item"><i class="fas fa-newspaper mr-2"></i>Berita</a>
                        <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs mr-2"></i>Layanan</a>
                        <a href="{{ route('public.kontak') }}" class="public-nav-item active"><i class="fas fa-phone mr-2"></i>Kontak</a>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex space-x-4 items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="public-nav-btn primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="public-nav-btn secondary">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="public-nav-btn primary">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-blue-800 focus:outline-none">
                        <i id="menu-icon" class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('welcome') }}" class="public-nav-item"><i class="fas fa-home mr-2"></i>Beranda</a>
                    <a href="{{ route('public.profil') }}" class="public-nav-item"><i class="fas fa-info-circle mr-2"></i>Profil</a>
                    <a href="{{ route('public.berita') }}" class="public-nav-item"><i class="fas fa-newspaper mr-2"></i>Berita</a>
                    <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs mr-2"></i>Layanan</a>
                    <a href="{{ route('public.kontak') }}" class="public-nav-item active"><i class="fas fa-phone mr-2"></i>Kontak</a>

                    @if (Route::has('login'))
                        <div class="flex flex-col space-y-2 pt-2 border-t border-gray-200">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="public-nav-btn primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="public-nav-btn secondary">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="public-nav-btn primary">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white py-16 pt-[150px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 fade-in">Hubungi Kami</h1>
            <p class="text-xl mb-8 opacity-90 fade-in">Kami siap melayani dan membantu kebutuhan administrasi Anda</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Contact Information -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Informasi Kontak</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Berikut adalah berbagai cara untuk menghubungi Kantor Camat Waesama</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Alamat -->
                <div class="contact-card bg-white rounded-xl p-6 text-center fade-in">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Alamat</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Jl. Raya Waesama No. 123<br>
                        Kecamatan Waesama<br>
                        Kabupaten Buru<br>
                        Provinsi Maluku<br>
                        97571
                    </p>
                </div>

                <!-- Telepon -->
                <div class="contact-card bg-white rounded-xl p-6 text-center fade-in">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Telepon</h3>
                    <div class="space-y-2 text-sm">
                        <p class="text-gray-600">
                            <span class="font-medium">Kantor:</span><br>
                            <a href="tel:+6291234567890" class="text-blue-600 hover:text-blue-800">(0912) 345-6789</a>
                        </p>
                        <p class="text-gray-600">
                            <span class="font-medium">WhatsApp:</span><br>
                            <a href="https://wa.me/6281234567890" class="text-green-600 hover:text-green-800">+62 812-3456-7890</a>
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="contact-card bg-white rounded-xl p-6 text-center fade-in">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Email</h3>
                    <div class="space-y-2 text-sm">
                        <p class="text-gray-600">
                            <span class="font-medium">Resmi:</span><br>
                            <a href="mailto:camat@waesama.go.id" class="text-blue-600 hover:text-blue-800">camat@waesama.go.id</a>
                        </p>
                        <p class="text-gray-600">
                            <span class="font-medium">Pengaduan:</span><br>
                            <a href="mailto:pengaduan@waesama.go.id" class="text-blue-600 hover:text-blue-800">pengaduan@waesama.go.id</a>
                        </p>
                    </div>
                </div>

                <!-- Jam Operasional -->
                <div class="contact-card bg-white rounded-xl p-6 text-center fade-in">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Jam Operasional</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>
                            <span class="font-medium">Senin - Jumat:</span><br>
                            08:00 - 16:00 WIT
                        </p>
                        <p>
                            <span class="font-medium">Istirahat:</span><br>
                            12:00 - 13:00 WIT
                        </p>
                        <p class="text-red-600 font-medium">
                            Sabtu & Minggu: TUTUP
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form & Map -->
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="fade-in">
                    <div class="bg-white rounded-xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('public.kontak.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_lengkap') border-red-500 @enderror" placeholder="Masukkan nama lengkap">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" placeholder="Masukkan email">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                                    <input type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_hp') border-red-500 @enderror" placeholder="Masukkan nomor HP">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                    <select name="kategori" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori') border-red-500 @enderror">
                                        <option value="">Pilih Kategori</option>
                                        <option value="informasi" {{ old('kategori') == 'informasi' ? 'selected' : '' }}>Permintaan Informasi</option>
                                        <option value="keluhan" {{ old('kategori') == 'keluhan' ? 'selected' : '' }}>Keluhan</option>
                                        <option value="saran" {{ old('kategori') == 'saran' ? 'selected' : '' }}>Saran</option>
                                        <option value="layanan" {{ old('kategori') == 'layanan' ? 'selected' : '' }}>Pertanyaan Layanan</option>
                                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subjek *</label>
                                <input type="text" name="subjek" value="{{ old('subjek') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subjek') border-red-500 @enderror" placeholder="Masukkan subjek pesan">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pesan *</label>
                                <textarea name="pesan" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('pesan') border-red-500 @enderror" placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" id="privacy" class="mt-1 mr-3">
                                <label for="privacy" class="text-sm text-gray-600">
                                    Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-800">kebijakan privasi</a> dan memberikan izin untuk memproses data pribadi saya.
                                </label>
                            </div>

                            <button type="submit" class="w-full btn-primary text-white py-3 rounded-lg font-medium">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Map & Location Info -->
                <div class="fade-in">
                    <div class="bg-white rounded-xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Lokasi Kantor</h2>

                        <!-- Google Maps Embed -->
                        <div class="map-container mb-6">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7!2d127.1!3d-3.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM8KwMzYnMDAuMCJTIDEyN8KwMDYnMDAuMCJF!5e0!3m2!1sid!2sid!4v1640995200000!5m2!1sid!2sid" 
                                width="100%" 
                                height="400" 
                                style="border:0; border-radius: 12px;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Peta Lokasi Kantor Camat Waesama">
                            </iframe>
                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 transition-all duration-300 rounded-xl flex items-center justify-center opacity-0 hover:opacity-100">
                                <div class="text-white text-center">
                                    <i class="fas fa-external-link-alt text-2xl mb-2"></i>
                                    <p class="font-medium">Klik untuk membuka di Google Maps</p>
                                </div>
                            </div>
                        </div>

                        <!-- Location Details -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-blue-600 text-lg mr-3 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Alamat Lengkap</h4>
                                    <p class="text-gray-600 text-sm">Jl. Raya Waesama No. 123, Kecamatan Waesama, Kabupaten Buru Selatan, Provinsi Maluku 97571</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-route text-green-600 text-lg mr-3 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Akses Transportasi</h4>
                                    <p class="text-gray-600 text-sm">Dapat diakses dengan kendaraan pribadi, angkutan umum, atau ojek. Tersedia area parkir yang luas.</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-landmark text-purple-600 text-lg mr-3 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Patokan</h4>
                                    <p class="text-gray-600 text-sm">Sebelah Kantor Pos Waesama, berseberangan dengan Pasar Tradisional Waesama.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6">
                            <a href="https://www.google.com/maps/place/Waesama,+Kabupaten+Buru+Selatan,+Maluku/@-3.6,127.1,15z" target="_blank" class="flex items-center justify-center bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors w-full">
                                <i class="fas fa-map mr-2"></i>
                                Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Contact -->
        <section class="mb-16">
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Kontak Cepat</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Emergency Contact -->
                    <div class="text-center p-6 border border-red-200 rounded-lg hover:border-red-400 transition-colors">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Darurat</h3>
                        <p class="text-gray-600 text-sm mb-4">Untuk keperluan mendesak dan darurat</p>
                        <a href="tel:+6291234567890" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors inline-block">
                            <i class="fas fa-phone mr-2"></i>
                            Hubungi Sekarang
                        </a>
                    </div>

                    <!-- WhatsApp -->
                    <div class="text-center p-6 border border-green-200 rounded-lg hover:border-green-400 transition-colors">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fab fa-whatsapp text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">WhatsApp</h3>
                        <p class="text-gray-600 text-sm mb-4">Chat langsung untuk pertanyaan cepat</p>
                        <a href="https://wa.me/6281234567890" target="_blank" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors inline-block">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Chat Sekarang
                        </a>
                    </div>

                    <!-- Email -->
                    <div class="text-center p-6 border border-blue-200 rounded-lg hover:border-blue-400 transition-colors">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Email</h3>
                        <p class="text-gray-600 text-sm mb-4">Untuk pertanyaan formal dan dokumen</p>
                        <a href="mailto:camat@waesama.go.id" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors inline-block">
                            <i class="fas fa-envelope mr-2"></i>
                            Kirim Email
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="mb-16">
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Pertanyaan yang Sering Diajukan</h2>

                <div class="space-y-6">
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Bagaimana cara mengurus surat keterangan domisili?</h3>
                        <p class="text-gray-600">Anda dapat mengurus surat keterangan domisili dengan membawa fotocopy KTP, KK, dan surat pengantar RT/RW. Proses pengurusan memakan waktu 1-2 hari kerja dan tidak dikenakan biaya.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Apakah bisa mengurus surat di luar jam kerja?</h3>
                        <p class="text-gray-600">Pelayanan hanya tersedia pada jam kerja (Senin-Jumat, 08:00-16:00 WIT). Untuk keperluan darurat, Anda dapat menghubungi nomor darurat yang tersedia.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Bagaimana cara menggunakan layanan antrian online?</h3>
                        <p class="text-gray-600">Anda dapat mengakses layanan antrian online melalui website ini. Pilih jenis layanan, isi data diri, dan dapatkan nomor antrian. Datang sesuai waktu yang telah ditentukan.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Apakah ada biaya untuk pengurusan surat?</h3>
                        <p class="text-gray-600">Semua layanan surat-menyurat di Kantor Camat Waesama tidak dikenakan biaya (gratis). Kami berkomitmen memberikan pelayanan terbaik tanpa pungutan biaya.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Bagaimana cara menyampaikan pengaduan?</h3>
                        <p class="text-gray-600">Anda dapat menyampaikan pengaduan melalui form online di website, email pengaduan@waesama.go.id, atau datang langsung ke kantor. Setiap pengaduan akan ditindaklanjuti maksimal 3x24 jam.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="text-center">
            <div class="text-white rounded-xl p-12 fade-in" style="background: #003f88;">
                <h2 class="text-3xl font-bold mb-4">Masih Ada Pertanyaan?</h2>
                <p class="text-xl mb-8 opacity-90">Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda 24/7</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/6281234567890" target="_blank" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Chat WhatsApp
                    </a>
                    <a href="tel:+6291234567890" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        <i class="fas fa-phone mr-2"></i>
                        Telepon Langsung
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='white'/%3E%3Ctext x='50' y='60' text-anchor='middle' fill='%23667eea' font-size='40' font-weight='bold'%3EW%3C/text%3E%3C/svg%3E" alt="Logo" class="h-12 w-12">
                        <div>
                            <h3 class="text-xl font-bold">Kantor Camat Waesama</h3>
                            <p class="text-gray-300">Melayani dengan Sepenuh Hati</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">Kantor Camat Waesama berkomitmen memberikan pelayanan terbaik kepada masyarakat dengan mengutamakan transparansi, akuntabilitas, dan profesionalisme.</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('public.profil') }}" class="text-gray-300 hover:text-white transition-colors">Profil</a></li>
                        <li><a href="{{ route('public.berita') }}" class="text-gray-300 hover:text-white transition-colors">Berita</a></li>
                        <li><a href="{{ route('public.layanan') }}" class="text-gray-300 hover:text-white transition-colors">Layanan</a></li>
                        <li><a href="{{ route('public.kontak') }}" class="text-gray-300 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Media Sosial</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; 2024 Kantor Camat Waesama. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    <!-- Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            
            // Map Click Handler
            const mapContainer = document.querySelector('.map-container');
            if (mapContainer) {
                mapContainer.addEventListener('click', function() {
                    window.open('https://www.google.com/maps/place/Waesama,+Kabupaten+Buru+Selatan,+Maluku/@-3.6,127.1,15z', '_blank');
                });
            }

            if (mobileMenuBtn && mobileMenu && menuIcon) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');

                    if (mobileMenu.classList.contains('hidden')) {
                        menuIcon.classList.remove('fa-times');
                        menuIcon.classList.add('fa-bars');
                    } else {
                        menuIcon.classList.remove('fa-bars');
                        menuIcon.classList.add('fa-times');
                    }
                });
            }
        });
    </script>
</body>
</html>