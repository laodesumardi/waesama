@extends('layouts.public')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Selamat Datang di<br>
                    <span class="text-gradient">Kantor Camat</span>
                </h1>
                <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto">
                    Melayani masyarakat dengan profesional, transparan, dan akuntabel untuk kemajuan daerah
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('news.index') }}" class="btn-secondary">Lihat Berita Terbaru</a>
                    <a href="{{ route('gallery.index') }}" class="btn-outline">Galeri Kegiatan</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    @if($latestNews->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4" style="color: #001d3d;">Berita Terbaru</h2>
                <p class="text-gray-600">Informasi dan update terkini dari Kantor Camat</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($latestNews as $news)
                <article class="admin-card hover:shadow-lg transition-all duration-300">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-48 object-cover rounded-t-lg">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-blue-200 rounded-t-lg flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2" style="color: #001d3d;">{{ $news->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $news->published_at->format('d M Y') }}</span>
                            <a href="{{ route('news.show', $news->id) }}" class="text-sm font-medium hover:underline" style="color: #001d3d;">Baca Selengkapnya</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('news.index') }}" class="btn-primary">Lihat Semua Berita</a>
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Gallery Section -->
    @if($latestGallery->count() > 0)
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4" style="color: #001d3d;">Galeri Kegiatan</h2>
                <p class="text-gray-600">Dokumentasi kegiatan dan program Kantor Camat</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($latestGallery as $gallery)
                <div class="gallery-item group cursor-pointer">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-32 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300">
                    <p class="text-sm text-center mt-2 text-gray-600">{{ $gallery->title }}</p>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('gallery.index') }}" class="btn-primary">Lihat Semua Galeri</a>
            </div>
        </div>
    </section>
    @endif



@endsection
