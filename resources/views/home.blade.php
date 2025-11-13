@extends('layouts.public') 
@section('title', 'TutorConsult - Find Your Perfect Tutor')

@section('content')
    
    <main class="relative z-10">
        <div class="max-w-7xl mx-auto px-4">
            
            <div class="text-center max-w-4xl mx-auto py-24">
                
            <h1 class="font-heading text-[3rem] md:text-[3.8rem] lg:text-[4.2rem] uppercase leading-[0.9] tracking-wide text-black text-center">
  LEARN NEW SKILLS FROM ANYWHERE, ANYTIME EASILY
</h1>

                
                <p class="text-lg text-text-subtle max-w-2xl mx-auto my-10">
                    Join thousands of learners upgrading their skills through interactive lessons, expert mentors, 
                    and always-updated course materials - all in one simple platform.
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
                        <img src="https://via.placeholder.com/36/FFBD59/10181B?text=A" alt="Avatar 1" class="w-9 h-9 rounded-full border-2 border-white -ml-2.5 first:ml-0">
                        <img src="https://via.placeholder.com/36/006CAB/FFFFFF?text=B" alt="Avatar 2" class="w-9 h-9 rounded-full border-2 border-white -ml-2.5">
                        <img src="https://via.placeholder.com/36/EAE6FF/10181B?text=C" alt="Avatar 3" class="w-9 h-9 rounded-full border-2 border-white -ml-2.5">
                    </div>
                    <span class="font-medium text-black text-sm">10k+ Happy Learners</span>
                </div>
            </div>

            <div class="absolute top-1/4 left-10 w-36 h-40 rounded-lg bg-white/40 border border-dashed border-gray-400 flex items-center justify-center text-sm text-text-subtle z-0 pointer-events-none hidden lg:flex"> <img src="C:\XPersonal-Projects\Laravel\HTC\public\images\Hero\Grades-bro.svg">  </div>
            <div class="absolute top-3/4 left-10 w-36 h-40 rounded-lg bg-white/40 border border-dashed border-gray-400 flex items-center justify-center text-sm text-text-subtle z-0 pointer-events-none hidden lg:flex">Bottom-Left Illus.</div>
            <div class="absolute top-1/4 right-10 w-36 h-40 rounded-lg bg-white/40 border border-dashed border-gray-400 flex items-center justify-center text-sm text-text-subtle z-0 pointer-events-none hidden lg:flex">public\images\Hero\cuate.svg</div>
            <div class="absolute top-3/4 right-10 w-36 h-40 rounded-lg bg-white/40 border border-dashed border-gray-400 flex items-center justify-center text-sm text-text-subtle z-0 pointer-events-none hidden lg:flex">Bottom-Right Illus.</div>
        
        </div>
    </main>
    
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