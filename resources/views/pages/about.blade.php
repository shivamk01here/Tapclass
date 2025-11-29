@extends('layouts.public')

@section('title', 'About Us - htc')

@section('content')

    <!-- Mission Section (Moved to Top) -->
    <section class="py-16 md:py-24">
        <div class="bg-white border-2 border-black rounded-2xl shadow-header-chunky p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="flex flex-col gap-6">
                    <h2 class="font-heading text-h2 uppercase leading-tight font-normal">Our Mission: Bridging the Education Gap</h2>
                    <p class="text-text-subtle text-base leading-relaxed">
                        At htc, we believe that every student deserves access to quality education tailored to their unique learning needs. Our mission is to bridge the gap between students and qualified tutors, making personalized learning accessible to everyone.
                    </p>
                    
                    <div class="bg-subscribe-bg rounded-2xl p-6 grid grid-cols-2 gap-6 mt-4">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-black mb-1">1000+</div>
                            <div class="text-text-subtle font-medium text-sm">Qualified Tutors</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-black mb-1">5000+</div>
                            <div class="text-text-subtle font-medium text-sm">Active Students</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-black mb-1">50+</div>
                            <div class="text-text-subtle font-medium text-sm">Subjects</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-black mb-1">4.8/5</div>
                            <div class="text-text-subtle font-medium text-sm">Average Rating</div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/about/bridge.svg') }}" alt="Mission statement illustration" class="w-full max-w-md h-auto rounded-lg object-contain" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Section (Light Mode with 3D Box Effect) -->
    <section class="pb-16 md:pb-24">
        <div class="flex flex-col gap-4 text-center mb-12">
            <h2 class="font-heading text-h2 uppercase leading-tight font-normal">Meet The Leadership</h2>
            <p class="text-text-subtle max-w-2xl mx-auto text-lg">The visionaries driving our mission forward.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Shivam Kumar -->
            <div class="flex flex-col gap-6 rounded-xl border-2 border-black bg-white p-6 text-center items-center shadow-button-chunky transition-all ease-out duration-300 hover:-translate-y-1 hover:shadow-header-chunky">
                <div class="w-24 h-24 rounded-full bg-subscribe-bg mb-2 mx-auto flex items-center justify-center text-2xl font-bold border-2 border-black">SK</div>
                <div>
                    <h3 class="font-heading text-xl uppercase leading-tight">Shivam Kumar</h3>
                    <p class="text-primary text-sm font-bold uppercase tracking-wider mb-4">Co-Founder & Tech Lead</p>
                    <p class="text-text-subtle text-sm leading-relaxed">
                        Technical vision, full-stack architecture, and scalability.
                    </p>
                </div>
                <a href="https://www.linkedin.com/in/shivam01here/" target="_blank" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#0077b5] text-white border-2 border-black hover:bg-[#006097] transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                    <i class="bi bi-linkedin"></i>
                </a>
            </div>

            <!-- Aditya Pathak -->
            <div class="flex flex-col gap-6 rounded-xl border-2 border-black bg-white p-6 text-center items-center shadow-button-chunky transition-all ease-out duration-300 hover:-translate-y-1 hover:shadow-header-chunky">
                <div class="w-24 h-24 rounded-full bg-subscribe-bg mb-2 mx-auto flex items-center justify-center text-2xl font-bold border-2 border-black">AP</div>
                <div>
                    <h3 class="font-heading text-xl uppercase leading-tight">Aditya Pathak</h3>
                    <p class="text-primary text-sm font-bold uppercase tracking-wider mb-4">Head of Growth & Strategy</p>
                    <p class="text-text-subtle text-sm leading-relaxed">
                        Sales acceleration, market positioning, and partnerships.
                    </p>
                </div>
                <a href="https://www.linkedin.com/in/aditya-pathak-/" target="_blank" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#0077b5] text-white border-2 border-black hover:bg-[#006097] transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                    <i class="bi bi-linkedin"></i>
                </a>
            </div>

            <!-- Hitesh Pathak -->
            <div class="flex flex-col gap-6 rounded-xl border-2 border-black bg-white p-6 text-center items-center shadow-button-chunky transition-all ease-out duration-300 hover:-translate-y-1 hover:shadow-header-chunky">
                <div class="w-24 h-24 rounded-full bg-subscribe-bg mb-2 mx-auto flex items-center justify-center text-2xl font-bold border-2 border-black">HP</div>
                <div>
                    <h3 class="font-heading text-xl uppercase leading-tight">Hitesh Pathak</h3>
                    <p class="text-primary text-sm font-bold uppercase tracking-wider mb-4">Head of Operations</p>
                    <p class="text-text-subtle text-sm leading-relaxed">
                        Execution, systems efficiency, and day-to-day excellence.
                    </p>
                </div>
                <a href="https://www.linkedin.com/in/hitesh-pathak-58655720/?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base%3BY36Z2vAIR6S%2BcREDSvuebA%3D%3D" target="_blank" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#0077b5] text-white border-2 border-black hover:bg-[#006097] transition-colors shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-y-0.5 active:shadow-none">
                    <i class="bi bi-linkedin"></i>
                </a>
            </div>

        </div>

        <!-- Extended Team Banner -->
        <div class="mt-12 p-8 rounded-2xl bg-subscribe-bg border-2 border-black text-center shadow-button-chunky">
            <p class="text-lg md:text-xl text-text-subtle font-medium max-w-3xl mx-auto">
                Beyond leadership, we are backed by a talented distributed team of <span class="text-black font-bold">developers, designers, and creators</span> who make the magic happen.
            </p>
        </div>
    </section>

    <!-- Original Hero Section (Moved to 3rd Place) -->
    <section class="pb-16 md:pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div class="flex flex-col gap-6 items-center lg:items-start text-center lg:text-left">
                
                <h1 class="font-heading text-hero-md uppercase leading-tight font-normal"> 
                    Empowering Minds Through Personalized Learning. 
                </h1>
                <p class="text-lg text-text-subtle max-w-2xl"> 
                    At htc, we're dedicated to transforming education by connecting students with expert tutors, fostering a love for learning, and unlocking individual potential.
                </p>
                
                <a href="{{ route('tutors.search') }}" 
                   class="inline-block bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                    Find Your Tutor Today
                </a>
            </div>
            
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/about/about-hero.png') }}" alt="Students learning with tutors" class="w-full max-w-lg h-auto rounded-lg object-contain" onerror="this.style.display='none'">
            </div>
        </div>
    </section>

    <section class="pb-16 md:pb-24">
        <div class="flex flex-col gap-4 text-center mb-12">
            <h2 class="font-heading text-h2 uppercase leading-tight font-normal">Our Core Values</h2>
            <p class="text-text-subtle max-w-2xl mx-auto text-lg">
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
            <div class="flex flex-col gap-6 rounded-xl border-2 border-black bg-white p-6 text-center items-center shadow-button-chunky transition-all ease-out duration-300 hover:-translate-y-1 hover:shadow-header-chunky">
                
                <div class="w-24 h-24 flex items-center justify-center rounded-full bg-subscribe-bg">
                    <img src="{{ asset('images/' . $value['image']) }}" alt="{{ $value['title'] }} illustration" class="w-full h-full object-contain rounded-full p-4" onerror="this.style.display='none'">
                </div>
                
                <h3 class="font-heading text-h3 uppercase leading-tight">{{ $value['title'] }}</h3>
                <p class="text-text-subtle text-base font-normal leading-normal">{{ $value['text'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="pb-16 md:pb-24" id="how-it-works">
        <div class="flex flex-col gap-4 text-center mb-12">
            <h2 class="font-heading text-h2 uppercase leading-tight font-normal">Your Journey with htc</h2>
            <p class="text-text-subtle max-w-2xl mx-auto text-lg">
                Simple steps to connect with knowledge and achieve your academic best.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center mb-8">
            <div class="flex flex-col gap-4">
                <span class="text-primary font-bold">Step 1</span>
                <h3 class="font-heading text-h3 uppercase">Find Your Ideal Tutor</h3>
                <p class="text-text-subtle">Browse our extensive database of certified tutors. Filter by subject, experience, ratings, and availability to find the perfect fit.</p>
            </div>
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/about/process-search.png') }}" alt="Search for tutors illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center mb-8">
            <div class="flex items-center justify-center lg:order-first">
                <img src="{{ asset('images\login\tutor.svg') }}" alt="Book a session illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
            </div>
            <div class="flex flex-col gap-4">
                <span class="text-primary font-bold">Step 2</span>
                <h3 class="font-heading text-h3 uppercase">Book & Connect Seamlessly</h3>
                <p class="text-text-subtle">With just a few clicks, schedule your preferred online or in-person session. Our integrated platform makes connecting with your tutor simple and secure.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="flex flex-col gap-4">
                <span class="text-primary font-bold">Step 3</span>
                <h3 class="font-heading text-h3 uppercase">Start Learning, Track Progress</h3>
                <p class="text-text-subtle">Dive into personalized lessons designed to meet your needs. Track your progress, review past sessions, and celebrate your achievements, all within htc.</p>
            </div>
            <div class="flex items-center justify-center">
                <img src="{{ asset('images\Hero\Grades-bro.svg') }}" alt="Start learning illustration" class="w-full max-w-md h-auto rounded-lg" onerror="this.style.display='none'">
            </div>
        </div>
    </section>

    <section class="pb-16 md:pb-24">
        <div class="bg-subscribe-bg border-2 border-black rounded-2xl shadow-header-chunky p-8 md:p-16 text-center flex flex-col items-center gap-6">
            <h2 class="font-heading text-h2 uppercase text-black leading-tight">Ready to Elevate Your Learning?</h2>
            <p class="text-text-subtle text-lg max-w-lg">
                Join thousands of students and expert tutors already thriving with htc.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                
                <a href="{{ route('register.student') }}" class="w-full sm:w-auto bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                    Register as Student
                </a>
                
                <a href="{{ route('register.tutor') }}" class="w-full sm:w-auto bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                    Become a Tutor
                </a>
            </div>
        </div>
    </section>

</div>
@endsection