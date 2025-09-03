<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Pengguna') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.show', $user->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- User Profile Header -->
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 h-16 w-16">
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xl font-medium text-gray-700">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900">Edit: {{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h4>
                                
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select name="role" id="role" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                            required>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="pegawai" {{ old('role', $user->role) === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                        <option value="masyarakat" {{ old('role', $user->role) === 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Akun</label>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_active" value="1" 
                                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-600">Akun Aktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Information -->
                            <div class="space-y-4" id="employment-info">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Kepegawaian</h4>
                                
                                <!-- Employee ID -->
                                <div>
                                    <label for="employee_id" class="block text-sm font-medium text-gray-700">ID Pegawai</label>
                                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $user->employee_id) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika bukan pegawai</p>
                                </div>

                                <!-- Position -->
                                <div>
                                    <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="position" id="position" value="{{ old('position', $user->position) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Department -->
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                                    <select name="department" id="department" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Departemen</option>
                                        <option value="Pimpinan" {{ old('department', $user->department) === 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                        <option value="Sekretariat" {{ old('department', $user->department) === 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                                        <option value="Pelayanan" {{ old('department', $user->department) === 'Pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                                        <option value="Kependudukan" {{ old('department', $user->department) === 'Kependudukan' ? 'selected' : '' }}>Kependudukan</option>
                                        <option value="Pemberdayaan" {{ old('department', $user->department) === 'Pemberdayaan' ? 'selected' : '' }}>Pemberdayaan</option>
                                        <option value="Keamanan" {{ old('department', $user->department) === 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                        <option value="IT" {{ old('department', $user->department) === 'IT' ? 'selected' : '' }}>IT</option>
                                    </select>
                                </div>

                                <!-- Account Info Display -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Informasi Akun</h5>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <div>Bergabung: {{ $user->created_at->format('d M Y H:i') }}</div>
                                        @if($user->email_verified_at)
                                            <div>Email Terverifikasi: {{ $user->email_verified_at->format('d M Y H:i') }}</div>
                                        @endif
                                        @if($user->last_login_at)
                                            <div>Login Terakhir: {{ $user->last_login_at->format('d M Y H:i') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Batal
                                </a>
                            </div>
                            <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-900">
                                ← Kembali ke Daftar Pengguna
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide employment fields based on role
        document.getElementById('role').addEventListener('change', function() {
            const employmentInfo = document.getElementById('employment-info');
            const employeeIdField = document.getElementById('employee_id');
            const positionField = document.getElementById('position');
            const departmentField = document.getElementById('department');
            
            if (this.value === 'masyarakat') {
                employmentInfo.style.opacity = '0.5';
                employeeIdField.value = '';
                positionField.value = '';
                departmentField.value = '';
            } else {
                employmentInfo.style.opacity = '1';
            }
        });
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value === 'masyarakat') {
                document.getElementById('employment-info').style.opacity = '0.5';
            }
        });
    </script>
</x-app-layout>