<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Data Penduduk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Detail Penduduk</h3>
                        <div class="space-x-2">
                            <a href="{{ route('admin.citizens.edit', $citizen) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('admin.citizens.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data Pribadi -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Data Pribadi</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">NIK</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->nik }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Tempat, Tanggal Lahir</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->birth_place }}, {{ \Carbon\Carbon::parse($citizen->birth_date)->format('d F Y') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Umur</label>
                                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($citizen->birth_date)->age }} tahun</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Agama</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->religion }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Status Perkawinan</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->marital_status }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Kontak & Lokasi -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Kontak & Lokasi</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Desa</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->village->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Alamat</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->address }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Telepon</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->phone ?: '-' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Email</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->email ?: '-' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Pekerjaan</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->occupation ?: '-' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Pendidikan</label>
                                    <p class="text-sm text-gray-900">{{ $citizen->education ?: '-' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Status</label>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $citizen->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $citizen->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Sistem -->
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-md font-semibold text-gray-800 mb-4">Informasi Sistem</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Dibuat pada</label>
                                <p class="text-sm text-gray-900">{{ $citizen->created_at->format('d F Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Terakhir diperbarui</label>
                                <p class="text-sm text-gray-900">{{ $citizen->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <form action="{{ route('admin.citizens.destroy', $citizen) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data penduduk ini?')">
                                Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>