@extends('layouts.public')

@section('title', 'Careers - Join Our Mission')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Hero Section -->
    <section class="py-16 px-6 border-b border-gray-100">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="font-heading text-4xl md:text-5xl uppercase leading-tight font-normal mb-4">
                Join Our Mission
            </h1>
            <p class="text-lg text-text-subtle max-w-2xl mx-auto leading-relaxed">
                We're building the future of personalized education. Be part of a team that values innovation, ownership, and impact.
            </p>
        </div>
    </section>

    <!-- Open Positions -->
    <section class="py-16 px-6">
        <div class="max-w-5xl mx-auto">
            <h2 class="font-heading text-2xl uppercase mb-8 text-center">Current Openings</h2>

            <div class="space-y-12">
                
                <!-- Marketing Category -->
                <div>
                    <h3 class="text-xl font-bold text-black mb-6 border-b border-gray-200 pb-2">Marketing</h3>
                    <div class="space-y-4">
                        @foreach($jobs['marketing'] as $job)
                        <a href="{{ route('careers.detail', $job['id']) }}" class="block group">
                            <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-black hover:shadow-button-chunky transition-all duration-200">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-lg font-bold text-black group-hover:text-primary transition-colors">{{ $job['title'] }}</h4>
                                            <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider">{{ $job['type'] }}</span>
                                        </div>
                                        <p class="text-text-subtle text-sm">{{ $job['location'] }}</p>
                                    </div>
                                    <div class="flex items-center text-primary font-bold text-sm group-hover:translate-x-1 transition-transform">
                                        View Details <i class="bi bi-arrow-right ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Content Category -->
                <div>
                    <h3 class="text-xl font-bold text-black mb-6 border-b border-gray-200 pb-2">Content & Creative</h3>
                    <div class="space-y-4">
                        @foreach($jobs['content'] as $job)
                        <a href="{{ route('careers.detail', $job['id']) }}" class="block group">
                            <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-black hover:shadow-button-chunky transition-all duration-200">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-lg font-bold text-black group-hover:text-primary transition-colors">{{ $job['title'] }}</h4>
                                            <span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-600 text-xs font-bold uppercase tracking-wider">{{ $job['type'] }}</span>
                                        </div>
                                        <p class="text-text-subtle text-sm">{{ $job['location'] }}</p>
                                    </div>
                                    <div class="flex items-center text-primary font-bold text-sm group-hover:translate-x-1 transition-transform">
                                        View Details <i class="bi bi-arrow-right ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
