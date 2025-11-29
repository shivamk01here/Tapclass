@extends('layouts.public')

@section('title', $job['title'] . ' - Careers')

@section('content')
<div class="bg-white min-h-screen" x-data="{ showApplyModal: false, submitted: false }">
    
    <!-- Header -->
    <div class="bg-gray-50 border-b border-gray-200 py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('careers') }}" class="inline-flex items-center text-text-subtle hover:text-black mb-6 text-sm font-medium transition-colors">
                <i class="bi bi-arrow-left mr-2"></i> Back to Openings
            </a>
            
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div>
                    <h1 class="font-heading text-3xl md:text-4xl uppercase leading-tight font-normal mb-2">
                        {{ $job['title'] }}
                    </h1>
                    <div class="flex flex-wrap gap-3 text-sm text-text-subtle">
                        <span class="flex items-center"><i class="bi bi-briefcase mr-1.5"></i> {{ $job['category'] }}</span>
                        <span class="flex items-center"><i class="bi bi-clock mr-1.5"></i> {{ $job['type'] }}</span>
                        <span class="flex items-center"><i class="bi bi-geo-alt mr-1.5"></i> {{ $job['location'] }}</span>
                    </div>
                </div>
                <button @click="showApplyModal = true" class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-8 shadow-button-chunky hover:shadow-button-chunky-hover hover:-translate-y-0.5 active:translate-y-0 active:shadow-button-chunky-active transition-all">
                    Apply Now
                </button>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="py-12 px-6">
        <div class="max-w-3xl mx-auto space-y-10">
            
            <section>
                <h2 class="font-heading text-xl uppercase mb-4">About the Role</h2>
                <p class="text-text-subtle leading-relaxed text-lg">
                    {{ $job['description'] }}
                </p>
            </section>

            @if(isset($job['responsibilities']))
            <section>
                <h2 class="font-heading text-xl uppercase mb-4">What You'll Do</h2>
                <ul class="space-y-3">
                    @foreach($job['responsibilities'] as $resp)
                    <li class="flex items-start gap-3 text-text-subtle">
                        <i class="bi bi-check2 text-green-500 text-xl flex-shrink-0"></i>
                        <span>{{ $resp }}</span>
                    </li>
                    @endforeach
                </ul>
            </section>
            @endif

            <section>
                <h2 class="font-heading text-xl uppercase mb-4">Requirements</h2>
                <ul class="space-y-3">
                    @foreach($job['requirements'] as $req)
                    <li class="flex items-start gap-3 text-text-subtle">
                        <i class="bi bi-dot text-3xl leading-none -mt-2 flex-shrink-0"></i>
                        <span>{{ $req }}</span>
                    </li>
                    @endforeach
                </ul>
            </section>

            <div class="pt-8 border-t border-gray-100">
                <button @click="showApplyModal = true" class="w-full md:w-auto bg-black text-white border-2 border-black rounded-lg font-bold uppercase text-sm py-4 px-8 hover:bg-gray-800 transition-colors">
                    Apply for this Position
                </button>
            </div>

        </div>
    </div>

    <!-- Apply Modal -->
    <div x-show="showApplyModal" 
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
             @click.away="showApplyModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95">
            
            <!-- Success State -->
            <div x-show="submitted" class="p-12 text-center">
                <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="bi bi-check-lg text-3xl"></i>
                </div>
                <h3 class="font-heading text-2xl uppercase mb-2">Application Sent!</h3>
                <p class="text-text-subtle mb-8">Thank you for your interest. We'll be in touch shortly.</p>
                <button @click="showApplyModal = false; submitted = false" class="bg-gray-100 text-black font-bold py-3 px-8 rounded-lg hover:bg-gray-200 transition-colors">
                    Close
                </button>
            </div>

            <!-- Form State -->
            <div x-show="!submitted">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg">Apply for {{ $job['title'] }}</h3>
                    <button @click="showApplyModal = false" class="text-gray-400 hover:text-black transition-colors">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <form @submit.prevent="submitted = true" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Full Name</label>
                        <input type="text" required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:border-black focus:ring-0 outline-none transition-colors" placeholder="John Doe">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Email Address</label>
                        <input type="email" required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:border-black focus:ring-0 outline-none transition-colors" placeholder="john@example.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Phone Number</label>
                        <input type="tel" required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:border-black focus:ring-0 outline-none transition-colors" placeholder="+91 98765 43210">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Highest Education</label>
                        <select required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:border-black focus:ring-0 outline-none transition-colors bg-white">
                            <option value="">Select Qualification</option>
                            <option value="High School">High School</option>
                            <option value="Bachelor's">Bachelor's Degree</option>
                            <option value="Master's">Master's Degree</option>
                            <option value="PhD">PhD</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Why do you want to join us?</label>
                        <textarea required rows="3" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:border-black focus:ring-0 outline-none transition-colors" placeholder="Tell us briefly about your motivation..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Resume / Portfolio Link</label>
                        <input type="url" required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:border-black focus:ring-0 outline-none transition-colors" placeholder="https://linkedin.com/in/...">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 shadow-button-chunky hover:shadow-button-chunky-hover hover:-translate-y-0.5 active:translate-y-0 active:shadow-button-chunky-active transition-all">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
