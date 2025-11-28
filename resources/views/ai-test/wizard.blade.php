@extends('layouts.public')

@section('title', 'Create AI Mock Test - HTC')

@section('content')
<div class="min-h-screen bg-black text-white py-12" x-data="aiWizard()">
    <div class="max-w-3xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="font-heading text-4xl uppercase mb-2">Configure Your Test</h1>
            <div class="flex items-center justify-center gap-2 text-gray-400">
                <span class="material-symbols-outlined text-accent-yellow">bolt</span>
                <span>Credits Remaining: <span class="text-white font-bold" x-text="credits"></span></span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-12 relative">
            <div class="h-1 bg-gray-800 rounded-full overflow-hidden">
                <div class="h-full bg-accent-yellow transition-all duration-500" :style="'width: ' + ((step / 4) * 100) + '%'"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs uppercase tracking-widest text-gray-500 font-bold">
                <span :class="{'text-accent-yellow': step >= 1}">Exam</span>
                <span :class="{'text-accent-yellow': step >= 2}">Topic</span>
                <span :class="{'text-accent-yellow': step >= 3}">Settings</span>
                <span :class="{'text-accent-yellow': step >= 4}">Generate</span>
            </div>
        </div>

        <!-- Wizard Card -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
            
            <!-- Loading Overlay -->
            <div x-show="loading" class="absolute inset-0 bg-black/80 backdrop-blur-sm z-50 flex flex-col items-center justify-center" x-transition>
                <div class="w-16 h-16 border-4 border-accent-yellow border-t-transparent rounded-full animate-spin mb-4"></div>
                <p class="text-accent-yellow font-mono animate-pulse" x-text="loadingMessage"></p>
            </div>

            <!-- Step 1: Exam Context -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="bg-gray-800 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                    Select Exam Goal
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                    <template x-for="exam in exams" :key="exam">
                        <button @click="form.exam = exam" 
                            :class="{'bg-accent-yellow text-black border-accent-yellow': form.exam === exam, 'bg-gray-800 border-gray-700 hover:border-gray-500': form.exam !== exam}"
                            class="p-4 rounded-xl border text-center font-bold transition-all">
                            <span x-text="exam"></span>
                        </button>
                    </template>
                    <button @click="form.exam = 'Other'" 
                        :class="{'bg-accent-yellow text-black border-accent-yellow': form.exam === 'Other', 'bg-gray-800 border-gray-700 hover:border-gray-500': form.exam !== 'Other'}"
                        class="p-4 rounded-xl border text-center font-bold transition-all">
                        Other
                    </button>
                </div>

                <div x-show="form.exam === 'Other'" class="mb-6">
                    <label class="block text-sm text-gray-400 mb-2">Specify Exam Name</label>
                    <input type="text" x-model="customExam" class="w-full bg-black border border-gray-700 rounded-lg p-3 text-white focus:border-accent-yellow focus:ring-1 focus:ring-accent-yellow outline-none" placeholder="e.g. UPSC, GMAT, Class 10 Boards">
                </div>

                <div class="flex justify-end">
                    <button @click="nextStep()" :disabled="!form.exam || (form.exam === 'Other' && !customExam)" class="bg-white text-black font-bold py-3 px-8 rounded-lg hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        Next Step
                    </button>
                </div>
            </div>

            <!-- Step 2: Topic Selection -->
            <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="bg-gray-800 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                    What are we studying?
                </h2>

                <div class="space-y-6 mb-8">
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Subject</label>
                        <input type="text" x-model="form.subject" class="w-full bg-black border border-gray-700 rounded-lg p-3 text-white focus:border-accent-yellow focus:ring-1 focus:ring-accent-yellow outline-none" placeholder="e.g. Physics, Mathematics, History">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Specific Topic</label>
                        <input type="text" x-model="form.topic" class="w-full bg-black border border-gray-700 rounded-lg p-3 text-white focus:border-accent-yellow focus:ring-1 focus:ring-accent-yellow outline-none" placeholder="e.g. Thermodynamics, Calculus, World War II">
                    </div>
                </div>

                <div x-show="validationError" class="mb-6 p-4 bg-red-900/50 border border-red-500 rounded-lg text-red-200 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">error</span>
                    <span x-text="validationError"></span>
                </div>

                <div class="flex justify-between">
                    <button @click="step--" class="text-gray-400 hover:text-white px-4">Back</button>
                    <button @click="validateAndNext()" :disabled="!form.subject || !form.topic" class="bg-white text-black font-bold py-3 px-8 rounded-lg hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        Validate & Next
                    </button>
                </div>
            </div>

            <!-- Step 3: Parameters -->
            <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="bg-gray-800 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                    Test Parameters
                </h2>

                <div class="mb-8">
                    <label class="block text-sm text-gray-400 mb-4 flex justify-between">
                        <span>Number of Questions</span>
                        <span class="text-accent-yellow font-bold" x-text="form.count"></span>
                    </label>
                    <input type="range" min="5" max="25" step="5" x-model="form.count" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer accent-accent-yellow">
                    <div class="flex justify-between text-xs text-gray-500 mt-2">
                        <span>5</span>
                        <span>25 (Free Limit)</span>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm text-gray-400 mb-4">Difficulty Level</label>
                    <div class="grid grid-cols-3 gap-3">
                        <button @click="form.difficulty = 'Easy'" :class="{'bg-green-900/50 border-green-500 text-green-400': form.difficulty === 'Easy', 'bg-gray-800 border-gray-700': form.difficulty !== 'Easy'}" class="p-3 rounded-lg border text-sm font-bold transition-all">Easy</button>
                        <button @click="form.difficulty = 'Medium'" :class="{'bg-yellow-900/50 border-yellow-500 text-yellow-400': form.difficulty === 'Medium', 'bg-gray-800 border-gray-700': form.difficulty !== 'Medium'}" class="p-3 rounded-lg border text-sm font-bold transition-all">Medium</button>
                        <button @click="form.difficulty = 'Hard'" :class="{'bg-red-900/50 border-red-500 text-red-400': form.difficulty === 'Hard', 'bg-gray-800 border-gray-700': form.difficulty !== 'Hard'}" class="p-3 rounded-lg border text-sm font-bold transition-all">Hard</button>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button @click="step--" class="text-gray-400 hover:text-white px-4">Back</button>
                    <button @click="step++" class="bg-white text-black font-bold py-3 px-8 rounded-lg hover:bg-gray-200 transition-colors">
                        Review
                    </button>
                </div>
            </div>

            <!-- Step 4: Review & Generate -->
            <div x-show="step === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="bg-gray-800 w-8 h-8 rounded-full flex items-center justify-center text-sm">4</span>
                    Ready to Generate?
                </h2>

                <div class="bg-gray-800/50 rounded-xl p-6 mb-8 border border-gray-700">
                    <div class="grid grid-cols-2 gap-y-4 text-sm">
                        <div class="text-gray-400">Exam:</div>
                        <div class="font-bold text-right" x-text="form.exam === 'Other' ? customExam : form.exam"></div>
                        
                        <div class="text-gray-400">Subject:</div>
                        <div class="font-bold text-right" x-text="form.subject"></div>
                        
                        <div class="text-gray-400">Topic:</div>
                        <div class="font-bold text-right" x-text="form.topic"></div>
                        
                        <div class="text-gray-400">Questions:</div>
                        <div class="font-bold text-right" x-text="form.count"></div>
                        
                        <div class="text-gray-400">Difficulty:</div>
                        <div class="font-bold text-right" :class="{'text-green-400': form.difficulty === 'Easy', 'text-yellow-400': form.difficulty === 'Medium', 'text-red-400': form.difficulty === 'Hard'}" x-text="form.difficulty"></div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-700 flex justify-between items-center">
                        <span class="text-gray-400">Cost:</span>
                        <span class="text-accent-yellow font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">bolt</span> 1 Credit
                        </span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button @click="step--" class="text-gray-400 hover:text-white px-4">Back</button>
                    <button @click="generateTest()" class="bg-accent-yellow text-black font-bold py-4 px-8 rounded-lg hover:bg-white hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,189,89,0.3)]">
                        Generate Test
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function aiWizard() {
        return {
            step: 1,
            credits: {{ $credits }},
            isLoggedIn: {{ $isLoggedIn ? 'true' : 'false' }},
            loading: false,
            loadingMessage: '',
            exams: ['JEE Mains', 'JEE Advanced', 'NEET', 'SAT', 'CBSE Class 12', 'CBSE Class 10'],
            customExam: '',
            form: {
                exam: '',
                subject: '',
                topic: '',
                difficulty: 'Medium',
                count: 10
            },
            validationError: '',
            
            nextStep() {
                if (this.step === 1) {
                    if (!this.isLoggedIn) {
                        // Redirect to login with return URL
                        window.location.href = "{{ route('login') }}?redirect={{ route('ai-test.create') }}";
                        return;
                    }
                }
                this.step++;
            },
            
            async validateAndNext() {
                this.loading = true;
                this.loadingMessage = 'Validating Topic with AI...';
                this.validationError = '';
                
                try {
                    const response = await fetch("{{ route('ai-test.validate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            subject: this.form.subject,
                            topic: this.form.topic
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.valid) {
                        if (data.corrected_subject) this.form.subject = data.corrected_subject;
                        if (data.corrected_topic) this.form.topic = data.corrected_topic;
                        this.step++;
                    } else {
                        this.validationError = data.reason || 'Invalid topic for this subject.';
                    }
                } catch (error) {
                    console.error('Validation error:', error);
                    this.validationError = 'Failed to validate. Please try again.';
                } finally {
                    this.loading = false;
                }
            },
            
            async generateTest() {
                if (this.credits <= 0) {
                    alert('You have 0 credits left. Please upgrade.');
                    return;
                }
                
                this.loading = true;
                this.loadingMessage = 'Constructing Questions...';
                
                try {
                    const response = await fetch("{{ route('ai-test.generate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            exam: this.form.exam === 'Other' ? this.customExam : this.form.exam,
                            subject: this.form.subject,
                            topic: this.form.topic,
                            difficulty: this.form.difficulty,
                            count: this.form.count
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.error || 'Generation failed. Please try again.');
                    }
                } catch (error) {
                    console.error('Generation error:', error);
                    alert('An error occurred. Please try again.');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endsection
