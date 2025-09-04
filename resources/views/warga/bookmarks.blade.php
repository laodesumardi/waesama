@extends('layouts.main')

@section('title', 'Bookmark Berita')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Bookmark Berita</h1>
        <p class="text-gray-600">Berita yang telah Anda bookmark</p>
    </div>

    <!-- News Grid -->
    <div id="newsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @include('warga.partials.berita-grid', ['berita' => $bookmarks])
    </div>

    <!-- Pagination -->
    @if($bookmarks->hasPages())
    <div class="mt-8" id="paginationContainer">
        {{ $bookmarks->links() }}
    </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsContainer = document.getElementById('newsGrid');
    const paginationContainer = document.getElementById('paginationContainer');
    
    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('.pagination a').href;
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    newsContainer.innerHTML = data.html;
                    if (paginationContainer) {
                        paginationContainer.innerHTML = data.pagination || '';
                    }
                    // Scroll to top of news container
                    newsContainer.scrollIntoView({ behavior: 'smooth' });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
    
    // Handle bookmark clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.bookmark-btn')) {
            e.preventDefault();
            const button = e.target.closest('.bookmark-btn');
            const beritaId = button.dataset.beritaId;
            const isBookmarked = button.dataset.bookmarked === 'true';
            const icon = button.querySelector('i');
            const card = button.closest('.bg-white');
            
            // Disable button during request
            button.disabled = true;
            
            fetch(`{{ url('/warga/bookmark') }}/${beritaId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (!data.is_bookmarked) {
                        // Remove the card with animation
                        card.style.transition = 'opacity 0.3s ease';
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.remove();
                            // Check if no more bookmarks
                            if (newsContainer.children.length === 0) {
                                newsContainer.innerHTML = `
                                    <div class="col-span-full">
                                        <div class="text-center py-12">
                                            <i class="fas fa-heart text-gray-300 text-6xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Bookmark</h3>
                                            <p class="text-gray-500">Anda belum memiliki berita yang di-bookmark.</p>
                                            <a href="{{ route('warga.berita.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                                Jelajahi Berita
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }
                        }, 300);
                    }
                    
                    // Show toast message
                    showToast(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat menghapus bookmark');
            })
            .finally(() => {
                button.disabled = false;
            });
        }
    });
    
    // Simple toast function
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
});
</script>
@endsection