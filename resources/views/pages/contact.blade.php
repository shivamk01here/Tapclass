@extends('layouts.public')

@section('title', 'Contact Us - Htc')

@section('content')
<div class="bg-white">
    <!-- Hero -->
   
    <!-- Contact Information & Form -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Contact Information</h2>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-primary text-2xl">mail</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">support@Htc.com</p>
                            <p class="text-gray-600">info@Htc.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-primary text-2xl">phone</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Phone</h3>
                            <p class="text-gray-600">+91 1234567890</p>
                            <p class="text-sm text-gray-500">Mon-Fri, 9AM-6PM IST</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-primary text-2xl">location_on</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Office</h3>
                            <p class="text-gray-600">123 Education Street</p>
                            <p class="text-gray-600">Bangalore, Karnataka 560001</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-bold text-gray-900 mb-4">Frequently Asked Questions</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span>How do I become a tutor?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span>How does the payment system work?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span>Can I cancel a booking?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span>How are tutors verified?</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-gray-50 rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                        <input type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Your name"/>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="your.email@example.com"/>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                        <input type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="How can we help?"/>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Tell us more about your inquiry..."></textarea>
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-blue-700 transition">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
