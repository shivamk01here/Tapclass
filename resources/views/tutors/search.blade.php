@extends('layouts.public')

@section('title', 'Contact Us - Htc')

@section('content')
<body class="bg-gray-50 font-display">


<!-- Hero Section -->
<div class="bg-blue-50 py-12">
<div class="max-w-5xl mx-auto px-4">
<h1 class="text-4xl md:text-5xl font-black text-center mb-4">Find Your Perfect Tutor</h1>
<p class="text-center text-gray-600 mb-8 text-lg">Discover expert tutors for online or in-person lessons. Tailor your search to fit<br/>your needs and schedule.</p>

<!-- Search Box -->
<div class="bg-white rounded-2xl shadow-lg p-6">
<div class="grid grid-cols-1 md:grid-cols-12 gap-4">
<!-- Subject & Location -->
<div class="md:col-span-4">
<label class="block text-sm font-medium text-gray-700 mb-2">Subject & Location</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
<input type="text" id="searchInput" placeholder="e.g. Math in New York" 
       value="{{ request('q') }}"
       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
       onkeypress="if(event.key === 'Enter') applyFilters()" />
</div>
</div>

<!-- Mode -->
<div class="md:col-span-3">
<label class="block text-sm font-medium text-gray-700 mb-2">Mode</label>
<select id="modeSelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary appearance-none bg-white">
<option value="online" {{ request('mode') == 'online' || !request('mode') ? 'selected' : '' }}>Online</option>
<option value="offline" {{ request('mode') == 'offline' ? 'selected' : '' }}>Offline</option>
<option value="both" {{ request('mode') == 'both' ? 'selected' : '' }}>Both</option>
</select>
</div>

<!-- Nearby Tutors -->
<div class="md:col-span-2 flex items-end">
<button onclick="findNearby()" class="w-full px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2 font-medium">
<span class="material-symbols-outlined">location_on</span>
Find Nearby
</button>
</div>

<!-- Search Button -->
<div class="md:col-span-3 flex items-end">
<button onclick="applyFilters()" class="w-full px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
<span class="material-symbols-outlined">search</span>
Search Tutors
</button>
</div>
</div>
</div>
</div>
</div>

<!-- Main Content with Sidebar -->
<div class="max-w-7xl mx-auto px-4 py-8 flex gap-6">
<!-- Sidebar Filters (Collapsible) -->
<aside id="filterSidebar" class="w-64 flex-shrink-0 hidden lg:block">
<div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-4">
<div class="flex items-center justify-between mb-6">
<h3 class="font-bold text-lg">Filters</h3>
<button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
<span class="material-symbols-outlined">close</span>
</button>
</div>

<!-- Mode Filter -->
<div class="mb-6">
<h4 class="font-semibold mb-3">Mode</h4>
<label class="flex items-center gap-2 mb-2">
<input type="radio" name="sidebar_mode" value="online" {{ request('mode') == 'online' || !request('mode') ? 'checked' : '' }} class="text-primary focus:ring-primary" />
<span class="text-sm">Online</span>
</label>
<label class="flex items-center gap-2 mb-2">
<input type="radio" name="sidebar_mode" value="offline" {{ request('mode') == 'offline' ? 'checked' : '' }} class="text-primary focus:ring-primary" />
<span class="text-sm">Offline</span>
</label>
<label class="flex items-center gap-2">
<input type="radio" name="sidebar_mode" value="both" {{ request('mode') == 'both' ? 'checked' : '' }} class="text-primary focus:ring-primary" />
<span class="text-sm">Both</span>
</label>
</div>

<!-- Rating Filter -->
<div class="mb-6">
<h4 class="font-semibold mb-3">Rating</h4>
<label class="flex items-center gap-2 mb-2">
<input type="checkbox" name="sidebar_rating[]" value="4" {{ in_array('4', request('rating', [])) ? 'checked' : '' }} class="text-primary focus:ring-primary rounded" />
<span class="text-sm">4 stars & up</span>
</label>
<label class="flex items-center gap-2">
<input type="checkbox" name="sidebar_rating[]" value="3" {{ in_array('3', request('rating', [])) ? 'checked' : '' }} class="text-primary focus:ring-primary rounded" />
<span class="text-sm">3 stars & up</span>
</label>
</div>

