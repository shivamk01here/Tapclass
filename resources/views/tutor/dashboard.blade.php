@extends('layouts.tutor')

@section('title', 'Dashboard - TapClass')

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

<div class="mt-8 p-6 bg-white rounded-xl border border-gray-200">
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
</div>
@endsection
