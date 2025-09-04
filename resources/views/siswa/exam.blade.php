<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ujian Online') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Timer and Progress -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary-900 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600">Waktu Tersisa:</span>
                                <span id="timer" class="ml-2 text-lg font-bold text-primary-900">{{ sprintf('%02d:%02d', session('exam_duration', 30), 0) }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-primary-900 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-600">Soal:</span>
                                <span class="ml-2 text-lg font-bold text-primary-900">{{ $questions->count() }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Progress</p>
                            <p class="text-lg font-bold text-primary-900"><span id="answered-count">0</span>/{{ $questions->count() }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progress-bar" class="bg-primary-900 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Question Navigation Panel -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Navigasi Soal</h3>
                            <div class="grid grid-cols-5 gap-2 mb-4">
                                @foreach($questions as $index => $question)
                                    <button type="button" 
                                            onclick="showQuestion({{ $index + 1 }})" 
                                            id="nav-btn-{{ $index + 1 }}"
                                            class="nav-button w-10 h-10 text-sm font-medium rounded-lg border-2 transition-all duration-200
                                                   {{ $index === 0 ? 'bg-primary-900 text-white border-primary-900' : 'bg-white text-gray-700 border-gray-300 hover:border-primary-500' }}">
                                        {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>
                            
                            <!-- Legend -->
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-primary-900 rounded mr-2"></div>
                                    <span class="text-gray-600">Sedang dikerjakan</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                                    <span class="text-gray-600">Sudah dijawab</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-yellow-500 rounded mr-2"></div>
                                    <span class="text-gray-600">Ditandai untuk review</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-gray-300 rounded mr-2"></div>
                                    <span class="text-gray-600">Belum dijawab</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Content -->
                <div class="lg:col-span-3">
                    <form id="exam-form" action="{{ route('student.exam.submit') }}" method="POST">
                        @csrf
                        
                        @foreach($questions as $index => $question)
                            <div class="question-container {{ $index === 0 ? '' : 'hidden' }}" id="question-{{ $index + 1 }}">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 text-gray-900">
                                        <div class="flex items-start justify-between mb-6">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-primary-900 text-white rounded-full flex items-center justify-center text-lg font-bold">
                                                    {{ $index + 1 }}
                                                </div>
                                                <h3 class="text-xl font-medium text-gray-900">
                                                    Soal {{ $index + 1 }} dari {{ $questions->count() }}
                                                </h3>
                                            </div>
                                            <button type="button" 
                                                    onclick="toggleMark({{ $index + 1 }})" 
                                                    id="mark-btn-{{ $index + 1 }}"
                                                    class="mark-button flex items-center px-3 py-2 text-sm font-medium rounded-lg border-2 transition-all duration-200 border-yellow-300 text-yellow-700 hover:bg-yellow-50">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Tandai untuk Review
                                            </button>
                                        </div>
                                        
                                        <div class="mb-6">
                                            <p class="text-lg text-gray-900 leading-relaxed">
                                                {{ $question->question_text }}
                                            </p>
                                        </div>
                                        
                                        <div class="space-y-3">
                                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150 answer-option">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}]" 
                                                       value="a" 
                                                       class="form-radio h-5 w-5 text-primary-900 focus:ring-primary-500 border-gray-300" 
                                                       onchange="updateAnswerStatus({{ $index + 1 }})">
                                                <span class="ml-4 text-gray-900">
                                                    <span class="font-medium text-primary-900 text-lg">A.</span> 
                                                    <span class="text-lg">{{ $question->option_a }}</span>
                                                </span>
                                            </label>
                                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150 answer-option">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}]" 
                                                       value="b" 
                                                       class="form-radio h-5 w-5 text-primary-900 focus:ring-primary-500 border-gray-300" 
                                                       onchange="updateAnswerStatus({{ $index + 1 }})">
                                                <span class="ml-4 text-gray-900">
                                                    <span class="font-medium text-primary-900 text-lg">B.</span> 
                                                    <span class="text-lg">{{ $question->option_b }}</span>
                                                </span>
                                            </label>
                                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150 answer-option">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}]" 
                                                       value="c" 
                                                       class="form-radio h-5 w-5 text-primary-900 focus:ring-primary-500 border-gray-300" 
                                                       onchange="updateAnswerStatus({{ $index + 1 }})">
                                                <span class="ml-4 text-gray-900">
                                                    <span class="font-medium text-primary-900 text-lg">C.</span> 
                                                    <span class="text-lg">{{ $question->option_c }}</span>
                                                </span>
                                            </label>
                                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150 answer-option">
                                                <input type="radio" 
                                                       name="answers[{{ $question->id }}]" 
                                                       value="d" 
                                                       class="form-radio h-5 w-5 text-primary-900 focus:ring-primary-500 border-gray-300" 
                                                       onchange="updateAnswerStatus({{ $index + 1 }})">
                                                <span class="ml-4 text-gray-900">
                                                    <span class="font-medium text-primary-900 text-lg">D.</span> 
                                                    <span class="text-lg">{{ $question->option_d }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Navigation Buttons -->
                                <div class="mt-6 flex items-center justify-between">
                                    <button type="button" 
                                            onclick="previousQuestion()" 
                                            id="prev-btn"
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 {{ $index === 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                            {{ $index === 0 ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Sebelumnya
                                    </button>
                                    
                                    <div class="flex space-x-3">
                                        @if($index < count($questions) - 1)
                                            <button type="button" 
                                                    onclick="nextQuestion()" 
                                                    class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-950 focus:bg-primary-950 active:bg-primary-950 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Selanjutnya
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="button" 
                                                    onclick="confirmSubmit()" 
                                                    class="inline-flex items-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                Kirim Ujian
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Pengiriman Ujian</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin mengirim ujian? Setelah dikirim, jawaban tidak dapat diubah lagi.
                    </p>
                    <p class="text-sm text-gray-700 mt-2 font-medium">
                        Soal terjawab: <span id="modal-answered-count">0</span>/{{ $questions->count() }}
                    </p>
                    <p class="text-sm text-gray-700 mt-1 font-medium">
                        Soal ditandai: <span id="modal-marked-count">0</span>
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-submit" class="px-4 py-2 bg-primary-900 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-primary-950 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        Ya, Kirim Ujian
                    </button>
                    <button onclick="closeModal()" class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentQuestion = 1;
        const totalQuestions = {{ $questions->count() }};
        let timeLeft = {{ session('exam_duration', 30) }} * 60; // exam duration in seconds from settings
        let markedQuestions = new Set();
        
        // Timer functionality
        const timerElement = document.getElementById('timer');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                alert('Waktu ujian telah habis! Ujian akan dikirim otomatis.');
                document.getElementById('exam-form').submit();
                return;
            }
            
            if (timeLeft <= 300) { // 5 minutes warning
                timerElement.classList.add('text-red-600');
                timerElement.classList.remove('text-primary-900');
            }
            
            timeLeft--;
        }
        
        // Start timer
        const timerInterval = setInterval(updateTimer, 1000);
        
        // Question navigation
        function showQuestion(questionNumber) {
            // Hide current question
            document.getElementById(`question-${currentQuestion}`).classList.add('hidden');
            
            // Update navigation buttons
            document.getElementById(`nav-btn-${currentQuestion}`).classList.remove('bg-primary-900', 'text-white', 'border-primary-900');
            document.getElementById(`nav-btn-${currentQuestion}`).classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            
            // Show new question
            currentQuestion = questionNumber;
            document.getElementById(`question-${currentQuestion}`).classList.remove('hidden');
            
            // Update navigation button
            document.getElementById(`nav-btn-${currentQuestion}`).classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
            document.getElementById(`nav-btn-${currentQuestion}`).classList.add('bg-primary-900', 'text-white', 'border-primary-900');
            
            // Update navigation buttons state
            updateNavigationButtons();
        }
        
        function nextQuestion() {
            if (currentQuestion < totalQuestions) {
                showQuestion(currentQuestion + 1);
            }
        }
        
        function previousQuestion() {
            if (currentQuestion > 1) {
                showQuestion(currentQuestion - 1);
            }
        }
        
        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prev-btn');
            if (currentQuestion === 1) {
                prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
                prevBtn.disabled = true;
            } else {
                prevBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                prevBtn.disabled = false;
            }
        }
        
        // Mark question for review
        function toggleMark(questionNumber) {
            const markBtn = document.getElementById(`mark-btn-${questionNumber}`);
            const navBtn = document.getElementById(`nav-btn-${questionNumber}`);
            
            if (markedQuestions.has(questionNumber)) {
                // Unmark
                markedQuestions.delete(questionNumber);
                markBtn.classList.remove('bg-yellow-100', 'border-yellow-500', 'text-yellow-800');
                markBtn.classList.add('border-yellow-300', 'text-yellow-700');
                markBtn.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tandai untuk Review
                `;
                
                // Update nav button if not answered
                if (!isQuestionAnswered(questionNumber)) {
                    navBtn.classList.remove('bg-yellow-500');
                    navBtn.classList.add('bg-gray-300');
                }
            } else {
                // Mark
                markedQuestions.add(questionNumber);
                markBtn.classList.add('bg-yellow-100', 'border-yellow-500', 'text-yellow-800');
                markBtn.classList.remove('border-yellow-300', 'text-yellow-700');
                markBtn.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"></path>
                    </svg>
                    Ditandai
                `;
                
                // Update nav button if not answered
                if (!isQuestionAnswered(questionNumber)) {
                    navBtn.classList.remove('bg-gray-300');
                    navBtn.classList.add('bg-yellow-500');
                }
            }
        }
        
        // Check if question is answered
        function isQuestionAnswered(questionNumber) {
            const questionContainer = document.getElementById(`question-${questionNumber}`);
            const radioButtons = questionContainer.querySelectorAll('input[type="radio"]');
            return Array.from(radioButtons).some(radio => radio.checked);
        }
        
        // Update answer status
        function updateAnswerStatus(questionNumber) {
            const navBtn = document.getElementById(`nav-btn-${questionNumber}`);
            
            // Remove all status classes
            navBtn.classList.remove('bg-gray-300', 'bg-yellow-500', 'bg-green-500');
            
            // Add answered status
            navBtn.classList.add('bg-green-500', 'text-white', 'border-green-500');
            
            updateProgress();
        }
        
        // Progress tracking
        function updateProgress() {
            const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
            const percentage = (answeredQuestions / totalQuestions) * 100;
            
            document.getElementById('answered-count').textContent = answeredQuestions;
            document.getElementById('progress-bar').style.width = percentage + '%';
        }
        
        // Modal functions
        function confirmSubmit() {
            const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
            document.getElementById('modal-answered-count').textContent = answeredQuestions;
            document.getElementById('modal-marked-count').textContent = markedQuestions.size;
            document.getElementById('confirmation-modal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('confirmation-modal').classList.add('hidden');
        }
        
        // Confirm submit button
        document.getElementById('confirm-submit').addEventListener('click', function() {
            clearInterval(timerInterval);
            document.getElementById('exam-form').submit();
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && currentQuestion > 1) {
                previousQuestion();
            } else if (e.key === 'ArrowRight' && currentQuestion < totalQuestions) {
                nextQuestion();
            }
        });
        
        // Prevent accidental page refresh
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = 'Apakah Anda yakin ingin meninggalkan halaman? Jawaban ujian akan hilang.';
        });
        
        // Initialize
        updateNavigationButtons();
    </script>
</x-app-layout>