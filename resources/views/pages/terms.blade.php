@extends('layouts.public')

@section('title', 'Terms & Conditions - Htc')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-gray-900 mb-8">Terms & Conditions</h1>
        <p class="text-gray-600 mb-8">Last updated: {{ date('F d, Y') }}</p>

        <div class="prose prose-lg max-w-none">
            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Acceptance of Terms</h2>
            <p class="text-gray-600 mb-4">
                By accessing and using Htc, you accept and agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our platform.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. User Accounts</h2>
            <p class="text-gray-600 mb-4">
                You must create an account to use certain features. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Tutor Verification</h2>
            <p class="text-gray-600 mb-4">
                All tutors must undergo verification before appearing on our platform. We verify qualifications and conduct background checks, but we do not guarantee the accuracy of all information provided by tutors.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Booking and Payments</h2>
            <p class="text-gray-600 mb-4">
                Students can book sessions through our platform. Payment must be made in advance using our secure wallet system. Cancellation policies apply and refunds are subject to our cancellation terms.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. User Conduct</h2>
            <p class="text-gray-600 mb-4">
                Users must not:
            </p>
            <ul class="list-disc pl-6 text-gray-600 mb-4 space-y-2">
                <li>Provide false or misleading information</li>
                <li>Harass, abuse, or harm other users</li>
                <li>Attempt to circumvent payment systems</li>
                <li>Violate any applicable laws or regulations</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Intellectual Property</h2>
            <p class="text-gray-600 mb-4">
                All content on Htc, including text, graphics, logos, and software, is the property of Htc and is protected by copyright and other intellectual property laws.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Limitation of Liability</h2>
            <p class="text-gray-600 mb-4">
                Htc is a platform connecting students and tutors. We are not responsible for the quality of tutoring services, disputes between users, or any damages arising from use of our platform.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Termination</h2>
            <p class="text-gray-600 mb-4">
                We reserve the right to suspend or terminate accounts that violate these terms or engage in fraudulent activities.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">9. Changes to Terms</h2>
            <p class="text-gray-600 mb-4">
                We may modify these terms at any time. Continued use of the platform after changes constitutes acceptance of the new terms.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">10. Contact</h2>
            <p class="text-gray-600 mb-4">
                For questions about these terms, please <a href="{{ route('contact') }}" class="text-primary hover:underline">contact us</a>.
            </p>
        </div>
    </div>
</div>
@endsection
