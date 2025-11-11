@extends('layouts.public')

@section('title', 'Contact Us - Htc')

@section('content')
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
                        
                        <img src="{{ asset('images/homepage/Exams-bro.svg') }}" alt="Online learning illustration" class="w-full max-w-lg h-auto rounded-lg object-contain" onerror="this.style.display='none'">
                        
                        <div class="w-full max-w-lg aspect-square bg-gray-200 dark:bg-gray-700/50 rounded-xl flex items-center justify-center text-subtext-light" style="display: none;">
                            Illustration (hero-illustration.png)
                        </div>
                    </div>
                </section>

                <section class="flex flex-col gap-4 md:gap-6" id="how-it-works">
                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="flex flex-col gap-2 text-center transition-all ease-out duration-700" 
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                        <h2 class="text-3xl md:text-4xl font-bold leading-tight tracking-[-0.015em]">Get Started in 3 Easy Steps</h2>
                        <p class="text-subtext-light dark:text-subtext-dark max-w-2xl mx-auto">Learning has never been more accessible. Here's how to begin.</p>
                    </div>

                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 items-center transition-all ease-out duration-700"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                        <div class="flex flex-col gap-2 md:gap-3">
                            <span class="text-primary font-bold">Step 1</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Search & Discover</h3>
                            <p class="text-subtext-light dark:text-subtext-dark">Use our smart search to find verified tutors by subject, price, or location. Read profiles, check reviews, and find the perfect match for your learning style.</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('images/homepage/how-it-works-1.png') }}" alt="Search for tutors illustration" class="w-full max-w-sm md:max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
                        </div>
                    </div>

                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 items-center transition-all ease-out duration-700"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                        <div class="flex items-center justify-center lg:order-first">
                            <img src="{{ asset('images/homepage/how-it-works-2.png') }}" alt="Connect with tutor illustration" class="w-full max-w-sm md:max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
                        </div>
                        <div class="flex flex-col gap-2 md:gap-3">
                            <span class="text-primary font-bold">Step 2</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Connect & Schedule</h3>
                            <p class="text-subtext-light dark:text-subtext-dark">Message tutors directly, ask questions, and book your first session. Our flexible scheduling works around your busy life, whether online or in-person.</p>
                        </div>
                    </div>

                    <div 
                        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                        class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 items-center transition-all ease-out duration-700"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                        <div class="flex flex-col gap-2 md:gap-3">
                            <span class="text-primary font-bold">Step 3</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Learn & Achieve</h3>
                            <p class="text-subtext-light dark:text-subtext-dark">Start your personalized learning journey! Pay securely, track your progress, and get the support you need to achieve your academic goals.</p>
                        </div>
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('images/homepage/how-it-works-3.png') }}" alt="Achieve results illustration" class="w-full max-w-sm md:max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
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
                            
                            <img src="{{ asset('images/homepage/tutor-illustration.svg') }}" alt="Illustration for tutors" class="w-full h-full object-cover rounded-lg" onerror="this.style.display='none'">

                            <div class="w-full aspect-square bg-gray-200 dark:bg-gray-700/50 rounded-lg flex items-center justify-center text-subtext-light" style="display: none;">
                                Illustration (tutor-illustration.svg)
                            </div>
                        </div>
                    </div>
                </section>

                @include('components.testimonials')
                
                @include('components.faq')

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
        </div>
    </div>
</main>

</div>
</div>
@endsection