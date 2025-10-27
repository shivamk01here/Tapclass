<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>TapClass - Unlock Your Potential</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#13a4ec",
              "secondary": "#FFA500",
              "background-light": "#f6f7f8",
              "background-dark": "#101c22",
              "text-light": "#111618",
              "text-dark": "#f8f9fa",
              "subtext-light": "#617c89",
              "subtext-dark": "#a0aec0",
            },
            fontFamily: {
              "display": ["Manrope", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.5rem", "lg": "0.75rem", "xl": "1rem", "full": "9999px"},
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark font-display">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<div class="px-4 md:px-10 lg:px-20 xl:px-40 flex flex-1 justify-center py-5">
<div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
<header x-data="{ open: false }" class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 dark:border-gray-700 px-6 py-4">
<div class="flex items-center gap-4 text-text-light dark:text-text-dark">
<div class="size-6 text-primary">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-xl font-bold leading-tight tracking-[-0.015em]">TapClass</h2>
</div>

<div class="hidden md:flex flex-1 justify-center items-center gap-6">
    <a class="text-sm font-medium leading-normal hover:text-primary dark:hover:text-primary" href="{{ route('tutors.search') }}">Find Tutors</a>
    <a class="text-sm font-medium leading-normal hover:text-primary dark:hover:text-primary" href="{{ route('about') }}">About Us</a>
    <a class="text-sm font-medium leading-normal hover:text-primary dark:hover:text-primary" href="{{ route('contact') }}">Contact</a>
</div>

<div class="hidden md:flex items-center gap-4">
    @auth
    <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : route('admin.dashboard')) }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
    <span class="truncate">Dashboard</span>
    </a>
    @else
    <a href="{{ route('login') }}" class="text-sm font-medium leading-normal hover:text-primary dark:hover:text-primary">Login</a>
    <a href="{{ route('register.student') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
    <span class="truncate">Sign Up</span>
    </a>
    @endauth
</div>

<div class="md:hidden">
<button @click="open = !open" class="text-text-light dark:text-text-dark">
<span class="material-symbols-outlined text-2xl" x-text="open ? 'close' : 'menu'">menu</span>
</button>
</div>
</header>

<div 
    x-show="open" 
    x-transition:enter="transition ease-out duration-200" 
    x-transition:enter-start="opacity-0 -translate-y-2" 
    x-transition:enter-end="opacity-100 translate-y-0" 
    x-transition:leave="transition ease-in duration-150" 
    x-transition:leave-start="opacity-100 translate-y-0" 
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="hidden md:hidden px-6 py-4 bg-white dark:bg-background-dark border-b border-gray-200 dark:border-gray-700"
>
<div class="flex flex-col gap-4">
    <a class="text-sm font-medium" href="{{ route('tutors.search') }}">Find Tutors</a>
    <a class="text-sm font-medium" href="{{ route('about') }}">About Us</a>
    <a class="text-sm font-medium" href="{{ route('contact') }}">Contact</a>

    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-3">
        @auth
        <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : route('admin.dashboard')) }}" class="block text-sm font-bold text-primary">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left text-sm font-medium">
                Logout
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="block text-sm font-medium">Login</a>
        <a href="{{ route('register.student') }}" class="block text-sm font-bold text-primary">Sign Up</a>
        @endauth
    </div>
</div>
</div>

<main class="flex flex-col gap-16 md:gap-24">
<div class="@container py-10 md:py-20">
<div class="flex flex-col gap-10 px-4">
<div class="flex flex-col gap-6 text-center items-center">
    <h1 
        x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" x-show="shown" 
        x-transition:enter="transition ease-out duration-700" 
        x-transition:enter-start="opacity-0 -translate-y-5" 
        x-transition:enter-end="opacity-100 translate-y-0"
        class="text-4xl font-black leading-tight tracking-[-0.033em] md:text-6xl max-w-3xl"> 
        Unlock Your Potential. Find Your Perfect Tutor. 
    </h1>
    <h2 
        x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 200)" x-show="shown"
        x-transition:enter="transition ease-out duration-700" 
        x-transition:enter-start="opacity-0 -translate-y-5" 
        x-transition:enter-end="opacity-100 translate-y-0"
        class="text-base font-normal leading-normal text-subtext-light dark:text-subtext-dark md:text-lg max-w-2xl"> 
        Connecting students with the best tutors for personalized learning, online or in-person with TapClass. 
    </h2>
