<section>
    <header>
        <h2 class="text-lg font-semibold mb-2" style="color: #003566;">
            <i class="fas fa-lock mr-2"></i>
            Ubah Password
        </h2>

        <p class="text-sm text-gray-600 mb-6">
            Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-key mr-1"></i>
                Password Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                   style="focus:ring-color: #003566;" 
                   autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-lock mr-1"></i>
                Password Baru
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                   style="focus:ring-color: #003566;" 
                   autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-check-circle mr-1"></i>
                Konfirmasi Password Baru
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                   style="focus:ring-color: #003566;" 
                   autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Password Requirements -->
        <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
            <h4 class="text-sm font-medium text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-1"></i>
                Persyaratan Password:
            </h4>
            <ul class="text-xs text-blue-700 space-y-1">
                <li><i class="fas fa-check mr-1"></i> Minimal 8 karakter</li>
                <li><i class="fas fa-check mr-1"></i> Kombinasi huruf besar dan kecil</li>
                <li><i class="fas fa-check mr-1"></i> Minimal 1 angka</li>
                <li><i class="fas fa-check mr-1"></i> Minimal 1 karakter khusus</li>
            </ul>
        </div>

        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2" style="background-color: #003566; focus:ring-color: #003566;">
                <i class="fas fa-save mr-2"></i>
                Ubah Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600">
                    <i class="fas fa-check-circle mr-1"></i>
                    Password berhasil diubah!
                </p>
            @endif
        </div>
    </form>
</section>
