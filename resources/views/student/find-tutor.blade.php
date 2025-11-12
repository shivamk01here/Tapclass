@extends('layouts.public')

@section('title', 'Contact Us - Htc')

@section('content')
<body class="bg-gray-50 font-display">
<div class="min-h-screen">
<header class="bg-white border-b px-6 py-4">
<div class="flex items-center justify-between max-w-7xl mx-auto">
<a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined">arrow_back</span>
<span class="font-bold">Back to Dashboard</span>
</a>
<form method="POST" action="{{ route('logout') }}" class="inline">
@csrf
<button class="text-sm text-gray-600 hover:text-primary">Logout</button>
</form>
</div>
</header>

<main class="max-w-7xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">Find Your Perfect Tutor</h1>

<form method="GET" class="bg-white p-6 rounded-xl border mb-6">
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
<div>
<label class="block text-sm font-medium mb-2">Subject</label>
<select name="subject_id" class="w-full rounded-lg border-gray-300">
<option value="">All Subjects</option>
@foreach($subjects as $subject)
<option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
{{ $subject->name }}
</option>
@endforeach
</select>
</div>
<div>
<label class="block text-sm font-medium mb-2">Session Type</label>
<select name="session_type" class="w-full rounded-lg border-gray-300">
<option value="">Both</option>
<option value="online" {{ request('session_type') == 'online' ? 'selected' : '' }}>Online</option>
<option value="offline" {{ request('session_type') == 'offline' ? 'selected' : '' }}>Offline</option>
</select>
</div>
<div>
<label class="block text-sm font-medium mb-2">Min Rating</label>
<select name="min_rating" class="w-full rounded-lg border-gray-300">
<option value="">Any</option>
<option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
<option value="4.5" {{ request('min_rating') == '4.5' ? 'selected' : '' }}>4.5+ Stars</option>
</select>
</div>
<div>
<label class="block text-sm font-medium mb-2">Sort By</label>
<select name="sort_by" class="w-full rounded-lg border-gray-300">
<option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>Rating</option>
<option value="reviews" {{ request('sort_by') == 'reviews' ? 'selected' : '' }}>Reviews</option>
</select>
</div>
</div>
<button type="submit" class="mt-4 bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90">
Search
</button>
</form>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
@forelse($tutors as $tutor)
<div class="bg-white rounded-xl border p-6 hover:shadow-lg transition-shadow">
<div class="flex items-start justify-between mb-4">
<div class="flex items-center gap-3">
<div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center text-primary text-2xl font-bold">
{{ substr($tutor->user->name, 0, 1) }}
</div>
<div>
<h3 class="font-bold text-lg">{{ $tutor->user->name }}</h3>
@if($tutor->is_verified_badge)
<span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">✓ Verified</span>
@endif
</div>
</div>
<button onclick="toggleLike({{ $tutor->user_id }})" class="heart-btn text-2xl" data-tutor-id="{{ $tutor->user_id }}">
{{ $tutor->likes->where('student_id', auth()->id())->count() > 0 ? '❤️' : '🤍' }}
</button>
</div>

<p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $tutor->bio }}</p>

<div class="flex items-center gap-2 mb-3">
<span class="material-symbols-outlined text-yellow-500">star</span>
<span class="font-bold">{{ number_format($tutor->average_rating, 1) }}</span>
<span class="text-sm text-gray-500">({{ $tutor->total_reviews }} reviews)</span>
</div>

<div class="flex flex-wrap gap-2 mb-3">
@foreach($tutor->subjects->take(3) as $subject)
<span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded">{{ $subject->name }}</span>
@endforeach
</div>

<div class="flex items-center justify-between mb-4">
<div>
@php
    $rates = [];
    foreach($tutor->subjects as $s) {
        if($s->pivot->online_rate && $s->pivot->online_rate > 0) {
            $rates[] = $s->pivot->online_rate;
        }
        if($s->pivot->offline_rate && $s->pivot->offline_rate > 0) {
            $rates[] = $s->pivot->offline_rate;
        }
    }
    $minRate = count($rates) > 0 ? min($rates) : 0;
@endphp
@if($minRate > 0)
    <p class="text-lg font-bold text-primary">From ₹{{ number_format($minRate, 0) }}<span class="text-sm text-gray-500 font-normal">/hour</span></p>
@else
    <p class="text-sm text-gray-500">Price on request</p>
@endif
</div>
<div class="text-sm text-gray-500">
{{ $tutor->experience_years }}+ yrs exp
</div>
</div>

<div class="flex gap-2">
<a href="{{ route('student.tutor.profile', $tutor->user_id) }}" class="flex-1 text-center bg-gray-100 text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-200 text-sm font-medium">
View Profile
</a>
<a href="{{ route('student.booking.create', $tutor->user_id) }}" class="flex-1 text-center bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium">
Book Now
</a>
</div>
</div>
@empty
<div class="col-span-3 text-center py-12">
<p class="text-gray-500">No tutors found. Try adjusting your filters.</p>
</div>
@endforelse
</div>

<div class="mt-6">
{{ $tutors->links() }}
</div>
</main>
</div>

<script>
async function toggleLike(tutorId) {
    try {
        const response = await fetch(`/student/tutor/${tutorId}/toggle-like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        const data = await response.json();
        if (data.success) {
            const btn = document.querySelector(`[data-tutor-id=\"${tutorId}\"]`);
            btn.textContent = data.liked ? '❤️' : '🤍';
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
</body>
</html>
@endsection