@forelse($berita ?? [] as $item)
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
    <div class="relative">
        <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/400x250?text=Berita' }}" 
             alt="{{ $item->judul }}" 
             class="w-full h-48 object-cover">
        <div class="absolute top-3 left-3">
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ ucfirst($item->kategori ?? 'Umum') }}
            </span>
        </div>
        @auth
        <div class="absolute top-3 right-3">
            <button type="button" 
                    class="bookmark-btn bg-white/80 hover:bg-white text-gray-600 hover:text-red-500 p-2 rounded-full shadow-sm transition-all duration-200"
                    data-berita-id="{{ $item->id }}"
                    data-bookmarked="{{ $item->isBookmarkedBy(auth()->id()) ? 'true' : 'false' }}">
                <i class="fas fa-heart {{ $item->isBookmarkedBy(auth()->id()) ? 'text-red-500' : '' }}"></i>
            </button>
        </div>
        @endauth
    </div>
    <div class="p-4">
        <div class="flex items-center text-gray-500 text-sm mb-2">
            <i class="fas fa-calendar-alt mr-1"></i>
            {{ $item->created_at->format('d M Y') }}
            <span class="mx-2">•</span>
            <i class="fas fa-user mr-1"></i>
            Admin
        </div>
        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">
            {{ $item->judul }}
        </h3>
        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
            {{ Str::limit(strip_tags($item->konten), 120) }}
        </p>
        <a href="{{ route('public.berita.detail', $item->slug) }}" 
           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm">
            Baca Selengkapnya
            <i class="fas fa-arrow-right ml-1 text-xs"></i>
        </a>
    </div>
</div>
@empty
<div class="col-span-full">
    <div class="text-center py-12">
        <i class="fas fa-newspaper text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Berita Ditemukan</h3>
        <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter kategori.</p>
    </div>
</div>
@endforelse