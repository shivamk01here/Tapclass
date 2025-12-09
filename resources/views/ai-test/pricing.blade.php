@extends('layouts.ai')

@section('title', 'Upgrade Plan - HTC X')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4">
        
        <div class="text-center mb-16">
            <h1 class="font-heading text-4xl uppercase mb-4 text-white">Unlock Your Potential</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">Choose a plan that fits your preparation needs. Get access to unlimited AI-generated mock tests and premium features.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            
            <!-- Free Plan -->
            <div class="bg-black border border-white/10 rounded-2xl p-8 relative group hover:border-white/30 transition-all">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-white mb-2">Starter</h3>
                    <div class="text-3xl font-bold text-white">Free</div>
                    <p class="text-gray-500 text-sm mt-2">Perfect for trying out the platform</p>
                </div>
                
                <ul class="space-y-4 mb-8 text-sm text-gray-300">
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-400 text-lg">check</span>
                        <span>1 Free Credit (One-time)</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-400 text-lg">check</span>
                        <span>Max 25 Questions per Test</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-gray-600 text-lg">close</span>
                        <span class="text-gray-600">Full Test Mode</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-gray-600 text-lg">close</span>
                        <span class="text-gray-600">Detailed Analytics</span>
                    </li>
                </ul>

                <button class="w-full py-3 rounded-lg border border-white/20 text-white font-bold hover:bg-white/10 transition-colors uppercase text-xs tracking-wider cursor-default">
                    Current Plan
                </button>
            </div>

            <!-- Standard Plan -->
            <div class="bg-gradient-to-b from-accent-yellow/10 to-black border border-accent-yellow rounded-2xl p-8 relative transform md:-translate-y-4 shadow-[0_0_30px_rgba(255,189,89,0.1)]">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-accent-yellow text-black px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    Most Popular
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-white mb-2">Exam Ready</h3>
                    <div class="flex items-baseline gap-1">
                        <span class="text-3xl font-bold text-white">₹200</span>
                        <span class="text-gray-500 text-sm">/ 10 Tests</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Best for focused preparation</p>
                </div>
                
                <ul class="space-y-4 mb-8 text-sm text-gray-300">
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-accent-yellow text-lg">check</span>
                        <span>10 Test Credits</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-accent-yellow text-lg">check</span>
                        <span>Up to 100 Questions/Test</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-accent-yellow text-lg">check</span>
                        <span>Full Test Mode Unlocked</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-accent-yellow text-lg">check</span>
                        <span>Premium Badge</span>
                    </li>
                </ul>

                <form action="{{ route('ai-test.purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan" value="standard">
                    <button type="submit" class="w-full py-3 rounded-lg bg-accent-yellow text-black font-bold hover:bg-white hover:scale-105 transition-all shadow-lg uppercase text-xs tracking-wider flex justify-center items-center gap-2">
                        Buy Now
                    </button>
                </form>
            </div>

            <!-- Pro Plan -->
            <div class="bg-black border border-white/10 rounded-2xl p-8 relative group hover:border-white/30 transition-all">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-white mb-2">Ranker</h3>
                    <div class="flex items-baseline gap-1">
                        <span class="text-3xl font-bold text-white">₹1000</span>
                        <span class="text-gray-500 text-sm">/ 100 Tests</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">For serious aspirants</p>
                </div>
                
                <ul class="space-y-4 mb-8 text-sm text-gray-300">
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-400 text-lg">check</span>
                        <span>100 Test Credits</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-400 text-lg">check</span>
                        <span>All Premium Features</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-400 text-lg">check</span>
                        <span>Priority Generation</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-400 text-lg">check</span>
                        <span>Detailed Analytics</span>
                    </li>
                </ul>

                <form action="{{ route('ai-test.purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan" value="pro">
                    <button type="submit" class="w-full py-3 rounded-lg border border-white/20 text-white font-bold hover:bg-white hover:text-black transition-all uppercase text-xs tracking-wider flex justify-center items-center gap-2">
                        Buy Now
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
