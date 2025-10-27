<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Book a Session with {{ $tutor->user->name }} - TapClass</title>
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
<span class="text-xl font-bold">TapClass</span>
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
<main class="max-w-6xl mx-auto px-4 py-8">
<!-- Back Button -->
<a href="{{ route('tutors.profile', $tutor->user_id) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary mb-6">
<span class="material-symbols-outlined">arrow_back</span>
</a>

<!-- Title -->
<h1 class="text-3xl font-black mb-2">Book a Session with {{ $tutor->user->name }}</h1>
<p class="text-gray-500 mb-8">Follow the steps below to book your session.</p>

<!-- Progress Steps -->
<div class="flex items-center justify-center mb-12">
<div class="flex items-center gap-2">
<div class="flex items-center gap-2">
<div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-lg">1</div>
<span class="font-medium">Select Subject</span>
</div>
<div class="w-20 h-0.5 bg-gray-300 mx-2"></div>
<div class="flex items-center gap-2">
<div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg">2</div>
<span class="text-gray-500">Select Mode</span>
</div>
<div class="w-20 h-0.5 bg-gray-300 mx-2"></div>
<div class="flex items-center gap-2">
<div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg">3</div>
<span class="text-gray-500">Pick a Date & Time</span>
</div>
<div class="w-20 h-0.5 bg-gray-300 mx-2"></div>
<div class="flex items-center gap-2">
<div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg">4</div>
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
<option value="">Mathematics</option>
@foreach($subjects as $subject)
<option value="{{ $subject->id }}" data-rate="{{ $subject->pivot->online_rate ?? $tutor->hourly_rate }}">{{ $subject->name }}</option>
@endforeach
</select>
</div>

<!-- Step 2: Select Mode -->
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
<h2 class="text-xl font-bold mb-4">Step 2: Select Mode</h2>
<div class="space-y-3">
<label class="flex items-center gap-3 p-4 border-2 border-primary bg-primary/5 rounded-lg cursor-pointer">
<input type="radio" name="session_mode" value="online" checked class="text-primary w-5 h-5"/>
<div class="flex-1">
<p class="font-semibold">Online</p>
<p class="text-sm text-gray-600">₹{{ number_format($tutor->hourly_rate, 0) }}/hr</p>
</div>
</label>
<label class="flex items-center gap-3 p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary">
<input type="radio" name="session_mode" value="in-person" class="text-primary w-5 h-5"/>
<div class="flex-1">
<p class="font-semibold">Offline</p>
<p class="text-sm text-gray-600">₹{{ number_format($tutor->hourly_rate + 100, 0) }}/hr</p>
</div>
</label>
</div>
</div>

<!-- Step 3: Pick Date & Time -->
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
<h2 class="text-xl font-bold mb-4">Step 3: Pick a Date & Time</h2>

<!-- Calendar -->
<div class="mb-6">
<div class="flex items-center justify-between mb-4">
<button type="button" class="p-2 hover:bg-gray-100 rounded-lg">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<span class="font-semibold text-lg">May 2024</span>
<button type="button" class="p-2 hover:bg-gray-100 rounded-lg">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>

<!-- Calendar Grid -->
<div class="grid grid-cols-7 gap-1 mb-4">
<div class="text-center text-sm font-medium text-gray-600 py-2">S</div>
<div class="text-center text-sm font-medium text-gray-600 py-2">M</div>
<div class="text-center text-sm font-medium text-gray-600 py-2">T</div>
<div class="text-center text-sm font-medium text-gray-600 py-2">W</div>
<div class="text-center text-sm font-medium text-gray-600 py-2">T</div>
<div class="text-center text-sm font-medium text-gray-600 py-2">F</div>
<div class="text-center text-sm font-medium text-gray-600 py-2">S</div>

<!-- Days -->
@for($i = 28; $i <= 31; $i++)
<div class="text-center py-2 text-gray-400 text-sm">{{ $i }}</div>
@endfor
@for($i = 1; $i <= 31; $i++)
@if($i == 7)
<button type="button" class="text-center py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90">{{ $i }}</button>
@else
<button type="button" class="text-center py-2 hover:bg-gray-100 rounded-lg">{{ $i }}</button>
@endif
@endfor
</div>

<input type="hidden" name="session_date" id="sessionDate" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required/>
</div>

