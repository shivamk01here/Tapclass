@extends('layouts.public')

@section('title', 'Contact Us - Htc')

@section('content')
<body class="bg-gray-50 font-display text-[12px]">


<!-- Hero Section -->
<div class="bg-blue-50 py-6">
<div class="max-w-5xl mx-auto px-4">
<h1 class="text-2xl md:text-3xl font-black text-center mb-2">Find Your Perfect Tutor</h1>
<p class="text-center text-gray-600 text-sm mb-4">Discover expert tutors for online or in-person lessons. Tailor your search to fit your needs.</p>

<!-- Search Box -->
<div class="bg-white rounded-2xl shadow-lg p-4">
<div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-end">
<!-- Subject & Location -->
<div class="md:col-span-4">
<label class="block text-xs font-medium text-gray-700 mb-2">Subject & Location</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
<input type="text" id="searchInput" placeholder="e.g. Math in New York" 
       value="{{ request('q') }}"
       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
       onkeypress="if(event.key === 'Enter') applyFilters()" />
</div>
</div>

<!-- Subject filter -->
<div class="md:col-span-3">
  <label class="block text-xs font-semibold text-gray-700 mb-2">Subject</label>
<select id="subjectSelectTop" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:border-primary bg-white">
    <option value="">Any</option>
    @foreach(($subjects ?? []) as $s)
      <option value="{{ $s->id }}" {{ request('subject')==$s->id ? 'selected' : '' }}>{{ $s->name }}</option>
    @endforeach
  </select>
</div>

<!-- Mode -->
<div class="md:col-span-3">
<label class="block text-xs font-semibold text-gray-700 mb-2">Mode</label>
<select id="modeSelect" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:border-primary appearance-none bg-white">
<option value="" {{ !request('mode') ? 'selected' : '' }}>Any</option>
<option value="online" {{ request('mode') == 'online' ? 'selected' : '' }}>Online</option>
<option value="offline" {{ request('mode') == 'offline' ? 'selected' : '' }}>Offline</option>
<option value="both" {{ request('mode') == 'both' ? 'selected' : '' }}>Both</option>
</select>
</div>

<!-- Nearby Tutors -->
<!-- Radius (offline only) -->
<div class="md:col-span-2" id="radiusWrap" style="display: none;">
  <label class="block text-xs font-semibold text-gray-700 mb-2">Radius (km)</label>
  <div class="flex items-center gap-3">
    <input type="range" id="radiusSlider" min="1" max="30" value="{{ request('radius', 10) }}" class="w-full"/>
<span id="radiusVal" class="text-xs text-gray-700 w-7">{{ request('radius', 10) }}</span>
  </div>
</div>

<!-- Nearby (offline only) -->
<div class="md:col-span-2 flex items-end">
<button id="nearbyBtn" onclick="findNearby()" class="w-full px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2 font-medium disabled:opacity-50 disabled:cursor-not-allowed">
<span class="material-symbols-outlined">my_location</span>
Find Nearby
</button>
</div>

<!-- Hidden nearby params -->
<input type="hidden" id="nearbyFlag" value="{{ request('nearby') }}"/>
<input type="hidden" id="latValue" value="{{ request('lat') }}"/>
<input type="hidden" id="lngValue" value="{{ request('lng') }}"/>
<input type="hidden" id="pinValue" value="{{ request('pincode') }}"/>

<!-- Search Button (centered) -->
<div class="md:col-span-12 flex items-center justify-center">
<button onclick="applyFilters()" class="px-5 py-2 text-sm bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
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
<aside id="filterSidebar" class="w-56 flex-shrink-0 hidden lg:block">
<div class="bg-white rounded-xl border border-gray-200 p-4 sticky top-4">
<div class="flex items-center justify-between mb-6">
<h3 class="font-bold text-base">Filters</h3>
<button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
<span class="material-symbols-outlined">close</span>
</button>
</div>

