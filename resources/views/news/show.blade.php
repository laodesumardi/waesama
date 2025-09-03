@extends('layouts.public')

@section('content')
<div class="bg-gray-50">
    <!-- Article Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-gray-900">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('news.index') }}" class="ml-1 text-gray-700 hover:text-gray-900 md:ml-2">
                                Berita
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ Str::limit($news->title, 50) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <h1 class="text-3xl md:text-4xl font-bold mb-4" style="color: #001d3d;">{{ $news->title }}</h1>
            
            <div class="flex items-center text-sm text-gray-500 mb-6">
                <time datetime="{{ $news->published_at->format('Y-m-d') }}">
                    {{ $news->published_at->format('d F Y') }}
                </time>
                @if($news->author)
                    <span class="mx-2">•</span>
                    <span>Oleh {{ $news->author }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <article class="admin-card">
            @if($news->image)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-64 md:h-96 object-cover rounded-lg">
                </div>
            @endif
            
            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($news->content)) !!}
            </div>
        </article>

        <!-- Related News -->
        @if($relatedNews->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-8" style="color: #001d3d;">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedNews as $related)
                <article class="admin-card hover:shadow-lg transition-all duration-300">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-32 object-cover rounded-t-lg">
                    @else
                        <div class="w-full h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-t-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2" style="color: #001d3d;">{{ $related->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit(strip_tags($related->content), 80) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">{{ $related->published_at->format('d M Y') }}</span>
                            <a href="{{ route('news.show', $related->id) }}" class="text-xs font-medium hover:underline" style="color: #001d3d;">Baca</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Navigation -->
        <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-between">
            <a href="{{ route('news.index') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Berita
            </a>
            <a href="{{ route('welcome') }}" class="btn-outline" style="border-color: #001d3d; color: #001d3d;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Beranda
            </a>
        </div>
    </div>
</div>
@endsection