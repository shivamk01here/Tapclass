<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\TutorProfile;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function dashboard()
    {
        return view('tutor.dashboard');
    }

    public function pending()
    {
        $user = auth()->user();
        $profile = $user->tutorProfile;
        return view('tutor.pending', compact('user', 'profile'));
    }

    public function onboarding()
    {
        $user = auth()->user();
        $profile = $user->tutorProfile;
        return view('tutor.onboarding', compact('user', 'profile'));
    }

    /**
     * Save onboarding step via AJAX.
     */
    public function saveOnboardingStep(Request $request)
    {
        // Always respond JSON for AJAX
        $request->headers->set('Accept', 'application/json');

        try {
            $request->validate(['step' => 'required|string']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }

        $user = auth()->user();
        $profile = $user->tutorProfile;

        DB::beginTransaction();
        try {
            switch ($request->step) {
                case 'basic':
                    try {
                        $data = $request->validate([
                            'bio' => 'required|string|min:50|max:500',
                            'experience_years' => 'required|integer|min:0|max:50',
                            'education' => 'required|string|max:500',
                        ]);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
                    }
                    $profile->update($data + ['onboarding_step' => 1]);
                    break;

                case 'subjects':
                    try {
                        $payload = $request->validate([
                            'subjects' => 'required|array|min:1',
                            'subjects.*.subject_id' => 'required|exists:subjects,id',
                            'subjects.*.online_rate' => 'nullable|numeric|min:0',
                            'subjects.*.offline_rate' => 'nullable|numeric|min:0',
                            'subjects.*.is_online_available' => 'boolean',
                            'subjects.*.is_offline_available' => 'boolean',
                        ]);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
                    }
                    // Upsert tutor subjects
                    \App\Models\TutorSubject::where('tutor_profile_id', $profile->id)->delete();
                    foreach ($payload['subjects'] as $s) {
                        \App\Models\TutorSubject::create([
                            'tutor_profile_id' => $profile->id,
                            'subject_id' => $s['subject_id'],
                            'online_rate' => $s['online_rate'] ?? null,
                            'offline_rate' => $s['offline_rate'] ?? null,
                            'is_online_available' => (bool)($s['is_online_available'] ?? false),
                            'is_offline_available' => (bool)($s['is_offline_available'] ?? false),
                        ]);
                    }
                    $profile->update(['onboarding_step' => 2]);
                    break;

                case 'documents':
                    $govPath = $request->file('government_id')
                        ? $request->file('government_id')->store('uploads/tutors/government_ids', 'public')
                        : $profile->government_id_path;
                    $degreePath = $request->file('degree_certificate')
                        ? $request->file('degree_certificate')->store('uploads/tutors/degrees', 'public')
                        : $profile->degree_certificate_path;
                    $cvPath = $request->file('cv')
                        ? $request->file('cv')->store('uploads/tutors/cvs', 'public')
                        : $profile->cv_path;
                    $profile->update([
                        'government_id_path' => $govPath,
                        'degree_certificate_path' => $degreePath,
                        'cv_path' => $cvPath,
                        'onboarding_step' => 3,
                    ]);
                    break;

                case 'location':
                    try {
                        $data = $request->validate([
                            'location' => 'nullable|string|max:255',
                            'city' => 'nullable|string|max:100',
                            'state' => 'nullable|string|max:100',
                            'latitude' => 'nullable|numeric',
                            'longitude' => 'nullable|numeric',
                            'teaching_mode' => 'nullable|in:online,offline,both',
                            'hourly_rate' => 'nullable|numeric|min:0',
                        ]);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
                    }
                    $profile->update($data + ['onboarding_step' => 4]);
                    break;

                case 'phone':
                    try {
                        $data = $request->validate([
                            'phone' => 'required|string|max:20',
                        ]);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
                    }
                    $user->update(['phone' => $data['phone'], 'otp' => '123456', 'otp_expires_at' => now()->addMinutes(10)]);
                    $profile->update(['onboarding_step' => 5]);
                    break;

                default:
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Invalid step'], 422);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to save step'], 500);
        }
    }

    /**
     * Verify onboarding OTP (static 123456 for now) and complete onboarding.
     */
    public function verifyOnboardingOtp(Request $request)
    {
        $data = $request->validate([
            'otp' => 'required|string',
        ]);
        $user = auth()->user();
        $profile = $user->tutorProfile;

        if ($data['otp'] !== '123456') {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 422);
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);
        $profile->update([
            'onboarding_completed' => true,
            'onboarding_step' => 6,
        ]);

        return response()->json(['success' => true, 'redirect' => route('tutor.dashboard')]);
    }

    public function bookings()
    {
        $tutor = auth()->user();
        
        // Tutors need to see pending requests to approve/decline them
        $pendingBookings = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutor->id)
            ->where('status', 'pending')
            ->where('session_date', '>=', now()->toDateString()) // Only show future pending
            ->orderBy('session_date')
            ->orderBy('session_start_time')
            ->get();

        $upcomingBookings = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutor->id)
            ->where('status', 'confirmed')
            ->where('session_date', '>=', now()->toDateString())
            ->orderBy('session_date')
            ->orderBy('session_start_time')
            ->get();
        
        $pastBookings = Booking::with(['student', 'subject', 'review'])
            ->where('tutor_id', $tutor->id)
            ->where('status', 'completed')
            ->orderBy('session_date', 'desc')
            ->get();
        
        $cancelledBookings = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutor->id)
            ->where('status', 'cancelled')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('tutor.bookings', compact(
            'pendingBookings', 
            'upcomingBookings', 
            'pastBookings', 
            'cancelledBookings'
        ));
    }

    public function earnings()
    {
        return view('tutor.earnings');
    }

    public function requestWithdrawal(Request $request)
    {
        return back()->with('success', 'Withdrawal request submitted');
    }

    public function availability()
    {
        return view('tutor.availability');
    }

    public function saveAvailability(Request $request)
    {
        return back()->with('success', 'Availability saved');
    }

    public function profile()
    {
        $tutor = auth()->user();
        $profile = $tutor->studentProfile;
        
        return view('tutor.profile', compact('tutor', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        return back()->with('success', 'Profile updated');
    }

    public function reviews()
    {
        $tutor = Auth::user();

        $reviews = Review::where('tutor_id', $tutor->id)
                        ->with(['student', 'booking.subject'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(15); // Paginate the results

        return view('tutor.reviews', compact('tutor', 'reviews'));
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('tutor.notifications', compact('notifications'));
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = auth()->user();

        // Delete old picture if exists
        if ($user->profile_picture && \Storage::exists('public/' . $user->profile_picture)) {
            \Storage::delete('public/' . $user->profile_picture);
        }

        // Store new picture
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');

        $user->update(['profile_picture' => $path]);

        return back()->with('success', 'Profile picture updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->update([
            'password' => \Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Approve a pending booking.
     */
    public function approveBooking(Booking $booking)
    {
        // Security check: ensure this tutor owns this booking
        if (auth()->id() !== $booking->tutor_id) {
            abort(403);
        }

        $booking->update(['status' => 'confirmed']);

        // You should also add a notification for the student here

        return back()->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Cancel a pending or confirmed booking.
     */
    public function cancelBooking(Booking $booking)
    {
        if (auth()->id() !== $booking->tutor_id) {
            abort(403);
        }

        // Add a reason if you have a modal for it
        $booking->update([
            'status' => 'cancelled',
            'cancelled_by' => 'tutor'
        ]);

        // You should also add a notification for the student here

        return back()->with('success', 'Booking has been cancelled.');
    }

    /**
     * Mark a confirmed session as completed.
     */
    public function completeBooking(Booking $booking)
    {
        if (auth()->id() !== $booking->tutor_id) {
            abort(403);
        }

        // You could add logic here to check if the session time has passed
        
        $booking->update(['status' => 'completed']);
        
        // You might trigger earning calculation here

        return back()->with('success', 'Session marked as completed!');
    }
    
    /**
     * Approve the payment for a completed session.
     */
    public function approvePayment(Booking $booking)
    {
        if (auth()->id() !== $booking->tutor_id) {
            abort(403);
        }

        // Ensure the session is completed before approving payment
        if (!$booking->isCompleted()) {
             return back()->with('error', 'You can only approve payment for completed sessions.');
        }

        $booking->update(['is_payment_approved' => true]);

        return back()->with('success', 'Payment approved!');
    }

    /**
     * Update the meeting link via AJAX.
     */
    public function updateMeetLink(Request $request, Booking $booking)
    {
        // if (auth()->id() !== $booking->tutor_id) {
        //     return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        // }

        $validated = $request->validate([
            'meet_link' => 'required|url'
        ]);

        $booking->update([
            'meet_link' => $validated['meet_link']
        ]);

        return response()->json(['success' => true, 'message' => 'Link updated!']);
    }
}
