@extends('layouts.public')

@section('title', 'About Us - Htc')

@section('content')
<div class="flex flex-col gap-16 md:gap-24 lg:gap-32 py-16 md:py-24">

    <section class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div 
                x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                class="flex flex-col gap-6 items-center lg:items-start text-center lg:text-left transition-all ease-out duration-700" 
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                <h1 class="text-4xl font-black leading-tight tracking-[-0.033em] md:text-5xl"> 
                    Empowering Minds Through Personalized Learning. 
                </h1>
                <p class="text-base font-normal leading-normal text-subtext-light dark:text-subtext-dark md:text-lg max-w-2xl"> 
                    At Htc, we're dedicated to transforming education by connecting students with expert tutors, fostering a love for learning, and unlocking individual potential.
                </p>
                <a href="{{ route('tutors.search') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                    <span class="truncate">Find Your Tutor Today</span>
                </a>
            </div>
            
            <div 
                x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                class="flex items-center justify-center transition-all ease-out duration-700 delay-100" 
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                <img src="{{ asset('images/about/about-hero.png') }}" alt="Students learning with tutors" class="w-full max-w-lg h-auto rounded-lg object-contain" onerror="this.style.display='none'">
            </div>
        </div>
    </section>

    <section class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div 
                x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                class="flex flex-col gap-6 transition-all ease-out duration-700" 
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                <h2 class="text-3xl font-bold leading-tight tracking-[-0.015em] md:text-4xl">Our Mission: Bridging the Education Gap</h2>
                <p class="text-subtext-light dark:text-subtext-dark text-lg leading-relaxed">
                    At Htc, we believe that every student deserves access to quality education tailored to their unique learning needs. Our mission is to bridge the gap between students and qualified tutors, making personalized learning accessible to everyone. We're committed to creating a platform that not only connects learners with educators but also fosters a community where knowledge sharing and growth thrive.
                </p>
                <div class="bg-gradient-to-br from-primary/10 to-primary/5 rounded-2xl p-8 grid grid-cols-2 gap-6 mt-4">
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">1000+</div>
                        <div class="text-gray-600 dark:text-gray-300 font-medium text-sm">Qualified Tutors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">5000+</div>
                        <div class="text-gray-600 dark:text-gray-300 font-medium text-sm">Active Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">50+</div>
                        <div class="text-gray-600 dark:text-gray-300 font-medium text-sm">Subjects</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">4.8/5</div>
                        <div class="text-gray-600 dark:text-gray-300 font-medium text-sm">Average Rating</div>
                    </div>
                </div>
            </div>
            <div 
                x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                class="flex items-center justify-center transition-all ease-out duration-700 delay-100" 
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                <img src="{{ asset('images/about/bridge.svg') }}" alt="Mission statement illustration" class="w-full max-w-md h-auto rounded-lg object-contain" onerror="this.style.display='none'">
            </div>
        </div>
    </section>

    <section class="bg-background-light dark:bg-background-dark/50 py-16">
        <div class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-6 flex flex-col gap-12">
            <div 
                x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                class="flex flex-col gap-4 text-center transition-all ease-out duration-700" 
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                <h2 class="text-3xl font-bold leading-tight tracking-[-0.015em] md:text-4xl">Our Core Values</h2>
                <p class="text-subtext-light dark:text-subtext-dark max-w-2xl mx-auto text-lg">
                    These principles guide everything we do, from connecting students to supporting our tutors.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $values = [
                        ['icon' => 'school', 'title' => 'Quality Education', 'text' => 'We ensure all tutors are verified and qualified to provide the best learning experience for students.', 'image' => 'about/value-quality.png'],
                        ['icon' => 'group', 'title' => 'Accessibility', 'text' => 'Making quality tutoring affordable and accessible to students from all backgrounds.', 'image' => 'about/value-accessibility.png'],
                        ['icon' => 'verified_user', 'title' => 'Trust & Safety', 'text' => 'Building a safe, transparent platform where students and tutors can connect with confidence.', 'image' => 'about/value-trust.png'],
                    ];
                @endphp
                @foreach($values as $index => $value)
                <div 
                    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
                    class="flex flex-col gap-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark/50 p-6 text-center items-center shadow-sm transition-all ease-out duration-500 hover:-translate-y-2" 
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                    style="transition-delay: {{ $index * 100 }}ms">
                    
                    <div class="w-24 h-24 flex items-center justify-center rounded-full bg-primary/10 dark:bg-primary/20">
                        <img src="{{ asset('images/' . $value['image']) }}" alt="{{ $value['title'] }} illustration" class="w-full h-full object-contain rounded-full p-4" onerror="this.style.display='none'">
                    </div>
                    
                    <h3 class="text-xl font-bold leading-tight">{{ $value['title'] }}</h3>
                    <p class="text-subtext-light dark:text-subtext-dark text-base font-normal leading-normal">{{ $value['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-6 flex flex-col gap-12" id="how-it-works">
        <div 
            x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
            class="flex flex-col gap-4 text-center transition-all ease-out duration-700" 
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <h2 class="text-3xl font-bold leading-tight tracking-[-0.015em] md:text-4xl">Your Journey with Htc</h2>
            <p class="text-subtext-light dark:text-subtext-dark max-w-2xl mx-auto text-lg">
                Simple steps to connect with knowledge and achieve your academic best.
            </p>
        </div>

        <div 
            x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
            class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center transition-all ease-out duration-700"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <div class="flex flex-col gap-4">
                <span class="text-primary font-bold">Step 1</span>
                <h3 class="text-2xl md:text-3xl font-bold">Find Your Ideal Tutor</h3>
                <p class="text-subtext-light dark:text-subtext-dark">Browse our extensive database of certified tutors. Filter by subject, experience, ratings, and availability to find the perfect fit for your learning needs.</p>
            </div>
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/about/process-search.png') }}" alt="Search for tutors illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
            </div>
        </div>

        <div 
            x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
            class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center transition-all ease-out duration-700 delay-100"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <div class="flex items-center justify-center lg:order-first">
                <img src="{{ asset('images/about/process-book.png') }}" alt="Book a session illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
            </div>
            <div class="flex flex-col gap-4">
                <span class="text-primary font-bold">Step 2</span>
                <h3 class="text-2xl md:text-3xl font-bold">Book & Connect Seamlessly</h3>
                <p class="text-subtext-light dark:text-subtext-dark">With just a few clicks, schedule your preferred online or in-person session. Our integrated platform makes connecting with your tutor simple and secure.</p>
            </div>
        </div>

        <div 
            x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
            class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center transition-all ease-out duration-700 delay-200"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <div class="flex flex-col gap-4">
                <span class="text-primary font-bold">Step 3</span>
                <h3 class="text-2xl md:text-3xl font-bold">Start Learning, Track Progress</h3>
                <p class="text-subtext-light dark:text-subtext-dark">Dive into personalized lessons designed to meet your needs. Track your progress, review past sessions, and celebrate your achievements, all within Htc.</p>
            </div>
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/about/process-learn.png') }}" alt="Start learning illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
            </div>
        </div>
    </section>

    <section 
        x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
        class="transition-all ease-out duration-700">
        <div class="bg-gradient-to-br from-primary to-blue-600 rounded-xl p-8 md:p-16 text-center flex flex-col items-center gap-6 max-w-[1200px] mx-auto px-4 md:px-10 lg:px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight tracking-[-0.015em]">Ready to Elevate Your Learning?</h2>
            <p class="text-blue-100 text-lg max-w-lg">
                Join thousands of students and expert tutors already thriving with Htc.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register.student') }}" class="px-8 py-3 bg-white text-primary rounded-lg font-bold hover:bg-gray-100 transition shadow-lg">
                    Register as Student
                </a>
                <a href="{{ route('register.tutor') }}" class="px-8 py-3 bg-secondary text-white rounded-lg font-bold hover:bg-secondary/90 transition shadow-lg">
                    Become a Tutor
                </a>
            </div>
        </div>
    </section>

</div>
@endsection