<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $tutor->user->name }} - Htc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>tailwind.config={theme:{extend:{colors:{"primary":"#13a4ec"},fontFamily:{"display":["Manrope","sans-serif"]}}}}</script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4 flex items-center justify-between">
    <a href="{{ route('student.find-tutor') }}" class="text-primary font-bold">← Back to Search</a>
    <a href="{{ route('student.dashboard') }}" class="text-gray-600 hover:text-primary">Dashboard</a>
</header>

<main class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Left Column - Tutor Info -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg border p-6 sticky top-4">
                <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-primary font-black text-4xl">{{ substr($tutor->user->name, 0, 1) }}</span>
                </div>
                
                <h1 class="text-2xl font-black text-center mb-2">{{ $tutor->user->name }}</h1>
                
                <div class="flex items-center justify-center gap-2 mb-4">
                    @if($tutorProfile->rating > 0)
                        <div class="flex items-center gap-1 text-yellow-500">
                            <span class="material-symbols-outlined text-lg">star</span>
                            <span class="font-bold">{{ number_format($tutorProfile->rating, 1) }}</span>
                        </div>
                        <span class="text-gray-400">•</span>
                    @endif
                    <span class="text-gray-600">{{ $tutorProfile->total_reviews }} reviews</span>
                </div>

                @if($tutorProfile->verification_status === 'verified')
                    <div class="bg-green-50 text-green-700 px-3 py-2 rounded-lg text-center mb-4 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">verified</span>
                        <span class="font-bold text-sm">Verified Tutor</span>
                    </div>
                @endif

                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-gray-600">
                        <span class="material-symbols-outlined">payments</span>
                        @php
                            $rates = [];
                            foreach($tutorProfile->subjects as $s) {
                                if($s->pivot->online_rate && $s->pivot->online_rate > 0) {
                                    $rates[] = $s->pivot->online_rate;
                                }
                                if($s->pivot->offline_rate && $s->pivot->offline_rate > 0) {
                                    $rates[] = $s->pivot->offline_rate;
                                }
                            }
                            $minRate = count($rates) > 0 ? min($rates) : 0;
                        @endphp
                        @if($minRate > 0)
                            <span class="font-bold text-primary text-lg">From ₹{{ number_format($minRate, 0) }}/hour</span>
                        @else
                            <span class="text-gray-500">Price on request</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <span class="material-symbols-outlined">location_on</span>
                        <span>{{ $tutorProfile->location ?? 'Location not specified' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <span class="material-symbols-outlined">work</span>
                        <span>{{ $tutorProfile->experience_years }} years exp.</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <span class="material-symbols-outlined">school</span>
                        <span>{{ $tutorProfile->education }}</span>
                    </div>
                </div>

                <a href="{{ route('student.booking.create', $tutor->user->id) }}" class="block w-full px-6 py-3 bg-primary text-white rounded-lg font-bold text-center hover:bg-primary/90 mb-3">
                    Book Session
                </a>

                <button onclick="toggleLike()" id="likeBtn" class="w-full px-6 py-3 {{ $isLiked ? 'bg-red-50 text-red-600 border-red-200' : 'bg-gray-50 text-gray-700 border-gray-200' }} border rounded-lg font-bold hover:opacity-80">
                    <span class="material-symbols-outlined align-middle">{{ $isLiked ? 'favorite' : 'favorite_border' }}</span>
                    <span id="likeBtnText">{{ $isLiked ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span>
                </button>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="md:col-span-2 space-y-6">
            <!-- About -->
            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-xl font-black mb-4">About</h2>
                <p class="text-gray-700 leading-relaxed">{{ $tutorProfile->bio ?: 'No bio provided yet.' }}</p>
            </div>

            <!-- Subjects -->
            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-xl font-black mb-4">Subjects I Teach</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    @forelse($subjects as $subject)
                        <div class="p-4 bg-gray-50 rounded-lg border">
                            <h3 class="font-bold text-lg mb-2">{{ $subject->name }}</h3>
                            <div class="space-y-1 text-sm">
                                @if($subject->pivot->is_online_available && $subject->pivot->online_rate)
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-600">Online:</span>
                                        <span class="font-semibold text-primary">₹{{ number_format($subject->pivot->online_rate, 0) }}/hr</span>
                                    </div>
                                @endif
                                @if($subject->pivot->is_offline_available && $subject->pivot->offline_rate)
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-600">Offline:</span>
                                        <span class="font-semibold text-primary">₹{{ number_format($subject->pivot->offline_rate, 0) }}/hr</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No subjects listed</p>
                    @endforelse
                </div>
            </div>

            <!-- Reviews -->
            <div class="bg-white rounded-lg border p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black">Student Reviews ({{ $reviews->count() }})</h2>
                    @auth
                        @if(auth()->user()->isStudent())
                            @php
                                // Check if student has completed a session with this tutor and hasn't reviewed yet
                                $canReview = \App\Models\Booking::where('student_id', auth()->id())
                                    ->where('tutor_id', $tutor->user_id)
                                    ->where('status', 'completed')
                                    ->whereDoesntHave('review')
                                    ->exists();
                            @endphp
                            @if($canReview)
                                <button onclick="toggleReviewForm()" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 text-sm font-medium">
                                    Write a Review
                                </button>
                            @endif
                        @endif
                    @endauth
                </div>

                <!-- Review Form -->
                @auth
                    @if(auth()->user()->isStudent() && isset($canReview) && $canReview)
                        <div id="reviewForm" class="hidden mb-6 p-6 bg-gray-50 rounded-xl border">
                            <h3 class="font-bold text-lg mb-4">Rate Your Experience</h3>
                            <form method="POST" action="{{ route('student.review.store', $tutor->user_id) }}">
                                @csrf
                                
                                <!-- Star Rating -->
                                <div class="mb-4">
                                    <label class="block font-semibold mb-3">Rating</label>
                                    <div class="flex gap-2" id="starRating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" onclick="setRating({{ $i }})" class="star-btn text-3xl text-gray-300 hover:text-yellow-500 transition-colors">
                                                <span class="material-symbols-outlined">star</span>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput" required>
                                </div>

                                <!-- Review Text -->
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">Your Review</label>
                                    <textarea name="comment" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary" placeholder="Share your experience with this tutor..." required></textarea>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium">
                                        Submit Review
                                    </button>
                                    <button type="button" onclick="toggleReviewForm()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth

                <!-- Reviews List -->
                <div class="space-y-4">
                    @forelse($reviews as $review)
                        <div class="border-b pb-4 last:border-b-0">
                            <div class="flex items-start gap-3 mb-2">
                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-primary font-bold text-sm">{{ substr($review->student->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="font-bold">{{ $review->student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center gap-1 text-yellow-500 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="material-symbols-outlined text-base">{{ $i <= $review->rating ? 'star' : 'star_border' }}</span>
                                        @endfor
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <span class="material-symbols-outlined text-gray-300 text-5xl mb-2">rate_review</span>
                            <p class="text-gray-500">No reviews yet. Be the first to review!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function toggleLike() {
    fetch(`/student/tutor/{{ $tutor->user->id }}/toggle-like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        const btn = document.getElementById('likeBtn');
        const text = document.getElementById('likeBtnText');
        const icon = btn.querySelector('.material-symbols-outlined');
        
        if (data.liked) {
            btn.className = 'w-full px-6 py-3 bg-red-50 text-red-600 border-red-200 border rounded-lg font-bold hover:opacity-80';
            icon.textContent = 'favorite';
            text.textContent = 'Remove from Wishlist';
        } else {
            btn.className = 'w-full px-6 py-3 bg-gray-50 text-gray-700 border-gray-200 border rounded-lg font-bold hover:opacity-80';
            icon.textContent = 'favorite_border';
            text.textContent = 'Add to Wishlist';
        }
    });
}

function toggleReviewForm() {
    const form = document.getElementById('reviewForm');
    form.classList.toggle('hidden');
}

let selectedRating = 0;

function setRating(rating) {
    selectedRating = rating;
    document.getElementById('ratingInput').value = rating;
    
    // Update star colors
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-500');
        } else {
            star.classList.remove('text-yellow-500');
            star.classList.add('text-gray-300');
        }
    });
}
</script>
</body>
</html>
