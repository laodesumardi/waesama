<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita - Kantor Camat Waesama</title>
    <meta name="description" content="Berita terbaru dari Kantor Camat Waesama - Melayani dengan sepenuh hati untuk kemajuan masyarakat">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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

        .news-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .news-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #d1d5db;
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

        .pagination-btn {
            transition: all 0.3s ease;
        }

        .pagination-btn:hover {
            background: #003f88;
            color: white;
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
                        <a href="{{ route('public.berita') }}" class="public-nav-item active"><i class="fas fa-newspaper mr-2"></i>Berita</a>
                        <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs mr-2"></i>Layanan</a>
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
                    <a href="{{ route('public.berita') }}" class="public-nav-item active"><i class="fas fa-newspaper mr-2"></i>Berita</a>
                    <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs mr-2"></i>Layanan</a>
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4 fade-in">Berita & Pengumuman</h1>
            <p class="text-xl mb-8 opacity-90 fade-in">Informasi terbaru dari Kantor Camat Waesama</p>

            <!-- Search Bar -->
            <div class="max-w-md mx-auto fade-in">
                <form method="GET" action="{{ route('public.berita') }}" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full px-4 py-3 pl-12 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-4 py-1 rounded-md hover:bg-blue-700 transition-colors">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- News List -->
            <div class="lg:col-span-3">
                @if($berita->count() > 0)
                    <div id="news-container" class="grid gap-6">
                        @include('public.partials.berita-grid', ['berita' => $berita])
                    </div>

                    <!-- Pagination -->
                    @if($berita->hasPages())
                        <div class="mt-8 flex justify-center">
                            <nav class="flex items-center space-x-2">
                                {{-- Previous Page Link --}}
                                @if ($berita->onFirstPage())
                                    <span class="pagination-btn px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $berita->previousPageUrl() }}" class="pagination-btn px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($berita->getUrlRange(1, $berita->lastPage()) as $page => $url)
                                    @if ($page == $berita->currentPage())
                                        <span class="px-4 py-2 text-white bg-blue-600 rounded-lg font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="pagination-btn px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($berita->hasMorePages())
                                    <a href="{{ $berita->nextPageUrl() }}" class="pagination-btn px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-600 hover:text-white">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="pagination-btn px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Berita</h3>
                        <p class="text-gray-500">Berita akan ditampilkan di sini ketika sudah tersedia.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Featured News -->
                @if($featuredNews->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            Berita Unggulan
                        </h3>
                        <div class="space-y-4">
                            @foreach($featuredNews as $featured)
                                <article class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                    @if($featured->gambar)
                                        <img src="{{ asset('storage/' . $featured->gambar) }}" alt="{{ $featured->judul }}" class="w-full h-32 object-cover rounded-lg mb-3">
                                    @endif
                                    <h4 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('public.berita.detail', $featured->slug) }}">{{ Str::limit($featured->judul, 60) }}</a>
                                    </h4>
                                    <div class="flex items-center text-xs text-gray-500 space-x-3">
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $featured->published_at ? $featured->published_at->format('d M Y') : $featured->created_at->format('d M Y') }}
                                        </span>
                                        <span>
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ number_format($featured->views) }}
                                        </span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-link text-blue-500 mr-2"></i>
                        Tautan Cepat
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('public.layanan') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-file-alt w-5 mr-3"></i>
                            Layanan Surat
                        </a>
                        <a href="{{ route('public.layanan') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-clock w-5 mr-3"></i>
                            Antrian Online
                        </a>
                        <a href="{{ route('public.kontak') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-comments w-5 mr-3"></i>
                            Pengaduan
                        </a>
                        <a href="{{ route('public.profil') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-info-circle w-5 mr-3"></i>
                            Profil Kantor
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-phone text-green-500 mr-2"></i>
                        Kontak
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Alamat</p>
                                <p class="text-gray-600">Jl. Raya Waesama No. 123<br>Kec. Waesama, Kab. Buru</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-blue-500"></i>
                            <div>
                                <p class="font-medium text-gray-800">Telepon</p>
                                <p class="text-gray-600">(0914) 123-456</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-purple-500"></i>
                            <div>
                                <p class="font-medium text-gray-800">Email</p>
                                <p class="text-gray-600">info@waesama.go.id</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23667eea'/%3E%3Ctext x='50' y='60' text-anchor='middle' fill='white' font-size='40' font-weight='bold'%3EW%3C/text%3E%3C/svg%3E" alt="Logo" class="h-12 w-12">
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

            // AJAX Search functionality
            const searchForm = document.querySelector('form[action*="berita"]');
            const searchInput = searchForm.querySelector('input[name="search"]');
            const newsContainer = document.getElementById('news-container');
            let searchTimeout;

            // Real-time search with debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch(this.value);
                }, 500);
            });

            // Form submission
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                performSearch(searchInput.value);
            });

            function performSearch(query) {
                // Show loading state
                newsContainer.innerHTML = '<div class="text-center py-12"><i class="fas fa-spinner fa-spin text-4xl text-gray-400 mb-4"></i><p class="text-gray-500">Mencari berita...</p></div>';

                // Perform AJAX request
                fetch(`{{ route('public.berita') }}?search=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    newsContainer.innerHTML = data.html;
                    
                    // Update pagination if exists
                    const paginationContainer = document.querySelector('.mt-8.flex.justify-center');
                    if (paginationContainer && data.pagination) {
                        paginationContainer.innerHTML = data.pagination;
                    } else if (paginationContainer && !data.pagination) {
                        paginationContainer.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    newsContainer.innerHTML = '<div class="text-center py-12"><i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i><p class="text-red-500">Terjadi kesalahan saat mencari berita.</p></div>';
                });
            }
        });
    </script>
</body>
</html>
