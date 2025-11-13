@extends('layouts.tutor')

@section('title', 'Dashboard - Htc')

@section('content')
<div class="max-w-7xl mx-auto px-8 py-8">
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
<p class="text-green-800">{{ session('success') }}</p>
</div>
@endif

@if(auth()->user()->tutorProfile && auth()->user()->tutorProfile->verification_status === 'pending')
<div class="mb-6 p-6 bg-blue-50 border border-blue-200 rounded-lg">
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-2xl text-blue-600">info</span>
<div>
<h3 class="font-bold text-blue-900 mb-1">Profile Under Review</h3>
<p class="text-sm text-blue-800">Your profile is currently being reviewed by our team. You'll be notified once it's approved.</p>
</div>
</div>
</div>
@endif

@if(auth()->user()->tutorProfile && auth()->user()->tutorProfile->verification_status === 'rejected')
<div class="mb-6 p-6 bg-red-50 border border-red-200 rounded-lg">
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-2xl text-red-600">error</span>
<div>
<h3 class="font-bold text-red-900 mb-1">Profile Rejected</h3>
<p class="text-sm text-red-800 mb-2">{{ auth()->user()->tutorProfile->verification_notes ?? 'Your profile was rejected. Please update your information.' }}</p>
<a href="{{ route('tutor.onboarding') }}" class="text-sm text-red-800 underline font-medium">Update Profile</a>
</div>
</div>
</div>
@endif

<h1 class="text-3xl font-black text-gray-900 mb-2">Tutor Dashboard</h1>
<p class="text-gray-600 mb-8">Manage your teaching profile and sessions</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="p-6 bg-white rounded-xl border border-gray-200">
<span class="material-symbols-outlined text-4xl text-primary mb-2">payments</span>
<h3 class="text-lg font-bold mb-1">Total Earnings</h3>
<p class="text-2xl font-black text-gray-900">₹0.00</p>
</div>

<div class="p-6 bg-white rounded-xl border border-gray-200">
<span class="material-symbols-outlined text-4xl text-primary mb-2">event</span>
<h3 class="text-lg font-bold mb-1">Upcoming Sessions</h3>
<p class="text-2xl font-black text-gray-900">0</p>
</div>

<div class="p-6 bg-white rounded-xl border border-gray-200">
<span class="material-symbols-outlined text-4xl text-primary mb-2">star</span>
<h3 class="text-lg font-bold mb-1">Average Rating</h3>
<p class="text-2xl font-black text-gray-900">{{ auth()->user()->tutorProfile->average_rating ?? '0.0' }}</p>
</div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
  <!-- Left: Quick actions -->
  <div class="lg:col-span-2 p-6 bg-white rounded-xl border border-gray-200">
    <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <a href="{{ route('tutor.profile') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
        <span class="material-symbols-outlined text-2xl text-primary">person</span>
        <h3 class="font-bold mt-2">Edit Profile</h3>
      </a>
      <a href="{{ route('tutor.availability') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
        <span class="material-symbols-outlined text-2xl text-primary">schedule</span>
        <h3 class="font-bold mt-2">Set Availability</h3>
      </a>
    </div>
  </div>

  <!-- Right: Calendar -->
  <div class="bg-white rounded-xl border border-gray-200 p-4">
    <div class="flex items-center justify-between mb-3">
      <h2 class="text-lg font-bold">{{ $calendar['monthName'] }} {{ $calendar['year'] }}</h2>
      <span class="text-xs text-gray-500">Current month</span>
    </div>
    <div class="grid grid-cols-7 gap-1 text-xs text-gray-500 mb-1">
      <div class="text-center">Sun</div><div class="text-center">Mon</div><div class="text-center">Tue</div><div class="text-center">Wed</div><div class="text-center">Thu</div><div class="text-center">Fri</div><div class="text-center">Sat</div>
    </div>
    <div class="grid grid-cols-7 gap-1 max-h-72 overflow-y-auto pr-1">
      @php
        $firstBlank = $calendar['firstWeekday'];
        $days = $calendar['daysInMonth'];
        $day = 1;
      @endphp
      @for($i=0; $i < $firstBlank; $i++)
        <div class="p-2 text-xs text-gray-400 text-center">&nbsp;</div>
      @endfor
      @for($d=1; $d <= $days; $d++)
        @php
          $date = sprintf('%04d-%02d-%02d', $calendar['year'], $calendar['month'], $d);
          $isToday = ($date === ($todayStr ?? '1970-01-01'));
          $count = (int)($hasBookings[$date] ?? 0);
        @endphp
        <div class="relative p-2 text-center">
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full {{ $isToday ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-100' }}">
            {{ $d }}
          </div>
          @if($count > 0)
            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full ring-2 ring-white bg-primary" title="{{ $count }} booking(s)"></span>
          @endif
        </div>
      @endfor
    </div>
    <div class="mt-3 flex items-center gap-3 text-xs text-gray-500">
      <span class="inline-flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-primary"></span> Booking day</span>
      <span class="inline-flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-200 border border-blue-400"></span> Today</span>
    </div>
  </div>
</div>
</div>
@endsection
