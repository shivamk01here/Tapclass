<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Book a Session with {{ $tutor->user->name }} - Htc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: { "primary": "#13a4ec", "secondary": "#FFA500" },
            fontFamily: { "display": ["Manrope", "sans-serif"] }
          }
        }
      }
    </script>
</head>
<body class="bg-gray-50 font-display">
<!-- Header -->
<header class="bg-white border-b border-gray-200">
<div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
<a href="{{ route('home') }}" class="flex items-center gap-2 text-primary">
<svg class="w-8 h-8" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
</svg>
<span class="text-xl font-bold">Htc</span>
</a>
<div class="flex items-center gap-6">
<a href="{{ route('student.dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-primary">Dashboard</a>
<a href="{{ route('tutors.search') }}" class="text-sm font-medium text-gray-700 hover:text-primary">Tutors</a>
<a href="{{ route('student.bookings') }}" class="text-sm font-medium text-gray-700 hover:text-primary">My Sessions</a>
<a href="{{ route('home') }}#community" class="text-sm font-medium text-gray-700 hover:text-primary">Community</a>
<a href="{{ route('student.bookings') }}" class="px-5 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">Book a Session</a>
<button class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
<span class="material-symbols-outlined">notifications</span>
</button>
<a href="{{ route('student.profile') }}" class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
@if(auth()->user()->profile_picture)
<img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" class="w-10 h-10 rounded-full object-cover" alt="Profile" />
@else
<span class="text-primary font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
@endif
</a>
</div>
</div>
</header>
<!-- Main Content -->
<main class="max-w-5xl mx-auto px-4 py-8">
<!-- Back Button -->
<a href="{{ route('tutors.profile', $tutor->user_id) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary mb-6">
<span class="material-symbols-outlined">arrow_back</span>
<span>Back</span>
</a>

<!-- Title -->
<h1 class="text-3xl font-black mb-2">Book a Session with {{ $tutor->user->name }}</h1>
<p class="text-gray-500 mb-8">Follow the steps below to book your session.</p>

<!-- Progress Steps -->
<div class="flex items-center justify-center mb-12">
<div class="flex items-center gap-2">
<div class="flex items-center gap-2" id="step1-indicator">
<div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold">1</div>
<span class="font-medium">Select Subject</span>
</div>
<div class="w-16 h-0.5 bg-gray-300 mx-2"></div>
<div class="flex items-center gap-2" id="step2-indicator">
<div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold">2</div>
<span class="text-gray-500">Select Mode</span>
</div>
<div class="w-16 h-0.5 bg-gray-300 mx-2"></div>
<div class="flex items-center gap-2" id="step3-indicator">
<div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold">3</div>
<span class="text-gray-500">Pick a Date & Time</span>
</div>
<div class="w-16 h-0.5 bg-gray-300 mx-2"></div>
<div class="flex items-center gap-2" id="step4-indicator">
<div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold">4</div>
<span class="text-gray-500">Confirmation</span>
</div>
</div>
</div>

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
<ul class="list-disc pl-5">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<!-- Booking Grid -->
<div class="grid lg:grid-cols-3 gap-8">
<!-- Left: Booking Form -->
<div class="lg:col-span-2">
<form method="POST" action="{{ route('student.booking.store') }}" id="bookingForm">
@csrf
<input type="hidden" name="tutor_id" value="{{ $tutor->user_id }}"/>

