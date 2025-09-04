<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Profil Kantor - Kantor Camat Waesama</title>
        <meta name="description" content="Profil lengkap Kantor Camat Waesama - Visi, Misi, Struktur Organisasi, dan Sejarah">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #333; }
                .hero-bg {
                    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #475569 75%, #64748b 100%);
                    position: relative;
                    overflow: hidden;
                    min-height: 70vh;
                }

                .hero-bg::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.15"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.15"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.2"/><circle cx="10" cy="60" r="0.5" fill="%23ffffff" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
                    opacity: 0.6;
                }

                .hero-bg::after {
                    content: '';
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    height: 120px;
                    background: linear-gradient(to top, rgba(255,255,255,0.15), transparent);
                }
                .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
                .card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
                .btn-primary { background: #003f88; }
                .btn-primary:hover { background: #002a5c; }
                .news-card { border-left: 4px solid #667eea; }
                .service-icon { background: #003f88; }
                .animate-fade-in { animation: fadeIn 0.6s ease-in; }
                .fade-in {
                    opacity: 0;
                    transform: translateY(40px);
                    animation: fadeInUp 1s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                }
                @keyframes fadeInUp {
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .slide-in-left {
                    opacity: 0;
                    transform: translateX(-50px);
                    animation: slideInLeft 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                }
                @keyframes slideInLeft {
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }

                .slide-in-right {
                    opacity: 0;
                    transform: translateX(50px);
                    animation: slideInRight 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                }
                @keyframes slideInRight {
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }

                .card-hover {
                    transition: all 0.3s ease;
                }

                .card-hover:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }

                .stats-card {
                    background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
                    border: 1px solid #e2e8f0;
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                }

                .stats-card:hover {
                    background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
                    color: white;
                    transform: translateY(-8px) scale(1.02);
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                }
                .text-gradient { color: #003f88; }

                /* Enhanced hover effects */
                .service-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }

                .news-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                }

                .btn-primary {
                    transition: all 0.3s ease;
                }

                .btn-primary:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 10px 20px rgba(0, 63, 136, 0.4);
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

                .timeline-item {
                    position: relative;
                    padding-left: 2rem;
                }

                .timeline-item::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0.5rem;
                    width: 0.75rem;
                    height: 0.75rem;
                    background: #667eea;
                    border-radius: 50%;
                }

                .timeline-item::after {
                    content: '';
                    position: absolute;
                    left: 0.375rem;
                    top: 1.25rem;
                    width: 2px;
                    height: calc(100% - 1.25rem);
                    background: #e5e7eb;
                }

                .timeline-item:last-child::after {
                    display: none;
                }
            </style>
        @endif
    </head>
    <body>
      <!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-lg border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Navigation Container -->
        <div class="flex justify-between items-center h-16 lg:h-20">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3 flex-shrink-0">
                <div class="bg-blue-800 p-2 rounded-lg">
                    <i class="fas fa-building text-xl text-white"></i>
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-gray-900 leading-tight">Kantor Camat Waesama</h1>
                    <p class="text-sm text-gray-600">Melayani dengan Sepenuh Hati</p>
                </div>
                <div class="sm:hidden">
                    <h1 class="text-base font-bold text-gray-900">Camat Waesama</h1>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <!-- Navigation Links -->
                <div class="flex items-center space-x-1">
                    <a href="{{ route('welcome') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-home text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('public.profil') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-blue-800 bg-blue-50 rounded-lg ">
                        <i class="fas fa-info-circle text-base mr-2"></i>
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('public.berita') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-newspaper text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Berita</span>
                    </a>

                    <a href="{{ route('public.layanan') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-cogs text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Layanan</span>
                    </a>

                    <a href="{{ route('public.kontak') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-phone text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Kontak</span>
                    </a>
                </div>

                <!-- Authentication Section -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-3 pl-6 border-l border-gray-200">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-4 py-2 border border-blue-800 text-blue-800 text-sm font-medium rounded-lg hover:bg-blue-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button id="mobile-menu-btn"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-blue-800 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="Toggle navigation menu">
                    <i id="menu-icon" class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-100 bg-white" role="navigation" aria-hidden="true">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Mobile Navigation Links -->
                <a href="{{ route('welcome') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-home text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('public.profil') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-blue-800 bg-blue-50 rounded-lg">
                    <i class="fas fa-info-circle text-lg mr-3"></i>
                    <span>Profil</span>
                </a>

                <a href="{{ route('public.berita') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-newspaper text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Berita</span>
                </a>

                <a href="{{ route('public.layanan') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-cogs text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Layanan</span>
                </a>

                <a href="{{ route('public.kontak') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-phone text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Kontak</span>
                </a>

                <!-- Mobile Authentication Section -->
                @if (Route::has('login'))
                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="flex items-center px-3 py-2 text-base font-medium text-white bg-blue-800 rounded-lg hover:bg-blue-900 transition-all duration-200">
                                <i class="fas fa-tachometer-alt text-lg mr-3"></i>
                                <span>Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="flex items-center px-3 py-2 text-base font-medium text-blue-800 border border-blue-800 rounded-lg hover:bg-blue-800 hover:text-white transition-all duration-200">
                                <i class="fas fa-sign-in-alt text-lg mr-3"></i>
                                <span>Masuk</span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="flex items-center px-3 py-2 text-base font-medium text-white bg-blue-800 rounded-lg hover:bg-blue-900 transition-all duration-200">
                                    <i class="fas fa-user-plus text-lg mr-3"></i>
                                    <span>Daftar</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

  <!-- Hero Section -->
<section class="hero-bg relative overflow-hidden text-white py-24 pt-[140px] bg-[#00468B]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="fade-in">
            <!-- Tagline -->
            <div class="inline-block bg-white/10 backdrop-blur-sm rounded-full px-6 py-2 mb-8 shadow-lg">
                <span class="text-sm font-medium text-white/90 tracking-wide">🏛️ Pemerintahan Kecamatan</span>
            </div>

            <!-- Title -->
            <h1 class="text-5xl md:text-7xl font-extrabold mb-8 leading-tight">
                Profil <span class="text-yellow-300">Kantor Camat</span>
            </h1>

            <!-- Description -->
            <p class="text-lg md:text-2xl mb-12 opacity-95 max-w-3xl mx-auto leading-relaxed font-light">
                Mengenal lebih dekat <span class="font-semibold text-yellow-300">Kantor Camat Waesama</span> dan komitmen kami dalam melayani masyarakat dengan sepenuh hati.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 shadow-md">
                    <div class="text-4xl font-bold text-yellow-300 mb-2">2008</div>
                    <div class="text-sm opacity-90 font-medium">Tahun Berdiri</div>
                    <div class="text-xs opacity-70 mt-1">Melayani sejak 16 tahun</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 shadow-md">
                    <div class="text-4xl font-bold text-yellow-300 mb-2">25K+</div>
                    <div class="text-sm opacity-90 font-medium">Penduduk</div>
                    <div class="text-xs opacity-70 mt-1">Warga yang dilayani</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300 shadow-md">
                    <div class="text-4xl font-bold text-yellow-300 mb-2">24/7</div>
                    <div class="text-sm opacity-90 font-medium">Pelayanan</div>
                    <div class="text-xs opacity-70 mt-1">Siap melayani kapan saja</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse blur-xl"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-white/10 rounded-full animate-pulse blur-2xl" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/10 rounded-full animate-pulse blur-lg" style="animation-delay: 2s;"></div>
</section>



    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Overview -->
        <section class="mb-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="slide-in-left">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent inline-block mb-4">
                        <h2 class="text-4xl font-bold">Tentang Kami</h2>
                    </div>
                    <div class="w-20 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-8"></div>
                    <p class="text-gray-700 mb-6 leading-relaxed text-lg">
                        Kantor Camat Waesama merupakan instansi pemerintahan tingkat kecamatan yang bertugas melaksanakan sebagian urusan otonomi daerah yang dilimpahkan oleh Bupati untuk menangani urusan pemerintahan di wilayah kecamatan.
                    </p>
                    <p class="text-gray-700 mb-8 leading-relaxed text-lg">
                        Kami berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat dengan mengutamakan prinsip transparansi, akuntabilitas, dan profesionalisme dalam setiap aspek pelayanan publik.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="stats-card text-center p-6 rounded-2xl">
                            <div class="text-4xl font-bold text-blue-600 mb-3">15+</div>
                            <div class="text-gray-600 text-sm font-semibold">Tahun Melayani</div>
                            <div class="text-xs text-gray-500 mt-1">Pengalaman terpercaya</div>
                        </div>
                        <div class="stats-card text-center p-6 rounded-2xl">
                            <div class="text-4xl font-bold text-blue-600 mb-3">25K+</div>
                            <div class="text-gray-600 text-sm font-semibold">Penduduk Dilayani</div>
                            <div class="text-xs text-gray-500 mt-1">Masyarakat terlayani</div>
                        </div>
                    </div>
                </div>

                <div class="slide-in-right">
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                        <div class="relative bg-white rounded-2xl p-8 shadow-2xl">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3Cdefs%3E%3ClinearGradient id='bg' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%23667eea;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%23764ba2;stop-opacity:1' /%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='400' height='300' fill='url(%23bg)'/%3E%3Crect x='40' y='40' width='320' height='220' fill='white' rx='15' opacity='0.1'/%3E%3Ctext x='200' y='140' text-anchor='middle' fill='white' font-size='28' font-weight='bold'%3EKantor Camat%3C/text%3E%3Ctext x='200' y='170' text-anchor='middle' fill='white' font-size='20' opacity='0.9'%3EWaesama%3C/text%3E%3Ctext x='200' y='200' text-anchor='middle' fill='white' font-size='14' opacity='0.7'%3EMelayani dengan Sepenuh Hati%3C/text%3E%3C/svg%3E" alt="Kantor Camat Waesama" class="w-full rounded-xl">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Visi Misi -->
        <section class="mb-20">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">Visi & Misi</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-3xl mx-auto">Komitmen kami dalam membangun masa depan yang lebih baik untuk Kecamatan Waesama</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Visi -->
                <div class="relative group slide-in-left">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-white rounded-2xl p-10 shadow-xl border border-gray-100">
                        <div class="text-center mb-8">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-5 rounded-2xl inline-block mb-6 shadow-lg">
                                <i class="fas fa-eye text-white text-4xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-800 mb-4">Visi</h3>
                            <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full mx-auto"></div>
                        </div>
                        <blockquote class="text-gray-700 text-center leading-relaxed text-lg italic font-medium">
                            "Terwujudnya Kecamatan Waesama yang Maju, Sejahtera, dan Berkeadilan melalui Pelayanan Prima dan Pembangunan Berkelanjutan"
                        </blockquote>
                    </div>
                </div>

                <!-- Misi -->
                <div class="relative group slide-in-right">
                    <div class="absolute -inset-1 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-white rounded-2xl p-10 shadow-xl border border-gray-100">
                        <div class="text-center mb-8">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-5 rounded-2xl inline-block mb-6 shadow-lg">
                                <i class="fas fa-bullseye text-white text-4xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-800 mb-4">Misi</h3>
                            <div class="w-16 h-1 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full mx-auto"></div>
                        </div>
                        <ul class="text-gray-700 space-y-4">
                            <li class="flex items-start group/item">
                                <div class="bg-green-100 p-2 rounded-full mr-4 mt-1 group-hover/item:bg-green-200 transition-colors">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <span class="leading-relaxed">Meningkatkan kualitas pelayanan publik yang profesional dan transparan</span>
                            </li>
                            <li class="flex items-start group/item">
                                <div class="bg-green-100 p-2 rounded-full mr-4 mt-1 group-hover/item:bg-green-200 transition-colors">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <span class="leading-relaxed">Mendorong pembangunan infrastruktur yang berkelanjutan</span>
                            </li>
                            <li class="flex items-start group/item">
                                <div class="bg-green-100 p-2 rounded-full mr-4 mt-1 group-hover/item:bg-green-200 transition-colors">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <span class="leading-relaxed">Memberdayakan masyarakat dalam pembangunan daerah</span>
                            </li>
                            <li class="flex items-start group/item">
                                <div class="bg-green-100 p-2 rounded-full mr-4 mt-1 group-hover/item:bg-green-200 transition-colors">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <span class="leading-relaxed">Menjaga keamanan dan ketertiban masyarakat</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Struktur Organisasi -->
        <section class="mb-16">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Struktur Organisasi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Struktur organisasi Kantor Camat Waesama yang terdiri dari berbagai bidang untuk melayani masyarakat</p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-lg fade-in">
                <!-- Camat -->
                <div class="text-center mb-12">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white p-8 rounded-2xl inline-block mb-6 shadow-xl card-hover">
                        <i class="fas fa-user-tie text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Camat Waesama</h3>
                    <div class="bg-blue-50 p-4 rounded-xl inline-block border border-blue-100">
                        <p class="text-lg font-semibold text-blue-800 mb-1">Drs. Ahmad Suryanto, M.AP</p>
                        <p class="text-sm text-blue-600 font-medium">Kepala Kecamatan</p>
                    </div>
                </div>

                <!-- Bidang-bidang -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-purple-50 p-6 rounded-xl text-center card-hover border border-purple-100 shadow-sm">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white p-4 rounded-xl inline-block mb-4 shadow-lg">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-3 text-lg">Bidang Pemerintahan</h4>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">Menangani urusan administrasi kependudukan dan pemerintahan</p>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <p class="text-sm font-semibold text-purple-700">Kepala Bidang</p>
                            <p class="text-sm text-purple-600">Budi Santoso, S.AP</p>
                        </div>
                    </div>

                    <div class="bg-orange-50 p-6 rounded-xl text-center card-hover border border-orange-100 shadow-sm">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-700 text-white p-4 rounded-xl inline-block mb-4 shadow-lg">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-3 text-lg">Bidang Pembangunan</h4>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">Menangani perencanaan dan pelaksanaan pembangunan</p>
                        <div class="bg-orange-100 p-3 rounded-lg">
                            <p class="text-sm font-semibold text-orange-700">Kepala Bidang</p>
                            <p class="text-sm text-orange-600">Ir. Dewi Sartika</p>
                        </div>
                    </div>

                    <div class="bg-teal-50 p-6 rounded-xl text-center card-hover border border-teal-100 shadow-sm">
                        <div class="bg-gradient-to-br from-teal-500 to-teal-700 text-white p-4 rounded-xl inline-block mb-4 shadow-lg">
                            <i class="fas fa-handshake text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-3 text-lg">Bidang Kesejahteraan</h4>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">Menangani program kesejahteraan dan pemberdayaan masyarakat</p>
                        <div class="bg-teal-100 p-3 rounded-lg">
                            <p class="text-sm font-semibold text-teal-700">Kepala Bidang</p>
                            <p class="text-sm text-teal-600">Siti Nurhaliza, S.Sos</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sejarah -->
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="fade-in">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Sejarah Singkat</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kecamatan Waesama dibentuk pada tahun 2008 sebagai hasil pemekaran dari Kecamatan induk. Pembentukan kecamatan ini bertujuan untuk mendekatkan pelayanan pemerintahan kepada masyarakat dan mempercepat pembangunan di wilayah tersebut.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Sejak berdiri, Kantor Camat Waesama terus berkomitmen untuk memberikan pelayanan terbaik dan mendorong pembangunan yang berkelanjutan di wilayah kecamatan.
                    </p>
                </div>

                <div class="fade-in">
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">Timeline Perkembangan</h3>
                        <div class="space-y-8">
                            <div class="timeline-item bg-blue-50 p-6 rounded-lg border-l-4 border-blue-500 card-hover">
                                <div class="flex items-center mb-3">
                                    <div class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold mr-4">2008</div>
                                    <i class="fas fa-flag text-blue-500 text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2 text-lg">Pembentukan Kecamatan</h4>
                                <p class="text-gray-600">Pembentukan Kecamatan Waesama melalui pemekaran untuk mendekatkan pelayanan kepada masyarakat</p>
                            </div>
                            <div class="timeline-item bg-green-50 p-6 rounded-lg border-l-4 border-green-500 card-hover">
                                <div class="flex items-center mb-3">
                                    <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold mr-4">2010</div>
                                    <i class="fas fa-building text-green-500 text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2 text-lg">Pembangunan Gedung</h4>
                                <p class="text-gray-600">Pembangunan gedung kantor camat yang representatif dan modern</p>
                            </div>
                            <div class="timeline-item bg-purple-50 p-6 rounded-lg border-l-4 border-purple-500 card-hover">
                                <div class="flex items-center mb-3">
                                    <div class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-bold mr-4">2015</div>
                                    <i class="fas fa-laptop text-purple-500 text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2 text-lg">Sistem Online</h4>
                                <p class="text-gray-600">Implementasi sistem pelayanan online pertama untuk kemudahan masyarakat</p>
                            </div>
                            <div class="timeline-item bg-orange-50 p-6 rounded-lg border-l-4 border-orange-500 card-hover">
                                <div class="flex items-center mb-3">
                                    <div class="bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold mr-4">2020</div>
                                    <i class="fas fa-digital-tachograph text-orange-500 text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2 text-lg">Era Digital</h4>
                                <p class="text-gray-600">Digitalisasi penuh layanan administrasi kependudukan dan pelayanan publik</p>
                            </div>
                            <div class="timeline-item bg-teal-50 p-6 rounded-lg border-l-4 border-teal-500 card-hover">
                                <div class="flex items-center mb-3">
                                    <div class="bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-bold mr-4">2024</div>
                                    <i class="fas fa-globe text-teal-500 text-lg"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2 text-lg">Sistem Terintegrasi</h4>
                                <p class="text-gray-600">Peluncuran website resmi dan sistem terintegrasi untuk pelayanan yang lebih optimal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-br from-gray-800 to-gray-900 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <!-- Logo & Description -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-600 p-3 rounded-xl mr-4">
                                <i class="fas fa-building text-2xl text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-1">Kantor Camat Waesama</h3>
                                <p class="text-blue-200 text-sm">Melayani dengan Sepenuh Hati</p>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-6 leading-relaxed max-w-md">
                            Kantor Camat Waesama berkomitmen memberikan pelayanan terbaik kepada masyarakat dengan mengutamakan transparansi, akuntabilitas, dan profesionalisme.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-gray-700 hover:bg-blue-600 p-3 rounded-lg transition-all duration-300 group">
                                <i class="fab fa-facebook-f text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                            <a href="#" class="bg-gray-700 hover:bg-blue-600 p-3 rounded-lg transition-all duration-300 group">
                                <i class="fab fa-twitter text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                            <a href="#" class="bg-gray-700 hover:bg-blue-600 p-3 rounded-lg transition-all duration-300 group">
                                <i class="fab fa-instagram text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                            <a href="#" class="bg-gray-700 hover:bg-blue-600 p-3 rounded-lg transition-all duration-300 group">
                                <i class="fab fa-youtube text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6 text-blue-200">Tautan Cepat</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('welcome') }}" class="text-gray-300 hover:text-blue-200 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Beranda
                            </a></li>
                            <li><a href="{{ route('public.profil') }}" class="text-gray-300 hover:text-blue-200 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Profil
                            </a></li>
                            <li><a href="{{ route('public.berita') }}" class="text-gray-300 hover:text-blue-200 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Berita
                            </a></li>
                            <li><a href="{{ route('public.layanan') }}" class="text-gray-300 hover:text-blue-200 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Layanan
                            </a></li>
                            <li><a href="{{ route('public.kontak') }}" class="text-gray-300 hover:text-blue-200 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Kontak
                            </a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-lg font-semibold mb-6 text-blue-200">Informasi Kontak</h4>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-blue-600 p-2 rounded-lg mr-3 mt-1">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-gray-300 text-sm leading-relaxed">Jl. Raya Waesama No. 123<br>Kecamatan Waesama</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-600 p-2 rounded-lg mr-3">
                                    <i class="fas fa-phone text-sm"></i>
                                </div>
                                <p class="text-gray-300 text-sm">(021) 123-4567</p>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-blue-600 p-2 rounded-lg mr-3">
                                    <i class="fas fa-envelope text-sm"></i>
                                </div>
                                <p class="text-gray-300 text-sm">info@waesama.go.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-gray-700 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm mb-4 md:mb-0">
                            &copy; 2024 Kantor Camat Waesama. Semua hak dilindungi.
                        </p>
                        <div class="flex items-center space-x-6 text-sm text-gray-400">
                            <a href="#" class="hover:text-blue-200 transition-colors">Kebijakan Privasi</a>
                            <a href="#" class="hover:text-blue-200 transition-colors">Syarat & Ketentuan</a>
                            <a href="#" class="hover:text-blue-200 transition-colors">Sitemap</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script>
           // Mobile Menu Toggle - Clean and Optimized Version
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    // Early return if required elements don't exist
    if (!mobileMenuBtn || !mobileMenu || !menuIcon) {
        console.warn('Mobile menu elements not found');
        return;
    }

    // Menu state management
    const MenuState = {
        isOpen: false,

        open() {
            this.isOpen = true;
            mobileMenu.classList.remove('hidden');
            menuIcon.className = 'fas fa-times text-xl';
            mobileMenuBtn.setAttribute('aria-expanded', 'true');

            // Smooth slide-in animation
            this.animateIn();
        },

        close() {
            this.isOpen = false;

            // Smooth slide-out animation
            this.animateOut(() => {
                mobileMenu.classList.add('hidden');
                menuIcon.className = 'fas fa-bars text-xl';
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            });
        },

        toggle() {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },

        animateIn() {
            mobileMenu.style.opacity = '0';
            mobileMenu.style.transform = 'translateY(-10px)';

            requestAnimationFrame(() => {
                mobileMenu.style.transition = 'opacity 0.2s ease-out, transform 0.2s ease-out';
                mobileMenu.style.opacity = '1';
                mobileMenu.style.transform = 'translateY(0)';
            });
        },

        animateOut(callback) {
            mobileMenu.style.transition = 'opacity 0.2s ease-in, transform 0.2s ease-in';
            mobileMenu.style.opacity = '0';
            mobileMenu.style.transform = 'translateY(-10px)';

            setTimeout(callback, 200);
        }
    };

    // Event Handlers
    const EventHandlers = {
        // Mobile menu button click handler
        handleMenuButtonClick(event) {
            event.preventDefault();
            event.stopPropagation();
            MenuState.toggle();
        },

        // Click outside to close menu
        handleDocumentClick(event) {
            if (MenuState.isOpen &&
                !mobileMenuBtn.contains(event.target) &&
                !mobileMenu.contains(event.target)) {
                MenuState.close();
            }
        },

        // Handle escape key to close menu
        handleKeyDown(event) {
            if (event.key === 'Escape' && MenuState.isOpen) {
                MenuState.close();
                mobileMenuBtn.focus(); // Return focus to button for accessibility
            }
        },

        // Handle window resize (close menu when switching to desktop)
        handleWindowResize() {
            if (window.innerWidth >= 1024 && MenuState.isOpen) {
                MenuState.close();
            }
        },

        // Handle focus trap within mobile menu
        handleFocusTrap(event) {
            if (!MenuState.isOpen) return;

            const focusableElements = mobileMenu.querySelectorAll(
                'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled])'
            );

            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            if (event.key === 'Tab') {
                if (event.shiftKey) {
                    // Shift + Tab
                    if (document.activeElement === firstFocusable) {
                        event.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    // Tab
                    if (document.activeElement === lastFocusable) {
                        event.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        }
    };

    // Initialize event listeners
    function initializeEventListeners() {
        // Mobile menu button click
        mobileMenuBtn.addEventListener('click', EventHandlers.handleMenuButtonClick);

        // Click outside to close
        document.addEventListener('click', EventHandlers.handleDocumentClick);

        // Keyboard navigation
        document.addEventListener('keydown', EventHandlers.handleKeyDown);
        document.addEventListener('keydown', EventHandlers.handleFocusTrap);

        // Window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(EventHandlers.handleWindowResize, 100);
        });

        // Prevent menu links from bubbling up to document click handler
        mobileMenu.addEventListener('click', (event) => {
            if (event.target.tagName === 'A') {
                // Close menu when clicking on a link (optional)
                setTimeout(() => MenuState.close(), 150);
            }
        });
    }

    // Initialize accessibility attributes
    function initializeAccessibility() {
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenuBtn.setAttribute('aria-controls', 'mobile-menu');
        mobileMenuBtn.setAttribute('aria-label', 'Toggle navigation menu');

        mobileMenu.setAttribute('aria-hidden', 'true');
        mobileMenu.setAttribute('role', 'navigation');
    }

    // Update accessibility attributes when menu state changes
    function updateAccessibility() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    mobileMenu.setAttribute('aria-hidden', isHidden.toString());
                }
            });
        });

        observer.observe(mobileMenu, {
            attributes: true,
            attributeFilter: ['class']
        });
    }

    // Initialize everything
    function init() {
        try {
            initializeAccessibility();
            initializeEventListeners();
            updateAccessibility();

            console.log('Mobile menu initialized successfully');
        } catch (error) {
            console.error('Error initializing mobile menu:', error);
        }
    }

    // Start the application
    init();

    // Expose MenuState for debugging (optional - remove in production)
    if (typeof window !== 'undefined' && window.location.hostname === 'localhost') {
        window.MobileMenu = MenuState;
    }
});
</script>
        </script>
    </body>
</html>
