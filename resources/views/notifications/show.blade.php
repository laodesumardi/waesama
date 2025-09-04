@extends('layouts.admin')

@section('title', 'Detail Notifikasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.notifications.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Notifikasi
            </a>
        </div>

        <!-- Notification Card -->
        <div class="bg-white rounded-lg shadow-sm border">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 {{ !$notification->isRead() ? 'bg-blue-50' : '' }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Type Icon -->
                        <div class="flex-shrink-0">
                            @if($notification->type === 'status_change')
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exchange-alt text-blue-600 text-lg"></i>
                                </div>
                            @elseif($notification->type === 'document_ready')
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-download text-green-600 text-lg"></i>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-bell text-gray-600 text-lg"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Title and Status -->
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-xl font-bold text-gray-900">{{ $notification->title }}</h1>
                                @if($notification->is_important)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Penting
                                    </span>
                                @endif
                                @if(!$notification->isRead())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-circle mr-1"></i>
                                        Belum Dibaca
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $notification->created_at->format('d M Y, H:i') }} ({{ $notification->time_ago }})
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        @if(!$notification->isRead())
                            <form action="{{ route('admin.notifications.mark-as-read', $notification) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-check mr-1"></i>
                                    Tandai Dibaca
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-6">
                <!-- Message -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Pesan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">{{ $notification->message }}</p>
                    </div>
                </div>

                <!-- Service Request Info -->
                @if($notification->serviceRequest)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Permohonan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Permohonan</label>
                                <p class="text-gray-900">{{ $notification->serviceRequest->request_number }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                                <p class="text-gray-900">{{ $notification->serviceRequest->service_type }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Saat Ini</label>
                                <div>{!! $notification->serviceRequest->status_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pemohon</label>
                                <p class="text-gray-900">{{ $notification->serviceRequest->citizen->name }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.service-requests.show', $notification->serviceRequest) }}" 
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Lihat Detail Permohonan
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Additional Data -->
                @if($notification->data && count($notification->data) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Detail Tambahan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($notification->data as $key => $value)
                                @if($key !== 'service_type' && $key !== 'request_number')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </label>
                                    <p class="text-gray-900">
                                        @if(is_array($value))
                                            {{ implode(', ', $value) }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </p>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Button -->
                @if($notification->action_url)
                <div class="text-center">
                    <a href="{{ $notification->action_url }}" 
                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        @if($notification->type === 'document_ready')
                            <i class="fas fa-download mr-2"></i>
                            Download Dokumen
                        @else
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Detail
                        @endif
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection