<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Berita') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.news.edit', $news) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Info -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $news->title }}</h1>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Oleh: <strong>{{ $news->author }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $news->created_at->format('d M Y, H:i') }}</span>
                                    @if($news->published_at)
                                        <span>•</span>
                                        <span>Dipublikasi: {{ $news->published_at->format('d M Y, H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($news->status === 'published')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Image -->
                    @if($news->image)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" 
                                 class="w-full max-w-2xl mx-auto rounded-lg shadow-md">
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose max-w-none">
                        <div class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $news->content }}</div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-gray-200 pt-6 mt-8">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                Terakhir diupdate: {{ $news->updated_at->format('d M Y, H:i') }}
                            </div>
                            <div class="flex space-x-2">
                                @if($news->status === 'published')
                                    <a href="{{ route('news.show', $news) }}" target="_blank" 
                                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Lihat di Website
                                    </a>
                                @endif
                                <a href="{{ route('admin.news.edit', $news) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Berita
                                </a>
                                <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus Berita
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>