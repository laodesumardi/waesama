@extends('layouts.admin')

@section('title', 'Notifikasi')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js">
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
        <div class="flex space-x-3">
            <button id="markAllReadBtn" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
            </button>
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors" data-bs-toggle="modal" data-bs-target="#sendNotificationModal">
                <i class="fas fa-plus mr-2"></i>Kirim Notifikasi
            </button>
        </div>
    </div>

    <!-- Send Notification Modal -->
    <div id="sendNotificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Kirim Notifikasi</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="sendNotificationForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Penerima</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="recipient_type" value="user" class="mr-2" checked onchange="toggleRecipientType()">
                                Pengguna Spesifik
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="recipient_type" value="role" class="mr-2" onchange="toggleRecipientType()">
                                Berdasarkan Role
                            </label>
                        </div>
                    </div>
                    
                    <div id="userSelect" class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Pengguna</label>
                        <select id="userId" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Pilih pengguna...</option>
                            <!-- Users will be loaded via AJAX -->
                        </select>
                    </div>
                    
                    <div id="roleSelect" class="mb-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Role</label>
                        <select id="roleId" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Pilih role...</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                        <select id="priority" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="low">Rendah</option>
                            <option value="medium" selected>Sedang</option>
                            <option value="high">Tinggi</option>
                            <option value="urgent">Mendesak</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Notifikasi</label>
                        <select id="notificationType" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="info">Informasi</option>
                            <option value="announcement">Pengumuman</option>
                            <option value="reminder">Pengingat</option>
                            <option value="urgent">Mendesak</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                        <input type="text" id="title" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Masukkan judul notifikasi">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea id="message" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Masukkan pesan notifikasi"></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL Aksi (Opsional)</label>
                        <input type="url" id="actionUrl" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="https://example.com">
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Daftar Notifikasi</h3>
                <div class="flex space-x-2">
                    <select id="filterPriority" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                        <option value="">Semua Prioritas</option>
                        <option value="urgent">Mendesak</option>
                        <option value="high">Tinggi</option>
                        <option value="medium">Sedang</option>
                        <option value="low">Rendah</option>
                    </select>
                    <select id="filterStatus" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                        <option value="">Semua Status</option>
                        <option value="unread">Belum Dibaca</option>
                        <option value="read">Sudah Dibaca</option>
                    </select>
                </div>
            </div>
            
            <div id="notificationsList" class="space-y-3">
                <!-- Notifications will be loaded here -->
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-bell text-4xl mb-4"></i>
                    <p>Memuat notifikasi...</p>
                </div>
            </div>
            
            <!-- Pagination -->
            <div id="pagination" class="mt-6 flex justify-center">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="{{ asset('js/notifications.js') }}"></script>
@endpush