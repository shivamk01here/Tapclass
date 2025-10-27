@extends('layouts.tutor') 

@section('title', 'My Bookings')

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
<h1 class="text-2xl sm:text-3xl font-black mb-6">My Bookings</h1>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
<p class="text-green-800">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
<p class="text-red-800">{{ session('error') }}</p>
</div>
@endif

<div class="space-y-6">

{{-- 1. Pending Requests Section --}}
<div class="bg-white rounded-xl border border-yellow-300 p-4 sm:p-6">
<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-yellow-600">pending_actions</span>
Pending Requests
</h2>

@forelse($pendingBookings as $booking)
<div class="border rounded-lg p-4 mb-3 hover:bg-gray-50">
<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
<div class="flex-1">
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-2">
<div class="w-12 h-12 rounded-full bg-secondary/20 flex items-center justify-center text-secondary font-bold flex-shrink-0">
{{ substr($booking->student->name, 0, 1) }}
</div>
<div>
<h3 class="font-bold">{{ $booking->subject->name }} with {{ $booking->student->name }}</h3>
<p class="text-sm text-gray-500">{{ $booking->booking_code }}</p>
</div>
</div>

<div class="flex flex-col sm:flex-row sm:gap-6 gap-3 text-sm mt-3">
<div>
<p class="text-gray-500">Date & Time</p>
<p class="font-medium">{{ $booking->session_date->format('M d, Y') }}</p>
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

{{-- Pending Actions --}}
<div class="flex flex-col sm:flex-row sm:gap-2 gap-2 w-full md:w-auto">
<form method="POST" action="{{ route('tutor.booking.approve', $booking->id) }}" class="w-full sm:w-auto">
@csrf
<button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 w-full sm:w-auto text-center">
Approve
</button>
</form>
<form method="POST" action="{{ route('tutor.booking.cancel', $booking->id) }}" class="w-full sm:w-auto">
@csrf
<button type="submit" onclick="return confirm('Decline this booking?')" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 w-full sm:w-auto">
Decline
</button>
</form>
</div>
</div>
</div>
@empty
<p class="text-gray-500 text-center py-8">No pending requests</p>
@endforelse
</div>

{{-- 2. Upcoming Sessions Section --}}
<div class="bg-white rounded-xl border p-4 sm:p-6">
<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-primary">event</span>
Upcoming Sessions
</h2>

@forelse($upcomingBookings as $booking)
{{-- Alpine.js component for inline editing --}}
<div 
    class="border rounded-lg p-4 mb-3 hover:bg-gray-50" 
    x-data="{ 
        editing: false, 
        newLink: '{{ $booking->meet_link ?? 'https://' }}', 
        bookingId: {{ $booking->id }}, 
        successMessage: '', 
        errorMessage: '' 
    }"
>
<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
<div class="flex-1">
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-2">
<div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold flex-shrink-0">
{{ substr($booking->student->name, 0, 1) }}
</div>
<div>
<h3 class="font-bold">{{ $booking->subject->name }} with {{ $booking->student->name }}</h3>
<p class="text-sm text-gray-500">{{ $booking->booking_code }}</p>
</div>
</div>
<div class="flex flex-col sm:flex-row sm:gap-6 gap-3 text-sm mt-3">
<div>
<p class="text-gray-500">Date & Time</p>
<p class="font-medium">{{ $booking->session_date->format('M d, Y') }}</p>
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

