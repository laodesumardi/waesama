@extends('layouts.public')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center fade-in">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Selamat Datang di<br>
                    <span class="text-gradient">Kantor Camat</span>
                </h1>
                <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto">
                    Melayani masyarakat dengan profesional, transparan, dan akuntabel untuk kemajuan daerah
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('news.index') }}" class="btn-secondary btn-ripple smooth-link">Lihat Berita Terbaru</a>
                    <a href="{{ route('gallery.index') }}" class="btn-outline btn-ripple smooth-link">Galeri Kegiatan</a>
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
                <article class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        <div class="relative">
                            @if($latestNews->first()->image)
                                <img src="{{ asset('storage/' . $latestNews->first()->image) }}" alt="{{ $latestNews->first()->title }}" class="w-full h-64 lg:h-full object-cover">
                            @else
                                <div class="w-full h-64 lg:h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: #001d3d;">
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
                @foreach($latestNews->skip(1) as $news)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover stagger-item">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-56 object-cover">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
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
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" data-stagger="100">
                @foreach($latestGallery as $gallery)
                <div class="gallery-item group cursor-pointer stagger-item">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-32 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300">
                    <p class="text-sm text-center mt-2 text-gray-600">{{ $gallery->title }}</p>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12 fade-in">
                <a href="{{ route('gallery.index') }}" class="btn-primary btn-ripple smooth-link">Lihat Semua Galeri</a>
            </div>
        </div>
    </section>
    @endif



@endsection
