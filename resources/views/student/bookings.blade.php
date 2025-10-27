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
{{-- Responsive Page Title: smaller on mobile, larger on desktop --}}
<h1 class="text-2xl sm:text-3xl font-black mb-6">My Bookings</h1>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
<p class="text-green-800">{{ session('success') }}</p>
</div>
@endif

<div class="space-y-6">
{{-- Responsive Padding: p-4 on mobile, p-6 on sm and up --}}
<div class="bg-white rounded-xl border p-4 sm:p-6">
<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-primary">event</span>
Upcoming Sessions
</h2>

@forelse($upcomingBookings as $booking)
<div class="border rounded-lg p-4 mb-3 hover:bg-gray-50">
{{-- Responsive Layout: stacks on mobile, row on md and up --}}
<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
<div class="flex-1">
{{-- Stacks avatar and name on small screens for better fit --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-2">
<div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold flex-shrink-0">
{{ substr($booking->tutor->name, 0, 1) }}
</div>
<div>
<h3 class="font-bold">{{ $booking->subject->name }} with {{ $booking->tutor->name }}</h3>
<p class="text-sm text-gray-500">{{ $booking->booking_code }}</p>
</div>
</div>

{{-- Responsive Details: stacks on mobile, row on sm and up --}}
<div class="flex flex-col sm:flex-row sm:gap-6 gap-3 text-sm mt-3">
<div>
<p class="text-gray-500">Date & Time</p>
<p class="font-medium">{{ \Carbon\Carbon::parse($booking->session_date)->format('M d, Y') }}</p>
<p class="font-medium">{{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->session_start_time)->format('h:i A') }}</p>
</div>
<div>
<p class="text-gray-500">Duration</p>
<p class="font-medium">{{ $booking->session_duration_minutes }} min</p>
</div>
<div>
<p class="text-gray-500">Type</p>
<p class="font-medium capitalize">{{ $booking->session_type }}</p>
</div>
</div>
</div>

{{-- Responsive Actions: stacks on mobile, row on sm and up. Full-width on mobile. --}}
<div class="flex flex-col sm:flex-row sm:gap-2 gap-2 w-full md:w-auto">
@if($booking->isOnline())
<a href="{{ $booking->meet_link }}" target="_blank" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90 w-full sm:w-auto text-center">
Join Session
</a>
@endif
{{-- Removed 'inline' class, letting flex control the form --}}
<form method="POST" action="{{ route('student.booking.cancel', $booking->id) }}" class="w-full sm:w-auto">
@csrf
<button type="submit" onclick="return confirm('Cancel this booking?')" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 w-full sm:w-auto">
Cancel
</button>
</form>
</div>
</div>
</div>
@empty
<p class="text-gray-500 text-center py-8">No upcoming sessions</p>
@endforelse
</div>

<div class="bg-white rounded-xl border p-4 sm:p-6">
<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-gray-600">history</span>
Past Sessions
</h2>

@forelse($pastBookings as $booking)
<div class="border rounded-lg p-4 mb-3">
{{-- Responsive Layout: stacks on mobile, row/centered on sm and up --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
<div class="flex-1">
<h3 class="font-bold">{{ $booking->subject->name }} with {{ $booking->tutor->name }}</h3>
<p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->session_date)->format('M d, Y') }} • {{ $booking->booking_code }}</p>
</div>

@if(!$booking->review)
{{-- Responsive Button: full-width on mobile, auto-width on sm and up --}}
<a href="{{ route('student.review.create', $booking->id) }}" class="bg-yellow-50 text-yellow-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-100 w-full sm:w-auto text-center">
    Rate & Review
</a>
@else
{{-- Responsive Stars: centered on mobile, right-aligned on sm and up --}}
<div class="flex items-center gap-1 text-yellow-500 w-full sm:w-auto justify-center sm:justify-end">
@for($i = 0; $i < $booking->review->rating; $i++)
<span class="material-symbols-outlined text-sm">star</span>
@endfor
</div>
@endif
</div>
</div>
@empty
<p class="text-gray-500 text-center py-8">No past sessions</p>
@endforelse
</div>

@if($cancelledBookings->count() > 0)
<div class="bg-white rounded-xl border p-4 sm:p-6">
<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-red-600">cancel</span>
Cancelled Sessions
</h2>

@foreach($cancelledBookings as $booking)
{{-- This layout is already responsive as content is naturally stacked --}}
<div class="border rounded-lg p-4 mb-3 opacity-60">
<div class="flex items-start justify-between">
<div>
<h3 class="font-bold">{{ $booking->subject->name }} with {{ $booking->tutor->name }}</h3>
<p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->session_date)->format('M d, Y') }}</p>
<p class="text-sm text-red-600 mt-1">Cancelled by {{ $booking->cancelled_by }}</p>
</div>
</div>
</div>
@endforeach
</div>
@endif
</div>
</main>
</body>
</html>

@endsection