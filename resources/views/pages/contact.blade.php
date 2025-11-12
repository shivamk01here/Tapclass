{{--
    THIS IS YOUR NEW /resources/views/contact.blade.php FILE
    FIX: Changed to layouts.app, uses new smaller font sizes, and name "htc".
--}}

@extends('layouts.public')

@section('title', 'Contact Us - htc')

@section('content')

    <div class="text-center max-w-4xl mx-auto py-24">
        <h1 class="font-heading text-hero-md uppercase leading-tight font-normal">
            Get In Touch
        </h1>
        <p class="text-lg text-text-subtle max-w-2xl mx-auto my-10">
            Have a question, feedback, or need support? We're here to help.
            Reach out to us, and we'll get back to you as soon as possible.
        </p>
    </div>

    <div class="pb-16 md:pb-24">
        <div class="grid md:grid-cols-2 gap-12">
            
            <div>
                <h2 class="font-heading text-h2 uppercase leading-tight font-normal mb-8">Contact Information</h2>
                <div class="space-y-6">
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-subscribe-bg rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-envelope-fill text-primary text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-black text-lg mb-1">Email</h3>
                            <p class="text-text-subtle">support@htc.com</p>
                            <p class="text-text-subtle">info@htc.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-subscribe-bg rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-telephone-fill text-primary text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-black text-lg mb-1">Phone</h3>
                            <p class="text-text-subtle">+91 1234567890</p>
                            <p class="text-sm text-text-subtle">Mon-Fri, 9AM-6PM IST</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-subscribe-bg rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-geo-alt-fill text-primary text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-black text-lg mb-1">Office</h3>
                            <p class="text-text-subtle">123 Education Street</p>
                            <p class="text-text-subtle">Bangalore, Karnataka 560001</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <h3 class="font-bold text-black text-lg mb-4">Frequently Asked Questions</h3>
                    <ul class="space-y-2 text-text-subtle">
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-primary text-xs mt-1.5"></i>
                            <span>How do I become a tutor?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-primary text-xs mt-1.5"></i>
                            <span>How does the payment system work?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-primary text-xs mt-1.5"></i>
                            <span>Can I cancel a booking?</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-white border-2 border-black rounded-2xl shadow-header-chunky p-8 md:p-12">
                <h2 class="font-heading text-h2 uppercase leading-tight font-normal mb-6">Send us a Message</h2>
                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Name *</label>
                        <input type="text" required class="w-full bg-white border-2 border-black rounded-lg px-4 py-3 placeholder:text-text-subtle focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="Your name"/>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Email *</label>
                        <input type="email" required class="w-full bg-white border-2 border-black rounded-lg px-4 py-3 placeholder:text-text-subtle focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="your.email@example.com"/>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Subject *</label>
                        <input type="text" required class="w-full bg-white border-2 border-black rounded-lg px-4 py-3 placeholder:text-text-subtle focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="How can we help?"/>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-black mb-2">Message *</l>
                        <textarea rows="5" required class="w-full bg-white border-2 border-black rounded-lg px-4 py-3 placeholder:text-text-subtle focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="Tell us more about your inquiry..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection