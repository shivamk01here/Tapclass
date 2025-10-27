<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        // Ensure the booking belongs to current student
        if ($booking->student_id !== Auth::id()) {
            abort(403);
        }

        // Ensure booking is completed
        if ($booking->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed sessions.');
        }

        // Check if already reviewed
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this session.');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to current student
        if ($booking->student_id !== Auth::id()) {
            abort(403);
        }

        // Ensure booking is completed
        if ($booking->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed sessions.');
        }

        // Check if already reviewed
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this session.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $review = Review::create([
            'booking_id' => $booking->id,
            'student_id' => Auth::id(),
            'tutor_id' => $booking->tutor_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Update tutor's average rating and review count
        $this->updateTutorRating($booking->tutor_id);

        return redirect()->route('student.bookings')->with('success', 'Review submitted successfully!');
    }

    public function storeFromProfile(Request $request, $tutorId)
    {
        // Find a completed booking for this student and tutor that hasn't been reviewed
        $booking = Booking::where('student_id', Auth::id())
            ->where('tutor_id', $tutorId)
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->first();

        if (!$booking) {
            return redirect()->back()->withErrors(['error' => 'You must complete a session before reviewing.']);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500'
        ]);

        $review = Review::create([
            'booking_id' => $booking->id,
            'student_id' => Auth::id(),
            'tutor_id' => $tutorId,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Update tutor's average rating and review count
        $this->updateTutorRating($tutorId);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    private function updateTutorRating($tutorId)
    {
        $reviews = Review::where('tutor_id', $tutorId)->get();
        $avgRating = $reviews->avg('rating');
        $totalReviews = $reviews->count();

        TutorProfile::where('user_id', $tutorId)->update([
            'average_rating' => round($avgRating, 2),
            'total_reviews' => $totalReviews
        ]);
    }
}