<!-- Available Slots -->
<div>
<h3 class="font-semibold mb-3">Available Slots for May 7, 2024</h3>
<div class="grid grid-cols-3 gap-3">
<button type="button" onclick="selectTime('09:00 AM')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:border-primary hover:bg-primary/5 font-medium">
09:00 AM
</button>
<button type="button" onclick="selectTime('10:00 AM')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:border-primary hover:bg-primary/5 font-medium">
10:00 AM
</button>
<button type="button" onclick="selectTime('11:00 AM')" class="px-4 py-2 border-2 border-primary bg-primary text-white rounded-lg font-medium">
11:00 AM
</button>
<button type="button" onclick="selectTime('01:00 PM')" class="px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed" disabled>
01:00 PM
</button>
<button type="button" onclick="selectTime('02:00 PM')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:border-primary hover:bg-primary/5 font-medium">
02:00 PM
</button>
<button type="button" onclick="selectTime('03:00 PM')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:border-primary hover:bg-primary/5 font-medium">
03:00 PM
</button>
</div>

<input type="hidden" name="start_time" id="startTime" value="11:00" required/>
<input type="hidden" name="end_time" id="endTime" value="12:00" required/>
</div>
</div>
</form>
</div>

<!-- Right: Booking Summary -->
<div class="lg:col-span-1">
<div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-4">
<h2 class="text-xl font-bold mb-6">Step 4: Confirmation</h2>

<div class="mb-6">
<h3 class="font-semibold mb-4">Booking Summary</h3>
<div class="space-y-3 text-sm">
<div class="flex justify-between">
<span class="text-gray-600">Subject:</span>
<span class="font-semibold" id="summarySubject">Mathematics</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">Mode:</span>
<span class="font-semibold" id="summaryMode">Online</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">Date:</span>
<span class="font-semibold" id="summaryDate">May 7, 2024</span>
</div>
<div class="flex justify-between">
<span class="text-gray-600">Time:</span>
<span class="font-semibold" id="summaryTime">11:00 AM</span>
</div>
</div>
</div>

<div class="border-t pt-4 mb-4">
<div class="flex justify-between items-center mb-2">
<span class="font-semibold">Total Cost:</span>
<span class="text-2xl font-bold text-gray-900">₹<span id="totalCost">50.00</span></span>
</div>
</div>

<div class="bg-blue-50 p-4 rounded-lg mb-6">
<div class="flex justify-between items-center">
<span class="text-sm font-medium text-gray-700">Your Wallet Balance</span>
<span class="text-lg font-bold text-primary">₹{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</span>
</div>
</div>

<button type="submit" form="bookingForm" class="w-full py-3 bg-secondary text-white rounded-lg font-bold text-lg hover:bg-secondary/90 transition-colors">
Confirm & Pay from Wallet
</button>
</div>
</div>
</div>
</main>

<script>
const hourlyRate = {{ $tutor->hourly_rate }};

function selectTime(time) {
    document.getElementById('summaryTime').textContent = time;
    // Update hidden inputs
    const hour = parseInt(time.split(':')[0]);
    const period = time.split(' ')[1];
    let hour24 = hour;
    if (period === 'PM' && hour !== 12) hour24 += 12;
    if (period === 'AM' && hour === 12) hour24 = 0;
    
    document.getElementById('startTime').value = hour24.toString().padStart(2, '0') + ':00';
    document.getElementById('endTime').value = (hour24 + 1).toString().padStart(2, '0') + ':00';
    
    // Update button styles
    document.querySelectorAll('button[onclick^="selectTime"]').forEach(btn => {
        btn.classList.remove('border-primary', 'bg-primary', 'text-white', 'border-2');
        btn.classList.add('border-gray-300', 'text-gray-700');
    });
    event.target.classList.add('border-primary', 'bg-primary', 'text-white', 'border-2');
    event.target.classList.remove('border-gray-300', 'text-gray-700');
}

// Update summary when subject changes
document.getElementById('subjectSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById('summarySubject').textContent = selectedOption.text;
});

// Update summary when mode changes
document.querySelectorAll('input[name="session_mode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('summaryMode').textContent = this.value === 'online' ? 'Online' : 'Offline';
    });
});

// Calculate total cost (hourly rate * 1 hour for now)
document.getElementById('totalCost').textContent = hourlyRate.toFixed(2);
</script>
</body>
</html>
