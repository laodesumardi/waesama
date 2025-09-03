<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold mb-2" style="color: #dc2626;">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Hapus Akun
        </h2>

        <div class="bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Peringatan: Tindakan ini tidak dapat dibatalkan!
                    </h3>
                    <p class="mt-2 text-sm text-red-700">
                        Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. 
                        Sebelum menghapus akun, silakan unduh data atau informasi yang ingin Anda simpan.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <button type="button" 
            x-data="" 
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        <i class="fas fa-trash-alt mr-2"></i>
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h2 class="text-lg font-medium text-gray-900">
                        Apakah Anda yakin ingin menghapus akun?
                    </h2>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                <p class="text-sm text-red-700">
                    <strong>Peringatan:</strong> Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. 
                    Masukkan password Anda untuk mengkonfirmasi bahwa Anda ingin menghapus akun secara permanen.
                </p>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-key mr-1"></i>
                    Konfirmasi Password
                </label>
                <input id="password" name="password" type="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" 
                       style="focus:ring-color: #dc2626;" 
                       placeholder="Masukkan password Anda">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" 
                        x-on:click="$dispatch('close')"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>

                <button type="submit" 
                         class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                     <i class="fas fa-trash-alt mr-2"></i>
                     Hapus Akun
                 </button>
            </div>
        </form>
    </x-modal>
</section>
