<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Ujian
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Settings Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-4 sm:p-6">
                <form action="{{ route('admin.exam-settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Exam Duration -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="exam_duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Durasi Ujian (Menit)
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="exam_duration" 
                                       name="exam_duration" 
                                       value="{{ $examDuration }}" 
                                       min="1" 
                                       max="300" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('exam_duration') border-red-500 @enderror"
                                       placeholder="60">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('exam_duration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Waktu yang diberikan untuk menyelesaikan ujian</p>
                        </div>

                        <!-- Questions Per Exam -->
                        <div>
                            <label for="questions_per_exam" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Soal Per Ujian
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="questions_per_exam" 
                                       name="questions_per_exam" 
                                       value="{{ $questionsPerExam }}" 
                                       min="1" 
                                       max="100" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('questions_per_exam') border-red-500 @enderror"
                                       placeholder="10">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('questions_per_exam')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Jumlah soal yang akan ditampilkan dalam setiap ujian</p>
                        </div>
                    </div>

                    <!-- Additional Settings -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Tambahan</h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Passing Score -->
                            <div>
                                <label for="passing_score" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nilai Minimum Lulus (%)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="passing_score" 
                                           name="passing_score" 
                                           value="{{ $passingScore }}" 
                                           min="0" 
                                           max="100" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passing_score') border-red-500 @enderror"
                                           placeholder="70">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-400 text-sm">%</span>
                                    </div>
                                </div>
                                @error('passing_score')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">Persentase minimum untuk dinyatakan lulus</p>
                            </div>

                            <!-- Show Results -->
                            <div>
                                <label for="show_results" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tampilkan Hasil
                                </label>
                                <select id="show_results" 
                                        name="show_results" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('show_results') border-red-500 @enderror">
                                    <option value="immediately" {{ $showResults == 'immediately' ? 'selected' : '' }}>Langsung Setelah Ujian</option>
                                    <option value="after_all" {{ $showResults == 'after_all' ? 'selected' : '' }}>Setelah Semua Siswa Selesai</option>
                                    <option value="manual" {{ $showResults == 'manual' ? 'selected' : '' }}>Manual oleh Admin</option>
                                </select>
                                @error('show_results')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">Kapan hasil ujian ditampilkan kepada siswa</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200">
                        <button type="button" 
                                onclick="window.location.href='{{ route('admin.dashboard') }}'" 
                                class="w-full sm:w-auto px-4 py-2 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-medium">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Current Settings Info -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-blue-800 font-medium mb-1">Informasi Pengaturan Saat Ini</h4>
                    <div class="text-blue-700 text-sm space-y-1">
                        <p>• Durasi ujian: <strong>{{ $examDuration }} menit</strong></p>
                        <p>• Jumlah soal: <strong>{{ $questionsPerExam }} soal</strong></p>
                        <p>• Nilai minimum lulus: <strong>{{ $passingScore }}%</strong></p>
                        <p>• Tampilkan hasil: <strong>
                            @if($showResults == 'immediately') Langsung setelah ujian
                            @elseif($showResults == 'after_all') Setelah semua siswa selesai
                            @else Manual oleh admin
                            @endif
                        </strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>