@extends('layouts.student')

@section('title', 'Page Title')

@section('content')
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<a href="{{ route('student.dashboard') }}" class="text-primary font-bold">← Back to Dashboard</a>
</header>
<main class="max-w-4xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">My Profile</h1>

@if(session('success'))
<div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 flex items-center gap-2">
    <span class="material-symbols-outlined">check_circle</span>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="grid md:grid-cols-3 gap-8">
    <!-- Profile Card -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg border p-6">
            <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-primary font-black text-4xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <h2 class="text-xl font-bold text-center mb-2">{{ auth()->user()->name }}</h2>
            <p class="text-gray-500 text-center text-sm">{{ auth()->user()->email }}</p>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="md:col-span-2">
        <form method="POST" action="{{ route('student.profile.update') }}" class="bg-white rounded-lg border p-6">
            @csrf
            
            <h3 class="text-lg font-bold mb-4">Personal Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block font-semibold mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" required/>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" required/>
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" required/>
                    @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">Grade Level</label>
                    <input type="text" name="grade_level" value="{{ old('grade_level', $profile->grade_level ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" placeholder="e.g., Class 10, Class 12"/>
                    @error('grade_level')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">School Name</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $profile->school_name ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" placeholder="Your school or college"/>
                    @error('school_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">Learning Goals</label>
                    <textarea name="learning_goals" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" placeholder="What do you want to achieve?">{{ old('learning_goals', $profile->learning_goals ?? '') }}</textarea>
                    @error('learning_goals')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">Subjects of Interest</label>
                    <p class="text-xs text-gray-500 mb-2">Select subjects you want to learn (helps us recommend tutors)</p>
                    <div class="space-y-2 max-h-48 overflow-y-auto border rounded-lg p-3">
                        @php
                            $subjects = \App\Models\Subject::where('is_active', true)->orderBy('name')->get();
                            $selectedSubjects = old('subjects_of_interest', $profile->subjects_of_interest ?? []);
                        @endphp
                        @foreach($subjects as $subject)
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input 
                                type="checkbox" 
                                name="subjects_of_interest[]" 
                                value="{{ $subject->id }}"
                                {{ in_array($subject->id, $selectedSubjects) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary"
                            />
                            <span class="text-sm text-gray-700">{{ $subject->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('subjects_of_interest')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-2">City</label>
                        <input type="text" name="city" value="{{ old('city', $profile->city ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary"/>
                    </div>
                    <div>
                        <label class="block font-semibold mb-2">State</label>
                        <input type="text" name="state" value="{{ old('state', $profile->state ?? '') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary"/>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">Save Changes</button>
            </div>
        </form>
    </div>
</div>
</main>
</body>
</html>
@endsection