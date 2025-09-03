<section>
    <header>
        <h2 class="text-lg font-semibold mb-2" style="color: #003566;">
            <i class="fas fa-user-edit mr-2"></i>
            Informasi Profile
        </h2>

        <p class="text-sm text-gray-600 mb-6">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-1"></i>
                    Nama Lengkap
                </label>
                <input id="name" name="name" type="text" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                       style="focus:ring-color: #003566;" 
                       value="{{ old('name', $user->name) }}" 
                       required autofocus autocomplete="name">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-1"></i>
                    Email
                </label>
                <input id="email" name="email" type="email" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                       style="focus:ring-color: #003566;" 
                       value="{{ old('email', $user->email) }}" 
                       required autocomplete="username">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-800">
                                        Email Anda belum diverifikasi.
                                        <button form="send-verification" class="font-medium underline hover:no-underline" style="color: #003566;">
                                            Klik di sini untuk mengirim ulang email verifikasi.
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 text-sm text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Link verifikasi baru telah dikirim ke alamat email Anda.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Nomor Telepon -->
        <div class="mb-6">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-phone mr-1"></i>
                Nomor Telepon
            </label>
            <input id="phone" name="phone" type="tel" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                   style="focus:ring-color: #003566;" 
                   value="{{ old('phone', $user->phone) }}"
                   placeholder="Masukkan nomor telepon">
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Informasi Kepegawaian (hanya untuk admin dan pegawai) -->
        @if($user->role !== 'masyarakat')
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h4 class="text-sm font-medium text-blue-800 mb-3">
                <i class="fas fa-briefcase mr-2"></i>
                Informasi Kepegawaian
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-id-badge mr-1"></i>
                        ID Pegawai
                    </label>
                    <input id="employee_id" name="employee_id" type="text" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                           style="focus:ring-color: #003566;" 
                           value="{{ old('employee_id', $user->employee_id) }}"
                           placeholder="ID Pegawai">
                    <x-input-error class="mt-1" :messages="$errors->get('employee_id')" />
                </div>
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user-tie mr-1"></i>
                        Jabatan
                    </label>
                    <input id="position" name="position" type="text" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                           style="focus:ring-color: #003566;" 
                           value="{{ old('position', $user->position) }}"
                           placeholder="Jabatan">
                    <x-input-error class="mt-1" :messages="$errors->get('position')" />
                </div>
                <div class="md:col-span-2">
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-building mr-1"></i>
                        Departemen
                    </label>
                    <select id="department" name="department" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                            style="focus:ring-color: #003566;">
                        <option value="">Pilih Departemen</option>
                        <option value="Pimpinan" {{ old('department', $user->department) == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                        <option value="Sekretariat" {{ old('department', $user->department) == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                        <option value="Pelayanan" {{ old('department', $user->department) == 'Pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                        <option value="IT" {{ old('department', $user->department) == 'IT' ? 'selected' : '' }}>IT</option>
                        <option value="Keuangan" {{ old('department', $user->department) == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="Umum" {{ old('department', $user->department) == 'Umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('department')" />
                </div>
            </div>
        </div>
        @endif

        <!-- Informasi Role dan Status -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
            <h4 class="text-sm font-medium text-gray-700 mb-3">
                <i class="fas fa-info-circle mr-2"></i>
                Informasi Akun
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center">
                    <span class="text-gray-500">Role:</span>
                    <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        @if($user->role === 'admin') bg-red-100 text-red-800
                        @elseif($user->role === 'pegawai') bg-green-100 text-green-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500">Status:</span>
                    <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <span class="text-gray-500">Bergabung sejak:</span>
                    <span class="ml-2 font-medium">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2" style="background-color: #003566; focus:ring-color: #003566;">
                <i class="fas fa-save mr-2"></i>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600">
                    <i class="fas fa-check-circle mr-1"></i>
                    Profil berhasil diperbarui!
                </p>
            @endif
        </div>
    </form>
</section>
