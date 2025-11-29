@extends('layouts.ai')

@section('title', 'AI Exam Prep - HTC X')

@section('content')
    
    <!-- Hero Section -->
    <section class="relative pt-20 pb-24 overflow-hidden">
        <!-- Premium 3D/Neon Background Effects -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <!-- Central Glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-primary/20 blur-[120px] animate-pulse"></div>
            <!-- Accent Orbs -->
            <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-accent-yellow/10 blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-purple-900/20 blur-[100px]"></div>
            
            <!-- Grid Overlay -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 relative z-10 text-center">
            
            <!-- Impactful Heading -->
            <h1 class="font-heading text-5xl md:text-7xl uppercase leading-none mb-6 text-white tracking-tight drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                THE FIRST MOCK TEST <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-yellow to-yellow-200">THAT LISTENS TO YOU.</span>
            </h1>
            
            <!-- Subheading -->
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 font-light leading-relaxed">
                Select your exam, pick your weak topic, and let AI build a realistic test pattern instantly.
            </p>
            
            <!-- Search Input Style -->
            <div class="max-w-xl mx-auto mb-10">
                <a href="{{ route('ai-test.create', ['exam' => 'Other']) }}" class="block w-full bg-white/5 border border-white/20 rounded-full py-4 px-6 text-left text-gray-400 hover:bg-white/10 hover:border-accent-yellow/50 hover:text-white transition-all flex items-center gap-4 group backdrop-blur-sm shadow-lg">
                    <span class="material-symbols-outlined text-2xl group-hover:text-accent-yellow transition-colors">search</span>
                    <span class="text-lg font-light">Search for your exams...</span>
                </a>
            </div>

            <!-- Popular Exams -->
            <div class="mb-10">
                <p class="text-gray-500 text-xs uppercase tracking-widest mb-4 font-bold">Choose from these</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('ai-test.create', ['exam' => 'JEE Mains']) }}" class="px-8 py-3 rounded-full border border-white/20 bg-white/5 hover:border-accent-yellow hover:text-black hover:bg-accent-yellow transition-all text-sm font-bold backdrop-blur-sm">JEE Mains</a>
                    <a href="{{ route('ai-test.create', ['exam' => 'NEET']) }}" class="px-8 py-3 rounded-full border border-white/20 bg-white/5 hover:border-accent-yellow hover:text-black hover:bg-accent-yellow transition-all text-sm font-bold backdrop-blur-sm">NEET</a>
                    <a href="{{ route('ai-test.create', ['exam' => 'SAT']) }}" class="px-8 py-3 rounded-full border border-white/20 bg-white/5 hover:border-accent-yellow hover:text-black hover:bg-accent-yellow transition-all text-sm font-bold backdrop-blur-sm">SAT</a>
                </div>
            </div>

            <!-- Custom Option -->
            <div>
                <p class="text-gray-500 text-xs uppercase tracking-widest mb-4 font-bold">Or Build Your Own</p>
                <a href="{{ route('ai-test.create', ['exam' => 'Custom']) }}" class="inline-flex items-center gap-3 px-8 py-3 border border-accent-yellow text-accent-yellow font-bold rounded-lg hover:bg-accent-yellow hover:text-black transition-all uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-lg">tune</span>
                    Build Subject Wise Custom
                </a>
            </div>
        </div>
    </section>

    <!-- Video Section (Premium Frame) -->
    <section class="py-12 relative z-10">
        <div class="max-w-4xl mx-auto px-4">
            <div class="relative rounded-xl overflow-hidden border border-white/10 shadow-[0_0_40px_rgba(0,0,0,0.5)] bg-black aspect-video group cursor-pointer ring-1 ring-white/5 hover:ring-accent-yellow/50 transition-all duration-500">
                <!-- Placeholder UI -->
                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/20 transition-all">
                    <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 group-hover:scale-110 group-hover:bg-accent-yellow group-hover:text-black group-hover:border-accent-yellow transition-all duration-300 shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                        <svg class="w-6 h-6 text-white group-hover:text-black ml-1 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black via-black/80 to-transparent">
                    <p class="text-white font-bold text-lg tracking-wide">See It In Action</p>
                    <p class="text-gray-400 text-sm">Watch how we generate a personalized test in seconds.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features / Offerings Section -->
    <section class="py-20 relative z-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-heading text-3xl md:text-4xl uppercase text-white mb-4">What We Offer</h2>
                <div class="w-24 h-1 bg-accent-yellow mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Feature 1 -->
                <div class="group relative p-8 rounded-2xl bg-white/5 border border-white/10 hover:border-accent-yellow/50 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <img src="https://api.iconify.design/solar/brain-bold-duotone.svg?color=%234cb9e1&width=120&height=120" alt="Icon">
                    </div>
                    <div class="w-14 h-14 rounded-lg bg-black/50 border border-white/10 flex items-center justify-center mb-6 shadow-lg">
                        <img src="https://api.iconify.design/solar/brain-bold-duotone.svg?color=%234cb9e1&width=32&height=32" alt="Icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-heading uppercase tracking-wide">Adaptive Intelligence</h3>
                    <p class="text-gray-400 text-sm leading-relaxed relative z-10">
                        Our secret engine analyzes your performance in real-time, adjusting difficulty to ensure optimal growth.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group relative p-8 rounded-2xl bg-white/5 border border-white/10 hover:border-accent-yellow/50 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <img src="https://api.iconify.design/solar/target-bold-duotone.svg?color=%234cb9e1&width=120&height=120" alt="Icon">
                    </div>
                    <div class="w-14 h-14 rounded-lg bg-black/50 border border-white/10 flex items-center justify-center mb-6 shadow-lg">
                        <img src="https://api.iconify.design/solar/target-bold-duotone.svg?color=%234cb9e1&width=32&height=32" alt="Icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-heading uppercase tracking-wide">Precision Targeting</h3>
                    <p class="text-gray-400 text-sm leading-relaxed relative z-10">
                        Don't waste time. Focus exactly on your weak chapters and topics with surgically precise question selection.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group relative p-8 rounded-2xl bg-white/5 border border-white/10 hover:border-accent-yellow/50 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <img src="https://api.iconify.design/solar/graph-new-bold-duotone.svg?color=%234cb9e1&width=120&height=120" alt="Icon">
                    </div>
                    <div class="w-14 h-14 rounded-lg bg-black/50 border border-white/10 flex items-center justify-center mb-6 shadow-lg">
                        <img src="https://api.iconify.design/solar/graph-new-bold-duotone.svg?color=%234cb9e1&width=32&height=32" alt="Icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-heading uppercase tracking-wide">Deep Analytics</h3>
                    <p class="text-gray-400 text-sm leading-relaxed relative z-10">
                        Get granular insights into your speed, accuracy, and conceptual clarity. Know exactly where you stand.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group relative p-8 rounded-2xl bg-white/5 border border-white/10 hover:border-accent-yellow/50 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <img src="https://api.iconify.design/solar/diploma-bold-duotone.svg?color=%234cb9e1&width=120&height=120" alt="Icon">
                    </div>
                    <div class="w-14 h-14 rounded-lg bg-black/50 border border-white/10 flex items-center justify-center mb-6 shadow-lg">
                        <img src="https://api.iconify.design/solar/diploma-bold-duotone.svg?color=%234cb9e1&width=32&height=32" alt="Icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-heading uppercase tracking-wide">Exam Simulation</h3>
                    <p class="text-gray-400 text-sm leading-relaxed relative z-10">
                        Experience the pressure of real exams like JEE, NEET, and SAT with our realistic test environment.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="group relative p-8 rounded-2xl bg-white/5 border border-white/10 hover:border-accent-yellow/50 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <img src="https://api.iconify.design/solar/bolt-bold-duotone.svg?color=%234cb9e1&width=120&height=120" alt="Icon">
                    </div>
                    <div class="w-14 h-14 rounded-lg bg-black/50 border border-white/10 flex items-center justify-center mb-6 shadow-lg">
                        <img src="https://api.iconify.design/solar/bolt-bold-duotone.svg?color=%234cb9e1&width=32&height=32" alt="Icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-heading uppercase tracking-wide">Instant Generation</h3>
                    <p class="text-gray-400 text-sm leading-relaxed relative z-10">
                        No waiting. Generate a full-length mock test or a quick 10-minute quiz in seconds.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="group relative p-8 rounded-2xl bg-white/5 border border-white/10 hover:border-accent-yellow/50 hover:bg-white/10 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                        <img src="https://api.iconify.design/solar/magic-stick-3-bold-duotone.svg?color=%234cb9e1&width=120&height=120" alt="Icon">
                    </div>
                    <div class="w-14 h-14 rounded-lg bg-black/50 border border-white/10 flex items-center justify-center mb-6 shadow-lg">
                        <img src="https://api.iconify.design/solar/magic-stick-3-bold-duotone.svg?color=%234cb9e1&width=32&height=32" alt="Icon">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 font-heading uppercase tracking-wide">Smart Recommendations</h3>
                    <p class="text-gray-400 text-sm leading-relaxed relative z-10">
                        After every test, get personalized recommendations on what to study next to maximize your score improvement.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-16 relative z-10 text-center">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="font-heading text-3xl uppercase text-white mb-6">Ready to Outperform?</h2>
            <a href="{{ route('ai-test.create') }}" class="inline-block border-b-2 border-accent-yellow text-accent-yellow font-bold uppercase tracking-widest hover:text-white hover:border-white transition-colors pb-1 text-sm">
                Start Your Journey Now
            </a>
        </div>
    </section>

@endsection
