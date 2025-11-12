{{--
    THIS IS YOUR NEW /resources/views/components/testimonials.blade.php FILE
    It has been re-styled to match the new "Sinau" theme.
--}}

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

<!-- Added consistent padding like other sections -->
<section class="py-16 md:py-24" id="testimonials">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Re-styled Title Block -->
        <div class="flex flex-col gap-4 text-center mb-12">
            <h2 class="font-heading text-4xl uppercase leading-tight font-normal">Testimonials</h2>
            <p class="text-lg text-text-subtle max-w-3xl mx-auto">Real stories from students, tutors, and parents using TutorConsult every day.</p>
        </div>

        <div class="relative">
            <div class="swiper testimonials-swiper">
                <div class="swiper-wrapper">
                    @foreach($items as $t)
                    <div class="swiper-slide !h-auto">
                        <!-- Re-styled Testimonial Card -->
                        <div class="h-full flex flex-col gap-4 rounded-xl border-2 border-black bg-white p-6 shadow-button-chunky">
                            <p class="text-base text-black">“{{ $t['quote'] }}”</p>
                            <div class="mt-auto flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <!-- Re-styled Avatar -->
                                    <div class="w-10 h-10 rounded-full bg-subscribe-bg flex items-center justify-center text-primary font-bold">
                                        {{ substr($t['name'],0,1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold leading-tight text-black">{{ $t['name'] }}</p>
                                        <p class="text-xs text-text-subtle">{{ $t['role'] }}</p>
                                    </div>
                                </div>
                                <!-- Re-styled Rating (New color and icon) -->
                                <div class="flex text-accent-yellow">
                                    @for($i=0;$i<$t['rating'];$i++)
                                        <i class="bi bi-star-fill text-lg"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Re-styled Navigation Buttons (Chunky) -->
                <div class="mt-8 flex items-center justify-center gap-4">
                    <button class="testimonials-prev w-12 h-12 rounded-lg bg-white border-2 border-black flex items-center justify-center shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                        <i class="bi bi-arrow-left text-xl text-black"></i>
                    </button>
                    <button class="testimonials-next w-12 h-12 rounded-lg bg-accent-yellow border-2 border-black flex items-center justify-center shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                        <i class="bi bi-arrow-right text-xl text-black"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<style>
    /* Linear, constant-speed scroll (Kept as per your code) */
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