@extends('layouts.tutor')

@section('title', 'My Reviews')

@section('content')
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
    <div class="flex items-center justify-between max-w-7xl mx-auto">
        <a href="{{ route('tutor.dashboard') }}" class="flex items-center gap-2 text-primary">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-bold">Back</span>
        </a>
    </div>
</header>
<main class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-black mb-6">My Reviews</h1>

    {{-- Overall Rating Summary Card --}}
    {{-- This assumes you have 'average_rating' and 'review_count' columns on your User (tutor) model --}}
    <div class="bg-white rounded-xl border p-4 sm:p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Overall Rating</h2>
        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-6">
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black text-primary">{{ number_format($tutor->average_rating ?? 0, 1) }}</span>
                <span class="text-gray-500">/ 5</span>
            </div>
            
            {{-- Star Rating Display --}}
            <div class="flex items-center gap-1">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined {{ $i <= round($tutor->average_rating ?? 0) ? 'text-yellow-500' : 'text-gray-300' }}">star</span>
                @endfor
            </div>
            
            <p class="text-gray-500 mt-2 sm:mt-0">
                Based on {{ $tutor->review_count ?? 0 }} {{ Str::plural('review', $tutor->review_count ?? 0) }}
            </p>
        </div>
    </div>

    {{-- Reviews List --}}
    <div class="space-y-4">
        @forelse($reviews as $review)
            <div class="bg-white rounded-xl border p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-center gap-3 mb-3 sm:mb-0">
                        <div class="w-12 h-12 rounded-full bg-secondary/20 flex items-center justify-center text-secondary font-bold flex-shrink-0">
                            {{-- Assuming student relationship is loaded --}}
                            {{ $review->student ? substr($review->student->name, 0, 1) : '?' }}
                        </div>
                        <div>
                            <h3 class="font-bold">{{ $review->student->name ?? 'Student' }}</h3>
                            <p class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-1 text-yellow-500">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <span class="material-symbols-outlined">star</span>
                        @endfor
                        @for ($i = $review->rating; $i < 5; $i++)
                            <span class="material-symbols-outlined text-gray-300">star</span>
                        @endfor
                    </div>
                </div>

                <div class="mt-4">
                    {{-- Check if booking and subject are loaded --}}
                    @if($review->booking && $review->booking->subject)
                    <p class="text-sm font-bold text-primary mb-2">
                        For: {{ $review->booking->subject->name }}
                    </p>
                    @endif
                    
                    {{-- Using 'comment' as per your store method --}}
                    <p class="text-gray-700 italic">"{{ $review->comment ?? 'No comment provided.' }}"</p>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border p-6 text-center">
                <p class="text-gray-500">You have not received any reviews yet.</p>
            </div>
        @endforelse

        {{-- Pagination Links --}}
        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    </div>
</main>
</body>
@endsection