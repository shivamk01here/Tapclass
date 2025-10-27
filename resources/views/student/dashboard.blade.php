@extends('layouts.student')

@section('title', 'Dashboard - TapClass')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
@if(session('success'))
<div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 border border-green-200 rounded-lg">
<p class="text-green-800 text-sm sm:text-base">{{ session('success') }}</p>
</div>
@endif

<h1 class="text-2xl sm:text-3xl font-black text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
<p class="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8">Your wallet balance: ₹{{ auth()->user()->wallet->balance ?? '0.00' }}</p>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
<a href="{{ route('tutors.search') }}" class="block p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-shadow">
<span class="material-symbols-outlined text-3xl sm:text-4xl text-primary mb-2">search</span>
<h3 class="text-base sm:text-lg font-bold mb-1">Find a Tutor</h3>
<p class="text-xs sm:text-sm text-gray-600">Browse and book tutors</p>
</a>

<a href="{{ route('student.bookings') }}" class="block p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-shadow">
<span class="material-symbols-outlined text-3xl sm:text-4xl text-primary mb-2">book_online</span>
<h3 class="text-base sm:text-lg font-bold mb-1">My Bookings</h3>
<p class="text-xs sm:text-sm text-gray-600">View your sessions</p>
</a>

<a href="{{ route('student.wallet') }}" class="block p-4 sm:p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-shadow">
<span class="material-symbols-outlined text-3xl sm:text-4xl text-primary mb-2">account_balance_wallet</span>
<h3 class="text-base sm:text-lg font-bold mb-1">Wallet</h3>
<p class="text-xs sm:text-sm text-gray-600">Manage your balance</p>
</a>
</div>

<!-- Upcoming Sessions -->
<div class="mt-6 sm:mt-8">
<h2 class="text-xl sm:text-2xl font-bold mb-4">Upcoming Sessions</h2>
@if($upcomingSessions->count() > 0)
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
<div class="divide-y divide-gray-200">
@foreach($upcomingSessions as $session)
<div class="p-4 sm:p-6 hover:bg-gray-50 transition">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
<div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
<img src="{{ $session->tutor->profile_picture ? asset('storage/' . $session->tutor->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($session->tutor->name) }}" 
alt="{{ $session->tutor->name }}" 
class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover flex-shrink-0">
<div class="min-w-0">
<h3 class="font-bold text-gray-900 text-sm sm:text-base truncate">{{ $session->tutor->name }}</h3>
<p class="text-xs sm:text-sm text-gray-600 truncate">{{ $session->subject->name }}</p>
</div>
</div>
<div class="text-left sm:text-right">
<p class="text-xs sm:text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }}</p>
<p class="text-xs sm:text-sm text-gray-600">{{ \Carbon\Carbon::createFromFormat('H:i:s', $session->session_start_time)->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->session_end_time)->format('g:i A') }}</p>
</div>
</div>
</div>
@endforeach
</div>
</div>
@else
<div class="bg-white rounded-xl border border-gray-200 p-6 sm:p-8 text-center">
<span class="material-symbols-outlined text-5xl sm:text-6xl text-gray-300 mb-3">event_busy</span>
<p class="text-sm sm:text-base text-gray-600">No upcoming sessions. <a href="{{ route('tutors.search') }}" class="text-primary hover:underline">Find a tutor</a> to book your first session!</p>
</div>
@endif
</div>

<!-- Recommended Tutors -->
<div class="mt-6 sm:mt-8">
<div class="flex items-center justify-between mb-4">
<h2 class="text-xl sm:text-2xl font-bold">Recommended Tutors</h2>
<a href="{{ route('tutors.search') }}" class="text-primary hover:underline text-xs sm:text-sm font-medium">View All</a>
</div>
@if($recommendedTutors->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
@foreach($recommendedTutors as $tutor)
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
<div class="p-4 sm:p-6">
<div class="flex items-start gap-4 mb-4">
<img src="{{ $tutor->user->profile_picture ? asset('storage/' . $tutor->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($tutor->user->name) }}" 
alt="{{ $tutor->user->name }}" 
class="w-16 h-16 rounded-full object-cover">
<div class="flex-1">
<h3 class="font-bold text-gray-900 mb-1">{{ $tutor->user->name }}</h3>
<div class="flex items-center gap-1 text-sm text-gray-600">
<span class="material-symbols-outlined text-yellow-500" style="font-size: 16px;">star</span>
<span class="font-medium">{{ number_format($tutor->average_rating, 1) }}</span>
<span>({{ $tutor->total_reviews }})</span>
</div>
</div>
</div>
<div class="mb-4">
<p class="text-sm text-gray-700 line-clamp-2">{{ $tutor->bio ?? 'Experienced tutor' }}</p>
</div>
<div class="flex flex-wrap gap-2 mb-4">
@foreach($tutor->subjects->take(3) as $subject)
<span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">{{ $subject->name }}</span>
@endforeach
</div>
<a href="{{ route('tutors.profile', $tutor->user_id) }}" 
class="block w-full py-2 px-4 bg-primary text-white text-center font-medium rounded-lg hover:bg-blue-700 transition">
View Profile
</a>
</div>
</div>
@endforeach
</div>
@else
<div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
<span class="material-symbols-outlined text-6xl text-gray-300 mb-3">person_search</span>
<p class="text-gray-600 mb-3">No recommended tutors found.</p>
<a href="{{ route('student.profile') }}" class="text-primary hover:underline">Update your subject preferences</a> to see personalized recommendations.
</div>
@endif
</div>
@endsection
