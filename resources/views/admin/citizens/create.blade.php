<x-admin-layout>
    <x-slot name="header">
        Tambah Data Penduduk
    </x-slot>



    <div class="space-y-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                                </div>
                                Form Tambah Penduduk
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Lengkapi semua informasi yang diperlukan dengan benar</p>
                        </div>
                        <a href="{{ route('admin.citizens.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="p-6 lg:p-8">

                    <form action="{{ route('admin.citizens.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Data Identitas -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-id-card text-blue-600 text-xs"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Data Identitas</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NIK -->
                                <div>
                                    <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-id-badge text-blue-500 mr-1"></i>
                                        NIK *
                                    </label>
                                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16"
                                           placeholder="Masukkan 16 digit NIK"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('nik') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('nik')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Nama -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user text-blue-500 mr-1"></i>
                                        Nama Lengkap *
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                           placeholder="Masukkan nama lengkap"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Foto -->
                                <div class="md:col-span-2">
                                    <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-camera text-blue-500 mr-1"></i>
                                        Foto Penduduk
                                    </label>
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div id="photo-preview" class="w-24 h-24 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                                <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Avatar" class="w-16 h-16 text-gray-400">
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" name="photo" id="photo" accept="image/*"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200 @error('photo') border-red-500 ring-2 ring-red-200 @enderror">
                                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                                            @error('photo')
                                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Tempat Lahir -->
                                <div>
                                    <label for="birth_place" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i>
                                        Tempat Lahir *
                                    </label>
                                    <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place') }}"
                                           placeholder="Masukkan tempat lahir"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('birth_place') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('birth_place')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Tanggal Lahir -->
                                <div>
                                    <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-calendar text-blue-500 mr-1"></i>
                                        Tanggal Lahir *
                                    </label>
                                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('birth_date') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('birth_date')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Jenis Kelamin -->
                                <div>
                                    <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-venus-mars text-blue-500 mr-1"></i>
                                        Jenis Kelamin *
                                    </label>
                                    <select name="gender" id="gender" class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('gender') border-red-500 ring-2 ring-red-200 @enderror">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Desa -->
                                <div>
                                    <label for="village_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-home text-blue-500 mr-1"></i>
                                        Desa *
                                    </label>
                                    <input type="text" name="village_name" id="village_name" value="{{ old('village_name') }}"
                                           placeholder="Masukkan nama desa"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('village_name') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('village_name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Personal -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-circle text-green-600 text-xs"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Data Personal</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Agama -->
                                <div>
                                    <label for="religion" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-pray text-green-500 mr-1"></i>
                                        Agama *
                                    </label>
                                    <select name="religion" id="religion" class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('religion') border-red-500 ring-2 ring-red-200 @enderror">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @error('religion')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Status Perkawinan -->
                                <div>
                                    <label for="marital_status" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-heart text-green-500 mr-1"></i>
                                        Status Perkawinan *
                                    </label>
                                    <select name="marital_status" id="marital_status" class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('marital_status') border-red-500 ring-2 ring-red-200 @enderror">
                                        <option value="">Pilih Status Perkawinan</option>
                                        <option value="Belum Kawin" {{ old('marital_status') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ old('marital_status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ old('marital_status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('marital_status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                    @error('marital_status')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Pekerjaan -->
                                <div>
                                    <label for="occupation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-briefcase text-green-500 mr-1"></i>
                                        Pekerjaan
                                    </label>
                                    <input type="text" name="occupation" id="occupation" value="{{ old('occupation') }}"
                                           placeholder="Masukkan pekerjaan"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('occupation') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('occupation')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Pendidikan -->
                                <div>
                                    <label for="education" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-graduation-cap text-green-500 mr-1"></i>
                                        Pendidikan
                                    </label>
                                    <input type="text" name="education" id="education" value="{{ old('education') }}"
                                           placeholder="Masukkan pendidikan terakhir"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('education') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('education')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Kontak -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="w-6 h-6 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-purple-600 text-xs"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Data Kontak</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Telepon -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-phone text-purple-500 mr-1"></i>
                                        Telepon
                                    </label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                           placeholder="Masukkan nomor telepon"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('phone') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-envelope text-purple-500 mr-1"></i>
                                        Email
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                           placeholder="Masukkan alamat email"
                                           class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('email') border-red-500 ring-2 ring-red-200 @enderror">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-toggle-on text-purple-500 mr-1"></i>
                                        Status *
                                    </label>
                                    <select name="is_active" id="is_active" class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('is_active') border-red-500 ring-2 ring-red-200 @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Alamat -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-orange-600 text-xs"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Data Alamat</h4>
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-home text-orange-500 mr-1"></i>
                                    Alamat Lengkap *
                                </label>
                                <textarea name="address" id="address" rows="4"
                                          placeholder="Masukkan alamat lengkap"
                                          class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none @error('address') border-red-500 ring-2 ring-red-200 @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
                            <!-- Tombol Batal -->
                            <a href="{{ route('admin.citizens.index') }}"
                               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>

                            <!-- Tombol Simpan -->
                            <button type="submit" id="submitBtn"
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-save mr-2" id="submitIcon"></i>
                                <span id="submitText">Simpan Data</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pop-up Form -->
    <div id="formModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-user-plus text-blue-600 mr-2"></i>
                        Form Tambah Data Penduduk
                    </h3>
                    <button type="button" onclick="closeFormModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="mt-4 max-h-96 overflow-y-auto">
                    <p class="text-gray-600 mb-4">Silakan isi form di bawah ini untuk menambahkan data penduduk baru. Pastikan semua data yang dimasukkan akurat dan lengkap.</p>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <span class="text-blue-800 font-medium">Informasi:</span>
                        </div>
                        <p class="text-blue-700 mt-2 text-sm">
                            Form lengkap tersedia di halaman ini. Anda dapat menggunakan form di bawah atau menggunakan modal ini sebagai referensi.
                        </p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end pt-4 border-t border-gray-200 mt-4">
                    <button type="button" onclick="closeFormModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors mr-2">
                        Tutup
                    </button>
                    <button type="button" onclick="scrollToForm()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Ke Form Utama
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openFormModal() {
            document.getElementById('formModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeFormModal() {
            document.getElementById('formModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function scrollToForm() {
            closeFormModal();
            document.querySelector('form').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Close modal when clicking outside
        document.getElementById('formModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFormModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFormModal();
            }
        });

        // Form submission handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            const submitIcon = document.getElementById('submitIcon');
            const submitText = document.getElementById('submitText');

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Show loading state
                    submitBtn.disabled = true;
                    submitIcon.className = 'fas fa-spinner fa-spin mr-2';
                    submitText.textContent = 'Menyimpan...';

                    // Basic validation
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                        } else {
                            field.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                        }
                    });

                    // Validate NIK length
                    const nikField = document.getElementById('nik');
                    if (nikField && nikField.value.length !== 16) {
                        isValid = false;
                        nikField.classList.add('border-red-500', 'ring-2', 'ring-red-200');

                        // Show error message
                        let errorMsg = nikField.parentNode.querySelector('.nik-error');
                        if (!errorMsg) {
                            errorMsg = document.createElement('p');
                            errorMsg.className = 'mt-2 text-sm text-red-600 flex items-center nik-error';
                            errorMsg.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>NIK harus 16 digit';
                            nikField.parentNode.appendChild(errorMsg);
                        }
                    } else if (nikField) {
                        nikField.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                        const errorMsg = nikField.parentNode.querySelector('.nik-error');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }

                    if (!isValid) {
                        e.preventDefault();
                        // Reset button state
                        submitBtn.disabled = false;
                        submitIcon.className = 'fas fa-save mr-2';
                        submitText.textContent = 'Simpan Data';

                        // Scroll to first error
                        const firstError = form.querySelector('.border-red-500');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstError.focus();
                        }
                    }
                });
            }

            // NIK input formatting
            const nikInput = document.getElementById('nik');
            if (nikInput) {
                nikInput.addEventListener('input', function(e) {
                    // Only allow numbers
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');

                    // Limit to 16 characters
                    if (e.target.value.length > 16) {
                        e.target.value = e.target.value.slice(0, 16);
                    }
                });
            }

            // Phone input formatting
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    // Only allow numbers, +, -, and spaces
                    e.target.value = e.target.value.replace(/[^0-9+\-\s]/g, '');
                });
            }

            // Photo preview functionality
            function previewPhoto(input) {
                const previewContainer = document.getElementById('photo-preview');
                
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    
                    // Validasi tipe file
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Hanya file JPG, JPEG, dan PNG yang diperbolehkan!');
                        input.value = '';
                        return;
                    }
                    
                    // Validasi ukuran file (2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file tidak boleh lebih dari 2MB!');
                        input.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-16 h-16 object-cover rounded-lg border border-gray-300">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                     previewContainer.innerHTML = '<img src="{{ asset("images/default-avatar.svg") }}" alt="Default Avatar" class="w-16 h-16 text-gray-400">';
                 }
             }
 
             // Photo input event listener
             const photoInput = document.getElementById('photo');
             if (photoInput) {
                 photoInput.addEventListener('change', function(e) {
                     previewPhoto(this);
                 });
             }
        });
    </script>
</x-admin-layout>