<!-- Budget Filter -->
<div class="mb-6">
<h4 class="font-semibold mb-3">Budget (per hour)</h4>
<input type="range" name="sidebar_price" id="sidebarPrice" min="10" max="200" value="{{ request('max_price', 100) }}" class="w-full" oninput="document.getElementById('sidebarPriceValue').textContent = this.value" />
<p class="text-sm text-gray-600 mt-2">₹10 - ₹<span id="sidebarPriceValue">{{ request('max_price', 100) }}</span></p>
</div>

<!-- Experience Filter -->
<div class="mb-6">
<h4 class="font-semibold mb-3">Experience</h4>
<select name="sidebar_experience" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-sm">
<option value="">Any</option>
<option value="1" {{ request('experience') == '1' ? 'selected' : '' }}>1+ Years</option>
<option value="3" {{ request('experience') == '3' ? 'selected' : '' }}>3+ Years</option>
<option value="5" {{ request('experience') == '5' ? 'selected' : '' }}>5+ Years</option>
<option value="10" {{ request('experience') == '10' ? 'selected' : '' }}>10+ Years</option>
</select>
</div>

<!-- Gender Filter -->
<div class="mb-6">
<h4 class="font-semibold mb-3">Gender</h4>
<label class="flex items-center gap-2 mb-2">
<input type="checkbox" name="sidebar_gender[]" value="male" class="text-primary focus:ring-primary rounded" />
<span class="text-sm">Male</span>
</label>
<label class="flex items-center gap-2 mb-2">
<input type="checkbox" name="sidebar_gender[]" value="female" class="text-primary focus:ring-primary rounded" />
<span class="text-sm">Female</span>
</label>
</div>

<button onclick="applySidebarFilters()" class="w-full py-2 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors mb-2">
Apply Filters
</button>
<button onclick="resetFilters()" class="w-full py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
Reset
</button>
</div>
</aside>

<!-- Main Content Area -->
<main class="flex-1">
<!-- Toggle Filters Button (Mobile) -->
<button onclick="toggleSidebar()" class="lg:hidden mb-4 px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium flex items-center gap-2">
<span class="material-symbols-outlined">tune</span>
Show Filters
</button>

<!-- Results Header -->
<div class="flex items-center justify-between mb-6">
<h2 class="text-2xl font-bold">Showing {{ $tutors->total() }} tutors{{ $subject ? ' for ' . $subject->name : '' }}</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
@forelse($tutors as $tutor)
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
<!-- Profile Picture -->
<div class="flex justify-center pt-6 mb-3">
@if($tutor->user->profile_picture)
<img src="{{ asset('storage/' . $tutor->user->profile_picture) }}" class="w-16 h-16 rounded-full object-cover" alt="{{ $tutor->user->name }}" />
@else
<div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center">
<span class="text-primary font-bold text-xl">{{ substr($tutor->user->name, 0, 1) }}</span>
</div>
@endif
</div>

<!-- Content -->
<div class="px-4 pb-4">
<!-- Name & Badge -->
<div class="text-center mb-2">
<div class="flex items-center justify-center gap-1 mb-1">
<h3 class="font-bold text-base">{{ $tutor->user->name }}</h3>
@if($tutor->is_verified_badge)
<span class="material-symbols-outlined text-green-600 text-sm">verified</span>
@endif
</div>
<div class="flex items-center justify-center gap-1 text-yellow-500 text-sm">
<span class="font-semibold">{{ number_format($tutor->average_rating, 1) }}</span>
<span class="material-symbols-outlined text-sm">star</span>
</div>
</div>

<!-- Details -->
<div class="mb-3">
<p class="text-xs text-gray-600 mb-1"><span class="font-medium">Subjects:</span> {{ $tutor->subjects->pluck('name')->take(2)->implode(', ') }}</p>
<p class="text-xs text-gray-600"><span class="font-medium">Availability:</span> {{ $tutor->teaching_mode == 'both' ? 'Online & Offline' : ucfirst($tutor->teaching_mode) }}</p>
</div>

