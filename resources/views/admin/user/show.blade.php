@extends('layouts.main')

@section('title', 'Detail User')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.user.index') }}" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <div class="border-l border-gray-300 pl-4">
                    <h1 class="text-2xl font-bold text-gray-800">Detail User</h1>
                    <nav class="text-sm text-gray-600">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('admin.user.index') }}" class="hover:text-blue-600">Manajemen User</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-800">Detail User</span>
                    </nav>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.user.edit', $user) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <p class="text-gray-600">{{ $user->email }}</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user mr-2 text-blue-600"></i>
                    Informasi User
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <p class="text-gray-900">{{ $user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($user->role->name === 'Admin') bg-red-100 text-red-800
                            @elseif($user->role->name === 'Pegawai') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ $user->role->display_name }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    
                    @if($user->nik)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                            <p class="text-gray-900 font-mono">{{ $user->nik }}</p>
                        </div>
                    @endif
                    
                    @if($user->phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <p class="text-gray-900">{{ $user->phone }}</p>
                        </div>
                    @endif
                    
                    @if($user->birth_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <p class="text-gray-900">{{ $user->birth_date->format('d F Y') }}</p>
                        </div>
                    @endif
                    
                    @if($user->gender)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <p class="text-gray-900">{{ $user->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    @endif
                    
                    @if($user->address)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <p class="text-gray-900">{{ $user->address }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Activity Summary -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                    Ringkasan Aktivitas
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $user->suratProcessed->count() }}</div>
                        <div class="text-sm text-gray-600">Surat Diproses</div>
                    </div>
                    
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $user->antrianServed->count() }}</div>
                        <div class="text-sm text-gray-600">Antrian Dilayani</div>
                    </div>
                    
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $user->berita->count() }}</div>
                        <div class="text-sm text-gray-600">Berita Dibuat</div>
                    </div>
                    
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ $user->pengaduanHandled->count() }}</div>
                        <div class="text-sm text-gray-600">Pengaduan Ditangani</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            @if($user->id !== auth()->id())
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-bolt mr-2 text-blue-600"></i>
                        Aksi Cepat
                    </h3>
                    
                    <div class="space-y-3">
                        <form action="{{ route('admin.user.toggle-status', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 {{ $user->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors">
                                <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} mr-2"></i>
                                {{ $user->is_active ? 'Nonaktifkan User' : 'Aktifkan User' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.user.reset-password', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset password user ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                                <i class="fas fa-key mr-2"></i>Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            @endif
            
            <!-- Account Information -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Akun
                </h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Terverifikasi</label>
                        <p class="text-gray-700">{{ $user->email_verified_at ? $user->email_verified_at->format('d F Y, H:i') . ' WIB' : 'Belum terverifikasi' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Terdaftar</label>
                        <p class="text-gray-700">{{ $user->created_at->format('d F Y, H:i:s') }} WIB</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                        <p class="text-gray-700">{{ $user->updated_at->format('d F Y, H:i:s') }} WIB</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-compass mr-2 text-blue-600"></i>
                    Navigasi
                </h3>
                
                <div class="space-y-2">
                    <a href="{{ route('admin.user.edit', $user) }}" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-edit mr-2"></i>Edit User
                    </a>
                    <a href="{{ route('admin.user.index') }}" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-list mr-2"></i>Daftar User
                    </a>
                    <a href="{{ route('admin.user.create') }}" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i>Tambah User
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection