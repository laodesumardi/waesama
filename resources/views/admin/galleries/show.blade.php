<x-admin-layout>
    <x-slot name="header">
        Gallery Item Details
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <a href="{{ route('admin.galleries.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 mr-4">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Gallery
                    </a>
                    <h2 class="text-2xl font-bold" style="color: #001d3d;">Gallery Item Details</h2>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                       class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                       style="background-color: #f59e0b;" 
                       onmouseover="this.style.backgroundColor='#d97706'" 
                       onmouseout="this.style.backgroundColor='#f59e0b'">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    
                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this gallery item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                                style="background-color: #dc2626;" 
                                onmouseover="this.style.backgroundColor='#b91c1c'" 
                                onmouseout="this.style.backgroundColor='#dc2626'">
                            <i class="fas fa-trash mr-2"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Gallery Item Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Image Section -->
                @if($gallery->image)
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                             alt="{{ $gallery->title }}" 
                             class="w-full h-96 object-cover">
                    </div>
                @else
                    <div class="h-96 bg-gray-100 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-image text-gray-400 text-6xl mb-4"></i>
                            <p class="text-gray-500">No image available</p>
                        </div>
                    </div>
                @endif

                <!-- Content Section -->
                <div class="p-6">
                    <!-- Title and Status -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $gallery->title }}</h1>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-500 mr-2">Status:</span>
                                    @if($gallery->status === 'active')
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($gallery->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                            <div class="prose max-w-none">
                                <p class="text-gray-700 leading-relaxed">{{ $gallery->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    {{ $gallery->created_at->format('l, F d, Y') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created Time</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                    {{ $gallery->created_at->format('g:i A') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-edit mr-2 text-gray-400"></i>
                                    {{ $gallery->updated_at->format('l, F d, Y g:i A') }}
                                </dd>
                            </div>
                            @if($gallery->image)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Image File</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <i class="fas fa-file-image mr-2 text-gray-400"></i>
                                        {{ basename($gallery->image) }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <div class="flex flex-wrap gap-4">
                            @if($gallery->status === 'active')
                                <a href="{{ route('gallery.index') }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                                   style="background-color: #059669;" 
                                   onmouseover="this.style.backgroundColor='#047857'" 
                                   onmouseout="this.style.backgroundColor='#059669'">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    View on Website
                                </a>
                            @endif
                            
                            <a href="{{ route('admin.galleries.index') }}" 
                               class="inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-list mr-2"></i>
                                Back to Gallery List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>