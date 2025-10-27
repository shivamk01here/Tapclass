@extends('layouts.public')

@section('title', 'About Us - TapClass')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    

    <!-- Mission Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-4">
                    At TapClass, we believe that every student deserves access to quality education tailored to their unique learning needs. Our mission is to bridge the gap between students and qualified tutors, making personalized learning accessible to everyone.
                </p>
                <p class="text-gray-600 text-lg leading-relaxed">
                    We're committed to creating a platform that not only connects learners with educators but also fosters a community where knowledge sharing and growth thrive.
                </p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8">
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">1000+</div>
                        <div class="text-gray-600 font-medium">Qualified Tutors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">5000+</div>
                        <div class="text-gray-600 font-medium">Active Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">50+</div>
                        <div class="text-gray-600 font-medium">Subjects</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-primary mb-2">4.8/5</div>
                        <div class="text-gray-600 font-medium">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Our Core Values</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">school</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Quality Education</h3>
                    <p class="text-gray-600">
                        We ensure all tutors are verified and qualified to provide the best learning experience for students.
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">group</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Accessibility</h3>
                    <p class="text-gray-600">
                        Making quality tutoring affordable and accessible to students from all backgrounds.
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Trust & Safety</h3>
                    <p class="text-gray-600">
                        Building a safe, transparent platform where students and tutors can connect with confidence.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">How TapClass Works</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                    1
                </div>
                <h3 class="text-xl font-bold mb-2">Search & Browse</h3>
                <p class="text-gray-600">
                    Find tutors by subject, location, ratings, and availability that match your needs.
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                    2
                </div>
                <h3 class="text-xl font-bold mb-2">Book a Session</h3>
                <p class="text-gray-600">
                    Choose online or in-person sessions, select your preferred time, and confirm booking.
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                    3
                </div>
                <h3 class="text-xl font-bold mb-2">Start Learning</h3>
                <p class="text-gray-600">
                    Connect with your tutor, learn at your pace, and track your progress.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Your Learning Journey?</h2>
            <p class="text-blue-100 text-lg mb-8">
                Join thousands of students already learning with TapClass
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register.student') }}" class="px-8 py-3 bg-white text-primary rounded-lg font-bold hover:bg-gray-100 transition">
                    Register as Student
                </a>
                <a href="{{ route('register.tutor') }}" class="px-8 py-3 bg-blue-700 text-white rounded-lg font-bold hover:bg-blue-800 transition">
                    Become a Tutor
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
