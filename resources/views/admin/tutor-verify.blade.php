@extends('layouts.admin')

@section('page-title', 'Verify Tutor')

@section('content')
<div class="mb-6">
<a href="{{ route('admin.tutors') }}" class="text-primary font-bold hover:underline">← Back to Tutors</a>
</div>

<div class="flex items-center gap-4 mb-8">
@php $pp = $tutor->profile_picture; $ppUrl = $pp ? (\Illuminate\Support\Str::startsWith($pp, ['/storage','http']) ? asset(ltrim($pp,'/')) : asset('storage/'.$pp)) : null; @endphp
@if($ppUrl)
<img src="{{ $ppUrl }}" class="w-20 h-20 rounded-full object-cover border-2 border-primary" alt="{{ $tutor->name }}" />
@else
<div class="w-20 h-20 rounded-full bg-primary/20 flex items-center justify-center border-2 border-primary">
<span class="text-primary font-bold text-2xl">{{ substr($tutor->name, 0, 1) }}</span>
</div>
@endif
<div>
<h1 class="text-3xl font-black mb-1">{{ $tutor->name }}</h1>
<p class="text-gray-600">Review tutor application</p>
</div>
</div>

<div class="grid md:grid-cols-2 gap-8">
    <!-- Tutor Information -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold mb-4">Personal Information</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm text-gray-500">Full Name</dt>
                    <dd class="font-semibold">{{ $tutor->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Email</dt>
                    <dd class="font-semibold">{{ $tutor->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Phone</dt>
                    <dd class="font-semibold">{{ $tutor->phone }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Location</dt>
                    <dd class="font-semibold">{{ $profile->city }}, {{ $profile->state }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold mb-4">Professional Details</h2>
            <dl class="space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Education</dt>
                        <dd class="font-semibold">{{ $profile->education ?? $profile->qualification ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Experience</dt>
                        <dd class="font-semibold">{{ (int)$profile->experience_years }} years</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Gender</dt>
                        <dd class="font-semibold">{{ ucfirst($profile->gender ?? '—') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Consultation Fee</dt>
                        <dd class="font-semibold">₹{{ number_format((int)$profile->hourly_rate,0) }}/hr</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Teaching Mode</dt>
                        <dd class="font-semibold">{{ ucfirst($profile->teaching_mode ?? '—') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Travel Radius</dt>
                        <dd class="font-semibold">{{ $profile->travel_radius_km ? $profile->travel_radius_km.' km' : '—' }}</dd>
                    </div>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Languages</dt>
                    <dd class="font-semibold">{{ !empty($languages) ? implode(', ', $languages) : '—' }}</dd>
                </div>
                @if(!empty($gradeLevels))
                <div>
                    <dt class="text-sm text-gray-500">Grades/Levels</dt>
                    <dd class="mt-1 flex flex-wrap gap-2">
                        @foreach($gradeLevels as $gl)
                            <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">{{ is_string($gl) ? strtoupper($gl) : json_encode($gl) }}</span>
                        @endforeach
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold mb-4">Location</h2>
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm text-gray-500">City</dt>
                    <dd class="font-semibold">{{ $profile->city ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">State</dt>
                    <dd class="font-semibold">{{ $profile->state ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">PIN Code</dt>
                    <dd class="font-semibold">{{ $profile->pin_code ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Coordinates</dt>
                    <dd class="font-semibold">{{ $profile->latitude ? ($profile->latitude.', '.$profile->longitude) : '—' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold mb-4">Subjects & Rates</h2>
            <div class="space-y-3">
                @foreach($subjects as $subject)
                <div class="border rounded-lg p-4">
                    <h3 class="font-bold text-lg mb-2">{{ $subject->name }}</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        @if($subject->pivot->is_online_available)
                        <div>
                            <span class="text-gray-500">Online:</span>
                            <span class="font-semibold text-primary">₹{{ number_format($subject->pivot->online_rate, 0) }}/hr</span>
                        </div>
                        @endif
                        @if($subject->pivot->is_offline_available)
                        <div>
                            <span class="text-gray-500">Offline:</span>
                            <span class="font-semibold text-primary">₹{{ number_format($subject->pivot->offline_rate, 0) }}/hr</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold mb-4">Bio</h2>
            <p class="text-gray-700">{{ $profile->bio ?: 'No bio provided' }}</p>
        </div>
    </div>

    <!-- Documents & Actions -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold mb-4">Uploaded Documents</h2>
            
            <div class="space-y-4">
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold">Government ID</span>
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                    <a href="{{ asset('storage/' . $profile->government_id_path) }}" target="_blank" class="text-primary hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">description</span>
                        View Document
                    </a>
                </div>

                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold">Degree Certificate</span>
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                    <a href="{{ asset('storage/' . $profile->degree_certificate_path) }}" target="_blank" class="text-primary hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">description</span>
                        View Document
                    </a>
                </div>

                @if($profile->cv_path)
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold">Curriculum Vitae (CV)</span>
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                    <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="text-primary hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">description</span>
                        View CV
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold mb-4">Verification Actions</h2>
            
            @if($profile->verification_status === 'pending')
            <form method="POST" action="{{ route('admin.tutors.approve', $tutor->id) }}" class="mb-4">
                @csrf
                <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">check</span>
                    Approve Tutor
                </button>
            </form>

            <form method="POST" action="{{ route('admin.tutors.reject', $tutor->id) }}">
                @csrf
                <textarea name="reason" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary mb-3" placeholder="Reason for rejection (required)" required></textarea>
                <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">close</span>
                    Reject Application
                </button>
            </form>
            @elseif($profile->verification_status === 'verified')
            <div class="bg-green-50 text-green-700 p-4 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">verified</span>
                <span class="font-bold">This tutor is verified</span>
            </div>
            @else
            <div class="bg-red-50 text-red-700 p-4 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">cancel</span>
                <span class="font-bold">This application was rejected</span>
            </div>
            @if($profile->verification_notes)
            <p class="mt-3 text-sm text-gray-700"><strong>Reason:</strong> {{ $profile->verification_notes }}</p>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection
