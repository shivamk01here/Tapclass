<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Student Registration - TapClass</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#13a4ec",
              "secondary": "#FFA500",
              "background-light": "#f6f7f8",
              "background-dark": "#101c22",
            },
            fontFamily: { "display": ["Manrope", "sans-serif"] },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
<div class="min-h-screen flex items-center justify-center px-4 py-12">
<div class="max-w-md w-full">
<div class="text-center mb-8">
<a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary mb-4">
<div class="size-8">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-2xl font-bold">TapClass</h2>
</a>
<h1 class="text-3xl font-black text-gray-900 dark:text-white">Create Student Account</h1>
<p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Join TapClass and start learning today</p>
</div>

<div class="bg-white dark:bg-background-dark rounded-xl border border-gray-200 dark:border-gray-700 p-8 shadow-sm">
@if($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
<ul class="text-sm text-red-600 space-y-1">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<!-- Google Registration Button -->
@if(!session('google_auth'))
<div class="mb-6">
<a href="{{ route('auth.google', ['role' => 'student']) }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
<svg class="w-5 h-5" viewBox="0 0 24 24">
<path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
<path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
<path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
<path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
</svg>
<span class="text-gray-700 font-bold">Register with Google</span>
</a>

<div class="relative my-6">
<div class="absolute inset-0 flex items-center">
<div class="w-full border-t border-gray-300"></div>
</div>
<div class="relative flex justify-center text-sm">
<span class="px-2 bg-white text-gray-500">Or register with email</span>
</div>
</div>
</div>
@else
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
<p class="text-sm text-green-700 flex items-center gap-2">
<span class="material-symbols-outlined text-green-600">check_circle</span>
<span>Connected with Google! Please complete your profile below.</span>
</p>
</div>
@endif

<form method="POST" action="{{ route('register.student') }}" enctype="multipart/form-data" class="space-y-6">
@csrf

@if(session('google_auth'))
<input type="hidden" name="google_auth" value="1">
@endif

@php
    $googleData = session('google_user_data');
@endphp

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="name">
Full Name *
</label>
<input 
    type="text" 
    id="name" 
    name="name" 
    value="{{ old('name', $googleData['name'] ?? '') }}"
    {{ session('google_auth') ? 'readonly' : 'required' }}
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 {{ session('google_auth') ? 'bg-gray-100' : 'bg-white' }} dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    placeholder="Enter your full name"
/>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="email">
Email Address *
</label>
<input 
    type="email" 
    id="email" 
    name="email" 
    value="{{ old('email', $googleData['email'] ?? '') }}"
    {{ session('google_auth') ? 'readonly' : 'required' }}
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 {{ session('google_auth') ? 'bg-gray-100' : 'bg-white' }} dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    placeholder="your.email@example.com"
/>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="phone">
Phone Number
</label>
<input 
    type="tel" 
    id="phone" 
    name="phone" 
    value="{{ old('phone') }}"
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    placeholder="+1 (555) 000-0000"
/>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="profile_picture">
Profile Picture (Optional)
</label>
<input 
    type="file" 
    id="profile_picture" 
    name="profile_picture" 
    accept="image/jpeg,image/png,image/jpg"
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    onchange="previewImage(event)"
/>
<p class="text-xs text-gray-500 mt-1">Max 2MB, JPEG/PNG/JPG</p>
<div id="image-preview" class="mt-3 hidden">
<img id="preview-img" src="" alt="Preview" class="w-24 h-24 rounded-full object-cover border-4 border-primary" />
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="grade">
Grade/Class
</label>
<input 
    type="text" 
    id="grade" 
    name="grade" 
    value="{{ old('grade') }}"
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    placeholder="e.g., Grade 10, Undergraduate"
/>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="location">
Location *
</label>
<div class="flex gap-2">
<input 
    type="text" 
    id="location" 
    name="location" 
    value="{{ old('location') }}"
    required
    class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    placeholder="Enter location or pincode"
/>
<button 
    type="button" 
    onclick="detectLocation()" 
    class="px-4 py-2.5 bg-primary text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2"
>
<span class="material-symbols-outlined text-xl">my_location</span>
<span class="hidden sm:inline">Detect</span>
</button>
</div>
<p class="text-xs text-gray-500 mt-1">We'll try to detect your location automatically, or enter manually</p>
<input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
<input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
Subjects of Interest
</label>
<p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Search and select subjects you want to learn</p>

<!-- Search Input -->
<input 
    type="text" 
    id="subject-search" 
    placeholder="Search subjects..."
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary mb-3"
    oninput="filterSubjects(this.value)"
/>

<!-- Selected Subjects Display -->
<div id="selected-subjects" class="mb-3 flex flex-wrap gap-2 min-h-[40px] p-2 border border-gray-200 rounded-lg">
<span class="text-sm text-gray-500" id="no-selection">No subjects selected yet</span>
</div>

<!-- Subjects List -->
<div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg p-3" id="subjects-list">
@foreach($subjects as $subject)
<label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded subject-item" data-subject-name="{{ strtolower($subject->name) }}">
<input 
    type="checkbox" 
    name="subjects_of_interest[]" 
    value="{{ $subject->id }}"
    data-subject-label="{{ $subject->name }}"
    {{ in_array($subject->id, old('subjects_of_interest', [])) ? 'checked' : '' }}
    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary subject-checkbox"
    onchange="updateSelectedSubjects()"
/>
<span class="text-sm text-gray-700 dark:text-gray-300">{{ $subject->name }}</span>
</label>
@endforeach
</div>
</div>

@if(!session('google_auth'))
<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="password">
Password *
</label>
<input 
    type="password" 
    id="password" 
    name="password" 
    required
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    placeholder="Minimum 6 characters"
/>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="password_confirmation">
Confirm Password *
</label>
<input 
    type="password" 
    id="password_confirmation" 
    name="password_confirmation" 
    required
    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-primary focus:ring-primary"
    placeholder="Re-enter your password"
/>
</div>
@endif

<button 
    type="submit"
    class="w-full bg-primary text-white font-bold py-3 px-4 rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2"
>
<span>Create Account</span>
<span class="material-symbols-outlined text-xl">arrow_forward</span>
</button>
</form>

<div class="mt-6 text-center">
<p class="text-sm text-gray-600 dark:text-gray-400">
Already have an account? 
<a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login here</a>
</p>
<p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
Want to teach instead? 
<a href="{{ route('register.tutor') }}" class="text-secondary font-medium hover:underline">Register as Tutor</a>
</p>
</div>
</div>

<p class="mt-4 text-center text-xs text-gray-500 dark:text-gray-400">
By creating an account, you agree to our Terms of Service and Privacy Policy
</p>
</div>
</div>

<script>
// Image Preview
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Check file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Location Detection
function detectLocation() {
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<span class="material-symbols-outlined text-xl animate-spin">refresh</span>';
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            async function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                // Reverse geocoding using Nominatim (free)
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    const data = await response.json();
                    
                    if (data.address) {
                        const address = data.address;
                        let location = '';
                        
                        if (address.city) location = address.city;
                        else if (address.town) location = address.town;
                        else if (address.village) location = address.village;
                        
                        if (address.state) location += ', ' + address.state;
                        if (address.postcode) location += ' - ' + address.postcode;
                        
                        document.getElementById('location').value = location || data.display_name;
                    }
                } catch (error) {
                    console.error('Geocoding error:', error);
                    document.getElementById('location').value = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                }
                
                button.disabled = false;
                button.innerHTML = originalHTML;
            },
            function(error) {
                alert('Unable to detect location. Please enter manually.');
                button.disabled = false;
                button.innerHTML = originalHTML;
            }
        );
    } else {
        alert('Geolocation is not supported by your browser.');
        button.disabled = false;
        button.innerHTML = originalHTML;
    }
}

// Subject Search and Filter
function filterSubjects(searchTerm) {
    const items = document.querySelectorAll('.subject-item');
    const term = searchTerm.toLowerCase();
    
    items.forEach(item => {
        const subjectName = item.getAttribute('data-subject-name');
        if (subjectName.includes(term)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Update Selected Subjects Display
function updateSelectedSubjects() {
    const checkboxes = document.querySelectorAll('.subject-checkbox:checked');
    const container = document.getElementById('selected-subjects');
    const noSelection = document.getElementById('no-selection');
    
    // Clear existing
    container.innerHTML = '';
    
    if (checkboxes.length === 0) {
        container.innerHTML = '<span class="text-sm text-gray-500" id="no-selection">No subjects selected yet</span>';
    } else {
        checkboxes.forEach(checkbox => {
            const label = checkbox.getAttribute('data-subject-label');
            const badge = document.createElement('span');
            badge.className = 'px-3 py-1 bg-primary text-white text-sm rounded-full flex items-center gap-2';
            badge.innerHTML = `
                ${label}
                <button type="button" onclick="removeSubject('${checkbox.value}')" class="hover:bg-blue-700 rounded-full">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            `;
            container.appendChild(badge);
        });
    }
}

// Remove Subject
function removeSubject(subjectId) {
    const checkbox = document.querySelector(`.subject-checkbox[value="${subjectId}"]`);
    if (checkbox) {
        checkbox.checked = false;
        updateSelectedSubjects();
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedSubjects();
});
</script>
</body>
</html>
