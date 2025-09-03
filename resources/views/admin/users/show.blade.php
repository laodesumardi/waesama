<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengguna') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- User Profile Header -->
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-20 w-20">
                            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-2xl font-medium text-gray-700">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="mt-2">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'pegawai') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="ml-2 inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->phone ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                                    <dd class="text-sm text-gray-900">{{ ucfirst($user->role) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Employment Information -->
                        @if($user->role !== 'masyarakat')
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kepegawaian</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ID Pegawai</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->employee_id ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->position ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Departemen</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->department ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                        @endif

                        <!-- Account Information -->
                        <div class="bg-gray-50 p-4 rounded-lg {{ $user->role === 'masyarakat' ? 'md:col-span-1' : '' }}">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                                    <dd class="text-sm text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email Terverifikasi</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($user->email_verified_at)
                                            <span class="text-green-600">✓ Terverifikasi</span>
                                            <div class="text-xs text-gray-500">{{ $user->email_verified_at->format('d M Y H:i') }}</div>
                                        @else
                                            <span class="text-red-600">✗ Belum Terverifikasi</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Login Terakhir</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($user->last_login_at)
                                            {{ $user->last_login_at->format('d M Y H:i') }}
                                            <div class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</div>
                                        @else
                                            <span class="text-gray-500">Belum pernah login</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $user->updated_at->format('d M Y H:i') }}
                                        <div class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Preferences (if any) -->
                        @if($user->preferences)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Preferensi</h4>
                            <pre class="text-sm text-gray-700 bg-white p-3 rounded border overflow-auto">{{ json_encode($user->preferences, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit Pengguna
                            </a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" 
                                      class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus Pengguna
                                    </button>
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-900">
                            ← Kembali ke Daftar Pengguna
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>