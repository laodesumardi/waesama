<x-guest-layout>
    <div class="register-form-container min-h-screen flex">
        <!-- Left side - Logo and Info -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-indigo-700 items-center justify-center p-12">
            <div class="text-center text-white">
                <img src="{{ asset('images/logo-kantor-camat.svg') }}" alt="Logo Kantor Camat" class="w-32 h-32 mx-auto mb-8">
                <h1 class="text-4xl font-bold mb-4">Sistem Manajemen Kantor Camat</h1>
                <p class="text-xl opacity-90">Daftar untuk mengakses layanan administrasi dan manajemen kantor camat</p>
            </div>
        </div>

        <!-- Right side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <img src="{{ asset('images/logo-kantor-camat.svg') }}" alt="Logo Kantor Camat" class="w-20 h-20 mx-auto mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Daftar Akun</h2>
                </div>

                <div class="register-card rounded-lg p-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Data Pribadi Section -->
                        <div class="form-section">
                            <h3 class="form-section-title">Data Pribadi</h3>
                            
                            <!-- Nama Lengkap -->
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- NIK -->
                            <div class="mt-4">
                                <x-input-label for="nik" :value="__('NIK (Nomor Induk Kependudukan)')" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required autocomplete="nik" placeholder="Masukkan 16 digit NIK" maxlength="16" pattern="[0-9]{16}" />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">NIK harus terdiri dari 16 digit angka</p>
                            </div>

                            <!-- Jenis Kelamin dan Tanggal Lahir -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                    <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required />
                                    <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Kontak Section -->
                        <div class="form-section">
                            <h3 class="form-section-title">Informasi Kontak</h3>
                            
                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Alamat Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="mt-4">
                                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="08xxxxxxxxxx" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Alamat -->
                            <div class="mt-4">
                                <x-input-label for="address" :value="__('Alamat Lengkap')" />
                                <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Keamanan Section -->
                        <div class="form-section">
                            <h3 class="form-section-title">Keamanan Akun</h3>
                            
                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Kata Sandi')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Kata sandi harus minimal 8 karakter</p>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-section">
                            <div class="flex items-start space-x-3">
                                <input id="terms" name="terms" type="checkbox" class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required>
                                <label for="terms" class="text-sm text-gray-700 leading-relaxed">
                                    Saya menyetujui <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">syarat dan ketentuan</a> serta <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">kebijakan privasi</a> yang berlaku di Sistem Manajemen Kantor Camat
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                        </div>

                        <div class="flex flex-col space-y-4 mt-6">
                            <x-primary-button class="w-full justify-center py-3 text-base font-medium">
                                Daftar Akun
                            </x-primary-button>
                            
                            <div class="text-center">
                                <span class="text-sm text-gray-600">Sudah memiliki akun? </span>
                                <a class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" href="{{ route('login') }}">
                                    Masuk di sini
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
