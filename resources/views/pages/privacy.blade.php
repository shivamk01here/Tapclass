@extends('layouts.public')

@section('title', 'Privacy Policy - htc')

@section('content')

<div class="py-16 md:py-24">
    <div class="max-w-4xl mx-auto"> 

        <div class="text-center mb-12">
            <h1 class="font-heading text-hero-md uppercase leading-tight font-normal">
                Privacy Policy
            </h1>
            <p class="text-text-subtle mt-4">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="bg-white border-2 border-black rounded-2xl shadow-header-chunky p-8 md:p-12">

            <h2 class="font-heading text-h2 uppercase text-black mb-4">1. Information We Collect</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We collect information you provide directly to us, including name, email address, phone number, profile information, and payment details when you register for an account, book tutoring sessions, or communicate with us.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">2. How We Use Your Information</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We use the information we collect to:
            </p>
            <ul class="list-disc pl-6 text-text-subtle mb-4 space-y-2">
                <li>Provide, maintain, and improve our services</li>
                <li>Process transactions and send related information</li>
                <li>Send you technical notices and support messages</li>
                <li>Respond to your comments and questions</li>
                <li>Monitor and analyze trends and usage</li>
            </ul>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">3. Information Sharing</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We do not share your personal information with third parties except as described in this policy. We may share information with tutors and students to facilitate bookings, with service providers who assist in our operations, and when required by law.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">4. Data Security</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We implement appropriate security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">5. Your Rights</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                You have the right to access, update, or delete your personal information at any time through your account settings. You may also contact us directly for assistance.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">6. Cookies</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We use cookies and similar tracking technologies to track activity on our platform and store certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">7. Changes to This Policy</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">8. Contact Us</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                If you have any questions about this Privacy Policy, please contact us at <a href="{{ route('contact') }}" class="text-primary font-bold hover:underline">our contact page</a>.
            </p>
        </div>
    </div>
</div>
@endsection