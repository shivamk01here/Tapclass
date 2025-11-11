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

<section class="flex flex-col gap-8">
  <div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="flex flex-col gap-2 transition-all ease-out duration-700" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
    <h2 class="text-3xl md:text-4xl font-bold leading-tight tracking-[-0.015em] text-center md:text-left">Frequently asked questions</h2>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <!-- Left: Accordion list -->
    <div class="lg:col-span-2">
      <div id="accordion-collapse" data-accordion="collapse" class="space-y-3">
        @foreach($faqs as $i => $faq)
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark/50">
          <h2 id="faq-heading-{{ $i }}">
            <button type="button"
              class="w-full flex items-center justify-between p-5 text-left"
              data-accordion-target="#faq-body-{{ $i }}" aria-expanded="false" aria-controls="faq-body-{{ $i }}">
              <span class="font-semibold">{{ $faq['q'] }}</span>
              <span class="material-symbols-outlined text-primary">add</span>
            </button>
          </h2>
          <div id="faq-body-{{ $i }}" class="hidden" aria-labelledby="faq-heading-{{ $i }}">
            <div class="px-5 pb-5 pt-0 text-sm text-subtext-light dark:text-subtext-dark">{{ $faq['a'] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Right: CTA/illustration card -->
    <aside class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark/50 p-6 flex flex-col gap-4">
      <img src="{{ asset('images\homepage\FAQs.svg') }}" alt="Illustration of a person looking at a phone">
      <div class="space-y-2">
        <h3 class="font-bold text-lg">Do you have more questions?</h3>
        <p class="text-sm text-subtext-light dark:text-subtext-dark">End-to-end learning management in a single solution. Reach out and we’ll help you decide the best path.</p>
      </div>
      <a href="{{ route('contact') }}" class="mt-auto inline-flex items-center justify-center h-11 px-5 rounded-lg bg-secondary text-white font-semibold hover:bg-secondary/90">Shoot a Direct Mail</a>
    </aside>
  </div>
</section>

@push('scripts')
<!-- Flowbite already loaded in layout via CDN; no extra JS needed here -->
@endpush
