<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - Kantor Camat Waesama</title>
    <meta name="description" content="Layanan publik Kantor Camat Waesama - Surat-menyurat, Antrian Online, dan berbagai layanan administrasi">

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

        .service-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .step-number {
            background: #003f88;
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
                        <a href="{{ route('public.layanan') }}" class="public-nav-item active"><i class="fas fa-cogs mr-2"></i>Layanan</a>
                        <a href="{{ route('public.kontak') }}" class="public-nav-item"><i class="fas fa-phone mr-2"></i>Kontak</a>
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
                    <a href="{{ route('public.layanan') }}" class="public-nav-item active"><i class="fas fa-cogs mr-2"></i>Layanan</a>
                    <a href="{{ route('public.kontak') }}" class="public-nav-item"><i class="fas fa-phone mr-2"></i>Kontak</a>

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
            <h1 class="text-4xl md:text-5xl font-bold mb-4 fade-in">Layanan Publik</h1>
            <p class="text-xl mb-8 opacity-90 fade-in">Berbagai layanan administrasi untuk kemudahan masyarakat</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                </div>
                <ul class="list-disc list-inside ml-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Featured Services -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Unggulan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Layanan prioritas yang paling sering digunakan oleh masyarakat</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Layanan Surat -->
                <div class="service-card bg-white rounded-xl p-8 text-center fade-in">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-alt text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Layanan Surat</h3>
                    <p class="text-gray-600 mb-6">Pengurusan berbagai jenis surat keterangan dan dokumen administrasi</p>
                    <a href="#layanan-surat" class="btn-primary text-white px-6 py-3 rounded-lg font-medium inline-block">
                        Lihat Detail
                    </a>
                </div>

                <!-- Antrian Online -->
                <div class="service-card bg-white rounded-xl p-8 text-center fade-in">
                    <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Antrian Online</h3>
                    <p class="text-gray-600 mb-6">Sistem antrian online untuk menghemat waktu dan menghindari kerumunan</p>
                    <a href="#antrian-online" class="btn-primary text-white px-6 py-3 rounded-lg font-medium inline-block">
                        Ambil Nomor
                    </a>
                </div>

                <!-- Pengaduan -->
                <div class="service-card bg-white rounded-xl p-8 text-center fade-in">
                    <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comments text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Pengaduan</h3>
                    <p class="text-gray-600 mb-6">Sampaikan keluhan, saran, atau laporan terkait pelayanan publik</p>
                    <a href="#pengaduan" class="btn-primary text-white px-6 py-3 rounded-lg font-medium inline-block">
                        Buat Pengaduan
                    </a>
                </div>
            </div>
        </section>

        <!-- Layanan Surat Detail -->
        <section id="layanan-surat" class="mb-16">
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <div class="flex items-center mb-8">
                    <div class="bg-blue-100 p-4 rounded-lg mr-6">
                        <i class="fas fa-file-alt text-blue-600 text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Layanan Surat-Menyurat</h2>
                        <p class="text-gray-600">Berbagai jenis surat keterangan dan dokumen administrasi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                        <h4 class="font-bold text-gray-800 mb-3">Surat Keterangan Domisili</h4>
                        <p class="text-gray-600 text-sm mb-4">Surat keterangan tempat tinggal untuk berbagai keperluan</p>
                        <div class="text-sm text-gray-500">
                            <p><i class="fas fa-clock mr-2"></i>Waktu: 1-2 hari kerja</p>
                            <p><i class="fas fa-money-bill mr-2"></i>Biaya: Gratis</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                        <h4 class="font-bold text-gray-800 mb-3">Surat Keterangan Usaha</h4>
                        <p class="text-gray-600 text-sm mb-4">Surat keterangan untuk keperluan usaha dan bisnis</p>
                        <div class="text-sm text-gray-500">
                            <p><i class="fas fa-clock mr-2"></i>Waktu: 1-2 hari kerja</p>
                            <p><i class="fas fa-money-bill mr-2"></i>Biaya: Gratis</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                        <h4 class="font-bold text-gray-800 mb-3">Surat Keterangan Tidak Mampu</h4>
                        <p class="text-gray-600 text-sm mb-4">Surat keterangan untuk bantuan sosial dan beasiswa</p>
                        <div class="text-sm text-gray-500">
                            <p><i class="fas fa-clock mr-2"></i>Waktu: 1-2 hari kerja</p>
                            <p><i class="fas fa-money-bill mr-2"></i>Biaya: Gratis</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                        <h4 class="font-bold text-gray-800 mb-3">Surat Pengantar KTP</h4>
                        <p class="text-gray-600 text-sm mb-4">Surat pengantar untuk pembuatan KTP baru atau perpanjangan</p>
                        <div class="text-sm text-gray-500">
                            <p><i class="fas fa-clock mr-2"></i>Waktu: 1 hari kerja</p>
                            <p><i class="fas fa-money-bill mr-2"></i>Biaya: Gratis</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                        <h4 class="font-bold text-gray-800 mb-3">Surat Pengantar Nikah</h4>
                        <p class="text-gray-600 text-sm mb-4">Surat pengantar untuk keperluan pernikahan</p>
                        <div class="text-sm text-gray-500">
                            <p><i class="fas fa-clock mr-2"></i>Waktu: 1-2 hari kerja</p>
                            <p><i class="fas fa-money-bill mr-2"></i>Biaya: Gratis</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                        <h4 class="font-bold text-gray-800 mb-3">Surat Keterangan Lainnya</h4>
                        <p class="text-gray-600 text-sm mb-4">Berbagai surat keterangan sesuai kebutuhan</p>
                        <div class="text-sm text-gray-500">
                            <p><i class="fas fa-clock mr-2"></i>Waktu: 1-3 hari kerja</p>
                            <p><i class="fas fa-money-bill mr-2"></i>Biaya: Gratis</p>
                        </div>
                    </div>
                </div>

                <!-- Persyaratan Umum -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Persyaratan Umum</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3">Dokumen yang Diperlukan:</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Fotocopy KTP yang masih berlaku</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Fotocopy Kartu Keluarga</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Surat pengantar dari RT/RW</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Dokumen pendukung sesuai jenis surat</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3">Ketentuan:</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-center"><i class="fas fa-info-circle text-blue-500 mr-2"></i>Pemohon harus WNI dan berdomisili di Kecamatan Waesama</li>
                                <li class="flex items-center"><i class="fas fa-info-circle text-blue-500 mr-2"></i>Dokumen asli dibawa untuk verifikasi</li>
                                <li class="flex items-center"><i class="fas fa-info-circle text-blue-500 mr-2"></i>Pengambilan surat sesuai jadwal yang ditentukan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Antrian Online -->
        <section id="antrian-online" class="mb-16">
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <div class="flex items-center mb-8">
                    <div class="bg-green-100 p-4 rounded-lg mr-6">
                        <i class="fas fa-clock text-green-600 text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Antrian Online</h2>
                        <p class="text-gray-600">Sistem antrian digital untuk pelayanan yang lebih efisien</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Cara Menggunakan Antrian Online</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="step-number text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Pilih Jenis Layanan</h4>
                                    <p class="text-gray-600 text-sm">Pilih jenis layanan yang ingin Anda gunakan dari daftar yang tersedia</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="step-number text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Isi Data Diri</h4>
                                    <p class="text-gray-600 text-sm">Lengkapi data diri dan informasi yang diperlukan dengan benar</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="step-number text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Dapatkan Nomor Antrian</h4>
                                    <p class="text-gray-600 text-sm">Sistem akan memberikan nomor antrian dan estimasi waktu pelayanan</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="step-number text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Datang Sesuai Jadwal</h4>
                                    <p class="text-gray-600 text-sm">Datang ke kantor sesuai waktu yang telah ditentukan dengan membawa dokumen</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Ambil Nomor Antrian</h3>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
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
                        
                        <form action="{{ route('public.service-request.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                                <select name="service_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">Pilih Jenis Layanan</option>
                                    <option value="surat_keterangan_domisili" {{ old('service_type') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                    <option value="surat_keterangan_tidak_mampu" {{ old('service_type') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                    <option value="surat_keterangan_usaha" {{ old('service_type') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                    <option value="surat_pengantar_nikah" {{ old('service_type') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                    <option value="surat_keterangan_kelahiran" {{ old('service_type') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                    <option value="surat_keterangan_kematian" {{ old('service_type') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                    <option value="surat_keterangan_belum_menikah" {{ old('service_type') == 'surat_keterangan_belum_menikah' ? 'selected' : '' }}>Surat Keterangan Belum Menikah</option>
                                    <option value="surat_keterangan_ahli_waris" {{ old('service_type') == 'surat_keterangan_ahli_waris' ? 'selected' : '' }}>Surat Keterangan Ahli Waris</option>
                                    <option value="surat_rekomendasi" {{ old('service_type') == 'surat_rekomendasi' ? 'selected' : '' }}>Surat Rekomendasi</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan NIK (16 digit)" maxlength="16" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nomor HP" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea name="address" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alamat lengkap" rows="3" required>{{ old('address') }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                                <textarea name="purpose" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jelaskan keperluan atau tujuan penggunaan surat" rows="3" required>{{ old('purpose') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                                <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full btn-primary text-white py-3 rounded-lg font-medium">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Ajukan Permohonan Surat
                            </button>
                        </form>

                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Informasi Antrian Hari Ini</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-blue-600">Nomor Sekarang:</p>
                                    <p class="font-bold text-blue-800">A-15</p>
                                </div>
                                <div>
                                    <p class="text-blue-600">Estimasi Tunggu:</p>
                                    <p class="font-bold text-blue-800">~30 menit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pengaduan -->
        <section id="pengaduan" class="mb-16">
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <div class="flex items-center mb-8">
                    <div class="bg-purple-100 p-4 rounded-lg mr-6">
                        <i class="fas fa-comments text-purple-600 text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Pengaduan Masyarakat</h2>
                        <p class="text-gray-600">Sampaikan keluhan, saran, atau laporan Anda</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Jenis Pengaduan</h3>
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Keluhan Pelayanan</h4>
                                <p class="text-gray-600 text-sm">Keluhan terkait kualitas pelayanan, sikap petugas, atau proses administrasi</p>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Saran Perbaikan</h4>
                                <p class="text-gray-600 text-sm">Saran untuk meningkatkan kualitas pelayanan dan fasilitas kantor</p>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Laporan Masalah</h4>
                                <p class="text-gray-600 text-sm">Laporan terkait masalah infrastruktur, keamanan, atau lingkungan</p>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Permintaan Informasi</h4>
                                <p class="text-gray-600 text-sm">Permintaan informasi terkait program, kebijakan, atau prosedur</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Form Pengaduan</h3>
                        <form action="{{ route('public.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pengaduan *</label>
                                <select name="jenis_pengaduan" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('jenis_pengaduan') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Pengaduan</option>
                                    <option value="keluhan" {{ old('jenis_pengaduan') == 'keluhan' ? 'selected' : '' }}>Keluhan Pelayanan</option>
                                    <option value="saran" {{ old('jenis_pengaduan') == 'saran' ? 'selected' : '' }}>Saran Perbaikan</option>
                                    <option value="laporan" {{ old('jenis_pengaduan') == 'laporan' ? 'selected' : '' }}>Laporan Masalah</option>
                                    <option value="informasi" {{ old('jenis_pengaduan') == 'informasi' ? 'selected' : '' }}>Permintaan Informasi</option>
                                </select>
                                @error('jenis_pengaduan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('nama_lengkap') border-red-500 @enderror" placeholder="Masukkan nama lengkap">
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('email') border-red-500 @enderror" placeholder="Masukkan email">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP *</label>
                                <input type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('nomor_hp') border-red-500 @enderror" placeholder="Masukkan nomor HP">
                                @error('nomor_hp')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subjek *</label>
                                <input type="text" name="subjek" value="{{ old('subjek') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('subjek') border-red-500 @enderror" placeholder="Masukkan subjek pengaduan">
                                @error('subjek')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Isi Pengaduan *</label>
                                <textarea name="isi_pengaduan" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('isi_pengaduan') border-red-500 @enderror" placeholder="Jelaskan pengaduan Anda secara detail">{{ old('isi_pengaduan') }}</textarea>
                                @error('isi_pengaduan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran (Opsional)</label>
                                <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('lampiran') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                                @error('lampiran')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-medium transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pengaduan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Jam Pelayanan -->
        <section class="mb-16">
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Jam Pelayanan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-100 p-6 rounded-lg mb-6">
                            <i class="fas fa-clock text-blue-600 text-4xl mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Hari Kerja</h3>
                            <p class="text-gray-600">Senin - Jumat</p>
                            <p class="text-2xl font-bold text-blue-600 mt-2">08:00 - 16:00</p>
                            <p class="text-sm text-gray-500">Istirahat: 12:00 - 13:00</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="bg-orange-100 p-6 rounded-lg mb-6">
                            <i class="fas fa-calendar-times text-orange-600 text-4xl mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Hari Libur</h3>
                            <p class="text-gray-600">Sabtu, Minggu & Hari Libur Nasional</p>
                            <p class="text-2xl font-bold text-orange-600 mt-2">TUTUP</p>
                            <p class="text-sm text-gray-500">Kecuali ada pelayanan khusus</p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-8">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-bold text-yellow-800 mb-2">Informasi Penting</h4>
                            <ul class="text-yellow-700 space-y-1 text-sm">
                                <li>• Pelayanan ditutup 30 menit sebelum jam tutup untuk penyelesaian administrasi</li>
                                <li>• Pada hari Jumat, pelayanan ditutup sementara pada jam 11:30-13:00 untuk sholat Jumat</li>
                                <li>• Pastikan membawa dokumen lengkap untuk menghindari penundaan pelayanan</li>
                                <li>• Untuk layanan tertentu, disarankan datang maksimal 2 jam sebelum tutup</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="text-center">
            <div class="text-white rounded-xl p-12 fade-in" style="background: #003f88;">
                <h2 class="text-3xl font-bold mb-4">Butuh Bantuan Lebih Lanjut?</h2>
                <p class="text-xl mb-8 opacity-90">Tim kami siap membantu Anda dengan pelayanan terbaik</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('public.kontak') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Kami
                    </a>
                    <a href="#antrian-online" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Ambil Antrian
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

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');

            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');

                // Toggle icon
                if (mobileMenu.classList.contains('hidden')) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                } else {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                }
            });
        });
    </script>
</body>
</html>