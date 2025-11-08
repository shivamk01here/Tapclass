<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Htc - Unlock Your Potential</title>
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
        /* Style for the horizontal scrollbar on testimonials (if needed, but hiding is fine) */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark font-display">

<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">

<header x-data="{ open: false }" class="sticky top-0 z-50 w-full bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-lg border-b border-solid border-gray-200 dark:border-gray-700">
    <div class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-6">
        <div class="flex items-center justify-between whitespace-nowrap h-16">
            <div class="flex items-center gap-4 text-text-light dark:text-text-dark">
                <div class="size-6 text-primary">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold leading-tight tracking-[-0.015em]">Htc</h2>
            </div>
    
            <div class="hidden md:flex flex-1 justify-center items-center gap-6">
                <a class="text-sm font-medium leading-normal text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors" href="{{ route('tutors.search') }}">Find Tutors</a>
                <a class="text-sm font-medium leading-normal text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors" href="{{ route('about') }}">About Us</a>
                <a class="text-sm font-medium leading-normal text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors" href="{{ route('contact') }}">Contact</a>
            </div>
    
            <div class="hidden md:flex items-center gap-4">
                @auth
                <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : (auth()->user()->isTutor() ? route('tutor.dashboard') : route('admin.dashboard')) }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                <span class="truncate">Dashboard</span>
                </a>
                @else
                <a href="{{ route('login') }}" class="text-sm font-medium leading-normal text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors">Login</a>
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
        </div>
    </div>
    
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
</header>
<main class="flex-1">
    <div class="px-4 md:px-10 lg:px-20 xl:px-40">
        <div class="layout-content-container flex flex-col max-w-[1200px] flex-1 mx-auto">
            <div class="flex flex-col gap-16 md:gap-24 lg:gap-32 py-16 md:py-24">

                <section class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                    <div 
                        x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" 
                        x-show="shown" 
                        x-transition:enter="transition ease-out duration-700" 
                        x-transition:enter-start="opacity-0 -translate-y-5" 
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="flex flex-col gap-6 items-center lg:items-start text-center lg:text-left">
                        
                        <h1 class="text-4xl font-black leading-tight tracking-[-0.033em] md:text-6xl"> 
                            Unlock Your Potential. Find Your Perfect Tutor. 
                        </h1>
                        <h2 class="text-base font-normal leading-normal text-subtext-light dark:text-subtext-dark md:text-lg max-w-2xl"> 
                            Connecting students with the best tutors for personalized learning, online or in-person with Htc. 
                        </h2>
                        
                        <div class="flex-wrap gap-4 flex justify-center lg:justify-start">
                            <a href="{{ route('tutors.search') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                            <span class="truncate">Find a Tutor</span>
                            </a>
                            <a href="{{ route('register.tutor') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-secondary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-secondary/90 transition-colors">
                            <span class="truncate">Become a Tutor</span>
                            </a>
                        </div>
                    </div>
                    
                    <div 
                        x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)" 
                        x-show="shown" 
                        x-transition:enter="transition ease-out duration-700" 
                        x-transition:enter-start="opacity-0 translate-y-5" 
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="flex items-center justify-center">
                        
                        <img src="{{ asset('images/homepage/hero-illustration.png') }}" alt="Online learning illustration" class="w-full max-w-lg h-auto rounded-lg object-contain" onerror="this.style.display='none'">
                        
                        <div class="w-full max-w-lg aspect-square bg-gray-200 dark:bg-gray-700/50 rounded-xl flex items-center justify-center text-subtext-light" style="display: none;">
                            Illustration (hero-illustration.png)
                        </div>
                    </div>
                </section>

                <section class="flex flex-col gap-12" id="how-it-works">
                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="flex flex-col gap-4 text-center transition-all ease-out duration-700" 
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <h2 class="text-3xl md:text-4xl font-bold leading-tight tracking-[-0.015em]">Get Started in 3 Easy Steps</h2>
                        <p class="text-subtext-light dark:text-subtext-dark max-w-2xl mx-auto">Learning has never been more accessible. Here's how to begin.</p>
                    </div>

                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center transition-all ease-out duration-700"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <div class="flex flex-col gap-4">
                            <span class="text-primary font-bold">Step 1</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Search & Discover</h3>
                            <p class="text-subtext-light dark:text-subtext-dark">Use our smart search to find verified tutors by subject, price, or location. Read profiles, check reviews, and find the perfect match for your learning style.</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('images/homepage/how-it-works-1.png') }}" alt="Search for tutors illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
                        </div>
                    </div>

                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center transition-all ease-out duration-700"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <div class="flex items-center justify-center lg:order-first">
                            <img src="{{ asset('images/homepage/how-it-works-2.png') }}" alt="Connect with tutor illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
                        </div>
                        <div class="flex flex-col gap-4">
                            <span class="text-primary font-bold">Step 2</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Connect & Schedule</h3>
                            <p class="text-subtext-light dark:text-subtext-dark">Message tutors directly, ask questions, and book your first session. Our flexible scheduling works around your busy life, whether online or in-person.</p>
                        </div>
                    </div>

                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center transition-all ease-out duration-700"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <div class="flex flex-col gap-4">
                            <span class="text-primary font-bold">Step 3</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Learn & Achieve</h3>
                            <p class="text-subtext-light dark:text-subtext-dark">Start your personalized learning journey! Pay securely, track your progress, and get the support you need to achieve your academic goals.</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('images/homepage/how-it-works-3.png') }}" alt="Achieve results illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
                        </div>
                    </div>
                </section>

                <section class="flex flex-col gap-8" id="features">
                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="flex flex-col gap-4 text-center transition-all ease-out duration-700" 
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <h2 class="text-3xl md:text-4xl font-bold leading-tight tracking-[-0.015em]">Everything You Need to Succeed</h2>
                        <p class="text-subtext-light dark:text-subtext-dark max-w-2xl mx-auto">We provide all the tools for a seamless learning experience.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                            $features = [
                                ['icon' => 'verified_user', 'title' => 'Verified Tutors', 'text' => 'Every tutor is vetted for expertise and experience.'],
                                ['icon' => 'event_available', 'title' => 'Flexible Scheduling', 'text' => 'Find a time that works for both you and your tutor.'],
                                ['icon' => 'price_check', 'title' => 'Transparent Pricing', 'text' => 'No hidden fees. Know the cost of your tuition upfront.'],
                                ['icon' => 'duo', 'title' => 'Online/Offline Modes', 'text' => 'Choose between online sessions or in-person tuitions.'],
                                ['icon' => 'person_search', 'title' => 'Smart Matching', 'text' => 'Our algorithm helps you find the perfect tutor match.'],
                                ['icon' => 'credit_card', 'title' => 'Secure Payments', 'text' => 'Pay for your sessions securely through the Htc platform.']
                            ];
                        @endphp

                        @foreach($features as $index => $feature)
                        <div 
                            x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                            class="flex flex-col gap-4 rounded-xl bg-white dark:bg-background-dark/50 border border-gray-200 dark:border-gray-700 p-6 text-center items-center transition-all ease-out duration-500 hover:-translate-y-2" 
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                            style="transition-delay: {{ $index * 50 }}ms">
                            
                            <div class="text-primary bg-primary/10 rounded-full p-3">
                                <span class="material-symbols-outlined text-3xl">{{ $feature['icon'] }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <h3 class="text-lg font-bold leading-tight">{{ $feature['title'] }}</h3>
                                <p class="text-subtext-light dark:text-subtext-dark text-sm font-normal leading-normal">{{ $feature['text'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                <section class="bg-white dark:bg-background-dark/50 rounded-xl border border-gray-200 dark:border-gray-700" id="tutors">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center p-8 md:p-12">
                        <div 
                            x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                            class="flex flex-col gap-6 transition-all ease-out duration-700" 
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                            <h2 class="text-2xl md:text-3xl font-bold leading-tight tracking-[-0.015em]">Are You a Tutor?</h2>
                            <p class="text-subtext-light dark:text-subtext-dark">Join our community of passionate educators and make a real impact.</p>
                            <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary mt-1">schedule</span>
                            <div>
                            <h4 class="font-bold">Flexible Schedule</h4>
                            <p class="text-subtext-light dark:text-subtext-dark text-sm">Teach when it works for you. Set your own hours and availability.</p>
                            </div>
                            </li>
                            <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary mt-1">payments</span>
                            <div>
                            <h4 class="font-bold">Set Your Own Rates</h4>
                            <p class="text-subtext-light dark:text-subtext-dark text-sm">You're in control of your pricing. We offer transparent fees.</p>
                            </div>
                            </li>
                            <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary mt-1">group</span>
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
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                            
                            <img src="{{ asset('images/homepage/tutor-illustration.png') }}" alt="Illustration for tutors" class="w-full h-full object-cover rounded-lg" onerror="this.style.display='none'">

                            <div class="w-full aspect-square bg-gray-200 dark:bg-gray-700/50 rounded-lg flex items-center justify-center text-subtext-light" style="display: none;">
                                Illustration (tutor-illustration.png)
                            </div>
                        </div>
                    </div>
                </section>

                @if($testimonials->count() > 0)
                <section class="flex flex-col gap-8">
                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="flex flex-col gap-4 text-center transition-all ease-out duration-700" 
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                        <h2 class="text-3xl md:text-4xl font-bold leading-tight tracking-[-0.015em]">What Our Users Say</h2>
                    </div>
                    <div class="relative"
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                        class="transition-all ease-out duration-700">
                        <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 py-4 scrollbar-hide">
                        @foreach($testimonials as $testimonial)
                        <div class="snap-center flex-shrink-0 w-full md:w-[calc(50%-0.75rem)] lg:w-[calc(33.33%-1rem)]">
                            <div class="flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark/50 p-6 h-full">
                                <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg">
                                {{ substr($testimonial->student->name, 0, 1) }}
                                </div>
                                <div>
                                <p class="font-bold">{{ $testimonial->student->name }}</p>
                                <p class="text-sm text-subtext-light dark:text-subtext-dark">Student</p>
                                </div>
                                </div>
                                <div class="flex text-secondary">
                                @for($i = 0; $i < $testimonial->rating; $i++)
                                <span class="material-symbols-outlined" style="font-size: 1.25rem; fill: 1;">star</span>
                                @endfor
                                </div>
                                <p class="text-subtext-light dark:text-subtext-dark text-base italic">"{{ $testimonial->review_text }}"</p>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    </div>
                </section>
                @endif
                
                <section class="flex flex-col gap-8"
                    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                    class="transition-all ease-out duration-700">
                    <div class="flex flex-col gap-4 text-center">
                        <h2 class="text-3xl md:text-4xl font-bold leading-tight tracking-[-0.015em]">Frequently Asked Questions</h2>
                    </div>
                    <div class="max-w-3xl mx-auto w-full space-y-4" x-data="{ open: 1 }">
                        @php
                            $faqs = [
                                1 => ['q' => 'How are tutors verified?', 'a' => 'All our tutors go through a rigorous verification process, including background checks and interviews, to ensure they are qualified and professional.'],
                                2 => ['q' => 'What is the pricing structure?', 'a' => 'Tutors set their own hourly rates, which are displayed transparently on their profiles. You only pay for the sessions you book. There are no hidden subscription fees.'],
                                3 => ['q' => 'Can I get a refund if I\'m not satisfied?', 'a' => 'Yes, we offer a satisfaction guarantee. If you are not satisfied with your first session, we will connect you with a new tutor or provide a refund.'],
                                4 => ['q' => 'What if I need to cancel a session?', 'a' => 'You can easily cancel or reschedule a session through your dashboard. Please refer to our cancellation policy for details on timelines.']
                            ];
                        @endphp
                        
                        @foreach($faqs as $id => $faq)
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark/50">
                            <button @click="open = (open === {{ $id }} ? 0 : {{ $id }})" class="w-full flex justify-between items-center text-left p-6">
                                <h3 class="font-bold text-base md:text-lg">{{ $faq['q'] }}</h3>
                                <span class="material-symbols-outlined text-primary" :class="open === {{ $id }} ? 'rotate-180' : ''" class="transition-transform">expand_more</span>
                            </button>
                            <div x-show="open === {{ $id }}" x-collapse class="px-6 pb-6 text-subtext-light dark:text-subtext-dark">
                                <p>{{ $faq['a'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                <section 
                    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                    class="transition-all ease-out duration-700">
                    <div class="bg-primary/10 dark:bg-primary/20 rounded-xl p-8 md:p-16 text-center flex flex-col items-center gap-6">
                        <h2 class="text-3xl md:text-4xl font-bold leading-tight tracking-[-0.015em]">Ready to Get Started?</h2>
                        <p class="text-subtext-light dark:text-subtext-dark max-w-lg">Whether you're a student looking to learn or a tutor ready to teach, your journey begins here.</p>
                        <div class="flex-wrap gap-4 flex justify-center">
                            <a href="{{ route('tutors.search') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                            <span class="truncate">Find a Tutor</span>
                            </a>
                            <a href="{{ route('register.tutor') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-secondary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-secondary/90 transition-colors">
                            <span class="truncate">Become a Tutor</span>
                            </a>
                        </div>
                    </div>
                </section>

            </div>

            <footer 
                x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                class="transition-all ease-out duration-700 border-t border-solid border-gray-200 dark:border-gray-700 mt-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 px-6 py-10">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <div class="size-6 text-primary">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold">Htc</h2>
                    </div>
                    <p class="text-sm text-subtext-light dark:text-subtext-dark">Your potential, unlocked.</p>
                </div>
            
                <div>
                    <h3 class="font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('tutors.search') }}">Find Tutors</a></li>
                        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('register.student') }}">Become a Student</a></li>
                        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('register.tutor') }}">Become a Tutor</a></li>
                    </ul>
                </div>
            
                <div>
                    <h3 class="font-bold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('about') }}">About Us</a></li>
                        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
            
                <div>
                    <h3 class="font-bold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary" href="{{ route('terms') }}">Terms & Conditions</a></li>
                    </ul>
                </div>
            
                </div>
                <div class="text-center text-sm text-subtext-light dark:text-subtext-dark py-4 border-t border-solid border-gray-200 dark:border-gray-700"> © {{ date('Y') }} Htc. All Rights Reserved. </div>
            </footer>
        </div>
    </div>
</main>

</div>
</div>

</body>
</html>