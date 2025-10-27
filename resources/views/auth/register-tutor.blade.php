<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tutor Registration - TapClass</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: { "primary": "#13a4ec", "secondary": "#FFA500", "background-light": "#f6f7f8", "background-dark": "#101c22" },
            fontFamily: { "display": ["Manrope", "sans-serif"] },
          },
        },
      }
    </script>
</head>
<body class="bg-background-light font-display">
<div class="min-h-screen flex items-center justify-center px-4 py-12">
<div class="max-w-2xl w-full">
<div class="text-center mb-6">
<a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary mb-4">
<div class="size-8">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-2xl font-bold">TapClass</h2>
</a>
<h1 class="text-3xl font-black text-gray-900">Become a Tutor</h1>
<p class="mt-2 text-sm text-gray-600">Complete all 5 steps to join our community</p>
</div>

<!-- Progress Bar -->
<div class="mb-8">
<div class="flex items-center justify-between mb-2">
<span id="step-label" class="text-sm font-semibold text-gray-700">Step 1 of 5: Basic Information</span>
<span id="progress-percent" class="text-sm font-semibold text-primary">20%</span>
</div>
<div class="h-2 bg-gray-200 rounded-full overflow-hidden">
<div id="progress-bar" class="h-full bg-primary transition-all duration-300" style="width: 20%"></div>
</div>
<div class="flex justify-between mt-4 text-xs text-gray-500">
<span id="step-1" class="font-semibold text-primary">Basic Info</span>
<span id="step-2">Experience</span>
<span id="step-3">Profile</span>
<span id="step-4">Documents</span>
<span id="step-5">Subjects</span>
</div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
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
<a href="{{ route('auth.google', ['role' => 'tutor']) }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
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

<form method="POST" action="{{ route('register.tutor') }}" enctype="multipart/form-data" id="registration-form">
@csrf

@if(session('google_auth'))
<input type="hidden" name="google_auth" value="1">
@endif

@php
    $googleData = session('google_user_data');
@endphp

<!-- Step 1: Basic Information -->
<div class="form-step active" data-step="1">
<h3 class="text-xl font-bold text-gray-900 mb-4">Basic Information</h3>
<div class="space-y-4">
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
<input type="text" name="name" value="{{ old('name', $googleData['name'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }}
    class="w-full rounded-lg border border-gray-300 {{ session('google_auth') ? 'bg-gray-100' : '' }} px-4 py-2.5 focus:border-primary focus:ring-primary" />
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
<input type="email" name="email" value="{{ old('email', $googleData['email'] ?? '') }}" {{ session('google_auth') ? 'readonly' : 'required' }}
    class="w-full rounded-lg border border-gray-300 {{ session('google_auth') ? 'bg-gray-100' : '' }} px-4 py-2.5 focus:border-primary focus:ring-primary" />
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
<input type="tel" name="phone" value="{{ old('phone') }}"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
<input type="text" name="location" value="{{ old('location') }}"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
</div>
</div>

@if(!session('google_auth'))
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
<input type="password" name="password" required
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
<input type="password" name="password_confirmation" required
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
</div>
</div>
@endif
</div>
</div>

<!-- Step 2: Experience -->
<div class="form-step" data-step="2" style="display: none;">
<h3 class="text-xl font-bold text-gray-900 mb-4">Your Experience</h3>
<div class="space-y-4">
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Teaching Experience (years) *</label>
<input type="number" name="experience_years" value="{{ old('experience_years') }}" required min="0"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Education Background *</label>
<textarea name="education" required rows="3"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" placeholder="E.g., B.Ed from XYZ University, M.Sc in Mathematics">{{ old('education') }}</textarea>
</div>
</div>
</div>

<!-- Step 3: Profile -->
<div class="form-step" data-step="3" style="display: none;">
<h3 class="text-xl font-bold text-gray-900 mb-4">Your Profile</h3>
<div class="space-y-4">
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Bio * (50-500 characters)</label>
<textarea name="bio" required rows="4"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" placeholder="Tell students about yourself, your teaching style, and what makes you a great tutor...">{{ old('bio') }}</textarea>
<p class="text-xs text-gray-500 mt-1">This will be displayed on your profile page</p>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture (optional, max 2MB)</label>
<input type="file" name="profile_picture" accept="image/jpeg,image/png,image/jpg" id="profile-pic-input"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
<div id="profile-pic-preview" class="mt-3 hidden">
<img src="" alt="Preview" class="w-32 h-32 rounded-full object-cover border-4 border-primary" />
</div>
<p class="text-xs text-gray-500 mt-1">Accepted formats: JPEG, PNG, JPG</p>
</div>
</div>
</div>

<!-- Step 4: Documents -->
<div class="form-step" data-step="4" style="display: none;">
<h3 class="text-xl font-bold text-gray-900 mb-4">Verification Documents</h3>
<div class="space-y-4">
<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Government ID * (max 5MB)</label>
<input type="file" name="government_id" required accept="image/*" id="gov-id-input"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
<p class="text-xs text-gray-500 mt-1">Aadhar Card, PAN Card, Passport, or Driver's License</p>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2">Degree Certificate * (max 5MB)</label>
<input type="file" name="degree_certificate" required accept="image/*" id="degree-input"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
<p class="text-xs text-gray-500 mt-1">Upload your highest educational qualification certificate</p>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2">CV/Resume (Optional, max 5MB)</label>
<input type="file" name="cv" accept=".pdf,.doc,.docx" id="cv-input"
    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary" />
<p class="text-xs text-gray-500 mt-1">PDF, DOC, or DOCX format</p>
</div>
</div>
</div>

<!-- Step 5: Subjects -->

<div class="form-step" data-step="5" style="display: none;">
<h3 class="text-xl font-bold text-gray-900 mb-4">Subjects You Teach</h3>
<div id="subjects-container" class="space-y-3">
<div class="subject-item p-4 border border-gray-200 rounded-lg bg-gray-50">
<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
<select name="subjects[0][subject_id]" required class="rounded-lg border border-gray-300 px-3 py-2">
<option value="">Select Subject</option>
@foreach($subjects as $subject)
<option value="{{ $subject->id }}">{{ $subject->name }}</option>
@endforeach
</select>
<div class="flex gap-4">
<label class="flex items-center">
<input type="checkbox" name="subjects[0][is_online_available]" value="1" class="rounded text-primary focus:ring-primary">
<span class="ml-2 text-sm">Online</span>
</label>
<label class="flex items-center">
<input type="checkbox" name="subjects[0][is_offline_available]" value="1" class="rounded text-primary focus:ring-primary">
<span class="ml-2 text-sm">Offline</span>
</label>
</div>
</div>
<div class="grid grid-cols-2 gap-3 mt-2">
<input type="number" name="subjects[0][online_rate]" placeholder="Online Rate (₹)" min="0" step="0.01"
    class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-primary" />
<input type="number" name="subjects[0][offline_rate]" placeholder="Offline Rate (₹)" min="0" step="0.01"
    class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-primary" />
</div>
</div>
</div>
<button type="button" onclick="addSubject()" class="text-sm text-primary font-semibold hover:underline mt-2">
+ Add Another Subject
</button>
</div>
</div>

<!-- Navigation Buttons -->
<div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
<button type="button" id="prev-btn" onclick="prevStep()" style="display: none;"
    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
← Previous
</button>
<button type="button" id="next-btn" onclick="nextStep()"
    class="ml-auto px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition-colors">
Next →
</button>
<button type="submit" id="submit-btn" style="display: none;"
    class="ml-auto px-6 py-2.5 bg-secondary text-white font-bold rounded-lg hover:bg-secondary/90 transition-colors">
Complete Registration
</button>
</div>
</form>

<div class="mt-6 text-center">
<p class="text-sm text-gray-600">
Already have an account? <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login</a>
</p>
</div>
</div>
</div>
</div>

<script>
let currentStep = 1;
const totalSteps = 5;
let subjectIndex = 1;

const stepLabels = [
    'Basic Information',
    'Your Experience',
    'Your Profile',
    'Verification Documents',
    'Subjects You Teach'
];

function updateProgress() {
    const progress = (currentStep / totalSteps) * 100;
    document.getElementById('progress-bar').style.width = progress + '%';
    document.getElementById('progress-percent').textContent = Math.round(progress) + '%';
    document.getElementById('step-label').textContent = `Step ${currentStep} of ${totalSteps}: ${stepLabels[currentStep - 1]}`;
    
    // Update step indicators
    for (let i = 1; i <= totalSteps; i++) {
        const stepEl = document.getElementById(`step-${i}`);
        if (i === currentStep) {
            stepEl.classList.add('font-semibold', 'text-primary');
        } else {
            stepEl.classList.remove('font-semibold', 'text-primary');
        }
    }
}

function showStep(step) {
    document.querySelectorAll('.form-step').forEach((el, index) => {
        el.style.display = (index + 1) === step ? 'block' : 'none';
    });
    
    // Show/hide navigation buttons
    document.getElementById('prev-btn').style.display = step > 1 ? 'block' : 'none';
    document.getElementById('next-btn').style.display = step < totalSteps ? 'block' : 'none';
    document.getElementById('submit-btn').style.display = step === totalSteps ? 'block' : 'none';
    
    updateProgress();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep() {
    if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

function addSubject() {
    const container = document.getElementById('subjects-container');
    const newSubject = `
        <div class="subject-item p-4 border border-gray-200 rounded-lg bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <select name="subjects[${subjectIndex}][subject_id]" required class="rounded-lg border border-gray-300 px-3 py-2">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="subjects[${subjectIndex}][is_online_available]" value="1" class="rounded text-primary focus:ring-primary">
                        <span class="ml-2 text-sm">Online</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="subjects[${subjectIndex}][is_offline_available]" value="1" class="rounded text-primary focus:ring-primary">
                        <span class="ml-2 text-sm">Offline</span>
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 mt-2">
                <input type="number" name="subjects[${subjectIndex}][online_rate]" placeholder="Online Rate (₹)" min="0" step="0.01"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-primary" />
                <input type="number" name="subjects[${subjectIndex}][offline_rate]" placeholder="Offline Rate (₹)" min="0" step="0.01"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-primary" />
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newSubject);
    subjectIndex++;
}

// Profile picture preview
document.addEventListener('DOMContentLoaded', function() {
    const profilePicInput = document.getElementById('profile-pic-input');
    if (profilePicInput) {
        profilePicInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profile-pic-preview');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Initialize
    showStep(1);
});
</script>
</body>
</html>