</div>
<div 
    x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)" x-show="shown"
    x-transition:enter="transition ease-out duration-700" 
    x-transition:enter-start="opacity-0 -translate-y-5" 
    x-transition:enter-end="opacity-100 translate-y-0"
    class="flex-wrap gap-4 flex justify-center">
    <a href="{{ route('tutors.search') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
    <span class="truncate">Find a Tutor</span>
    </a>
    <a href="{{ route('register.tutor') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-secondary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-secondary/90 transition-colors">
    <span class="truncate">Become a Tutor</span>
    </a>
</div>
</div>
</div>

<div class="flex flex-col gap-8 px-4" id="students">
<div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="flex flex-col gap-4 text-center transition-all ease-out duration-700" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
    <h2 class="text-2xl md:text-3xl font-bold leading-tight tracking-[-0.015em]">Everything You Need to Succeed</h2>
    <p class="text-subtext-light dark:text-subtext-dark max-w-2xl mx-auto">TapClass provides all the tools and features to ensure a seamless and effective learning experience for everyone.</p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">verified_user</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Verified Tutors</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Every tutor on TapClass is vetted for expertise and experience.</p>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500 delay-100" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">event_available</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Flexible Scheduling</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Find a time that works for both you and your tutor.</p>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500 delay-200" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">price_check</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Transparent Pricing</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">No hidden fees. Know the cost of your tuition upfront.</p>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">duo</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Online/Offline Modes</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Choose between online sessions or in-person tuitions.</p>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500 delay-100" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">person_search</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Smart Matching</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Our algorithm helps you find the perfect tutor match.</p>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500 delay-200" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">credit_card</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Secure Payments</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Pay for your sessions securely through the TapClass platform.</p>
        </div>
    </div>
</div>
</div>

<div class="flex flex-col gap-6 px-4" id="how-it-works">
<div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="transition-all ease-out duration-700" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
    <h2 class="text-2xl md:text-3xl font-bold leading-tight tracking-[-0.015em] text-center">How it Works for Students</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4">
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-1 flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">search</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Search for Subjects</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Find the perfect tutor for any subject you need help with.</p>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-1 flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500 delay-100" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">group_add</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Connect with Tutors</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Schedule and connect for online or in-person sessions.</p>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-1 flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 text-center items-center transition-all ease-out duration-500 delay-200" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <div class="text-primary bg-primary/10 rounded-full p-3">
        <span class="material-symbols-outlined text-3xl">school</span>
        </div>
        <div class="flex flex-col gap-1">
        <h3 class="text-lg font-bold leading-tight">Start Learning</h3>
        <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">Achieve your academic goals with personalized help.</p>
        </div>
    </div>
</div>
</div>