<!-- Mode Filter -->
<div class="mb-6">
<h4 class="font-semibold text-sm mb-2">Mode</h4>
<label class="flex items-center gap-2 mb-2">
<input type="radio" name="sidebar_mode" value="" {{ !request('mode') ? 'checked' : '' }} class="text-primary focus:ring-primary" />
<span class="text-xs">Any</span>
</label>
<label class="flex items-center gap-2 mb-2">
<input type="radio" name="sidebar_mode" value="online" {{ request('mode') == 'online' ? 'checked' : '' }} class="text-primary focus:ring-primary" />
<span class="text-xs">Online</span>
</label>
<label class="flex items-center gap-2 mb-2">
<input type="radio" name="sidebar_mode" value="offline" {{ request('mode') == 'offline' ? 'checked' : '' }} class="text-primary focus:ring-primary" />
<span class="text-xs">Offline</span>
</label>
<label class="flex items-center gap-2">
<input type="radio" name="sidebar_mode" value="both" {{ request('mode') == 'both' ? 'checked' : '' }} class="text-primary focus:ring-primary" />
<span class="text-xs">Both</span>
</label>
</div>

<!-- Rating Filter -->
<div class="mb-6">
<h4 class="font-semibold text-sm mb-2">Rating</h4>
<label class="flex items-center gap-2 mb-2">
<input type="checkbox" name="sidebar_rating[]" value="4" {{ in_array('4', request('rating', [])) ? 'checked' : '' }} class="text-primary focus:ring-primary rounded" />
<span class="text-xs">4 stars & up</span>
</label>
<label class="flex items-center gap-2">
<input type="checkbox" name="sidebar_rating[]" value="3" {{ in_array('3', request('rating', [])) ? 'checked' : '' }} class="text-primary focus:ring-primary rounded" />
<span class="text-xs">3 stars & up</span>
</label>
</div>

<!-- Budget Filter -->
<div class="mb-6">
<h4 class="font-semibold text-sm mb-2">Budget (per hour)</h4>
<input type="range" name="sidebar_price" id="sidebarPrice" min="10" max="200" value="{{ request('max_price', 100) }}" class="w-full" oninput="document.getElementById('sidebarPriceValue').textContent = this.value" />
<p class="text-xs text-gray-600 mt-2">₹10 - ₹<span id="sidebarPriceValue">{{ request('max_price', 100) }}</span></p>
</div>

<!-- Experience Filter -->
<div class="mb-6">
<h4 class="font-semibold mb-3">Experience</h4>
<select name="sidebar_experience" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary text-xs">
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
<span class="text-xs">Male</span>
</label>
<label class="flex items-center gap-2 mb-2">
<input type="checkbox" name="sidebar_gender[]" value="female" class="text-primary focus:ring-primary rounded" />
<span class="text-xs">Female</span>
</label>
</div>

<button onclick="applySidebarFilters()" class="w-full py-1.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors mb-2 text-sm">
Apply Filters
</button>
<button onclick="resetFilters()" class="w-full py-1.5 text-gray-700 hover:bg-gray-100 rounded-lg font-medium text-sm">
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
<h2 class="text-lg font-extrabold">Showing {{ $tutors->total() }} tutors{{ $subject ? ' for ' . $subject->name : '' }}</h2>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
@forelse($tutors as $tutor)
<div class="tutor-card bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 text-[11px] opacity-100" style="min-height: 280px;">
<!-- Profile Picture -->
<div class="flex justify-center pt-6 mb-3">
@if($tutor->user->profile_picture)
<img src="{{ asset('storage/' . $tutor->user->profile_picture) }}" class="w-12 h-12 rounded-full object-cover" alt="{{ $tutor->user->name }}" />
@else
<div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
<span class="text-primary font-bold text-lg">{{ substr($tutor->user->name, 0, 1) }}</span>
</div>
@endif
</div>

<!-- Content -->
<div class="px-4 pb-4">
<!-- Name & Badge -->
<div class="text-center mb-2">
<div class="flex items-center justify-center gap-1 mb-1">
<h3 class="font-bold text-sm">{{ $tutor->user->name }}</h3>
@if($tutor->is_verified_badge)
<span class="material-symbols-outlined text-green-600 text-sm">verified</span>
@endif
</div>
@if(($tutor->average_rating ?? 0) > 0)
<div class="h-4 flex items-center justify-center gap-1 text-yellow-500 text-xs">
<span class="font-semibold">{{ number_format($tutor->average_rating, 1) }}</span>
<span class="material-symbols-outlined text-xs">star</span>
</div>
@endif
</div>

<!-- Details -->
<div class="mb-3 space-y-2">
  <div class="flex flex-wrap gap-1 justify-center">
    @foreach($tutor->subjects->take(3) as $s)
