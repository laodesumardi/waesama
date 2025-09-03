<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pengguna Baru') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h4>
                                
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="08xxxxxxxxxx">
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" id="password" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required minlength="8">
                                    <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                                </div>

                                <!-- Password Confirmation -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required minlength="8">
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                                    <select name="role" id="role" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                            required>
                                        <option value="">Pilih Role</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="pegawai" {{ old('role') === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                        <option value="masyarakat" {{ old('role') === 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Akun</label>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_active" value="1" 
                                                   {{ old('is_active', true) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-600">Akun Aktif</span>
                                        </label>
                                    </div>
                                </div>
            </div>

                            <!-- Employment Information -->
                            <div class="space-y-4" id="employment-info">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Kepegawaian</h4>
                                <p class="text-sm text-gray-600">Isi bagian ini hanya untuk pegawai dan admin</p>
                                
                                <!-- Employee ID -->
                                <div>
                                    <label for="employee_id" class="block text-sm font-medium text-gray-700">ID Pegawai</label>
                                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="PEG001">
                                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika bukan pegawai</p>
                                </div>

                                <!-- Position -->
                                <div>
                                    <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="position" id="position" value="{{ old('position') }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Contoh: Staff Pelayanan">
                                </div>

                                <!-- Department -->
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                                    <select name="department" id="department" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Departemen</option>
                                        <option value="Pimpinan" {{ old('department') === 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                        <option value="Sekretariat" {{ old('department') === 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                                        <option value="Pelayanan" {{ old('department') === 'Pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                                        <option value="Kependudukan" {{ old('department') === 'Kependudukan' ? 'selected' : '' }}>Kependudukan</option>
                                        <option value="Pemberdayaan" {{ old('department') === 'Pemberdayaan' ? 'selected' : '' }}>Pemberdayaan</option>
                                        <option value="Keamanan" {{ old('department') === 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                        <option value="IT" {{ old('department') === 'IT' ? 'selected' : '' }}>IT</option>
                                    </select>
                                </div>

                                <!-- Info Box -->
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li>Password default akan dikirim ke email pengguna</li>
                                                    <li>Pengguna dapat mengubah password setelah login pertama</li>
                                                    <li>Informasi kepegawaian hanya diperlukan untuk role Admin dan Pegawai</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Buat Pengguna
                                </button>
                                <a href="{{ route('admin.users') }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Batal
                                </a>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="text-red-500">*</span> Wajib diisi
                            </div>
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
                employeeIdField.removeAttribute('required');
            } else {
                employmentInfo.style.opacity = '1';
                if (this.value === 'admin' || this.value === 'pegawai') {
                    employeeIdField.setAttribute('required', 'required');
                }
            }
        });
        
        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (password !== confirmation) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });
        
        document.getElementById('password').addEventListener('input', function() {
            const confirmation = document.getElementById('password_confirmation');
            if (confirmation.value) {
                confirmation.dispatchEvent(new Event('input'));
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