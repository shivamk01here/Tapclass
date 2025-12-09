@extends('layouts.ai')

@section('title', 'Test Results - HTC X')

@section('content')
@php
    $data = json_decode($test->questions_json, true);
    $questions = $data['questions'] ?? [];
    $userAnswers = $test->user_answers_json ?? [];
    $score = $test->score ?? 0;
    $total = count($questions);
    $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
    
    // Calculate stats
    $correct = $score;
    $wrong = 0;
    $skipped = 0;
    
    foreach ($questions as $index => $q) {
        $userAns = $userAnswers[$index] ?? null;
        if ($userAns === null) {
            $skipped++;
        } elseif ($userAns != $q['correct_index']) {
            $wrong++;
        }
    }
    
    // Determine grade
    $grade = 'F';
    $gradeColor = 'red';
    $gradeMessage = 'Needs Improvement';
    
    if ($percentage >= 90) {
        $grade = 'A+';
        $gradeColor = 'emerald';
        $gradeMessage = 'Outstanding!';
    } elseif ($percentage >= 80) {
        $grade = 'A';
        $gradeColor = 'emerald';
        $gradeMessage = 'Excellent!';
    } elseif ($percentage >= 70) {
        $grade = 'B';
        $gradeColor = 'green';
        $gradeMessage = 'Good Job!';
    } elseif ($percentage >= 60) {
        $grade = 'C';
        $gradeColor = 'yellow';
        $gradeMessage = 'Fair Performance';
    } elseif ($percentage >= 50) {
        $grade = 'D';
        $gradeColor = 'orange';
        $gradeMessage = 'Keep Practicing';
    }
    
    // Performance message
    $performanceInsight = match(true) {
        $percentage >= 90 => "Exceptional performance! You've mastered this topic.",
        $percentage >= 80 => "Great work! You have a strong understanding of the material.",
        $percentage >= 70 => "Good effort! A little more practice will help you excel.",
        $percentage >= 60 => "You're on the right track. Focus on the areas you missed.",
        $percentage >= 50 => "Keep going! Review the explanations carefully.",
        default => "Don't give up! Every attempt is a step toward improvement.",
    };
@endphp

