@php
    $items = [
        [
            'quote' => "I improved my grades within a month. Booking sessions is seamless and tutors are truly verified.",
            'name' => 'Aarav Patel',
            'role' => 'Student',
            'avatar' => null,
            'rating' => 5,
        ],
        [
            'quote' => "Htc helped me reach more students and manage my schedule easily. Payouts are on time.",
            'name' => 'Neha Sharma',
            'role' => 'Tutor',
            'avatar' => null,
            'rating' => 5,
        ],
        [
            'quote' => "As a parent, I can add my child and track bookings. The consultation was super helpful.",
            'name' => 'Rohan Mehta',
            'role' => 'Parent',
            'avatar' => null,
            'rating' => 5,
        ],
        [
            'quote' => "Found an amazing Physics tutor nearby. Loved the transparent pricing.",
            'name' => 'Ishita Verma',
            'role' => 'Student',
            'avatar' => null,
            'rating' => 5,
        ],
        [
            'quote' => "The platform makes managing subjects and rates simple, and reviews boost my profile.",
            'name' => 'Aditya Rao',
            'role' => 'Tutor',
            'avatar' => null,
            'rating' => 4,
        ],
    ];
@endphp

<section class="flex flex-col gap-6">
  <div 
    x-data="{ shown: false }" x-intersect.once.threshold(0.3)="shown = true" 
    class="flex flex-col gap-2 text-center transition-all ease-out duration-700" 
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
    <h2 class="text-3xl md:text-4xl font-bold tracking-[-0.015em]">Testimonials</h2>
    <p class="text-subtext-light dark:text-subtext-dark max-w-3xl mx-auto">Real stories from students, tutors, and parents using Htc every day.</p>
  </div>

  <div class="relative">
    <div class="swiper testimonials-swiper">
      <div class="swiper-wrapper">
        @foreach($items as $t)
          <div class="swiper-slide !h-auto">
            <div class="h-full flex flex-col gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark/50 p-6 shadow-sm">
              <p class="text-base text-gray-700 dark:text-gray-300">“{{ $t['quote'] }}”</p>
              <div class="mt-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-primary/15 flex items-center justify-center text-primary font-bold">
                    {{ substr($t['name'],0,1) }}
                  </div>
                  <div>
                    <p class="font-bold leading-tight">{{ $t['name'] }}</p>
                    <p class="text-xs text-subtext-light dark:text-subtext-dark">{{ $t['role'] }}</p>
                  </div>
                </div>
                <div class="flex text-secondary">
                  @for($i=0;$i<$t['rating'];$i++)
                    <span class="material-symbols-outlined text-[18px]">star</span>
                  @endfor
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="mt-6 flex items-center justify-center gap-4">
        <button class="testimonials-prev w-10 h-10 rounded-full border border-gray-300 dark:border-gray-700 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 transition"><span class="material-symbols-outlined">arrow_back</span></button>
        <button class="testimonials-next w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center hover:bg-primary/90 transition"><span class="material-symbols-outlined">arrow_forward</span></button>
      </div>
    </div>
  </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<style>
  /* Linear, constant-speed scroll */
  .testimonials-swiper .swiper-wrapper { transition-timing-function: linear !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.testimonials-swiper', {
    loop: true,
    slidesPerView: 1.1,
    spaceBetween: 16,
    speed: 8000, // higher = slower per slide; used with linear timing
    autoplay: { delay: 0, disableOnInteraction: false, pauseOnMouseEnter: true },
    breakpoints: {
      640: { slidesPerView: 1.5 },
      768: { slidesPerView: 2.2 },
      1024: { slidesPerView: 3.2 },
    },
    navigation: {
      nextEl: '.testimonials-next',
      prevEl: '.testimonials-prev',
    },
  });
</script>
@endpush
