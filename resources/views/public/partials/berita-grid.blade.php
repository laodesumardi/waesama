@if($berita->count() > 0)
    @foreach($berita as $item)
        <article class="news-card bg-white rounded-xl overflow-hidden fade-in">
            <div class="md:flex">
                @if($item->gambar)
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 md:h-full object-cover">
                    </div>
                @endif

                <div class="p-6 {{ $item->gambar ? 'md:w-2/3' : 'w-full' }}">
                    <div class="flex items-center space-x-4 mb-3">
                        @if($item->is_featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        @endif
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-user mr-1"></i>
                            {{ $item->author->name ?? 'Admin' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-eye mr-1"></i>
                            {{ number_format($item->views ?? 0) }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                        <a href="{{ route('public.berita.detail', $item->slug) }}">{{ $item->judul }}</a>
                    </h2>

                    @if($item->excerpt)
                        <p class="text-gray-600 mb-4">{{ $item->excerpt }}</p>
                    @else
                        <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($item->konten), 150) }}</p>
                    @endif

                    <a href="{{ route('public.berita.detail', $item->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                        Baca Selengkapnya
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </article>
    @endforeach
@else
    <div class="text-center py-12">
        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada berita ditemukan</h3>
        <p class="text-gray-500">Coba gunakan kata kunci yang berbeda atau hapus filter pencarian.</p>
    </div>
@endif