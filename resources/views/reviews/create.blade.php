<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Write a Review - TapClass</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>tailwind.config={theme:{extend:{colors:{"primary":"#13a4ec"},fontFamily:{"display":["Manrope","sans-serif"]}}}}</script>
</head>
<body class="bg-gray-50 font-display">
<header class="bg-white border-b px-6 py-4">
<a href="{{ route('student.bookings') }}" class="text-primary font-bold">← Back to Bookings</a>
</header>
<main class="max-w-2xl mx-auto px-4 py-8">
<h1 class="text-3xl font-black mb-6">Write a Review</h1>

<div class="bg-white p-6 rounded-lg border mb-6">
<p class="text-sm text-gray-500 mb-2">Session with</p>
<p class="font-bold text-lg">{{ $booking->tutor->name }}</p>
<p class="text-sm text-gray-600">{{ $booking->subject->name }} - {{ $booking->session_date->format('M d, Y') }}</p>
</div>

<form method="POST" action="{{ route('reviews.store', $booking) }}" class="bg-white p-6 rounded-lg border">
@csrf

<div class="mb-6">
<label class="block font-bold mb-2">Rating</label>
<div class="flex gap-2" id="rating-stars">
@for($i = 1; $i <= 5; $i++)
<span class="material-symbols-outlined text-4xl cursor-pointer text-gray-300 hover:text-yellow-400" data-rating="{{ $i }}">star</span>
@endfor
</div>
<input type="hidden" name="rating" id="rating-input" required/>
@error('rating')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<div class="mb-6">
<label class="block font-bold mb-2">Comment (Optional)</label>
<textarea name="comment" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary" placeholder="Share your experience...">{{ old('comment') }}</textarea>
@error('comment')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

<button type="submit" class="w-full px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">Submit Review</button>
</form>
</main>

<script>
const stars = document.querySelectorAll('#rating-stars span');
const ratingInput = document.getElementById('rating-input');
let selectedRating = 0;

stars.forEach(star => {
    star.addEventListener('click', function() {
        selectedRating = parseInt(this.dataset.rating);
        ratingInput.value = selectedRating;
        updateStars();
    });

    star.addEventListener('mouseenter', function() {
        const hoverRating = parseInt(this.dataset.rating);
        stars.forEach((s, i) => {
            if (i < hoverRating) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
            }
        });
    });
});

document.getElementById('rating-stars').addEventListener('mouseleave', updateStars);

function updateStars() {
    stars.forEach((s, i) => {
        if (i < selectedRating) {
            s.classList.remove('text-gray-300');
            s.classList.add('text-yellow-400');
        } else {
            s.classList.remove('text-yellow-400');
            s.classList.add('text-gray-300');
        }
    });
}
</script>
</body>
</html>
