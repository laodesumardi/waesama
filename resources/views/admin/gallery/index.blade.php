<x-admin-layout>
    <x-slot name="header">
        Gallery Management
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold" style="color: #001d3d;">Gallery Items</h2>
                <a href="{{ route('admin.gallery.create') }}" 
                   class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                   style="background-color: #001d3d;" 
                   onmouseover="this.style.backgroundColor='#003366'" 
                   onmouseout="this.style.backgroundColor='#001d3d'">
                    <i class="fas fa-plus mr-2"></i>
                    Add Gallery Item
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Gallery Items Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                @if($galleries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background-color: #f8fafc;">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Image
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($galleries as $gallery)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($gallery->image)
                                                <img src="{{ asset('storage/' . $gallery->image) }}" 
                                                     alt="{{ $gallery->title }}" 
                                                     class="h-16 w-16 object-cover rounded-lg">
                                            @else
                                                <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $gallery->title }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($gallery->description, 50) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($gallery->status === 'active')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $gallery->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.gallery.show', $gallery) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.gallery.destroy', $gallery) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this gallery item?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $galleries->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-images text-gray-400 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Gallery Items</h3>
                        <p class="text-gray-500 mb-4">Get started by creating your first gallery item.</p>
                        <a href="{{ route('admin.gallery.create') }}" 
                           class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                           style="background-color: #001d3d;" 
                           onmouseover="this.style.backgroundColor='#003366'" 
                           onmouseout="this.style.backgroundColor='#001d3d'">
                            <i class="fas fa-plus mr-2"></i>
                            Add Gallery Item
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>