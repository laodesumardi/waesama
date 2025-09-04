@extends('layouts.main')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Pengaturan Sistem</h2>
                <p class="text-blue-100">Kelola konfigurasi dan pengaturan sistem dengan mudah.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-cog text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <form action="{{ route('admin.settings.clear-cache') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-broom"></i>
                    <span>Bersihkan Cache</span>
                </button>
            </form>
            
            <a href="{{ route('admin.settings.backup') }}" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-download"></i>
                <span>Backup Database</span>
            </a>
            
            <a href="{{ route('admin.settings.system-info') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-info-circle"></i>
                <span>Info Sistem</span>
            </a>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Pengaturan Umum</h3>
        
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Site Information -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-700 border-b pb-2">Informasi Situs</h4>
                    
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Situs</label>
                        <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('site_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Situs</label>
                        <textarea id="site_description" name="site_description" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ old('site_description', $settings['site_description']) }}</textarea>
                        @error('site_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-700 border-b pb-2">Informasi Kontak</h4>
                    
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('contact_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('contact_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Office Information -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-700 border-b pb-2">Informasi Kantor</h4>
                    
                    <div>
                        <label for="office_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Kantor</label>
                        <textarea id="office_address" name="office_address" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ old('office_address', $settings['office_address']) }}</textarea>
                        @error('office_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="office_hours" class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                        <input type="text" id="office_hours" name="office_hours" value="{{ old('office_hours', $settings['office_hours']) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('office_hours')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- System Settings -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-700 border-b pb-2">Pengaturan Sistem</h4>
                    
                    <div>
                        <label for="max_queue_per_day" class="block text-sm font-medium text-gray-700 mb-2">Maksimal Antrian per Hari</label>
                        <input type="number" id="max_queue_per_day" name="max_queue_per_day" value="{{ old('max_queue_per_day', $settings['max_queue_per_day']) }}" 
                               min="1" max="200" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('max_queue_per_day')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" id="auto_approve_letters" name="auto_approve_letters" value="1" 
                                   {{ old('auto_approve_letters', $settings['auto_approve_letters']) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="auto_approve_letters" class="ml-2 block text-sm text-gray-700">
                                Otomatis Setujui Surat
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="notification_email" name="notification_email" value="1" 
                                   {{ old('notification_email', $settings['notification_email']) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="notification_email" class="ml-2 block text-sm text-gray-700">
                                Notifikasi Email
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" 
                                   {{ old('maintenance_mode', $settings['maintenance_mode']) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="maintenance_mode" class="ml-2 block text-sm text-gray-700">
                                Mode Maintenance
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="mt-8 flex justify-end space-x-4">
                <button type="button" onclick="window.location.reload()" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Reset
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Real-time update for text inputs and textareas
    $('input[type="text"], textarea').on('blur', function() {
        updateSetting($(this));
    });
    
    // Real-time update for checkboxes
    $('input[type="checkbox"]').on('change', function() {
        updateSetting($(this));
    });
    
    // Real-time update for number inputs
    $('input[type="number"]').on('blur', function() {
        updateSetting($(this));
    });
    
    function updateSetting($element) {
        const field = $element.attr('name');
        let value = $element.val();
        
        // Handle checkbox values
        if ($element.attr('type') === 'checkbox') {
            value = $element.is(':checked') ? 1 : 0;
        }
        
        // Skip if field name is not defined or value is empty for required fields
        if (!field || (value === '' && $element.prop('required'))) {
            return;
        }
        
        // Show loading indicator
        showLoadingIndicator($element);
        
        $.ajax({
            url: '{{ route("admin.settings.update-realtime") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                field: field,
                value: value
            },
            success: function(response) {
                if (response.success) {
                    showSuccessIndicator($element, response.message);
                    
                    // Update global settings if needed
                    updateGlobalSettings(field, response.value);
                } else {
                    showErrorIndicator($element, response.message);
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat menyimpan pengaturan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showErrorIndicator($element, message);
            },
            complete: function() {
                hideLoadingIndicator($element);
            }
        });
    }
    
    function showLoadingIndicator($element) {
        $element.addClass('border-blue-300 bg-blue-50');
        
        // Add loading icon if not exists
        if (!$element.siblings('.loading-icon').length) {
            $element.after('<i class="fas fa-spinner fa-spin text-blue-500 loading-icon ml-2"></i>');
        }
    }
    
    function hideLoadingIndicator($element) {
        $element.removeClass('border-blue-300 bg-blue-50');
        $element.siblings('.loading-icon').remove();
    }
    
    function showSuccessIndicator($element, message) {
        $element.addClass('border-green-300 bg-green-50');
        
        // Show success message
        showToast('success', message);
        
        // Remove success styling after 2 seconds
        setTimeout(function() {
            $element.removeClass('border-green-300 bg-green-50');
        }, 2000);
    }
    
    function showErrorIndicator($element, message) {
        $element.addClass('border-red-300 bg-red-50');
        
        // Show error message
        showToast('error', message);
        
        // Remove error styling after 3 seconds
        setTimeout(function() {
            $element.removeClass('border-red-300 bg-red-50');
        }, 3000);
    }
    
    function showToast(type, message) {
        const toastClass = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const toast = $(`
            <div class="fixed top-4 right-4 ${toastClass} text-white px-6 py-3 rounded-lg shadow-lg z-50 toast-notification">
                <div class="flex items-center space-x-2">
                    <i class="fas ${icon}"></i>
                    <span>${message}</span>
                </div>
            </div>
        `);
        
        $('body').append(toast);
        
        // Auto remove after 3 seconds
        setTimeout(function() {
            toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    function updateGlobalSettings(field, value) {
        // Update any global elements that depend on these settings
        if (field === 'site_name') {
            // Update site name in header or other places if needed
            $('.site-name').text(value);
        }
        
        if (field === 'maintenance_mode') {
            // Handle maintenance mode changes
            if (value) {
                console.log('Maintenance mode activated');
            } else {
                console.log('Maintenance mode deactivated');
            }
        }
    }
});
</script>
@endpush

@endsection