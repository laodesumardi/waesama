<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Soal Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.questions.store') }}">
                        @csrf

                        <!-- Question Text -->
                        <div class="mb-6">
                            <x-input-label for="question_text" :value="__('Pertanyaan')" />
                            <textarea id="question_text" name="question_text" rows="4" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>{{ old('question_text') }}</textarea>
                            <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
                        </div>

                        <!-- Option A -->
                        <div class="mb-4">
                            <x-input-label for="option_a" :value="__('Pilihan A')" />
                            <x-text-input id="option_a" class="block mt-1 w-full" type="text" name="option_a" :value="old('option_a')" required />
                            <x-input-error :messages="$errors->get('option_a')" class="mt-2" />
                        </div>

                        <!-- Option B -->
                        <div class="mb-4">
                            <x-input-label for="option_b" :value="__('Pilihan B')" />
                            <x-text-input id="option_b" class="block mt-1 w-full" type="text" name="option_b" :value="old('option_b')" required />
                            <x-input-error :messages="$errors->get('option_b')" class="mt-2" />
                        </div>

                        <!-- Option C -->
                        <div class="mb-4">
                            <x-input-label for="option_c" :value="__('Pilihan C')" />
                            <x-text-input id="option_c" class="block mt-1 w-full" type="text" name="option_c" :value="old('option_c')" required />
                            <x-input-error :messages="$errors->get('option_c')" class="mt-2" />
                        </div>

                        <!-- Option D -->
                        <div class="mb-4">
                            <x-input-label for="option_d" :value="__('Pilihan D')" />
                            <x-text-input id="option_d" class="block mt-1 w-full" type="text" name="option_d" :value="old('option_d')" required />
                            <x-input-error :messages="$errors->get('option_d')" class="mt-2" />
                        </div>

                        <!-- Correct Answer -->
                        <div class="mb-6">
                            <x-input-label for="correct_answer" :value="__('Jawaban Benar')" />
                            <select id="correct_answer" name="correct_answer" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                <option value="">Pilih jawaban yang benar</option>
                                <option value="a" {{ old('correct_answer') == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('correct_answer') == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('correct_answer') == 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('correct_answer') == 'd' ? 'selected' : '' }}>D</option>
                            </select>
                            <x-input-error :messages="$errors->get('correct_answer')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('admin.questions') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kembali
                            </a>
                            
                            <x-primary-button class="bg-primary-900 hover:bg-primary-950 focus:bg-primary-950 active:bg-primary-950 focus:ring-primary-500">
                                {{ __('Tambah Soal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>