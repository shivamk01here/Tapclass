@extends('layouts.public') 
@section('title', 'HTC - Find Your Perfect Tutor')

@section('content')
    
    <main class="relative z-10">
        <div class="max-w-7xl mx-auto px-4">
            
            <div class="text-center max-w-4xl mx-auto py-24">
                
            <h1 class="font-heading text-[3rem] md:text-[3.8rem] lg:text-[4.2rem] uppercase leading-[0.9] tracking-wide text-black text-center">
            Find Your Perfect Tutor, ANYTIME EASILY
            </h1>

                
                <p class="text-lg text-text-subtle max-w-2xl mx-auto my-10">
                    Join thousands of learners upgrading their skills through interactive lessons, expert mentors - all in one simple platform.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a href="{{ route('tutors.search') }}" 
                       class="inline-block w-full sm:w-auto bg-accent-yellow border-2 border-black rounded-lg text-black font-bold py-4 px-8 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                        FIND A TUTOR
                    </a>
                    <a href="{{ route('register.tutor') }}" 
                       class="inline-block w-full sm:w-auto bg-white border-2 border-black rounded-lg text-black font-bold py-4 px-8 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                        BECOME A TUTOR
                    </a>
                </div>
                
                <div class="flex justify-center items-center mt-6">
                    <div class="flex mr-3">
                        <img src="https://api.dicebear.com/7.x/lorelei/svg?seed=Emma&backgroundColor=ffd5dc" alt="Student" class="w-9 h-9 rounded-full border-2 border-white -ml-2.5 first:ml-0">
                        <img src="https://api.dicebear.com/9.x/notionists/svg?seed=Aneka&backgroundColor=b6e3f4" alt="Tutor" class="w-9 h-9 rounded-full border-2 border-white -ml-2.5">
                        <img src="https://api.dicebear.com/9.x/lorelei/svg?backgroundColor=b6e3f4" alt="Student" class="w-9 h-9 rounded-full border-2 border-white -ml-2.5">
                        <img src="https://api.dicebear.com/9.x/notionists/svg?seed=Felix&backgroundColor=e3f2fd" alt="Tutor" class="w-9 h-9 rounded-full border-2 border-white -ml-2.5">
                    </div>
                    <span class="font-medium text-black text-sm">10k+ Happy Learners</span>
                </div>
            </div>

           

            <!-- Top Left -->
            <div class="absolute top-20 left-8 w-32 h-32 z-0 pointer-events-none hidden lg:block transform -rotate-12 opacity-70 hover:opacity-100 transition-all duration-300">
                <img src="https://api.iconify.design/solar/book-bookmark-bold-duotone.svg?color=%23f09711&width=128&height=128" alt="Study" class="w-full h-full drop-shadow-lg">
            </div>

            <!-- Bottom Left -->
            <div class="absolute bottom-24 left-16 w-28 h-28 z-0 pointer-events-none hidden lg:block transform rotate-6 opacity-60 hover:opacity-90 transition-all duration-300">
                <img src="https://api.iconify.design/solar/diploma-bold-duotone.svg?color=%234cb9e1&width=112&height=112" alt="Graduate" class="w-full h-full drop-shadow-md">
            </div>

            <!-- Top Right -->
            <div class="absolute top-32 right-12 w-24 h-24 z-0 pointer-events-none hidden lg:block transform rotate-12 opacity-65 hover:opacity-95 transition-all duration-300">
                <img src="https://api.iconify.design/solar/laptop-minimalistic-bold-duotone.svg?color=%230066a1&width=96&height=96" alt="Laptop">
            </div>

            <!-- Bottom Right -->
            <div class="absolute bottom-32 right-8 w-36 h-36 z-0 pointer-events-none hidden lg:block transform -rotate-6 opacity-70 hover:opacity-100 transition-all duration-300">
                <img src="https://api.iconify.design/solar/cup-star-bold-duotone.svg?color=%233f8bfc&width=144&height=144" alt="Achievement" class="w-full h-full drop-shadow-lg">
            </div>










        </div>
    </main>

    <!-- AI Mock Test Marketing Block -->
    <section class="py-12 bg-black text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left">
                    <span class="inline-block py-1 px-3 rounded bg-accent-yellow text-black text-xs font-bold uppercase tracking-wider mb-4">New Feature</span>
                    <h2 class="font-heading text-4xl md:text-5xl uppercase leading-none mb-4">Don't Just Learn. <span class="text-accent-yellow">Prove It.</span></h2>
                    <p class="text-gray-300 text-lg max-w-xl mb-8">Generate custom mock tests in seconds using AI. Pinpoint your weak areas before the real exam does.</p>
                    <a href="{{ route('ai-test.landing') }}" class="inline-block bg-accent-yellow text-black font-bold py-3 px-8 rounded-lg shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)] hover:translate-y-1 hover:shadow-none transition-all">
                        Start Free Assessment
                    </a>
                </div>
                <div class="flex-1 flex justify-center md:justify-end">
                    <div class="relative w-full max-w-md bg-gray-900 rounded-xl border border-gray-700 p-6 shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="flex items-center gap-2 mb-4 border-b border-gray-700 pb-4">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="ml-auto text-xs text-gray-500 font-mono">AI_Generator.exe</span>
                        </div>
                        <div class="space-y-3 font-mono text-sm">
                            <div class="flex gap-2">
                                <span class="text-green-400">➜</span>
                                <span class="text-white">Generating test for:</span>
                                <span class="text-accent-yellow">Physics / Thermodynamics</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="text-green-400">➜</span>
                                <span class="text-white">Difficulty:</span>
                                <span class="text-red-400">Hard (JEE Advanced)</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="text-green-400">➜</span>
                                <span class="text-white">Analyzing weak spots...</span>
                            </div>
                            <div class="mt-4 p-3 bg-gray-800 rounded border border-gray-700 text-gray-300">
                                <span class="block mb-2 text-xs uppercase tracking-widest text-gray-500">Output</span>
                                "Q1: Calculate the entropy change in an adiabatic reversible expansion..."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-16 md:py-24" id="how-it-works">
        <div class="max-w-7xl mx-auto px-4">
            
            <div class="flex flex-col gap-4 md:gap-6 text-center mb-12">
                <h2 class="font-heading text-4xl uppercase leading-tight font-normal">Get Started in 3 Easy Steps</h2>
                <p class="text-lg text-text-subtle max-w-2xl mx-auto">Learning has never been more accessible. Here's how to begin.</p>
            </div>

            <div class="bg-[#b6e1e3] border-2 border-black rounded-2xl shadow-header-chunky p-8 md:p-12">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                    
                    <div class="flex flex-col">
                        <img src="{{ asset('images/homepage/how-it-works-1.png') }}" alt="Search for tutors illustration" class="w-full h-auto rounded-lg mb-4" onerror="this.style.display='none'">
                        <span class="font-bold text-primary">Step 1</span>
                        <h3 class="text-2xl font-bold">Search & Discover</h3>
                        <p class="text-text-subtle text-sm">Use our smart search to find verified tutors by subject, price, or location. Read profiles, check reviews, and find the perfect match.</p>
                    </div>

                    <div class="flex flex-col">
                        <img src="{{ asset('images/homepage/how-it-works-2.png') }}" alt="Connect with tutor illustration" class="w-full h-auto rounded-lg mb-4" onerror="this.style.display='none'">
                        <span class="font-bold text-primary">Step 2</span>
                        <h3 class="text-2xl font-bold">Connect & Schedule</h3>
                        <p class="text-text-subtle text-sm">Message tutors directly, ask questions, and book your first session. Our flexible scheduling works around your busy life.</p>
                    </div>

                    <div class="flex flex-col">
                        <img src="{{ asset('images/homepage/how-it-works-3.png') }}" alt="Achieve results illustration" class="w-full h-auto rounded-lg mb-4" onerror="this.style.display='none'">
                        <span class="font-bold text-primary">Step 3</span>
                        <h3 class="text-2xl font-bold">Learn & Achieve</h3>
                        <p class="text-text-subtle text-sm">Start your personalized learning journey! Pay securely, track your progress, and get the support you need to achieve your goals.</p>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="py-16 md:py-24" id="features">
        <div class="max-w-7xl mx-auto px-4">

            <div class="flex flex-col gap-4 text-center mb-12">
                <h2 class="font-heading text-4xl uppercase leading-tight font-normal">Everything You Need to Succeed</h2>
                <p class="text-lg text-text-subtle max-w-2xl mx-auto">We provide all the tools for a seamless learning experience.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $features = [
                        ['icon' => 'bi-shield-check', 'title' => 'Verified Tutors', 'text' => 'Every tutor is vetted for expertise and experience.'],
                        ['icon' => 'bi-calendar-check', 'title' => 'Flexible Scheduling', 'text' => 'Find a time that works for both you and your tutor.'],
                        ['icon' => 'bi-tag', 'title' => 'Transparent Pricing', 'text' => 'No hidden fees. Know the cost of your tuition upfront.'],
                        ['icon' => 'bi-display', 'title' => 'Online/Offline Modes', 'text' => 'Choose between online sessions or in-person tuitions.'],
                        ['icon' => 'bi-person-check', 'title' => 'Smart Matching', 'text' => 'Our algorithm helps you find the perfect tutor match.'],
                        ['icon' => 'bi-credit-card', 'title' => 'Secure Payments', 'text' => 'Pay for your sessions securely through the Htc platform.']
                    ];
                @endphp

                @foreach($features as $index => $feature)
                <div class="flex flex-col gap-4 rounded-xl bg-white border-2 border-black p-6 text-center items-center shadow-button-chunky hover:shadow-header-chunky hover:-translate-y-1 transition-all ease-out duration-300">
                    
                    <div class="text-primary bg-subscribe-bg rounded-full p-3">
                        <i class="{{ $feature['icon'] }} text-3xl"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-lg font-bold leading-tight">{{ $feature['title'] }}</h3>
                        <p class="text-text-subtle text-sm font-normal leading-normal">{{ $feature['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24" id="tutors">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white border-2 border-black rounded-2xl shadow-header-chunky">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center p-8 md:p-12">
                    
                    <div class="flex flex-col gap-6">
                        <h2 class="font-heading text-4xl uppercase leading-tight font-normal">Are You a Tutor?</h2>
                        <p class="text-lg text-text-subtle">Join our community of passionate educators and make a real impact.</p>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <i class="bi bi-clock-history text-accent-yellow text-2xl mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-lg">Flexible Schedule</h4>
                                    <p class="text-text-subtle text-sm">Teach when it works for you. Set your own hours and availability.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="bi bi-cash-coin text-accent-yellow text-2xl mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-lg">Set Your Own Rates</h4>
                                    <p class="text-text-subtle text-sm">You're in control of your pricing. We offer transparent fees.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="bi bi-people-fill text-accent-yellow text-2xl mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-lg">Reach More Students</h4>
                                    <p class="text-text-subtle text-sm">Connect with a broad network of students looking for your expertise.</p>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-4">
                            <a href="{{ route('register.tutor') }}" class="inline-block bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Start Teaching
                            </a>
                        </div>
                    </div>
                    
                    <div class="w-full flex items-center justify-center">
                        <img src="{{ asset('images/homepage/tutor-illustration.svg') }}" alt="Illustration for tutors" class="w-full h-full max-w-md object-cover rounded-lg" onerror="this.style.display='none'">
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('components.testimonials')
    
    @include('components.faq')

    @include('components.newsletter')

@endsection 