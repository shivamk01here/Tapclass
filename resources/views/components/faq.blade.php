@php
  $faqs = [
    [
      'q' => 'How do students book a session?',
      'a' => 'Search tutors, open a profile, pick subject, mode (online/in-person), date and time, then confirm the booking and pay from your wallet.'
    ],
    [
      'q' => 'How are tutors verified?',
      'a' => 'Tutors upload documents and complete onboarding. Admins verify profiles before tutors can accept bookings.'
    ],
    [
      'q' => 'Can parents manage learners?',
      'a' => 'Yes. Parents add learners, switch the active child, and book sessions on their behalf from the parent dashboard.'
    ],
    [
      'q' => 'What is the cancellation policy?',
      'a' => 'You can cancel from your dashboard. Refunds follow the platform policy and are credited back to your wallet.'
    ],
    [
      'q' => 'How are tutor payouts handled?',
      'a' => 'Tutor earnings are tracked per booking and become available after completion. Withdrawals are processed from the earnings page.'
    ],
  ];
@endphp

<div class="max-w-7xl mx-auto px-4 py-12">
  <div class="bg-[#FFD9AD] border-2 border-black rounded-2xl shadow-header-chunky p-8 md:p-12 overflow-hidden relative">
    <!-- Background Noise Overlay -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100%\' height=\'100%\' viewBox=\'0 0 400 400\'><defs><filter id=\'n\' x=\'0\' y=\'0\' width=\'100%\' height=\'100%\'><feTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\' /><feComponentTransfer><feFuncA type=\'linear\' slope=\'0.7\' intercept=\'0.1\' /></feComponentTransfer><feColorMatrix type=\'saturate\' values=\'0\' /><feBlend in=\'SourceGraphic\' mode=\'multiply\' /></filter></defs><rect width=\'100%\' height=\'100%\' fill=\'%23FFD9AD\' /><rect width=\'100%\' height=\'100%\' filter=\'url(%23n)\' fill-opacity=\'0.3\' /></svg>')] opacity-70"></div>

    <div class="relative z-10 grid md:grid-cols-2 gap-10 items-center">
      <!-- LEFT SIDE -->
      <div>
        <h2 class="font-heading text-3xl md:text-4xl uppercase leading-tight font-bold mb-6 text-black">
          Frequently Asked Questions
        </h2>

        <div x-data="{ active: null }" class="space-y-4">
          @foreach($faqs as $i => $faq)
          <div class="bg-white border-2 border-black rounded-xl shadow-button-chunky transition-transform duration-100 hover:-translate-y-0.5">
            <button 
              type="button"
              @click="active = (active === {{ $i }} ? null : {{ $i }})"
              class="w-full flex items-center justify-between px-5 py-4 text-left font-semibold text-black text-[15px] focus:outline-none">
              <span>{{ $faq['q'] }}</span>
              <span class="text-2xl font-bold select-none" x-text="active === {{ $i }} ? '–' : '+'">+</span>
            </button>

            <div x-show="active === {{ $i }}" x-collapse class="px-5 text-[14px] text-gray-700">
              <div class="pb-4">{{ $faq['a'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="hidden md:flex justify-center items-center">
        <img src="{{ asset('images/homepage/FAQs.svg') }}" alt="FAQ Illustration" class="w-[85%] max-w-sm object-contain">
      </div>
    </div>
  </div>
</div>
