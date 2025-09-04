<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - Kantor Camat Waesama</title>
    <meta name="description" content="{{ $berita->excerpt ?: Str::limit(strip_tags($berita->konten), 150) }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ $berita->excerpt ?: Str::limit(strip_tags($berita->konten), 150) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($berita->gambar)
        <meta property="og:image" content="{{ asset('storage/' . $berita->gambar) }}">
    @endif
    
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
            .hero-bg { background: #003f88; }
            .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
            .card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
            .btn-primary { background: #003f88; }
            .btn-primary:hover { background: #002a5c; }
            .news-card { border-left: 4px solid #667eea; }
            .service-icon { background: #003f88; }
            .animate-fade-in { animation: fadeIn 0.6s ease-in; }
            .fade-in { animation: fadeIn 0.6s ease-in; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
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
            
            .prose {
                max-width: none;
            }
            
            .prose p {
                margin-bottom: 1rem;
                line-height: 1.7;
            }
            
            .share-btn {
                transition: all 0.3s ease;
            }
            
            .share-btn:hover {
                transform: translateY(-2px);
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
                           class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                            <i class="fas fa-info-circle text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            <span>Profil</span>
                        </a>

                        <a href="{{ route('public.berita') }}"
                           class="group flex items-center px-3 py-2 text-sm font-medium text-blue-800 bg-blue-50 rounded-lg">
                            <i class="fas fa-newspaper text-base mr-2"></i>
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
                            class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-blue-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
                            aria-expanded="false"
                            aria-label="Toggle navigation menu">
                        <i id="menu-icon" class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-200">
                <div class="px-2 pt-4 pb-6 space-y-2">
                    <!-- Mobile Navigation Links -->
                    <div class="space-y-1">
                        <a href="{{ route('welcome') }}"
                           class="group flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                            <i class="fas fa-home text-lg mr-3 text-gray-500 group-hover:text-blue-600"></i>
                            <span>Beranda</span>
                        </a>

                        <a href="{{ route('public.profil') }}"
                           class="flex items-center px-3 py-3 text-base font-medium text-gray-700 rounded-lg hover:text-blue-600 hover:bg-gray-100 transition duration-200">
                            <i class="fas fa-info-circle text-lg mr-3 text-gray-500"></i>
                            <span>Profil</span>
                            <i class="fas fa-chevron-right text-sm ml-auto text-gray-400 group-hover:text-blue-600"></i>
                        </a>

                        <a href="{{ route('public.berita') }}"
                           class="group flex items-center px-3 py-3 text-base font-medium text-blue-800 bg-blue-50 rounded-lg">
                            <i class="fas fa-newspaper text-lg mr-3 text-blue-600"></i>
                            <span>Berita</span>
                        </a>

                        <a href="{{ route('public.layanan') }}"
                           class="group flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                            <i class="fas fa-cogs text-lg mr-3 text-gray-500 group-hover:text-blue-600"></i>
                            <span>Layanan</span>
                        </a>

                        <a href="{{ route('public.kontak') }}"
                           class="group flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                            <i class="fas fa-phone text-lg mr-3 text-gray-500 group-hover:text-blue-600"></i>
                            <span>Kontak</span>
                        </a>
                    </div>

                    <!-- Mobile Authentication Section -->
                    @if (Route::has('login'))
                        <div class="pt-4 border-t border-gray-200 space-y-2">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="flex items-center px-3 py-3 text-base font-medium text-white bg-blue-800 rounded-lg hover:bg-blue-900 transition-all duration-200">
                                    <i class="fas fa-tachometer-alt text-lg mr-3"></i>
                                    <span>Dashboard</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex items-center px-3 py-3 text-base font-medium text-blue-800 border border-blue-800 rounded-lg hover:bg-blue-800 hover:text-white transition-all duration-200">
                                    <i class="fas fa-sign-in-alt text-lg mr-3"></i>
                                    <span>Masuk</span>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="flex items-center px-3 py-3 text-base font-medium text-white bg-blue-800 rounded-lg hover:bg-blue-900 transition-all duration-200">
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

    <!-- Breadcrumb -->
    <div class="bg-white border-b mt-16 lg:mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Beranda</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('public.berita') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Berita</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-800 font-medium">{{ Str::limit($berita->judul, 50) }}</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Article Content -->
            <article class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in">
                    @if($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-64 md:h-96 object-cover">
                    @endif
                    
                    <div class="p-6 md:p-8">
                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-500">
                            @if($berita->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-star mr-1"></i>
                                    Unggulan
                                </span>
                            @endif
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-user"></i>
                                <span>{{ $berita->author->name }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-eye"></i>
                                <span>{{ number_format($berita->views) }} views</span>
                            </div>
                        </div>
                        
                        <!-- Title -->
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">{{ $berita->judul }}</h1>
                        
                        <!-- Excerpt -->
                        @if($berita->excerpt)
                            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                                <p class="text-lg text-gray-700 font-medium leading-relaxed">{{ $berita->excerpt }}</p>
                            </div>
                        @endif
                        
                        <!-- Content -->
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($berita->konten)) !!}
                        </div>
                        
                        <!-- Share Buttons -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Artikel</h3>
                            <div class="flex flex-wrap gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fab fa-facebook-f mr-2"></i>
                                    Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="share-btn inline-flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors">
                                    <i class="fab fa-twitter mr-2"></i>
                                    Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" class="share-btn inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    WhatsApp
                                </a>
                                <button onclick="copyToClipboard('{{ url()->current() }}')" class="share-btn inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-copy mr-2"></i>
                                    Salin Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Related News -->
                @if($relatedNews && $relatedNews->count() > 0)
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($relatedNews as $related)
                                <article class="bg-white rounded-xl shadow-sm overflow-hidden news-card">
                                    @if($related->gambar)
                                        <img src="{{ asset('storage/' . $related->gambar) }}" alt="{{ $related->judul }}" class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-6">
                                        <div class="flex items-center text-gray-500 text-sm mb-3">
                                            <i class="fas fa-calendar mr-2"></i>
                                            <span>{{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                            <a href="{{ route('public.berita.detail', $related->slug) }}">{{ $related->judul }}</a>
                                        </h3>
                                        @if($related->excerpt)
                                            <p class="text-gray-600 mb-4">{{ Str::limit($related->excerpt, 100) }}</p>
                                        @else
                                            <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($related->konten), 100) }}</p>
                                        @endif
                                        
                                        <a href="{{ route('public.berita.detail', $related->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                            Baca Selengkapnya
                                            <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Back to News -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <a href="{{ route('public.berita') }}" class="w-full btn-primary text-white font-medium py-3 px-4 rounded-lg transition-colors text-center block">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Berita
                    </a>
                </div>
                
                <!-- Latest News -->
                @if($latestNews && $latestNews->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Berita Terbaru</h3>
                        <div class="space-y-4">
                            @foreach($latestNews as $latest)
                                <article class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('public.berita.detail', $latest->slug) }}">{{ Str::limit($latest->judul, 60) }}</a>
                                    </h4>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <span>{{ $latest->published_at ? $latest->published_at->format('d M Y') : $latest->created_at->format('d M Y') }}</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-blue-600 p-2 rounded-lg">
                            <i class="fas fa-building text-xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Kantor Camat Waesama</h3>
                            <p class="text-sm text-gray-400">Melayani dengan Sepenuh Hati</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Kantor Camat Waesama berkomitmen memberikan pelayanan terbaik untuk masyarakat dengan mengutamakan transparansi, akuntabilitas, dan profesionalisme.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Raya Waesama No. 123, Kec. Waesama</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>(0123) 456-789</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span>info@waesama.go.id</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Jam Pelayanan</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <div>Senin - Kamis: 08:00 - 16:00</div>
                        <div>Jumat: 08:00 - 11:30</div>
                        <div>Sabtu - Minggu: Tutup</div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Kantor Camat Waesama. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            
            mobileMenu.classList.toggle('hidden');
            
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            } else {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            }
        });
        
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Link berhasil disalin!');
            }, function(err) {
                console.error('Gagal menyalin link: ', err);
            });
        }
    </script>
</body>
</html>