<!-- Step 1: Select Subject -->
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
<h2 class="text-xl font-bold mb-4">Step 1: Select Subject</h2>
<select name="subject_id" id="subjectSelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-lg" required>
<option value="">Select a subject</option>
@foreach($subjects as $subject)
<option value="{{ $subject->id }}" data-rate="{{ $subject->pivot->online_rate ?? $tutor->hourly_rate }}">{{ $subject->name }}</option>
@endforeach
</select>
</div>

                <div>
                    <label class="block font-bold mb-2">Session Date</label>
                    <input type="date" name="session_date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" required/>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold mb-2">Start Time</label>
                        <input type="time" name="start_time" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" required/>
                    </div>
                    <div>
                        <label class="block font-bold mb-2">End Time</label>
                        <input type="time" name="end_time" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" required/>
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-2">Session Mode</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center gap-2 p-4 border rounded-lg cursor-pointer hover:border-primary">
                            <input type="radio" name="session_mode" value="online" checked class="text-primary"/>
                            <div>
                                <p class="font-semibold">Online</p>
                                <p class="text-sm text-gray-500">Via video call</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 p-4 border rounded-lg cursor-pointer hover:border-primary">
                            <input type="radio" name="session_mode" value="in-person" class="text-primary"/>
                            <div>
                                <p class="font-semibold">In-Person</p>
                                <p class="text-sm text-gray-500">Meet in person</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="locationField" style="display:none;">
                    <label class="block font-bold mb-2">Location</label>
                    <input type="text" name="location" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" placeholder="Enter meeting location"/>
                </div>

                <div>
                    <label class="block font-bold mb-2">Special Requirements (Optional)</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" placeholder="Any specific topics or requirements?"></textarea>
                </div>

                <button type="submit" class="w-full px-6 py-4 bg-primary text-white rounded-lg font-bold text-lg hover:bg-primary/90">
Confirm Booking & Pay ₹<span id="totalAmount">{{ number_format($tutorProfile->hourly_rate, 0) }}</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Sidebar -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg border p-6 sticky top-4">
            <h3 class="font-bold text-lg mb-4">Booking Summary</h3>
            
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                        <span class="text-primary font-bold text-lg">{{ substr($tutor->user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-bold">{{ $tutor->user->name }}</p>
                        <div class="flex items-center gap-1 text-yellow-500 text-sm">
                            <span class="material-symbols-outlined text-sm">star</span>
                            <span>{{ number_format($tutorProfile->rating, 1) }}</span>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-3">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Hourly Rate</span>
                        <span class="font-bold">₹{{ number_format($tutorProfile->hourly_rate, 0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-bold" id="durationText">1 hour</span>
                    </div>
                    <div class="border-t pt-2 flex justify-between">
                        <span class="font-bold">Total</span>
                        <span class="font-bold text-primary text-lg">₹<span id="summaryAmount">{{ number_format($tutorProfile->hourly_rate, 0) }}</span></span>
                    </div>
                </div>

                <div class="bg-blue-50 p-3 rounded-lg mt-4">
                    <p class="text-sm text-gray-700">
                        <span class="material-symbols-outlined text-sm align-middle">info</span>
                        Payment will be deducted from your wallet
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<script>
const startTimeInput = document.querySelector('input[name="start_time"]');
const endTimeInput = document.querySelector('input[name="end_time"]');
const hourlyRate = {{ $tutorProfile->hourly_rate }};
const sessionModeInputs = document.querySelectorAll('input[name="session_mode"]');
const locationField = document.getElementById('locationField');

function calculateTotal() {
    const start = startTimeInput.value;
    const end = endTimeInput.value;
    
    if (start && end) {
        const startDate = new Date('2000-01-01 ' + start);
        const endDate = new Date('2000-01-01 ' + end);
        const hours = (endDate - startDate) / (1000 * 60 * 60);
        
        if (hours > 0) {
            const total = hours * hourlyRate;
            document.getElementById('totalAmount').textContent = Math.round(total).toLocaleString();
            document.getElementById('summaryAmount').textContent = Math.round(total).toLocaleString();
            document.getElementById('durationText').textContent = hours + ' hour' + (hours !== 1 ? 's' : '');
        }
    }
}

startTimeInput.addEventListener('change', calculateTotal);
endTimeInput.addEventListener('change', calculateTotal);

sessionModeInputs.forEach(input => {
    input.addEventListener('change', function() {
        if (this.value === 'in-person') {
            locationField.style.display = 'block';
            locationField.querySelector('input').required = true;
        } else {
            locationField.style.display = 'none';
            locationField.querySelector('input').required = false;
        }
    });
});
</script>
</body>
</html>
@endsection