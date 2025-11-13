@extends('layouts.tutor')

@section('content')
<div class="max-w-5xl mx-auto" data-aos="fade-up">
  <div class="bg-white rounded-2xl shadow-header-chunky border-2 border-black overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-5">
      
      <!-- Left Side - Illustration -->
      <aside class="bg-subscribe-bg p-6 md:col-span-2 flex items-center justify-center">
        <div class="w-full max-w-xs">
          <img src="{{ asset('images/pending/writing.svg') }}" alt="Under Review" class="w-full h-auto" />
          <div class="mt-4 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-accent-yellow rounded-full border-2 border-black">
              <span class="material-symbols-outlined text-black text-lg animate-pulse">schedule</span>
              <span class="font-bold text-black uppercase text-xs">Under Review</span>
            </div>
          </div>
        </div>
      </aside>

      <!-- Right Side - Content -->
      <main class="p-6 md:p-8 md:col-span-3 space-y-5">
        <div>
          <h1 class="font-heading text-h3 md:text-h2 uppercase text-black mb-1">Welcome to HTC   {{ auth()->user()->first_name }}!</h1>
          <p class="text-sm text-text-subtle">Your profile has been submitted for review. We'll notify you once your account is verified.</p>
        </div>

        <!-- Status Card -->
        <div class="flex items-start gap-3 p-4 bg-steps-bg border-2 border-black rounded-lg">
          <div class="w-10 h-10 bg-accent-yellow rounded-full flex items-center justify-center flex-shrink-0 border-2 border-black">
            <span class="material-symbols-outlined text-black text-xl">hourglass_empty</span>
          </div>
          <div>
            <h3 class="font-bold text-base text-black">Verification Status: <span class="text-primary">{{ ucfirst($profile->verification_status) }}</span></h3>
            <p class="text-xs text-text-subtle mt-1">Our team is reviewing your submitted documents. This usually takes 24-48 hours.</p>
          </div>
        </div>

        <!-- What's Next -->
        <div class="bg-white rounded-lg p-4 border-2 border-black">
          <h3 class="font-bold text-sm text-black mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-lg">info</span>
            What happens next?
          </h3>
          <ul class="space-y-2 text-xs text-black">
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-primary text-lg flex-shrink-0">task_alt</span>
              <span>We'll verify your government ID and degree certificate</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-primary text-lg flex-shrink-0">task_alt</span>
              <span>You'll receive an email notification once verified</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-primary text-lg flex-shrink-0">task_alt</span>
              <span>You can then start accepting bookings from students</span>
            </li>
          </ul>
        </div>

        <!-- Info Tip -->
        <div class="p-3 bg-page-bg rounded-lg border border-black/10 flex gap-2 items-start">
          <span class="material-symbols-outlined text-primary text-lg flex-shrink-0">lightbulb</span>
          <p class="text-xs text-black">
            <span class="font-semibold">Pro tip:</span> You'll receive an email as soon as your profile is verified. Check your inbox regularly!
          </p>
        </div>
      </main>
    </div>
  </div>
</div>

<style>
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
  }
  .animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
  }
</style>
@endsection
