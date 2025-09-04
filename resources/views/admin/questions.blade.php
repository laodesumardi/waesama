<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Soal') }}
            </h2>
            <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-950 focus:bg-primary-950 active:bg-primary-950 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah Soal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($questions->count() > 0)
                        <div class="space-y-6">
                            @foreach($questions as $index => $question)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Soal #{{ $questions->firstItem() + $index }}
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                            Jawaban: {{ strtoupper($question->correct_answer) }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-gray-900 font-medium mb-3">{{ $question->question_text }}</p>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <div class="flex items-center p-2 rounded {{ $question->correct_answer == 'a' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                                                <span class="font-semibold text-sm mr-2 {{ $question->correct_answer == 'a' ? 'text-green-700' : 'text-gray-700' }}">A.</span>
                                                <span class="text-sm {{ $question->correct_answer == 'a' ? 'text-green-700' : 'text-gray-700' }}">{{ $question->option_a }}</span>
                                            </div>
                                            
                                            <div class="flex items-center p-2 rounded {{ $question->correct_answer == 'b' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                                                <span class="font-semibold text-sm mr-2 {{ $question->correct_answer == 'b' ? 'text-green-700' : 'text-gray-700' }}">B.</span>
                                                <span class="text-sm {{ $question->correct_answer == 'b' ? 'text-green-700' : 'text-gray-700' }}">{{ $question->option_b }}</span>
                                            </div>
                                            
                                            <div class="flex items-center p-2 rounded {{ $question->correct_answer == 'c' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                                                <span class="font-semibold text-sm mr-2 {{ $question->correct_answer == 'c' ? 'text-green-700' : 'text-gray-700' }}">C.</span>
                                                <span class="text-sm {{ $question->correct_answer == 'c' ? 'text-green-700' : 'text-gray-700' }}">{{ $question->option_c }}</span>
                                            </div>
                                            
                                            <div class="flex items-center p-2 rounded {{ $question->correct_answer == 'd' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                                                <span class="font-semibold text-sm mr-2 {{ $question->correct_answer == 'd' ? 'text-green-700' : 'text-gray-700' }}">D.</span>
                                                <span class="text-sm {{ $question->correct_answer == 'd' ? 'text-green-700' : 'text-gray-700' }}">{{ $question->option_d }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs text-gray-500">
                                        Dibuat: {{ $question->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $questions->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada soal</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan soal pertama.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-950 focus:bg-primary-950 active:bg-primary-950 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Tambah Soal
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>