@extends('layouts.tutor')

@section('content')
<div class="max-w-2xl mx-auto">
<div class="bg-white rounded-xl border border-gray-200 p-8">
<h1 class="text-3xl font-black text-gray-900 mb-2">Welcome to TapClass!</h1>
<p class="text-gray-600 mb-6">Your profile has been submitted for review. We'll notify you once your account is verified.</p>

<div class="space-y-4">
<div class="flex items-center gap-4 p-5 bg-blue-50 border border-blue-200 rounded-lg">
<div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-white text-3xl">schedule</span>
</div>
<div>
<h3 class="font-bold text-lg text-gray-900">Verification Status: {{ ucfirst(auth()->user()->tutorProfile->verification_status) }}</h3>
<p class="text-sm text-gray-600 mt-1">Our team is reviewing your submitted documents. This usually takes 24-48 hours.</p>
</div>
</div>

<div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
<h3 class="font-bold text-gray-900 mb-3">What happens next?</h3>
<ul class="space-y-2 text-sm text-gray-600">
<li class="flex items-start gap-2">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span>We'll verify your government ID and degree certificate</span>
</li>
<li class="flex items-start gap-2">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span>You'll receive an email notification once verified</span>
</li>
<li class="flex items-start gap-2">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span>You can then start accepting bookings from students</span>
</li>
</ul>
</div>

<a href="{{ route('tutor.dashboard') }}" class="block w-full text-center bg-primary text-white font-bold py-3 px-4 rounded-lg hover:bg-primary/90 transition-colors">
Go to Dashboard
</a>
</div>
</div>
</div>
@endsection
