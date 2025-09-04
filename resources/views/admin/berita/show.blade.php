@extends('layouts.main')

@section('title', 'Detail Berita')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.berita.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Berita</h1>
                <p class="text-gray-600">{{ $berita->judul }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.berita.edit', $berita) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            @if($berita->status === 'Published')
                <a href="{{ route('public.berita.detail', $berita->slug) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Lihat Publik</span>
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Article Content -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-64 object-cover">
                @endif
                
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="flex items-center space-x-3 mb-4">
                        @if($berita->status === 'Published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Published
                            </span>
                        @elseif($berita->status === 'Draft')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-edit mr-1"></i> Draft
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-archive mr-1"></i> Archived
                            </span>
                        @endif
                        
                        @if($berita->is_featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        @endif
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $berita->judul }}</h1>
                    
                    <!-- Meta Info -->
                    <div class="flex items-center space-x-6 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <span>{{ $berita->author->name }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $berita->created_at->format('d M Y') }}</span>
                        </div>
                        @if($berita->published_at)
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-globe"></i>
                                <span>Dipublikasi {{ $berita->published_at->format('d M Y H:i') }}</span>
                            </div>
                        @endif
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($berita->views) }} views</span>
                        </div>
                    </div>
                    
                    <!-- Excerpt -->
                    @if($berita->excerpt)
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <p class="text-gray-700 font-medium">{{ $berita->excerpt }}</p>
                        </div>
                    @endif
                    
                    <!-- Content -->
                    <div class="prose max-w-none">
                        {!! nl2br(e($berita->konten)) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.berita.edit', $berita) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                        <i class="fas fa-edit mr-2"></i>Edit Berita
                    </a>
                    
                    @if($berita->status !== 'Published')
                        <form action="{{ route('admin.berita.update', $berita) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="judul" value="{{ $berita->judul }}">
                            <input type="hidden" name="excerpt" value="{{ $berita->excerpt }}">
                            <input type="hidden" name="konten" value="{{ $berita->konten }}">
                            <input type="hidden" name="status" value="Published">
                            <input type="hidden" name="is_featured" value="{{ $berita->is_featured ? '1' : '0' }}">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-globe mr-2"></i>Publikasikan
                            </button>
                        </form>
                    @else
                        <a href="{{ route('public.berita.detail', $berita->slug) }}" target="_blank" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                            <i class="fas fa-external-link-alt mr-2"></i>Lihat Publik
                        </a>
                    @endif
                    
                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i>Hapus Berita
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Article Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Artikel</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Slug:</span>
                        <span class="text-gray-900 font-mono text-xs">{{ $berita->slug }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="text-gray-900">#{{ $berita->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat:</span>
                        <span class="text-gray-900">{{ $berita->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diperbarui:</span>
                        <span class="text-gray-900">{{ $berita->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    @if($berita->published_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dipublikasi:</span>
                            <span class="text-gray-900">{{ $berita->published_at->format('d M Y H:i') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Views:</span>
                        <span class="text-gray-900 font-semibold">{{ number_format($berita->views) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- SEO Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">SEO Preview</h3>
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="text-blue-600 text-lg font-medium mb-1">{{ $berita->judul }}</div>
                    <div class="text-green-600 text-sm mb-2">{{ url('/berita/' . $berita->slug) }}</div>
                    <div class="text-gray-600 text-sm">{{ $berita->excerpt ?: Str::limit(strip_tags($berita->konten), 150) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection