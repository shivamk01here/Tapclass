@extends('layouts.ai')

@section('title', 'Upgrade Plan - HTC X')

@section('content')
<div class="py-12" x-data="pricingPage()">
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

                <button @click="purchase('standard')" :disabled="processing" class="w-full py-3 rounded-lg bg-accent-yellow text-black font-bold hover:bg-white hover:scale-105 transition-all shadow-lg uppercase text-xs tracking-wider flex justify-center items-center gap-2">
                    <span x-show="processing && selectedPlan === 'standard'" class="w-4 h-4 border-2 border-black border-t-transparent rounded-full animate-spin"></span>
                    Buy Now
                </button>
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

                <button @click="purchase('pro')" :disabled="processing" class="w-full py-3 rounded-lg border border-white/20 text-white font-bold hover:bg-white hover:text-black transition-all uppercase text-xs tracking-wider flex justify-center items-center gap-2">
                    <span x-show="processing && selectedPlan === 'pro'" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    Buy Now
                </button>
            </div>

        </div>

        <!-- Mock Payment Modal -->
        <div x-show="showPaymentModal" style="display: none;" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-transition>
            <div class="bg-white rounded-xl p-6 max-w-sm w-full shadow-2xl text-black">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold">Secure Payment</h3>
                    <span class="material-symbols-outlined text-green-600">lock</span>
                </div>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Plan:</span>
                        <span class="font-bold" x-text="planName"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-bold text-xl" x-text="planPrice"></span>
                    </div>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xs">P</div>
                    <div>
                        <div class="text-xs font-bold">Mock Payment Gateway</div>
                        <div class="text-[10px] text-gray-500">Test Mode Enabled</div>
                    </div>
                </div>

                <button @click="confirmPayment()" class="w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition-colors flex justify-center items-center gap-2">
                    <span x-show="paying" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span x-text="paying ? 'Processing...' : 'Pay Now'"></span>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function pricingPage() {
        return {
            processing: false,
            selectedPlan: '',
            showPaymentModal: false,
            planName: '',
            planPrice: '',
            paying: false,

            purchase(plan) {
                this.selectedPlan = plan;
                this.processing = true;
                
                // Simulate network delay
                setTimeout(() => {
                    if (plan === 'standard') {
                        this.planName = 'Exam Ready (10 Tests)';
                        this.planPrice = '₹200';
                    } else if (plan === 'pro') {
                        this.planName = 'Ranker (100 Tests)';
                        this.planPrice = '₹1000';
                    }
                    this.showPaymentModal = true;
                    this.processing = false;
                }, 500);
            },

            async confirmPayment() {
                this.paying = true;
                
                try {
                    const response = await fetch("{{ route('ai-test.purchase') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ plan: this.selectedPlan })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Show success animation or toast if needed
                        alert('Payment Successful! Credits added.');
                        window.location.href = "{{ route('ai-test.create') }}";
                    } else {
                        alert('Payment failed. Please try again.');
                    }
                } catch (error) {
                    console.error('Payment error:', error);
                    alert('An error occurred.');
                } finally {
                    this.paying = false;
                    this.showPaymentModal = false;
                }
            }
        }
    }
</script>
@endsection