{{-- Upcoming Actions --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 gap-2 w-full md:w-auto">
@if($booking->isOnline())
<a :href="newLink" target="_blank" x-show="!editing" id="join-link-{{ $booking->id }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90 w-full sm:w-auto text-center">
Join Session
</a>
<button @click="editing = true" x-show="!editing" type="button" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 w-full sm:w-auto">
Edit Link
</button>
@endif
<form method="POST" action="{{ route('tutor.booking.complete', $booking->id) }}" class="w-full sm:w-auto" x-show="!editing">
@csrf
<button type="submit" onclick="return confirm('Mark this session as completed?')" class="bg-green-50 text-green-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-100 w-full sm:w-auto">
Mark as Completed
</button>
</form>
<form method="POST" action="{{ route('tutor.booking.cancel', $booking->id) }}" class="w-full sm:w-auto" x-show="!editing">
@csrf
<button type="submit" onclick="return confirm('Cancel this booking?')" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 w-full sm:w-auto">
Cancel
</button>
</form>
</div>
</div>

{{-- Inline Edit Form --}}
<div x-show="editing" class="mt-4" x-transition>
<p class="text-sm font-medium">Edit Meeting Link:</p>
<div class="flex flex-col sm:flex-row gap-2 mt-1">
<input type="url" x-model="newLink" class="flex-1 rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary">
<div class="flex gap-2">
<button 
    type="button" 
    @click="
        errorMessage = ''; successMessage = '';
        fetch(`/tutor/bookings/${bookingId}/update-link`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ meet_link: newLink })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                successMessage = 'Link updated!';
                editing = false;
                setTimeout(() => successMessage = '', 3000);
            } else {
                errorMessage = data.message || 'Error updating link.';
            }
        })
        .catch(() => errorMessage = 'An error occurred.')
    "
    class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90">
    Save
</button>
<button type="button" @click="editing = false" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">
Cancel
</button>
</div>
</div>
<p x-text="successMessage" class="text-sm text-green-600 mt-1"></p>
<p x-text="errorMessage" class="text-sm text-red-600 mt-1"></p>
</div>
</div>
@empty
<p class="text-gray-500 text-center py-8">No upcoming sessions</p>
@endforelse
</div>

{{-- 3. Past Sessions Section --}}
<div class="bg-white rounded-xl border p-4 sm:p-6">
<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-gray-600">history</span>
Past Sessions
</h2>

@forelse($pastBookings as $booking)
<div class="border rounded-lg p-4 mb-3">
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
<div class="flex-1">
<h3 class="font-bold">{{ $booking->subject->name }} with {{ $booking->student->name }}</h3>
<p class="text-sm text-gray-500">{{ $booking->session_date->format('M d, Y') }} • {{ $booking->booking_code }}</p>
</div>

<div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full sm:w-auto">
@if($booking->review)
<div class="flex items-center gap-1 text-yellow-500 w-full sm:w-auto justify-center sm:justify-end">
@for($i = 0; $i < $booking->review->rating; $i++)
<span class="material-symbols-outlined text-sm">star</span>
@endfor
</div>
@else
<p class="text-sm text-gray-500 italic text-center sm:text-right">No review yet</p>
@endif

{{-- Approve Payment Button --}}
{{-- NOTE: You must add a boolean column 'is_payment_approved' to your 'bookings' table for this to work --}}
@if(isset($booking->is_payment_approved) && !$booking->is_payment_approved)
<form method="POST" action="{{ route('tutor.booking.approve-payment', $booking->id) }}" class="w-full sm:w-auto">
@csrf
<button type="submit" class.="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-100 w-full sm:w-auto">
Approve Payment
</button>
</form>
@elseif(isset($booking->is_payment_approved) && $booking->is_payment_approved)
<span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium w-full sm:w-auto text-center">
Payment Approved
</span>
@endif
</div>
</div>
</div>
@empty
<p class="text-gray-500 text-center py-8">No past sessions</p>
@endforelse
</div>

{{-- 4. Cancelled Sessions Section --}}
@if($cancelledBookings->count() > 0)
<div class="bg-white rounded-xl border p-4 sm:p-6">
<h2 class="text-xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-red-600">cancel</span>
Cancelled Sessions
</h2>

@foreach($cancelledBookings as $booking)
<div class="border rounded-lg p-4 mb-3 opacity-60">
<div class="flex items-start justify-between">
<div>
<h3 class="font-bold">{{ $booking->subject->name }} with {{ $booking->student->name }}</h3>
<p class="text-sm text-gray-500">{{ $booking->session_date->format('M d, Y') }}</p>
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

{{-- Add Alpine.js CDN to your main layouts/tutor.blade.php if it's not already there --}}
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}