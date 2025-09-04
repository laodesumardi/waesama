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
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23667eea'/%3E%3Ctext x='50' y='60' text-anchor='middle' fill='white' font-size='40' font-weight='bold'%3EW%3C/text%3E%3C/svg%3E" alt="Logo" class="h-10 w-10">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Kantor Camat</h1>
                        <p class="text-sm text-gray-600">Waesama</p>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="{{ route('public.profil') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Profil</a>
                    <a href="{{ route('public.berita') }}" class="text-blue-600 font-medium">Berita</a>
                    <a href="{{ route('public.layanan') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Layanan</a>
                    <a href="{{ route('public.kontak') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Kontak</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Daftar
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-white border-b">
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
                                    <i class="fas fa-star mr-1"></i> Featured
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
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! nl2br(e($berita->konten)) !!}
                        </div>
                        
                        <!-- Share Buttons -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bagikan Artikel</h3>
                            <div class="flex flex-wrap gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                    <i class="fab fa-facebook-f"></i>
                                    <span>Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="share-btn bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                    <i class="fab fa-twitter"></i>
                                    <span>Twitter</span>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" class="share-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>WhatsApp</span>
                                </a>
                                <button onclick="copyToClipboard()" class="share-btn bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                    <i class="fas fa-link"></i>
                                    <span>Salin Link</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Related News -->
                @if($relatedNews->count() > 0)
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terkait</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($relatedNews as $related)
                                <article class="news-card bg-white rounded-xl overflow-hidden">
                                    @if($related->gambar)
                                        <img src="{{ asset('storage/' . $related->gambar) }}" alt="{{ $related->judul }}" class="w-full h-48 object-cover">
                                    @endif
                                    
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4 mb-3 text-sm text-gray-500">
                                            <span>
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}
                                            </span>
                                            <span>
                                                <i class="fas fa-eye mr-1"></i>
                                                {{ number_format($related->views) }}
                                            </span>
                                        </div>
                                        
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
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
                @if($latestNews->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-newspaper text-blue-500 mr-2"></i>
                            Berita Terbaru
                        </h3>
                        <div class="space-y-4">
                            @foreach($latestNews as $latest)
                                <article class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                    @if($latest->gambar)
                                        <img src="{{ asset('storage/' . $latest->gambar) }}" alt="{{ $latest->judul }}" class="w-full h-32 object-cover rounded-lg mb-3">
                                    @endif
                                    <h4 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('public.berita.detail', $latest->slug) }}">{{ Str::limit($latest->judul, 60) }}</a>
                                    </h4>
                                    <div class="flex items-center text-xs text-gray-500 space-x-3">
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $latest->published_at ? $latest->published_at->format('d M Y') : $latest->created_at->format('d M Y') }}
                                        </span>
                                        <span>
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ number_format($latest->views) }}
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
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Link berhasil disalin!');
            }, function(err) {
                console.error('Gagal menyalin link: ', err);
            });
        }
    </script>
</body>
</html>