<div class="py-8 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="font-heading text-3xl uppercase text-white mb-1">Test Results</h1>
                <p class="text-gray-500 text-sm">{{ $test->exam_context }} • {{ $test->subject }} • {{ $test->topic }}</p>
            </div>
            <a href="{{ route('ai-test.create') }}" class="bg-accent-yellow text-black px-6 py-3 rounded-lg font-bold text-sm uppercase tracking-wide hover:bg-yellow-400 transition-colors">
                <i class="bi bi-plus-lg mr-2"></i>Create New Test
            </a>
        </div>

        <!-- Main Score Card -->
        <div class="bg-gradient-to-br from-white/10 to-white/5 border border-white/10 rounded-2xl p-8 mb-8">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                
                <!-- Circular Progress -->
                <div class="relative w-48 h-48 flex-shrink-0">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                        <!-- Background circle -->
                        <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="10"/>
                        <!-- Progress circle -->
                        <circle cx="50" cy="50" r="45" fill="none" 
                                stroke="url(#gradient)" 
                                stroke-width="10" 
                                stroke-linecap="round"
                                stroke-dasharray="{{ $percentage * 2.83 }} 283"
                                class="transition-all duration-1000"/>
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#FFBD59"/>
                                <stop offset="100%" stop-color="#FF8C00"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-5xl font-heading text-accent-yellow">{{ $percentage }}%</span>
                        <span class="text-xs text-gray-400 uppercase tracking-widest">Accuracy</span>
                    </div>
                </div>

                <!-- Grade & Stats -->
                <div class="flex-grow text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-4 mb-4">
                        <div class="w-20 h-20 rounded-2xl bg-{{ $gradeColor }}-500/20 border-2 border-{{ $gradeColor }}-500 flex items-center justify-center">
                            <span class="text-4xl font-heading text-{{ $gradeColor }}-400">{{ $grade }}</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ $gradeMessage }}</h2>
                            <p class="text-gray-400 text-sm mt-1">{{ $performanceInsight }}</p>
                        </div>
                    </div>
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-3 gap-4 mt-6">
                        <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4 text-center">
                            <div class="text-3xl font-heading text-green-400">{{ $correct }}</div>
                            <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">Correct</div>
                        </div>
                        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 text-center">
                            <div class="text-3xl font-heading text-red-400">{{ $wrong }}</div>
                            <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">Wrong</div>
                        </div>
                        <div class="bg-gray-500/10 border border-gray-500/30 rounded-xl p-4 text-center">
                            <div class="text-3xl font-heading text-gray-400">{{ $skipped }}</div>
                            <div class="text-xs text-gray-400 uppercase tracking-wider mt-1">Skipped</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analysis -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Strengths -->
            <div class="bg-white/5 border border-white/10 rounded-xl p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center">
                        <i class="bi bi-trophy-fill text-green-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Strengths</h3>
                </div>
                @if($percentage >= 70)
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-green-400 mt-0.5"></i>
                            <span>Strong understanding of {{ $test->topic }}</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-green-400 mt-0.5"></i>
                            <span>Good accuracy rate of {{ $percentage }}%</span>
                        </li>
                        @if($skipped == 0)
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-green-400 mt-0.5"></i>
                            <span>Attempted all questions</span>
                        </li>
                        @endif
                    </ul>
                @else
                    <p class="text-sm text-gray-400">Focus on improving your fundamentals to build strengths in this area.</p>
                @endif
            </div>

            <!-- Areas to Improve -->
            <div class="bg-white/5 border border-white/10 rounded-xl p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center">
                        <i class="bi bi-lightbulb-fill text-orange-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Areas to Improve</h3>
                </div>
                <ul class="space-y-2 text-sm text-gray-300">
                    @if($wrong > 0)
                    <li class="flex items-start gap-2">
                        <i class="bi bi-arrow-right-circle text-orange-400 mt-0.5"></i>
                        <span>Review the {{ $wrong }} incorrect answer{{ $wrong > 1 ? 's' : '' }} below</span>
                    </li>
                    @endif
                    @if($skipped > 0)
                    <li class="flex items-start gap-2">
                        <i class="bi bi-arrow-right-circle text-orange-400 mt-0.5"></i>
                        <span>Attempt all questions - {{ $skipped }} were skipped</span>
                    </li>
                    @endif
                    @if($percentage < 70)
                    <li class="flex items-start gap-2">
                        <i class="bi bi-arrow-right-circle text-orange-400 mt-0.5"></i>
                        <span>Practice more {{ $test->subject }} problems</span>
                    </li>
                    @endif
                    <li class="flex items-start gap-2">
                        <i class="bi bi-arrow-right-circle text-orange-400 mt-0.5"></i>
                        <span>Read explanations carefully for each question</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Suggestions -->
        <div class="bg-gradient-to-r from-accent-yellow/10 to-orange-500/10 border border-accent-yellow/30 rounded-xl p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-accent-yellow/20 flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-stars text-accent-yellow text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-2">Personalized Suggestions</h3>
                    <ul class="space-y-2 text-sm text-gray-300">
                        @if($percentage < 50)
                            <li>• Start with basic concepts of {{ $test->topic }} before attempting advanced questions</li>
                            <li>• Consider studying with video tutorials or detailed notes</li>
                            <li>• Take smaller quizzes (10-15 questions) to build confidence</li>
                        @elseif($percentage < 70)
                            <li>• Focus on understanding the "why" behind each answer</li>
                            <li>• Practice similar questions daily for consistency</li>
                            <li>• Try timed tests to improve speed and accuracy</li>
                        @elseif($percentage < 90)
                            <li>• Challenge yourself with harder difficulty levels</li>
                            <li>• Aim for 100% in your next attempt</li>
                            <li>• Help others learn - teaching reinforces understanding</li>
                        @else
                            <li>• Excellent! Move on to more advanced topics</li>
                            <li>• Try full-length mock tests for exam simulation</li>
                            <li>• Maintain consistency with daily practice</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Questions Review Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-heading uppercase text-white">Detailed Question Review</h2>
            <span class="text-sm text-gray-500">{{ $total }} Questions</span>
        </div>

        <!-- Questions List -->
        <div class="space-y-4" x-data="{ expandedAll: false }">
            <!-- Expand/Collapse All -->
            <div class="flex justify-end mb-2">
                <button @click="expandedAll = !expandedAll" class="text-sm text-accent-yellow hover:text-white transition-colors">
                    <span x-text="expandedAll ? 'Collapse All' : 'Expand All'"></span>
                    <i class="bi" :class="expandedAll ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                </button>
            </div>

            @foreach($questions as $index => $q)
            @php
                $userAns = $userAnswers[$index] ?? null;
                $isCorrect = $userAns !== null && $userAns == $q['correct_index'];
                $isSkipped = $userAns === null;
                $statusColor = $isSkipped ? 'gray' : ($isCorrect ? 'green' : 'red');
                $statusIcon = $isSkipped ? 'bi-dash-circle' : ($isCorrect ? 'bi-check-circle-fill' : 'bi-x-circle-fill');
                $statusText = $isSkipped ? 'Skipped' : ($isCorrect ? 'Correct' : 'Incorrect');
            @endphp
            
            <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden" 
                 x-data="{ open: false }"
                 :class="{ 'border-{{ $statusColor }}-500/30': true }">
                
                <!-- Question Header (Clickable) -->
                <button @click="open = !open; if(expandedAll) expandedAll = false" 
                        class="w-full p-4 flex items-center gap-4 text-left hover:bg-white/5 transition-colors">
                    <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm
                        bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-grow min-w-0">
                        <p class="text-white text-sm truncate">{{ Str::limit($q['question'], 80) }}</p>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="text-xs px-2 py-1 rounded-full bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400">
                            <i class="bi {{ $statusIcon }} mr-1"></i>{{ $statusText }}
                        </span>
                        <i class="bi text-gray-400" :class="open || expandedAll ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                    </div>
                </button>

                <!-- Expanded Content -->
                <div x-show="open || expandedAll" x-collapse class="border-t border-white/10">
                    <div class="p-4">
                        <h4 class="text-white font-medium mb-4">{{ $q['question'] }}</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                            @foreach($q['options'] as $optIndex => $option)
                            @php
                                $optionClass = 'border-white/10 bg-white/5 text-gray-300';
                                $optionIcon = '';
                                if ($optIndex == $q['correct_index']) {
                                    $optionClass = 'border-green-500 bg-green-500/10 text-green-400';
                                    $optionIcon = 'bi-check-lg text-green-400';
                                } elseif ($optIndex == $userAns && !$isCorrect) {
                                    $optionClass = 'border-red-500 bg-red-500/10 text-red-400';
                                    $optionIcon = 'bi-x-lg text-red-400';
                                }
                            @endphp
                            <div class="p-3 rounded-lg border text-sm {{ $optionClass }} flex items-center justify-between">
                                <span>
                                    <span class="font-bold mr-2">{{ chr(65 + $optIndex) }}.</span>{{ $option }}
                                </span>
                                @if($optionIcon)
                                <i class="bi {{ $optionIcon }}"></i>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        @if(!$isCorrect || $isSkipped)
                        <div class="bg-green-900/20 border border-green-500/20 rounded-lg p-3 mb-3">
                            <p class="text-green-400 font-bold text-xs mb-1">
                                <i class="bi bi-check-circle-fill mr-1"></i>Correct Answer: {{ chr(65 + $q['correct_index']) }}
                            </p>
                        </div>
                        @endif

                        <div class="bg-white/5 rounded-lg p-3">
                            <p class="text-accent-yellow font-bold text-xs mb-1">
                                <i class="bi bi-lightbulb-fill mr-1"></i>Explanation
                            </p>
                            <p class="text-gray-400 text-sm leading-relaxed">{{ $q['explanation'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('ai-test.create') }}" class="bg-accent-yellow text-black px-8 py-4 rounded-xl font-bold text-center hover:bg-yellow-400 transition-colors">
                <i class="bi bi-plus-lg mr-2"></i>Take Another Test
            </a>
            <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : route('home') }}" class="bg-white/10 text-white px-8 py-4 rounded-xl font-bold text-center hover:bg-white/20 transition-colors border border-white/20">
                <i class="bi bi-house mr-2"></i>Back to Dashboard
            </a>
        </div>

    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Dynamic color classes for Tailwind JIT */
    .bg-emerald-500\/20 { background-color: rgb(16 185 129 / 0.2); }
    .border-emerald-500 { border-color: rgb(16 185 129); }
    .text-emerald-400 { color: rgb(52 211 153); }
    .bg-green-500\/20 { background-color: rgb(34 197 94 / 0.2); }
    .border-green-500 { border-color: rgb(34 197 94); }
    .text-green-400 { color: rgb(74 222 128); }
    .bg-yellow-500\/20 { background-color: rgb(234 179 8 / 0.2); }
    .border-yellow-500 { border-color: rgb(234 179 8); }
    .text-yellow-400 { color: rgb(250 204 21); }
    .bg-orange-500\/20 { background-color: rgb(249 115 22 / 0.2); }
    .border-orange-500 { border-color: rgb(249 115 22); }
    .text-orange-400 { color: rgb(251 146 60); }
    .bg-red-500\/20 { background-color: rgb(239 68 68 / 0.2); }
    .border-red-500 { border-color: rgb(239 68 68); }
    .text-red-400 { color: rgb(248 113 113); }
</style>
@endsection