<div class="bg-white dark:bg-background-dark rounded-xl border border-gray-200 dark:border-gray-700 p-8 md:p-12" id="tutors">
<div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-6 transition-all ease-out duration-700" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
        <h2 class="text-2xl md:text-3xl font-bold leading-tight tracking-[-0.015em]">For Tutors</h2>
        <p class="text-subtext-light dark:text-subtext-dark">Join our community of passionate educators and make a real impact.</p>
        <ul class="space-y-4">
        <li class="flex items-start gap-3">
        <span class="material-symbols-outlined text-primary mt-1">schedule</span>
        <div>
        <h4 class="font-bold">Flexible Schedule</h4>
        <p class="text-subtext-light dark:text-subtext-dark text-sm">Teach when it works for you. Set your own hours and availability.</p>
        </div>
        </li>
        <li class="flex items-start gap-3">
        <span class="material-symbols-outlined text-primary mt-1">payments</span>
        <div>
        <h4 class="font-bold">Set Your Own Rates</h4>
        <p class="text-subtext-light dark:text-subtext-dark text-sm">You're in control of your pricing. We offer transparent fees.</p>
        </div>
        </li>
        <li class="flex items-start gap-3">
        <span class="material-symbols-outlined text-primary mt-1">group</span>
        <div>
        <h4 class="font-bold">Reach More Students</h4>
        <p class="text-subtext-light dark:text-subtext-dark text-sm">Connect with a broad network of students looking for your expertise.</p>
        </div>
        </li>
        </ul>
        <div class="mt-4">
        <a href="{{ route('register.tutor') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-secondary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-secondary/90 transition-colors">
        <span class="truncate">Start Teaching</span>
        </a>
        </div>
    </div>
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="w-full aspect-square bg-center bg-no-repeat bg-cover rounded-lg transition-all ease-out duration-700 delay-100" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        style='background-image: url("https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=600&fit=crop");'>
    </div>
</div>
</div>

@if($testimonials->count() > 0)
<div class="flex flex-col gap-6 px-4">
<div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="transition-all ease-out duration-700" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
    <h2 class="text-2xl md:text-3xl font-bold leading-tight tracking-[-0.015em] text-center">What Our Users Say</h2>
</div>
<div class="relative">
<div class="flex overflow-x-auto snap-x snap-mandatory gap-6 py-4 scrollbar-hide">
@foreach($testimonials as $testimonial)
<div class="snap-center flex-shrink-0 w-full md:w-[calc(50%-0.75rem)]">
    <div 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-6 h-full transition-all ease-out duration-500" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        style="transition-delay: {{ $loop->index * 100 }}ms">
        <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
        {{ substr($testimonial->student->name, 0, 1) }}
        </div>
        <div>
        <p class="font-bold">{{ $testimonial->student->name }}</p>
        <p class="text-sm text-subtext-light dark:text-subtext-dark">Student</p>
        </div>
        </div>
        <div class="flex text-secondary">
        @for($i = 0; $i < $testimonial->rating; $i++)
        <span class="material-symbols-outlined text-base">star</span>
        @endfor
        </div>
        <p class="text-subtext-light dark:text-subtext-dark">{{ $testimonial->review_text }}</p>
    </div>
</div>
@endforeach
</div>
</div>
</div>
@endif

<footer class="border-t border-solid border-gray-200 dark:border-gray-700 mt-10">
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 px-6 py-10">
<div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="flex flex-col gap-4 transition-all ease-out duration-700" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
<div class="flex items-center gap-2">
<div class="size-6 text-primary">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-lg font-bold">TapClass</h2>
</div>
<p class="text-sm text-subtext-light dark:text-subtext-dark">Your potential, unlocked.</p>
</div>

<div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="transition-all ease-out duration-700 delay-100" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
    <h3 class="font-bold mb-4">Quick Links</h3>
    <ul class="space-y-2">
        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('tutors.search') }}">Find Tutors</a></li>
        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('register.student') }}">Become a Student</a></li>
        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('register.tutor') }}">Become a Tutor</a></li>
    </ul>
</div>

<div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="transition-all ease-out duration-700 delay-200" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
    <h3 class="font-bold mb-4">Company</h3>
    <ul class="space-y-2">
        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('about') }}">About Us</a></li>
        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('contact') }}">Contact</a></li>
    </ul>
</div>

<div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="transition-all ease-out duration-700 delay-300" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
    <h3 class="font-bold mb-4">Legal</h3>
    <ul class="space-y-2">
        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('privacy') }}">Privacy Policy</a></li>
        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('terms') }}">Terms & Conditions</a></li>
    </ul>
</div>

</div>
<div class="text-center text-sm text-subtext-light dark:text-subtext-dark py-4 border-t border-solid border-gray-200 dark:border-gray-700"> © {{ date('Y') }} TapClass. All Rights Reserved. </div>
</footer>
</main>
</div>
</div>
</div>
</div>
</body>
</html>