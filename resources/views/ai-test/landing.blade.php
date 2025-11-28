@extends('layouts.public')

@section('title', 'AI Exam Prep - The First Mock Test That Listens to You')

@section('full-width-content')
<div class="bg-black text-white min-h-screen font-sans w-full">
    
    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] rounded-full bg-accent-yellow/10 blur-[80px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-primary/20 blur-[100px]"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-0.5 px-2 rounded-full border border-gray-700 bg-gray-900/50 backdrop-blur-sm text-gray-300 text-[10px] font-bold uppercase tracking-widest mb-4">
                <span class="w-1.5 h-1.5 inline-block rounded-full bg-green-500 mr-1.5"></span>
                Powered by Grok 4 AI
            </span>
            
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl uppercase leading-[0.9] mb-6">
                The First Mock Test<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">That Listens to You.</span>
            </h1>
            
            <p class="text-base md:text-lg text-gray-400 max-w-2xl mx-auto mb-8 font-light">
                Select your exam, pick your weak topic, and let AI build a realistic test pattern instantly.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('ai-test.create') }}" class="group relative inline-flex items-center justify-center px-6 py-3 font-bold text-black transition-all duration-200 bg-accent-yellow font-heading uppercase tracking-wider rounded-lg hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-yellow ring-offset-black text-sm">
                    Build My Test
                    <span class="absolute -top-2 -right-2 flex h-5 w-5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-5 w-5 bg-red-500 text-white text-[9px] items-center justify-center font-sans">3</span>
                    </span>
                    <svg class="w-4 h-4 ml-2 -mr-1 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <span class="text-xs text-gray-500 font-mono">3 Free Credits Left</span>
            </div>
        </div>
    </section>

    <!-- Video Placeholder -->
    <section class="py-8 relative z-10">
        <div class="max-w-4xl mx-auto px-4">
            <div class="relative rounded-xl overflow-hidden border border-gray-800 shadow-2xl bg-gray-900 aspect-video group cursor-pointer">
                <!-- Placeholder UI -->
                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/20 transition-all">
                    <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/90 to-transparent">
                    <p class="text-white font-bold text-base">Watch how we generate a JEE/SAT/Custom test in under 30 seconds.</p>
                </div>
                <!-- Grid Pattern Overlay -->
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/grid-me.png')] opacity-10 pointer-events-none"></div>
            </div>
        </div>
    </section>

    <!-- How It Works (3-Step Flow) -->
    <section class="py-16 relative z-10">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-10 left-[16%] right-[16%] h-0.5 bg-gradient-to-r from-gray-800 via-accent-yellow/50 to-gray-800 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 rounded-xl bg-gray-900 border border-gray-700 flex items-center justify-center mb-4 shadow-[0_0_20px_rgba(0,0,0,0.5)] group-hover:border-accent-yellow/50 group-hover:shadow-[0_0_20px_rgba(255,189,89,0.2)] transition-all duration-300">
                        <span class="material-symbols-outlined text-3xl text-gray-400 group-hover:text-accent-yellow transition-colors">target</span>
                    </div>
                    <h3 class="text-xl font-heading uppercase mb-2">1. Target</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Choose your Exam (JEE, SAT, NEET) or Academic Standard to set the baseline.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 rounded-xl bg-gray-900 border border-gray-700 flex items-center justify-center mb-4 shadow-[0_0_20px_rgba(0,0,0,0.5)] group-hover:border-accent-yellow/50 group-hover:shadow-[0_0_20px_rgba(255,189,89,0.2)] transition-all duration-300">
                        <span class="material-symbols-outlined text-3xl text-gray-400 group-hover:text-accent-yellow transition-colors">tune</span>
                    </div>
                    <h3 class="text-xl font-heading uppercase mb-2">2. Customize</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Drill down to specific chapters or topics (e.g., "Thermodynamics") to focus your practice.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center text-center group">
                    <div class="w-20 h-20 rounded-xl bg-gray-900 border border-gray-700 flex items-center justify-center mb-4 shadow-[0_0_20px_rgba(0,0,0,0.5)] group-hover:border-accent-yellow/50 group-hover:shadow-[0_0_20px_rgba(255,189,89,0.2)] transition-all duration-300">
                        <span class="material-symbols-outlined text-3xl text-gray-400 group-hover:text-accent-yellow transition-colors">analytics</span>
                    </div>
                    <h3 class="text-xl font-heading uppercase mb-2">3. Analyze</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Get deep insights into your performance and hire experts for your weak spots.</p>
                </div>
            </div>
            
            <div class="mt-16 text-center">
                <a href="{{ route('ai-test.create') }}" class="inline-block border-b-2 border-accent-yellow text-accent-yellow font-bold uppercase tracking-widest hover:text-white hover:border-white transition-colors pb-1 text-sm">
                    Start Your First Test Now
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