<span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-gray-100 rounded-full text-gray-700">
        @if($s->icon)
<img src="{{ asset($s->icon) }}" class="w-3 h-3" alt="" onerror="this.style.display='none'"/>
        @else
          <span class="material-symbols-outlined text-xs">menu_book</span>
        @endif
        <span class="hidden sm:inline">{{ $s->name }}</span>
      </span>
    @endforeach
  </div>
  <div class="flex items-center justify-center gap-2 text-gray-600">
    @if(in_array($tutor->teaching_mode,['online','both']))
<span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-primary text-sm">wifi</span> <span class="hidden sm:inline">Online</span></span>
    @endif
    @if(in_array($tutor->teaching_mode,['offline','both']))
<span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-primary text-sm">home</span> <span class="hidden sm:inline">Offline</span></span>
      @if($tutor->travel_radius_km)
<span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-primary text-sm">pin_drop</span> <span class="hidden sm:inline">{{ $tutor->travel_radius_km }} km</span></span>
      @endif
    @endif
  </div>
  <div class="flex items-center justify-center gap-1 text-gray-600">
<span class="material-symbols-outlined text-sm">location_on</span>
    <span>{{ $tutor->city ?? $tutor->location ?? '—' }}</span>
  </div>
</div>

<!-- Price -->
<div class="text-center mb-3">
<span class="text-lg font-bold text-gray-900">₹{{ number_format($tutor->hourly_rate, 0) }}</span>
<span class="text-[11px] text-gray-500">/hr</span>
</div>

<!-- View Profile Button -->
<a href="{{ route('tutors.profile', $tutor->user_id) }}" class="block w-full py-2 bg-sky-100 text-primary text-center rounded-lg font-semibold hover:bg-sky-200 transition-colors text-sm">
View Profile
</a>
</div>
</div>
@empty
<div class="col-span-full text-center py-16">
<span class="material-symbols-outlined text-6xl text-gray-300 mb-4">search_off</span>
<p class="text-lg font-medium text-gray-600">No tutors found</p>
<p class="text-gray-500">Try adjusting your filters or search terms</p>
</div>
@endforelse
</div>

<!-- Pagination -->
@if($tutors->hasPages())
<div class="flex justify-center mt-6">
{{ $tutors->links() }}
</div>
@endif
</main>
</div>

<script>
// Nearby
function findNearby() {
const setNearby = (params)=>{ const slider = document.getElementById('radiusSlider'); const r = slider ? slider.value : (params.get('radius') || 10); params.set('nearby', 1); params.set('radius', r); };
    const params = new URLSearchParams(window.location.search);
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos){
            setNearby(params);
            params.set('lat', pos.coords.latitude.toFixed(6));
            params.set('lng', pos.coords.longitude.toFixed(6));
            window.location.href = '{{ route('tutors.search') }}?' + params.toString();
        }, function(){
            // Fallback to PIN modal
            document.getElementById('pinModal').classList.remove('hidden');
            document.getElementById('pinInput').focus();
        }, { enableHighAccuracy:true, timeout:8000, maximumAge:0 });
    } else {
        document.getElementById('pinModal').classList.remove('hidden');
    }
}

function applySidebarFilters() {
    const params = new URLSearchParams(window.location.search);
    params.delete('subject'); params.delete('mode'); params.delete('max_price'); params.delete('rating[]'); params.delete('experience'); params.delete('gender[]');
    
    const searchValue = document.getElementById('searchInput').value.trim();
    const pinMatch = (/^\d{4,6}$/).test(searchValue);
    if (pinMatch) { params.set('pincode', searchValue); params.delete('q'); }
    else if (searchValue) { params.set('q', searchValue); params.delete('pincode'); }
    else { params.delete('q'); params.delete('pincode'); }
    
    const mode = document.querySelector('input[name="sidebar_mode"]:checked')?.value;
    if (mode) params.set('mode', mode);

    if (mode === 'offline' && document.getElementById('radiusSlider')) {
      params.set('radius', document.getElementById('radiusSlider').value);
    } else {
      params.delete('radius');
    }
    
    const maxPrice = document.getElementById('sidebarPrice')?.value;
    if (maxPrice) params.set('max_price', maxPrice);
    
    const experience = document.querySelector('select[name="sidebar_experience"]')?.value;
    if (experience) params.set('experience', experience);
    
    const ratings = Array.from(document.querySelectorAll('input[name="sidebar_rating[]"]:checked')).map(cb => cb.value);
    params.delete('rating[]'); ratings.forEach(r => params.append('rating[]', r));
    
    const gender = Array.from(document.querySelectorAll('input[name="sidebar_gender[]"]:checked')).map(cb => cb.value);
    params.delete('gender[]'); gender.forEach(g => params.append('gender[]', g));

    const subjTop = document.getElementById('subjectSelectTop')?.value;
    if (subjTop) params.set('subject', subjTop); else params.delete('subject');
    
    window.location.href = '{{ route("tutors.search") }}?' + params.toString();
}

