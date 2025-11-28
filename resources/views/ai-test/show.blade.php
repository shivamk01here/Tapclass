@extends('layouts.public')

@section('title', 'Your AI Mock Test - HTC')

@section('content')
<div class="min-h-screen bg-black text-white py-12">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-heading text-3xl uppercase">{{ $test->exam_context }} Mock Test</h1>
                <p class="text-gray-400">{{ $test->subject }} - {{ $test->topic }} ({{ $test->difficulty }})</p>
            </div>
            <a href="{{ route('ai-test.create') }}" class="text-accent-yellow hover:text-white text-sm font-bold uppercase tracking-widest">
                Create New Test
            </a>
        </div>

        @php
            $data = json_decode($test->questions_json, true);
            $questions = $data['questions'] ?? [];
        @endphp

        <div class="space-y-8">
            @foreach($questions as $index => $q)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 shadow-lg" x-data="{ showAnswer: false }">
                <div class="flex gap-4">
                    <span class="flex-shrink-0 w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center font-bold text-gray-400">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold mb-4">{{ $q['question'] }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                            @foreach($q['options'] as $optIndex => $option)
                            <div class="p-3 rounded-lg border border-gray-700 bg-black/50 text-gray-300">
                                <span class="font-bold text-gray-500 mr-2">{{ chr(65 + $optIndex) }}.</span> {{ $option }}
                            </div>
                            @endforeach
                        </div>

                        <button @click="showAnswer = !showAnswer" class="text-sm text-accent-yellow hover:text-white font-bold uppercase tracking-wider flex items-center gap-1">
                            <span x-text="showAnswer ? 'Hide Answer' : 'Show Answer'"></span>
                            <span class="material-symbols-outlined text-sm" x-text="showAnswer ? 'visibility_off' : 'visibility'"></span>
                        </button>

                        <div x-show="showAnswer" class="mt-4 p-4 bg-green-900/20 border border-green-900 rounded-lg" style="display: none;">
                            <p class="text-green-400 font-bold mb-1">Correct Answer: {{ chr(65 + $q['correct_index']) }}</p>
                            <p class="text-gray-400 text-sm">{{ $q['explanation'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
