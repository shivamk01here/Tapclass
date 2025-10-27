@extends('layouts.student')

@section('title', 'Page Title')

@section('content')
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<div class="flex items-center justify-between max-w-7xl mx-auto">
<a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined">arrow_back</span>
<span class="font-bold">Back</span>
</a>
</div>
</header>

<main class="max-w-7xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">My Wishlist</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
@forelse($likedTutors as $tutor)
<div class="bg-white rounded-xl border p-6">
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
</div>

<p class="text-sm text-gray-600 mb-3">{{ Str::limit($tutor->bio, 100) }}</p>

<div class="flex items-center gap-2 mb-4">
<span class="material-symbols-outlined text-yellow-500 text-lg">star</span>
<span class="font-bold">{{ number_format($tutor->average_rating, 1) }}</span>
<span class="text-sm text-gray-500">({{ $tutor->total_reviews }})</span>
</div>

<div class="flex gap-2">
<a href="{{ route('student.tutor.profile', $tutor->id) }}" class="flex-1 text-center bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200 text-sm font-medium">
View Profile
</a>
<a href="{{ route('student.booking.create', $tutor->id) }}" class="flex-1 text-center bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium">
Book Now
</a>
</div>
</div>
@empty
<div class="col-span-3 text-center py-12">
<span class="material-symbols-outlined text-gray-300 text-6xl mb-4">favorite_border</span>
<p class="text-gray-500">No tutors in your wishlist yet</p>
<a href="{{ route('student.find-tutor') }}" class="inline-block mt-4 bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90">
Find Tutors
</a>
</div>
@endforelse
</div>
</main>
</body>
</html>
@endsection