<!-- Price -->
<div class="text-center mb-3">
<span class="text-2xl font-bold text-gray-900">₹{{ number_format($tutor->hourly_rate, 0) }}</span>
<span class="text-sm text-gray-500">/hr</span>
</div>

<!-- View Profile Button -->
<a href="{{ route('tutors.profile', $tutor->user_id) }}" class="block w-full py-2.5 bg-sky-100 text-primary text-center rounded-lg font-semibold hover:bg-sky-200 transition-colors">
View Profile
</a>
</div>
</div>
@empty
<div class="col-span-full text-center py-16">
<span class="material-symbols-outlined text-7xl text-gray-300 mb-4">search_off</span>
<p class="text-xl font-medium text-gray-600">No tutors found</p>
<p class="text-gray-500">Try adjusting your filters or search terms</p>
</div>
@endforelse
</div>

<!-- Pagination -->
@if($tutors->hasPages())
<div class="flex justify-center mt-8">
{{ $tutors->links() }}
</div>
@endif
</main>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('filterSidebar');
    sidebar.classList.toggle('hidden');
}

function findNearby() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log('Location:', position.coords.latitude, position.coords.longitude);
            alert('Location feature coming soon!');
        });
    } else {
        alert('Geolocation is not supported by your browser');
    }
}

function applySidebarFilters() {
    const params = new URLSearchParams();
    
    const searchValue = document.getElementById('searchInput').value;
    if (searchValue) params.set('q', searchValue);
    
    const mode = document.querySelector('input[name="sidebar_mode"]:checked')?.value;
    if (mode) params.set('mode', mode);
    
    const maxPrice = document.getElementById('sidebarPrice')?.value;
    if (maxPrice) params.set('max_price', maxPrice);
    
    const experience = document.querySelector('select[name="sidebar_experience"]')?.value;
    if (experience) params.set('experience', experience);
    
    const ratings = Array.from(document.querySelectorAll('input[name="sidebar_rating[]"]:checked')).map(cb => cb.value);
    ratings.forEach(r => params.append('rating[]', r));
    
    const gender = Array.from(document.querySelectorAll('input[name="sidebar_gender[]"]:checked')).map(cb => cb.value);
    gender.forEach(g => params.append('gender[]', g));
    
    window.location.href = '{{ route("tutors.search") }}?' + params.toString();
}

function applyFilters() {
    const params = new URLSearchParams();
    
    const searchValue = document.getElementById('searchInput').value;
    if (searchValue) params.set('q', searchValue);
    
    const mode = document.querySelector('input[name="mode"]:checked')?.value;
    if (mode) params.set('mode', mode);
    
    if (mode === 'offline') {
        const proximity = document.querySelector('input[name="proximity"]')?.value;
        if (proximity) params.set('proximity', proximity);
    }
    
    const maxPrice = document.querySelector('input[name="max_price"]')?.value;
    if (maxPrice) params.set('max_price', maxPrice);
    
    const ratings = Array.from(document.querySelectorAll('input[name="rating[]"]:checked')).map(cb => cb.value);
    ratings.forEach(r => params.append('rating[]', r));
    
    const availability = Array.from(document.querySelectorAll('input[name="availability[]"]:checked')).map(cb => cb.value);
    availability.forEach(a => params.append('availability[]', a));
    
    const gender = Array.from(document.querySelectorAll('input[name="gender[]"]:checked')).map(cb => cb.value);
    gender.forEach(g => params.append('gender[]', g));
    
    window.location.href = '{{ route("tutors.search") }}?' + params.toString();
}

function resetFilters() {
    window.location.href = '{{ route("tutors.search") }}';
}

// Show/hide proximity filter based on mode
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const proximityFilter = document.getElementById('proximityFilter');
        if (this.value === 'offline') {
            proximityFilter.style.display = 'block';
        } else {
            proximityFilter.style.display = 'none';
        }
    });
});
</script>
</body>
@endsection