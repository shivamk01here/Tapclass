<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use App\Models\TutorLike;
use App\Models\Booking;
use App\Models\Subject;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();
        $studentProfile = $student->studentProfile;
        
        // Get upcoming sessions
        $upcomingSessions = Booking::with(['tutor', 'subject'])
            ->where('student_id', $student->id)
            ->where('status', 'confirmed')
            ->where('session_date', '>=', now()->toDateString())
            ->orderBy('session_date')
            ->orderBy('session_start_time')
            ->limit(5)
            ->get();
        
        // Get recommended tutors based on student's subject preferences
        $recommendedTutors = collect();
        
        if ($studentProfile && $studentProfile->subjects_of_interest && count($studentProfile->subjects_of_interest) > 0) {
            // Get tutors teaching student's preferred subjects
            $recommendedTutors = TutorProfile::with(['user', 'subjects'])
                ->where('verification_status', 'verified')
                ->whereHas('subjects', function($q) use ($studentProfile) {
                    $q->whereIn('subject_id', $studentProfile->subjects_of_interest);
                })
                ->orderBy('average_rating', 'desc')
                ->limit(6)
                ->get();
        } else {
            // If no preferences set, show top-rated tutors
            $recommendedTutors = TutorProfile::with(['user', 'subjects'])
                ->where('verification_status', 'verified')
                ->orderBy('average_rating', 'desc')
                ->limit(6)
                ->get();
        }
        
        return view('student.dashboard', compact('upcomingSessions', 'recommendedTutors'));
    }

    public function findTutor(Request $request)
    {
        $query = TutorProfile::with(['user', 'subjects', 'reviews'])
            ->where('verification_status', 'verified');
        
        // Search by subject
        if ($request->filled('subject_id')) {
            $query->whereHas('subjects', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }
        
        // Filter by session type
        if ($request->filled('session_type')) {
            if ($request->session_type === 'online') {
                $query->whereHas('tutorSubjects', function($q) {
                    $q->where('is_online_available', true);
                });
            } elseif ($request->session_type === 'offline') {
                $query->whereHas('tutorSubjects', function($q) {
                    $q->where('is_offline_available', true);
                });
            }
        }
        
        // Filter by rating
        if ($request->filled('min_rating')) {
            $query->where('average_rating', '>=', $request->min_rating);
        }
        
        // Sort
        $sortBy = $request->get('sort_by', 'rating');
        if ($sortBy === 'rating') {
            $query->orderBy('average_rating', 'desc');
        } elseif ($sortBy === 'reviews') {
            $query->orderBy('total_reviews', 'desc');
        }
        
        $tutors = $query->paginate(12);
        $subjects = Subject::where('is_active', true)->get();
        
        return view('student.find-tutor', compact('tutors', 'subjects'));
    }

    public function tutorProfile($id)
    {
        $tutor = TutorProfile::with(['user', 'subjects', 'reviews.student'])
            ->where('user_id', $id)
            ->where('verification_status', 'verified')
            ->firstOrFail();
        
        $tutorProfile = $tutor;
        $subjects = $tutor->subjects;
        $reviews = $tutor->reviews;
        
        $isLiked = TutorLike::where('student_id', auth()->id())
            ->where('tutor_id', $tutor->user_id)
            ->exists();
        
        return view('student.tutor-profile', compact('tutor', 'tutorProfile', 'subjects', 'reviews', 'isLiked'));
    }

    public function bookings()
    {
        $student = auth()->user();
        
        $upcomingBookings = Booking::with(['tutor', 'subject'])
            ->where('student_id', $student->id)
            ->where('status', 'confirmed')
            ->where('session_date', '>=', now()->toDateString())
            ->orderBy('session_date')
            ->orderBy('session_start_time')
            ->get();
        
        $pastBookings = Booking::with(['tutor', 'subject', 'review'])
            ->where('student_id', $student->id)
            ->where('status', 'completed')
            ->orderBy('session_date', 'desc')
            ->get();
        
        $cancelledBookings = Booking::with(['tutor', 'subject'])
            ->where('student_id', $student->id)
            ->where('status', 'cancelled')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('student.bookings', compact('upcomingBookings', 'pastBookings', 'cancelledBookings'));
    }

    public function wishlist()
    {
        $likedTutors = TutorProfile::with(['user', 'subjects'])
            ->whereHas('likes', function($q) {
                $q->where('student_id', auth()->id());
            })
            ->get();
        
        return view('student.wishlist', compact('likedTutors'));
    }

    public function wallet()
    {
        $wallet = auth()->user()->wallet;
        
        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('student.wallet', compact('wallet', 'transactions'));
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('student.notifications', compact('notifications'));
    }

    public function profile()
    {
        $student = auth()->user();
        $profile = $student->studentProfile;
        
        return view('student.profile', compact('student', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'grade' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'subjects_of_interest' => 'nullable|array',
        ]);
        
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        
        $user->studentProfile->update([
            'grade' => $request->grade,
            'location' => $request->location,
            'subjects_of_interest' => $request->subjects_of_interest,
        ]);
        
        return back()->with('success', 'Profile updated successfully!');
    }

    public function toggleLike($id)
    {
        $tutor = TutorProfile::findOrFail($id);
        $studentId = auth()->id();
        $tutorUserId = $tutor->user_id;
        
        $like = TutorLike::where('student_id', $studentId)
            ->where('tutor_id', $tutorUserId)
            ->first();
        
        if ($like) {
            $like->delete();
            $tutor->decrement('total_likes');
            $isLiked = false;
        } else {
            TutorLike::create([
                'student_id' => $studentId,
                'tutor_id' => $tutorUserId,
            ]);
            $tutor->increment('total_likes');
            $isLiked = true;
        }
        
        return response()->json([
            'success' => true,
            'liked' => $isLiked,
            'total_likes' => $tutor->total_likes,
        ]);
    }

    public function settings()
    {
        $student = auth()->user();
        $profile = $student->studentProfile;
        
        return view('student.settings', compact('student', 'profile'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!\Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        auth()->user()->update([
            'password' => \Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password updated successfully!');
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
}
