@extends('layouts.ai')

@section('title', 'Your AI Mock Test - HTC X')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4">
        
        <div class="flex justify-between items-center mb-8 border-b border-white/10 pb-4">
            <div>
                <h1 class="font-heading text-2xl uppercase text-white mb-1">{{ $test->exam_context }} Mock Test</h1>
                <p class="text-gray-500 text-xs">{{ $test->subject }} - {{ $test->topic }} ({{ $test->difficulty }})</p>
            </div>
            <a href="{{ route('ai-test.create') }}" class="text-accent-yellow hover:text-white text-xs font-bold uppercase tracking-widest">
                Create New Test
            </a>
        </div>

        @php
            $data = json_decode($test->questions_json, true);
            $questions = $data['questions'] ?? [];
            $userAnswers = $test->user_answers_json ?? [];
            $score = $test->score;
            $total = count($questions);
            $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
        @endphp

        <!-- Score Card -->
        @if(isset($score))
        <div class="bg-white/5 border border-white/10 rounded-xl p-6 mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-white mb-1">Test Results</h2>
                <p class="text-gray-400 text-sm">You scored <span class="text-white font-bold">{{ $score }}</span> out of <span class="text-white font-bold">{{ $total }}</span></p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-heading text-accent-yellow">{{ $percentage }}%</div>
                <div class="text-xs text-gray-500 uppercase tracking-widest">Accuracy</div>
            </div>
        </div>
        @endif

        <div class="space-y-6">
            @foreach($questions as $index => $q)
            @php
                $userAns = $userAnswers[$index] ?? null;
                $isCorrect = $userAns == $q['correct_index'];
                $isSkipped = $userAns === null;
            @endphp
            <div class="border-b border-white/10 pb-6 last:border-0" x-data="{ showAnswer: false }">
                <div class="flex gap-4">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center font-bold text-xs mt-0.5
                        {{ $isSkipped ? 'bg-gray-700 text-gray-400' : ($isCorrect ? 'bg-green-500/20 text-green-500' : 'bg-red-500/20 text-red-500') }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-grow">
                        <h3 class="text-base font-bold mb-3 text-white">{{ $q['question'] }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
                            @foreach($q['options'] as $optIndex => $option)
                            @php
                                $optionClass = 'border-white/10 bg-white/5 text-gray-300';
                                if ($optIndex == $q['correct_index']) {
                                    $optionClass = 'border-green-500 bg-green-500/10 text-green-400';
                                } elseif ($optIndex == $userAns && !$isCorrect) {
                                    $optionClass = 'border-red-500 bg-red-500/10 text-red-400';
                                }
                            @endphp
                            <div class="p-2.5 rounded border text-xs {{ $optionClass }}">
                                <span class="font-bold mr-2">{{ chr(65 + $optIndex) }}.</span> {{ $option }}
                                @if($optIndex == $userAns)
                                    <span class="float-right text-[10px] uppercase font-bold tracking-wider opacity-70">(Your Answer)</span>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-3 p-3 bg-green-900/10 border border-green-500/20 rounded">
                            <p class="text-green-400 font-bold mb-1 text-xs">Correct Answer: {{ chr(65 + $q['correct_index']) }}</p>
                            <p class="text-gray-500 text-xs leading-relaxed">{{ $q['explanation'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
