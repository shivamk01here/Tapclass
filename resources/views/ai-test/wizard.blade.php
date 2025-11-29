@extends('layouts.ai')

@section('title', 'Create AI Mock Test - HTC X')

@section('content')
<div class="py-8" x-data="aiWizard()">
    <div class="max-w-2xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="font-heading text-3xl uppercase mb-1 text-white">Configure Your Test</h1>
            <div class="flex items-center justify-center gap-2 text-gray-500 text-xs">
                <span class="material-symbols-outlined text-accent-yellow text-sm">bolt</span>
                <span>Credits Remaining: <span class="text-white font-bold" x-text="credits"></span></span>
                <span x-show="isPremium" class="ml-2 px-2 py-0.5 bg-accent-yellow text-black rounded text-[10px] font-bold uppercase">Premium</span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-10 relative">
            <div class="h-0.5 bg-white/10 rounded-full overflow-hidden">
                <div class="h-full bg-accent-yellow transition-all duration-500" :style="'width: ' + ((step / 4) * 100) + '%'"></div>
            </div>
            <div class="flex justify-between mt-2 text-[10px] uppercase tracking-widest text-gray-600 font-bold">
                <span :class="{'text-accent-yellow': step >= 1}">Exam</span>
                <span :class="{'text-accent-yellow': step >= 2}">Topic</span>
                <span :class="{'text-accent-yellow': step >= 3}">Settings</span>
                <span :class="{'text-accent-yellow': step >= 4}">Generate</span>
            </div>
        </div>

        <!-- Wizard Container (Transparent) -->
        <div class="relative">
            
            <!-- Loading Overlay -->
            <div x-show="loading" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 flex flex-col items-center justify-center" x-transition>
                <div class="w-12 h-12 border-2 border-accent-yellow border-t-transparent rounded-full animate-spin mb-3"></div>
                <p class="text-accent-yellow font-mono text-sm animate-pulse" x-text="loadingMessage"></p>
            </div>

            <!-- Step 1: Exam Context -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-white">
                    <span class="bg-white/10 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                    Select Exam Goal
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                    <template x-for="exam in exams" :key="exam">
                        <button @click="selectExam(exam)" 
                            :class="{'bg-accent-yellow text-black border-accent-yellow': form.exam === exam, 'bg-black border-white/20 hover:border-white/50 text-gray-300': form.exam !== exam}"
                            class="p-3 rounded-lg border text-center font-bold text-xs transition-all">
                            <span x-text="exam"></span>
                        </button>
                    </template>
                    
                    <!-- Custom Option -->
                    <button @click="selectExam('Custom')" 
                        :class="{'bg-accent-yellow text-black border-accent-yellow': form.exam === 'Custom', 'bg-black border-white/20 hover:border-white/50 text-gray-300': form.exam !== 'Custom'}"
                        class="p-3 rounded-lg border text-center font-bold text-xs transition-all">
                        Custom
                    </button>

                    <button @click="selectExam('Other')" 
                        :class="{'bg-accent-yellow text-black border-accent-yellow': form.exam === 'Other', 'bg-black border-white/20 hover:border-white/50 text-gray-300': form.exam !== 'Other'}"
                        class="p-3 rounded-lg border text-center font-bold text-xs transition-all">
                        Other
                    </button>
                </div>

                <!-- Other Exam Input -->
                <div x-show="form.exam === 'Other'" class="mb-6 space-y-3">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Specify Exam Name</label>
                        <div class="flex gap-2">
                            <input type="text" x-model="customExam" 
                                @keydown.enter.prevent="validateExamInput()"
                                :disabled="examValidated"
                                class="flex-1 bg-black border border-white/20 rounded-lg p-2.5 text-white text-sm focus:border-accent-yellow focus:ring-1 focus:ring-accent-yellow outline-none disabled:opacity-50 disabled:cursor-not-allowed placeholder-gray-700" 
                                placeholder="e.g. UPSC, GMAT, Class 10 Boards">
                            
                            <button @click="validateExamInput()" 
                                x-show="!examValidated"
                                :disabled="!customExam || validatingExam"
                                class="bg-white/10 text-white px-4 rounded-lg hover:bg-white/20 disabled:opacity-50 transition-colors flex items-center gap-2 text-xs font-bold">
                                <span x-show="validatingExam" class="w-3 h-3 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                <span x-text="validatingExam ? 'Checking...' : 'Verify'"></span>
                            </button>

                            <button @click="resetExamValidation()" 
                                x-show="examValidated"
                                class="bg-white/10 text-red-400 px-4 rounded-lg hover:bg-white/20 transition-colors text-xs font-bold">
                                Change
                            </button>
                        </div>
                    </div>

                    <!-- Suggestions -->
                    <div x-show="examSuggestions.length > 0 && !examValidated" class="bg-white/5 border border-white/10 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-2">Did you mean one of these?</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="suggestion in examSuggestions" :key="suggestion">
                                <button @click="selectSuggestion(suggestion)" 
                                    class="px-2.5 py-1 bg-black border border-white/20 rounded-full text-xs text-gray-300 hover:border-accent-yellow hover:text-accent-yellow transition-colors">
                                    <span x-text="suggestion"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Validation Message -->
                    <div x-show="examValidationMsg" 
                        :class="{'text-green-400': examValidated, 'text-red-400': !examValidated}"
                        class="text-xs flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm" x-text="examValidated ? 'check_circle' : 'error'"></span>
                        <span x-text="examValidationMsg"></span>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button @click="nextStep()" 
                        :disabled="!form.exam || (form.exam === 'Other' && !examValidated)" 
                        class="bg-white text-black font-bold py-2.5 px-6 rounded hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-xs uppercase tracking-wider">
                        Next Step
                    </button>
                </div>
            </div>

            <!-- Step 2: Topic Selection -->
            <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-white">
                    <span class="bg-white/10 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                    What are we studying?
                </h2>

                <div class="space-y-4 mb-6">
                    <!-- Mixed/Random Toggle for All Exams -->
                    <div class="flex items-center justify-between bg-white/5 p-3 rounded-lg border border-white/10">
                        <div>
                            <span class="text-white text-sm font-bold block">Mixed Topics</span>
                            <span class="text-gray-500 text-xs">Generate questions from various subjects/topics</span>
                        </div>
                        <button @click="toggleMixedMode()" 
                            class="w-10 h-5 rounded-full relative transition-colors duration-300"
                            :class="isMixedMode ? 'bg-accent-yellow' : 'bg-gray-700'">
                            <div class="w-3 h-3 bg-black rounded-full absolute top-1 transition-all duration-300"
                                :class="isMixedMode ? 'left-6' : 'left-1'"></div>
                        </button>
                    </div>

                    <div x-show="!isMixedMode" x-transition>
                        <div class="mb-4">
                            <label class="block text-xs text-gray-500 mb-1">Subject</label>
                            <input type="text" x-model="form.subject" class="w-full bg-black border border-white/20 rounded-lg p-2.5 text-white text-sm focus:border-accent-yellow focus:ring-1 focus:ring-accent-yellow outline-none placeholder-gray-700" placeholder="e.g. Physics, Mathematics, History">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Specific Topic</label>
                            <input type="text" x-model="form.topic" class="w-full bg-black border border-white/20 rounded-lg p-2.5 text-white text-sm focus:border-accent-yellow focus:ring-1 focus:ring-accent-yellow outline-none placeholder-gray-700" placeholder="e.g. Thermodynamics, Calculus, World War II">
                        </div>
                    </div>
                </div>

                <div x-show="validationError" class="mb-4 p-3 bg-red-900/20 border border-red-500/50 rounded text-red-300 text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">error</span>
                    <span x-text="validationError"></span>
                </div>

                <div class="flex justify-between">
                    <button @click="step--" class="text-gray-500 hover:text-white px-4 text-xs font-bold uppercase tracking-wider">Back</button>
                    <button @click="validateAndNext()" :disabled="!isMixedMode && (!form.subject || !form.topic)" class="bg-white text-black font-bold py-2.5 px-6 rounded hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-xs uppercase tracking-wider">
                        <span x-text="form.exam === 'Custom' ? 'Proceed' : 'Validate & Next'"></span>
                    </button>
                </div>
            </div>

            <!-- Step 3: Parameters -->
            <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-white">
                    <span class="bg-white/10 w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
                    Test Parameters
                </h2>

                <!-- Full Test Toggle (Premium Only) -->
                <div class="mb-6 flex items-center justify-between bg-white/5 p-3 rounded-lg border border-white/10">
                    <div>
                        <span class="text-white text-sm font-bold block flex items-center gap-2">
                            Full Test Mode 
                            <span x-show="!isPremium" class="material-symbols-outlined text-xs text-gray-500">lock</span>
                        </span>
                        <span class="text-gray-500 text-xs">Let AI decide question count (up to 100)</span>
                    </div>
                    <button @click="toggleFullTest()" 
                        class="w-10 h-5 rounded-full relative transition-colors duration-300"
                        :class="isFullTest ? 'bg-accent-yellow' : 'bg-gray-700'">
                        <div class="w-3 h-3 bg-black rounded-full absolute top-1 transition-all duration-300"
                            :class="isFullTest ? 'left-6' : 'left-1'"></div>
                    </button>
                </div>

                <div class="mb-6" :class="{'opacity-50 pointer-events-none': isFullTest}">
                    <label class="block text-xs text-gray-500 mb-3 flex justify-between">
                        <span>Number of Questions</span>
                        <span class="text-accent-yellow font-bold" x-text="form.count"></span>
                    </label>
                    <input type="range" min="5" max="100" step="5" x-model="form.count" @input="checkPremiumLimit()" class="w-full h-1.5 bg-gray-800 rounded-lg appearance-none cursor-pointer accent-accent-yellow">
                    <div class="flex justify-between text-[10px] text-gray-600 mt-1">
                        <span>5</span>
                        <span class="flex items-center gap-1">25 <span x-show="!isPremium" class="material-symbols-outlined text-[10px]">lock</span></span>
                        <span>100</span>
                    </div>
                    
                    <!-- Premium Lock Message -->
                    <div x-show="showPremiumLock" class="mt-2 text-xs text-accent-yellow flex items-center gap-1 animate-pulse">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        Upgrade to Premium to unlock more than 25 questions!
                        <a href="{{ route('ai-test.pricing') }}" class="underline font-bold ml-1">View Plans</a>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-xs text-gray-500 mb-3">Difficulty Level</label>
                    <div class="grid grid-cols-3 gap-3">
                        <button @click="form.difficulty = 'Easy'" :class="{'bg-green-900/20 border-green-500 text-green-400': form.difficulty === 'Easy', 'bg-black border-white/20 text-gray-400': form.difficulty !== 'Easy'}" class="p-2.5 rounded border text-xs font-bold transition-all">Easy</button>
                        <button @click="form.difficulty = 'Medium'" :class="{'bg-yellow-900/20 border-yellow-500 text-yellow-400': form.difficulty === 'Medium', 'bg-black border-white/20 text-gray-400': form.difficulty !== 'Medium'}" class="p-2.5 rounded border text-xs font-bold transition-all">Medium</button>
                        <button @click="form.difficulty = 'Hard'" :class="{'bg-red-900/20 border-red-500 text-red-400': form.difficulty === 'Hard', 'bg-black border-white/20 text-gray-400': form.difficulty !== 'Hard'}" class="p-2.5 rounded border text-xs font-bold transition-all">Hard</button>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button @click="step--" class="text-gray-500 hover:text-white px-4 text-xs font-bold uppercase tracking-wider">Back</button>
                    <button @click="step++" class="bg-white text-black font-bold py-2.5 px-6 rounded hover:bg-gray-200 transition-colors text-xs uppercase tracking-wider">
                        Review
                    </button>
                </div>
            </div>

            <!-- Step 4: Review & Generate -->
            <div x-show="step === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-white">
                    <span class="bg-white/10 w-6 h-6 rounded-full flex items-center justify-center text-xs">4</span>
                    Ready to Generate?
                </h2>

                <div class="bg-white/5 rounded-lg p-5 mb-6 border border-white/10">
                    <div class="grid grid-cols-2 gap-y-3 text-xs">
                        <div class="text-gray-500">Exam:</div>
                        <div class="font-bold text-right text-white" x-text="form.exam === 'Other' ? customExam : form.exam"></div>
                        
                        <div class="text-gray-500">Subject:</div>
                        <div class="font-bold text-right text-white" x-text="isMixedMode ? 'Mixed / Random' : form.subject"></div>
                        
                        <div class="text-gray-500">Topic:</div>
                        <div class="font-bold text-right text-white" x-text="isMixedMode ? 'General Knowledge' : form.topic"></div>
                        
                        <div class="text-gray-500">Questions:</div>
                        <div class="font-bold text-right text-white" x-text="isFullTest ? 'AI Decided (Full Test)' : form.count"></div>
                        
                        <div class="text-gray-500">Difficulty:</div>
                        <div class="font-bold text-right" :class="{'text-green-400': form.difficulty === 'Easy', 'text-yellow-400': form.difficulty === 'Medium', 'text-red-400': form.difficulty === 'Hard'}" x-text="form.difficulty"></div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t border-white/10 flex justify-between items-center">
                        <span class="text-gray-500 text-xs">Cost:</span>
                        <span class="text-accent-yellow font-bold flex items-center gap-1 text-xs">
                            <span class="material-symbols-outlined text-sm">bolt</span> 1 Credit
                        </span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button @click="step--" class="text-gray-500 hover:text-white px-4 text-xs font-bold uppercase tracking-wider">Back</button>
                    <button @click="generateTest()" class="bg-accent-yellow text-black font-bold py-3 px-8 rounded hover:bg-white hover:scale-105 transition-all shadow-[0_0_15px_rgba(255,189,89,0.2)] text-xs uppercase tracking-wider">
                        Generate Test
                    </button>
                </div>
            </div>

            <!-- Correction Modal -->
            <div x-show="showCorrectionModal" style="display: none;" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-transition>
                <div class="bg-black border border-white/20 rounded-xl p-6 max-w-md w-full shadow-2xl">
                    <div class="flex items-center gap-3 mb-4 text-accent-yellow">
                        <span class="material-symbols-outlined text-2xl">lightbulb</span>
                        <h3 class="text-lg font-bold">Did you mean?</h3>
                    </div>
                    
                    <p class="text-gray-400 mb-6 text-sm">We found a more standard name for your topic. Would you like to use this instead?</p>
                    
                    <div class="bg-white/5 rounded-lg p-4 mb-6 border border-white/10">
                        <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2 text-xs">
                            <span class="text-gray-500">Subject:</span>
                            <span class="font-bold text-white" x-text="correctionData.subject"></span>
                            
                            <span class="text-gray-500">Topic:</span>
                            <span class="font-bold text-white" x-text="correctionData.topic"></span>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button @click="applyCorrection()" class="flex-1 bg-accent-yellow text-black font-bold py-2.5 rounded hover:bg-white transition-colors text-xs uppercase tracking-wider">
                            Yes, Use This
                        </button>
                        <button @click="skipCorrection()" class="flex-1 bg-white/10 text-white font-bold py-2.5 rounded hover:bg-white/20 transition-colors text-xs uppercase tracking-wider">
                            No, Keep Mine
                        </button>
                    </div>
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
            isPremium: {{ auth()->check() && auth()->user()->is_premium ? 'true' : 'false' }},
            loading: false,
            loadingMessage: '',
            exams: ['JEE Mains', 'JEE Advanced', 'NEET', 'SAT', 'CBSE Class 12', 'CBSE Class 10'],
            customExam: '',
            validatingExam: false,
            examValidated: false,
            examSuggestions: [],
            examValidationMsg: '',
            showCorrectionModal: false,
            correctionData: { subject: '', topic: '' },
            isMixedMode: false,
            isFullTest: false,
            showPremiumLock: false,
            form: {
                exam: '',
                subject: '',
                topic: '',
                difficulty: 'Medium',
                count: 10
            },
            validationError: '',

            selectExam(exam) {
                this.form.exam = exam;
                if (exam === 'Custom') {
                    this.customExam = ''; // Reset custom input
                    this.examValidated = true; // Custom doesn't need validation
                } else if (exam === 'Other') {
                    this.examValidated = false;
                } else {
                    this.examValidated = true;
                }
            },

            toggleMixedMode() {
                this.isMixedMode = !this.isMixedMode;
                if (this.isMixedMode) {
                    this.form.subject = 'Mixed / Random';
                    this.form.topic = 'General Knowledge';
                } else {
                    this.form.subject = '';
                    this.form.topic = '';
                }
            },

            toggleFullTest() {
                if (!this.isPremium) {
                    window.location.href = "{{ route('ai-test.pricing') }}";
                    return;
                }
                this.isFullTest = !this.isFullTest;
                if (this.isFullTest) {
                    this.form.count = 50; // Placeholder
                }
            },

            checkPremiumLimit() {
                if (!this.isPremium && this.form.count > 25) {
                    this.form.count = 25;
                    this.showPremiumLock = true;
                    setTimeout(() => this.showPremiumLock = false, 3000);
                }
            },

            async validateExamInput() {
                if (!this.customExam) return;
                
                this.validatingExam = true;
                this.examValidationMsg = '';
                this.examSuggestions = [];
                
                try {
                    const response = await fetch("{{ route('ai-test.validate-exam') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ exam: this.customExam })
                    });
                    
                    const data = await response.json();
                    
                    if (data.valid) {
                        if (data.match_type === 'exact') {
                            this.customExam = data.exam;
                            this.examValidated = true;
                            this.examValidationMsg = 'Exam verified: ' + data.exam;
                        } else if (data.match_type === 'ambiguous') {
                            this.examSuggestions = data.suggestions;
                            this.examValidationMsg = 'Please select the exact exam from the suggestions.';
                        }
                    } else {
                        this.examValidationMsg = data.reason || 'Invalid exam name. Please try again.';
                    }
                } catch (error) {
                    console.error('Exam validation network/server error:', error);
                    this.examValidationMsg = 'Validation failed. Check console for details.';
                } finally {
                    this.validatingExam = false;
                }
            },

            selectSuggestion(suggestion) {
                this.customExam = suggestion;
                this.examSuggestions = [];
                this.examValidated = true;
                this.examValidationMsg = 'Exam verified: ' + suggestion;
            },

            resetExamValidation() {
                this.examValidated = false;
                this.examValidationMsg = '';
                this.examSuggestions = [];
            },
            
            nextStep() {
                if (this.step === 1) {
                    if (!this.isLoggedIn) {
                        window.location.href = "{{ route('login') }}?redirect={{ route('ai-test.create') }}";
                        return;
                    }
                }
                this.step++;
            },
            
            async validateAndNext() {
                if (this.form.exam === 'Custom' || this.isMixedMode) {
                    this.step++;
                    return;
                }

                this.loading = true;
                this.loadingMessage = 'Verifying Topic...';
                this.validationError = '';
                
                try {
                    const examName = this.form.exam === 'Other' ? this.customExam : this.form.exam;
                    
                    const response = await fetch("{{ route('ai-test.validate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            exam: examName,
                            subject: this.form.subject,
                            topic: this.form.topic
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.valid) {
                        if (data.corrected_subject !== this.form.subject || data.corrected_topic !== this.form.topic) {
                            this.correctionData = {
                                subject: data.corrected_subject,
                                topic: data.corrected_topic
                            };
                            this.showCorrectionModal = true;
                            this.loading = false;
                            return;
                        }
                        this.step++;
                    } else {
                        this.validationError = data.reason || 'Invalid topic for this subject.';
                    }
                } catch (error) {
                    console.error('Validation error:', error);
                    this.validationError = 'Failed to validate. Please try again.';
                } finally {
                    if (!this.showCorrectionModal) {
                        this.loading = false;
                    }
                }
            },

            applyCorrection() {
                this.form.subject = this.correctionData.subject;
                this.form.topic = this.correctionData.topic;
                this.showCorrectionModal = false;
                this.step++;
            },

            skipCorrection() {
                this.showCorrectionModal = false;
                this.step++;
            },
            
            async generateTest() {
                if (this.credits <= 0) {
                    alert('You have 0 credits left. Please upgrade.');
                    return;
                }
                
                this.loading = true;
                this.loadingMessage = 'Initiating Test Generation...';
                
                const messages = [
                    "Analyzing syllabus...",
                    "Consulting expert sources...",
                    "Drafting challenging questions...",
                    "Reviewing difficulty levels...",
                    "Finalizing your mock test...",
                    "Almost there..."
                ];
                let msgIndex = 0;
                const msgInterval = setInterval(() => {
                    this.loadingMessage = messages[msgIndex % messages.length];
                    msgIndex++;
                }, 3000);

                try {
                    const response = await fetch("{{ route('ai-test.generate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            exam: this.form.exam === 'Other' ? this.customExam : this.form.exam,
                            subject: this.form.subject,
                            topic: this.form.topic,
                            difficulty: this.form.difficulty,
                            count: this.form.count,
                            is_full_test: this.isFullTest
                        })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        try {
                            const errorJson = JSON.parse(errorText);
                            alert(errorJson.error || 'Server Error: ' + response.status);
                        } catch (e) {
                            alert('Server Error (' + response.status + '). Check console for details.');
                        }
                        clearInterval(msgInterval);
                        this.loading = false;
                        return;
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        const testId = data.test_id;
                        const pollInterval = setInterval(async () => {
                            try {
                                const statusRes = await fetch(`/ai-test/${testId}/status`, {
                                    headers: { 'Accept': 'application/json' }
                                });
                                const statusData = await statusRes.json();
                                
                                console.log('Polling Status:', statusData.status);

                                if (statusData.status === 'completed' || statusData.status === 'ready_to_start') {
                                    clearInterval(pollInterval);
                                    clearInterval(msgInterval);
                                    window.location.href = statusData.redirect_url;
                                } else if (statusData.status === 'failed') {
                                    clearInterval(pollInterval);
                                    clearInterval(msgInterval);
                                    this.loading = false;
                                    alert(statusData.error || 'Generation failed.');
                                }
                            } catch (e) {
                                console.error('Polling error', e);
                            }
                        }, 2000);
                    } else {
                        clearInterval(msgInterval);
                        this.loading = false;
                        alert(data.error || 'Generation failed. Please try again.');
                    }
                } catch (error) {
                    clearInterval(msgInterval);
                    console.error('Generation error:', error);
                    this.loading = false;
                    alert('An error occurred. Please try again.');
                }
            }
        }
    }
</script>
@endsection