function applyFilters() {
    const params = new URLSearchParams(window.location.search);
    params.delete('q'); params.delete('subject'); params.delete('mode'); params.delete('max_price'); params.delete('rating[]'); params.delete('availability[]'); params.delete('gender[]');
    
    const searchValue = document.getElementById('searchInput').value.trim();
    const modeSel = document.getElementById('modeSelect')?.value;
    const subjTop = document.getElementById('subjectSelectTop')?.value;

    // If user typed a pincode (4-6 digits), search by pincode
    const pinMatch = (/^\d{4,6}$/).test(searchValue);
    if (pinMatch) { params.set('pincode', searchValue); params.delete('q'); }
    else if (searchValue) { params.set('q', searchValue); params.delete('pincode'); }

    if (subjTop) params.set('subject', subjTop);
    if (modeSel) params.set('mode', modeSel);

    // Carry radius if offline
    if (modeSel === 'offline' && document.getElementById('radiusSlider')) {
      params.set('radius', document.getElementById('radiusSlider').value);
    } else {
      params.delete('radius');
    }

    window.location.href = '{{ route("tutors.search") }}?' + params.toString();
}

// Mode toggle visibility for Nearby/Radius
const modeSel = document.getElementById('modeSelect');
const nearbyBtn = document.getElementById('nearbyBtn');
const radiusWrap = document.getElementById('radiusWrap');
const radiusSlider = document.getElementById('radiusSlider');
const radiusVal = document.getElementById('radiusVal');
function syncMode(){
  const isOffline = modeSel?.value === 'offline';
  nearbyBtn?.classList.toggle('hidden', !isOffline);
  radiusWrap.style.display = isOffline ? 'block' : 'none';
}
modeSel?.addEventListener('change', syncMode);
if(radiusSlider && radiusVal){ radiusSlider.addEventListener('input', ()=> radiusVal.textContent = radiusSlider.value); }
syncMode();

function resetFilters() {
    window.location.href = '{{ route("tutors.search") }}';
}

</script>

<!-- PIN Modal -->
<div id="pinModal" class="hidden fixed inset-0 bg-black/30 flex items-center justify-center z-40">
<div class="bg-white rounded-xl p-4 w-72 shadow">
<h3 class="font-semibold text-sm mb-2">Enter Pincode</h3>
    <p class="text-xs text-gray-600 mb-3">We couldn't detect your location. Enter your pincode to find nearby tutors.</p>
<input id="pinInput" type="text" placeholder="e.g., 226010" class="w-full px-3 py-1.5 border rounded-lg mb-3" />
    <div class="flex gap-2 justify-end">
<button onclick="document.getElementById('pinModal').classList.add('hidden')" class="px-3 py-1.5 text-gray-600 text-sm">Cancel</button>
<button onclick="applyPin()" class="px-3 py-1.5 bg-primary text-white rounded-lg text-sm">Find</button>
    </div>
  </div>
</div>

<script>
function applyPin(){
  const pin = document.getElementById('pinInput').value.trim();
  if(!pin || pin.length < 4){ document.getElementById('pinInput').classList.add('border-red-500'); return; }
  const params = new URLSearchParams(window.location.search);
  params.set('nearby',1); params.set('pincode', pin); params.delete('lat'); params.delete('lng');
  const modeSel = document.getElementById('modeSelect')?.value;
  if (modeSel === 'offline' && document.getElementById('radiusSlider')) {
    params.set('radius', document.getElementById('radiusSlider').value);
  }
  window.location.href = '{{ route('tutors.search') }}?' + params.toString();
}
</script>
</body>
@endsection
