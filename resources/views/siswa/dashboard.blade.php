<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 sm:mb-8">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="text-lg sm:text-2xl font-bold text-primary-900 break-words">Selamat Datang, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600 mt-2 text-sm sm:text-base">Siap untuk mengikuti ujian hari ini?</p>
                        </div>
                        <div class="hidden sm:block">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-2 sm:p-3 rounded-full bg-primary-100 text-primary-900 flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Total Ujian Diikuti</p>
                                <p class="text-xl sm:text-2xl font-bold text-primary-900">{{ $totalExams }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-2 sm:p-3 rounded-full bg-primary-100 text-primary-900 flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Nilai Rata-rata</p>
                                <p class="text-xl sm:text-2xl font-bold text-primary-900">
                                    @if($averageScore > 0)
                                        {{ number_format($averageScore, 1) }}/60
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-2 sm:p-3 rounded-full bg-primary-100 text-primary-900 flex-shrink-0">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-600 truncate">Nilai Tertinggi</p>
                                <p class="text-xl sm:text-2xl font-bold text-primary-900">
                                    @if($highestScore > 0)
                                        {{ $highestScore }}/60
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Exam Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 sm:mb-8">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="text-center">
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Mulai Ujian Baru</h3>
                        <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base px-2 sm:px-0">Ujian terdiri dari {{ $questionsPerExam }} soal pilihan ganda. Pastikan koneksi internet stabil sebelum memulai.</p>
                        
                        @if($canTakeExam)
                            <a href="{{ route('student.exam.start') }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-primary-900 border border-transparent rounded-md font-semibold text-xs sm:text-xs text-white uppercase tracking-widest hover:bg-primary-950 focus:bg-primary-950 active:bg-primary-950 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mulai Ujian
                            </a>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3 sm:p-4 mx-2 sm:mx-0">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-2 sm:ml-3">
                                        <h3 class="text-xs sm:text-sm font-medium text-yellow-800">
                                            Ujian Tidak Tersedia
                                        </h3>
                                        <div class="mt-1 sm:mt-2 text-xs sm:text-sm text-yellow-700">
                                            <p>{{ $examMessage }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Exam History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">Riwayat Ujian</h3>
                        <a href="{{ route('student.history') }}" class="text-primary-900 hover:text-primary-950 text-xs sm:text-sm font-medium">
                            Lihat Semua
                        </a>
                    </div>
                    
                    @if($recentExams->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Skor
                                        </th>
                                        <th scope="col" class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Persentase
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentExams as $exam)
                                        <tr>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                                <div class="hidden sm:block">{{ $exam->completed_at->format('d M Y, H:i') }}</div>
                                                <div class="sm:hidden">{{ $exam->completed_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                                {{ $exam->score }}/60
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($exam->percentage >= 75) bg-green-100 text-green-800
                                                    @elseif($exam->percentage >= 60) bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $exam->percentage }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-6 sm:py-8">
                            <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-xs sm:text-sm font-medium text-gray-900">Belum ada riwayat ujian</h3>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500 px-4 sm:px-0">Mulai ujian pertama Anda untuk melihat riwayat di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>