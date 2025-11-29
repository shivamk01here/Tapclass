@extends('layouts.ai')

@section('title', 'AI Exam Prep - HTC X')

@section('content')
    
    <!-- Hero Section -->
    <section class="relative pt-10 pb-16 overflow-hidden">
        <!-- Background Elements (Subtle) -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[300px] h-[300px] rounded-full bg-accent-yellow/5 blur-[80px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-primary/10 blur-[100px]"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-0.5 px-2 rounded-full border border-white/10 bg-white/5 backdrop-blur-sm text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-4">
                <span class="w-1.5 h-1.5 inline-block rounded-full bg-green-500 mr-1.5"></span>
                Powered by Gemini 2.0
            </span>
            
            <h1 class="font-heading text-4xl md:text-5xl uppercase leading-none mb-4 text-white">
                The First Mock Test<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">That Listens to You.</span>
            </h1>
            
            <p class="text-sm md:text-base text-gray-400 max-w-xl mx-auto mb-6 font-light">
                Select your exam, pick your weak topic, and let AI build a realistic test pattern instantly.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('ai-test.create') }}" class="group relative inline-flex items-center justify-center px-5 py-2.5 font-bold text-black transition-all duration-200 bg-accent-yellow font-heading uppercase tracking-wider rounded hover:bg-white focus:outline-none text-xs">
                    Build My Test
                    <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-white text-[8px] items-center justify-center font-sans">3</span>
                    </span>
                    <svg class="w-3 h-3 ml-2 -mr-1 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <span class="text-[10px] text-gray-500 font-mono">3 Free Credits Left</span>
            </div>
        </div>
    </section>

    <!-- Video Placeholder (Full Width Style) -->
    <section class="py-6 relative z-10">
        <div class="max-w-3xl mx-auto px-4">
            <div class="relative rounded-lg overflow-hidden border border-white/10 shadow-2xl bg-black aspect-video group cursor-pointer">
                <!-- Placeholder UI -->
                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/20 transition-all">
                    <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 w-full p-3 bg-gradient-to-t from-black/90 to-transparent">
                    <p class="text-white font-bold text-sm">Watch how we generate a JEE/SAT/Custom test in under 30 seconds.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works (3-Step Flow) -->
    <section class="py-12 relative z-10">
        <div class="max-w-4xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-8 left-[16%] right-[16%] h-px bg-gradient-to-r from-white/5 via-accent-yellow/30 to-white/5 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 rounded-lg bg-black border border-white/10 flex items-center justify-center mb-3 shadow-lg group-hover:border-accent-yellow/50 transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl text-gray-500 group-hover:text-accent-yellow transition-colors">target</span>
                    </div>
                    <h3 class="text-lg font-heading uppercase mb-1 text-white">1. Target</h3>
                    <p class="text-gray-500 text-xs leading-relaxed max-w-[200px]">Choose your Exam (JEE, SAT, NEET) or Academic Standard.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 rounded-lg bg-black border border-white/10 flex items-center justify-center mb-3 shadow-lg group-hover:border-accent-yellow/50 transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl text-gray-500 group-hover:text-accent-yellow transition-colors">tune</span>
                    </div>
                    <h3 class="text-lg font-heading uppercase mb-1 text-white">2. Customize</h3>
                    <p class="text-gray-500 text-xs leading-relaxed max-w-[200px]">Drill down to specific chapters or topics to focus your practice.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 rounded-lg bg-black border border-white/10 flex items-center justify-center mb-3 shadow-lg group-hover:border-accent-yellow/50 transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl text-gray-500 group-hover:text-accent-yellow transition-colors">analytics</span>
                    </div>
                    <h3 class="text-lg font-heading uppercase mb-1 text-white">3. Analyze</h3>
                    <p class="text-gray-500 text-xs leading-relaxed max-w-[200px]">Get deep insights into your performance and hire experts.</p>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('ai-test.create') }}" class="inline-block border-b border-accent-yellow text-accent-yellow font-bold uppercase tracking-widest hover:text-white hover:border-white transition-colors pb-0.5 text-xs">
                    Start Your First Test Now
                </a>
            </div>
        </div>
    </section>

@endsection
