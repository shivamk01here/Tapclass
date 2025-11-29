@extends('layouts.ai')

@section('title', 'Attempt Test - ' . $test->exam_context)

@section('content')
<div class="h-[calc(100vh-80px)] flex flex-col" x-data="examEngine()">
    
    <!-- Mode Selection Modal -->
    <div x-show="!examStarted" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm">
        <div class="bg-gray-900 border border-white/10 rounded-xl p-8 max-w-2xl w-full mx-4 shadow-2xl">
            <h2 class="text-3xl font-heading text-white mb-2 uppercase">Select Exam Mode</h2>
            <p class="text-gray-400 mb-8">Choose how you want to attempt this mock test.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Normal Mode -->
                <button @click="startExam('normal')" class="group relative p-6 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 transition-all text-left">
                    <div class="absolute top-4 right-4 text-gray-500 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-3xl">school</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Normal Mode</h3>
                    <p class="text-sm text-gray-400">Standard practice mode. You can switch tabs, take breaks, and review answers freely.</p>
                </button>

                <!-- Exam Hall Mode -->
                <button @click="startExam('strict')" class="group relative p-6 rounded-xl border border-red-500/30 bg-red-900/10 hover:bg-red-900/20 transition-all text-left">
                    <div class="absolute top-4 right-4 text-red-500">
                        <span class="material-symbols-outlined text-3xl">security</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Exam Hall Mode</h3>
                    <p class="text-sm text-gray-400">Strict environment. Fullscreen enforced. No tab switching. No copy-paste. Simulates real exam pressure.</p>
                </button>
            </div>
        </div>
    </div>

    <!-- Exam Interface -->
    <div x-show="examStarted" class="flex-grow flex flex-col max-w-6xl mx-auto w-full px-4 py-6" style="display: none;">
        
        <!-- Header: Timer & Progress -->
        <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
            <div>
                <h1 class="font-heading text-xl uppercase text-white">{{ $test->exam_context }} Mock Test</h1>
                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                    <span class="px-2 py-0.5 rounded bg-white/10">{{ $test->subject }}</span>
                    <span>•</span>
                    <span>{{ $test->topic }}</span>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Timer -->
                <div class="flex items-center gap-2 text-accent-yellow font-mono text-xl">
                    <span class="material-symbols-outlined">timer</span>
                    <span x-text="formatTime(timeLeft)"></span>
                </div>
                
                <button @click="requestSubmit()" class="px-6 py-2 bg-white text-black font-bold uppercase text-sm tracking-widest hover:bg-gray-200 transition-colors rounded">
                    Submit Test
                </button>
            </div>
        </div>

        <!-- Main Content: Question & Palette -->
        <div class="flex-grow flex gap-8 overflow-hidden">
            
            <!-- Question Area -->
            <div class="flex-grow flex flex-col">
                <!-- Question Card -->
                <div class="bg-white/5 border border-white/10 rounded-xl p-8 flex-grow overflow-y-auto custom-scrollbar relative">
                    
                    <!-- Question Number -->
                    <div class="absolute top-0 left-0 bg-white/10 px-4 py-2 rounded-br-xl text-xs font-bold text-gray-300">
                        Question <span x-text="currentQuestionIndex + 1"></span> of <span x-text="totalCount"></span>
                    </div>

                    <div class="mt-8">
                        <template x-if="currentQuestion">
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-white mb-8 leading-relaxed" x-text="currentQuestion.question"></h2>

                                <div class="space-y-3">
                                    <template x-for="(option, index) in currentQuestion.options" :key="index">
                                        <label class="flex items-center p-4 rounded-lg border cursor-pointer transition-all group"
                                            @click.prevent="selectAnswer(index)"
                                            :class="answers[currentQuestionIndex] === index ? 'border-accent-yellow bg-accent-yellow/10' : 'border-white/10 bg-black/20 hover:bg-white/5'">
                                            
                                            <input type="radio" :name="'q'+currentQuestionIndex" :value="index" 
                                                :checked="answers[currentQuestionIndex] === index" class="hidden">
                                            
                                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-4 transition-colors"
                                                :class="answers[currentQuestionIndex] === index ? 'border-accent-yellow text-accent-yellow' : 'border-gray-600 text-transparent group-hover:border-gray-400'">
                                                <div class="w-2.5 h-2.5 rounded-full bg-current" x-show="answers[currentQuestionIndex] === index"></div>
                                            </div>
                                            
                                            <span class="text-gray-300 group-hover:text-white" x-text="option"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Loading State for Current Question (if somehow index > length) -->
                        <template x-if="!currentQuestion">
                            <div class="flex flex-col items-center justify-center h-64 text-gray-500">
                                <span class="material-symbols-outlined text-4xl animate-spin mb-4">sync</span>
                                <p>Loading Question...</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between mt-6">
                    <button @click="prevQuestion()" :disabled="currentQuestionIndex === 0" 
                        class="px-6 py-3 rounded border border-white/10 text-white font-bold uppercase text-xs tracking-widest hover:bg-white/5 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span> Previous
                    </button>

                    <button @click="nextQuestion()" :disabled="currentQuestionIndex >= questions.length - 1 && currentQuestionIndex >= totalCount - 1"
                        class="px-6 py-3 rounded bg-white text-black font-bold uppercase text-xs tracking-widest hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                        Next <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </div>
            </div>

            <!-- Question Palette (Sidebar) -->
            <div class="w-64 flex-shrink-0 hidden md:flex flex-col bg-white/5 border border-white/10 rounded-xl p-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Question Palette</h3>
                
                <div class="grid grid-cols-4 gap-2 content-start overflow-y-auto custom-scrollbar pr-1">
                    <template x-for="i in totalCount" :key="i">
                        <button @click="goToQuestion(i-1)" 
                            :disabled="i-1 >= questions.length"
                            class="aspect-square rounded flex items-center justify-center text-xs font-bold transition-all border relative overflow-hidden"
                            :class="{
                                'bg-accent-yellow text-black border-accent-yellow': currentQuestionIndex === i-1,
                                'bg-green-600 text-white border-green-600': answers[i-1] !== undefined && currentQuestionIndex !== i-1,
                                'bg-white/5 text-gray-400 border-white/10 hover:bg-white/10': answers[i-1] === undefined && currentQuestionIndex !== i-1 && i-1 < questions.length,
                                'bg-blue-900/20 text-blue-400 border-blue-500/30 cursor-wait': i-1 >= questions.length
                            }">
                            <span x-text="i"></span>
                            
                            <!-- Loading Pulse -->
                            <div x-show="i-1 >= questions.length" class="absolute inset-0 bg-blue-500/10 animate-pulse"></div>
                        </button>
                    </template>
                </div>

                <div class="mt-auto pt-4 border-t border-white/10 text-xs text-gray-500 space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-green-600"></div> <span>Answered</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-accent-yellow"></div> <span>Current</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-blue-900/50 border border-blue-500/30"></div> <span>Generating...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Confirmation Modal -->
    <div x-show="showSubmitModal" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/90 backdrop-blur-sm" x-transition>
        <div class="bg-gray-900 border border-white/10 rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl text-center">
            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 text-accent-yellow">
                <span class="material-symbols-outlined text-3xl">flag</span>
            </div>
            
            <h2 class="text-2xl font-bold text-white mb-2">Submit Test?</h2>
            <p class="text-gray-400 mb-8 text-sm">
                You have answered <span class="text-white font-bold" x-text="Object.keys(answers).length"></span> out of <span class="text-white font-bold" x-text="totalCount"></span> questions.
                <br>Once submitted, you cannot change your answers.
            </p>

            <div class="flex gap-3">
                <button @click="confirmSubmit()" class="flex-1 bg-white text-black font-bold py-3 rounded hover:bg-gray-200 transition-colors text-xs uppercase tracking-wider">
                    Yes, Submit
                </button>
                <button @click="showSubmitModal = false" class="flex-1 bg-white/5 text-white font-bold py-3 rounded hover:bg-white/10 transition-colors text-xs uppercase tracking-wider">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Submission -->
    <form id="submitForm" action="{{ route('ai-test.submit', $test->uuid) }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="answers" :value="JSON.stringify(answers)">
        <input type="hidden" name="time_taken" :value="timeTaken">
    </form>

