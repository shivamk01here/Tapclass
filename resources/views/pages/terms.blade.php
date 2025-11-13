@extends('layouts.public')

@section('title', 'Terms & Conditions - htc')

@section('content')

<div class="py-16 md:py-24">
    <div class="max-w-4xl mx-auto"> 

        <div class="text-center mb-12">
            <h1 class="font-heading text-hero-md uppercase leading-tight font-normal">
                Terms & Conditions
            </h1>
            <p class="text-text-subtle mt-4">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="bg-white border-2 border-black rounded-2xl shadow-header-chunky p-8 md:p-12">

            <h2 class="font-heading text-h2 uppercase text-black mb-4">1. Acceptance of Terms</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                By accessing and using htc, you accept and agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our platform.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">2. User Accounts</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                You must create an account to use certain features. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">3. Tutor Verification</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                All tutors must undergo verification before appearing on our platform. We verify qualifications and conduct background checks, but we do not guarantee the accuracy of all information provided by tutors.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">4. Booking and Payments</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                Students can book sessions through our platform. Payment must be made in advance using our secure wallet system. Cancellation policies apply and refunds are subject to our cancellation terms.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">5. User Conduct</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                Users must not:
            </p>
            <ul class="list-disc pl-6 text-text-subtle mb-4 space-y-2">
                <li>Provide false or misleading information</li>
                <li>Harass, abuse, or harm other users</li>
                <li>Attempt to circumvent payment systems</li>
                <li>Violate any applicable laws or regulations</li>
            </ul>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">6. Intellectual Property</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                All content on htc, including text, graphics, logos, and software, is the property of htc and is protected by copyright and other intellectual property laws.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">7. Limitation of Liability</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                htc is a platform connecting students and tutors. We are not responsible for the quality of tutoring services, disputes between users, or any damages arising from use of our platform.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">8. Termination</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We reserve the right to suspend or terminate accounts that violate these terms or engage in fraudulent activities.
            </p>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">9. Changes to Terms</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                We may modify these terms at any time. Continued use of the platform after changes constitutes acceptance of the new terms.
            </D>

            <h2 class="font-heading text-h2 uppercase text-black mt-8 mb-4">10. Contact</h2>
            <p class="text-text-subtle text-base leading-relaxed mb-4">
                For questions about these terms, please <a href="{{ route('contact') }}" class="text-primary font-bold hover:underline">contact us</a>.
            </p>
        </div>
    </div>
</div>
@endsection