</div>

<script>
    function examEngine() {
        return {
            examStarted: false,
            mode: 'normal',
            questions: @json(json_decode($test->questions_json, true)['questions'] ?? []),
            totalCount: {{ json_decode($test->questions_json, true)['total_count'] ?? 20 }},
            currentQuestionIndex: 0,
            answers: {},
            timeLeft: {{ ($test->duration ?? 30) * 60 }},
            timeTaken: 0,
            timerInterval: null,
            status: '{{ $test->status }}',
            pollInterval: null,
            showSubmitModal: false,

            get currentQuestion() {
                return this.questions[this.currentQuestionIndex];
            },

            init() {
                if (this.status === 'processing' || this.status === 'pending') {
                    this.startPolling();
                }
            },

            startExam(selectedMode) {
                this.mode = selectedMode;
                this.examStarted = true;
                this.startTimer();

                if (this.mode === 'strict') {
                    this.enterFullscreen();
                    this.enableAntiCheat();
                }
            },

            startPolling() {
                this.pollInterval = setInterval(() => {
                    fetch('{{ route('ai-test.questions', $test->uuid) }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.questions && data.questions.length > this.questions.length) {
                                const newQuestions = data.questions.slice(this.questions.length);
                                this.questions.push(...newQuestions);
                            }
                            
                            if (data.status === 'completed' || data.status === 'failed') {
                                clearInterval(this.pollInterval);
                                this.status = data.status;
                            }
                        });
                }, 3000);
            },

            goToQuestion(index) {
                if (index < this.questions.length) {
                    this.currentQuestionIndex = index;
                }
            },

            nextQuestion() {
                if (this.currentQuestionIndex < this.questions.length - 1) {
                    this.currentQuestionIndex++;
                }
            },

            prevQuestion() {
                if (this.currentQuestionIndex > 0) {
                    this.currentQuestionIndex--;
                }
            },

            selectAnswer(optionIndex) {
                this.answers[this.currentQuestionIndex] = optionIndex;
            },

            startTimer() {
                this.timerInterval = setInterval(() => {
                    if (this.timeLeft > 0) {
                        this.timeLeft--;
                        this.timeTaken++;
                    } else {
                        this.confirmSubmit(); // Auto submit
                    }
                }, 1000);
            },

            formatTime(seconds) {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            },

            enterFullscreen() {
                const elem = document.documentElement;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) { /* Safari */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) { /* IE11 */
                    elem.msRequestFullscreen();
                }
            },

            exitFullscreen() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            },

            enableAntiCheat() {
                document.addEventListener('copy', (e) => e.preventDefault());
                document.addEventListener('paste', (e) => e.preventDefault());
                document.addEventListener('contextmenu', (e) => e.preventDefault());

                document.addEventListener('visibilitychange', () => {
                    if (document.hidden && this.examStarted && !this.showSubmitModal) {
                        // Only warn if not submitting
                        // alert('WARNING: Tab switching is not allowed!'); 
                        // Native alerts are bad in fullscreen, maybe just log it or show a toast
                        console.log('Tab switch detected');
                    }
                });
            },

            requestSubmit() {
                this.showSubmitModal = true;
            },

            confirmSubmit() {
                // Exit fullscreen if needed
                if (this.mode === 'strict') {
                    this.exitFullscreen();
                }
                document.getElementById('submitForm').submit();
            }
        }
    }
</script>
@endsection
