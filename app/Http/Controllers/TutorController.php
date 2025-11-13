<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\TutorProfile;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TutorController extends Controller
{
    public function dashboard()
    {
        $tutorId = auth()->id();
        $today = \Carbon\Carbon::today();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        // Fetch this month's bookings for the tutor
        $bookingsThisMonth = \App\Models\Booking::where('tutor_id', $tutorId)
            ->whereBetween('session_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->get(['session_date']);
        $hasBookings = collect($bookingsThisMonth)
            ->groupBy(function($b){ return \Carbon\Carbon::parse($b->session_date)->toDateString(); })
            ->map->count();

        $calendar = [
            'year' => (int)$today->format('Y'),
            'month' => (int)$today->format('n'),
            'monthName' => $today->format('F'),
            'daysInMonth' => (int)$today->daysInMonth,
            // 0=Sun .. 6=Sat
            'firstWeekday' => (int)$monthStart->dayOfWeek,
        ];

        return view('tutor.dashboard', [
            'calendar' => $calendar,
            'hasBookings' => $hasBookings,
            'todayStr' => $today->toDateString(),
        ]);
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
        $languages = \DB::table('languages')->where('is_active',1)->orderBy('name')->get(['id','name']);
        $cities = \DB::table('cities')->orderBy('name')->get(['id','name']);
        $gradeBands = ['k-5'=>'K-5','6-8'=>'Middle School (6-8)','9-12'=>'High School (9-12)','college'=>'College','test-prep'=>'Test Prep'];
        $qualifications = ["Bachelor's","Master's","PhD","Diploma","Other"];
        $experienceBands = ['0-1','1-3','3-5','5-10','10+'];
        return view('tutor.onboarding-modern', compact('user', 'profile','languages','cities','gradeBands','qualifications','experienceBands'));
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
                            'bio' => 'required|string|min:50|max:1000',
                            'experience_band' => 'required|in:0-1,1-3,3-5,5-10,10+',
                            'qualification' => 'nullable|in:'.implode(',',["Bachelor's","Master's","PhD","Diploma","Other"]),
                            'gender' => 'nullable|in:male,female,other',
                            'languages' => 'nullable|array',
                            'languages.*' => 'integer',
                            'profile_photo' => 'nullable|image|max:5120',
                        ]);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
                    }
// Map experience band to numeric years (approx)
                    $map = ['0-1'=>1,'1-3'=>2,'3-5'=>4,'5-10'=>7,'10+'=>10];
                    $expYears = $map[$data['experience_band']] ?? 1;

                    // Save profile picture if provided
                    if ($request->hasFile('profile_photo')) {
$path = $request->file('profile_photo')->store('avatars','public');
                        $rel = ltrim($path,'/');
                        $save = Str::startsWith($rel,'storage/') ? '/'.trim($rel,'/') : '/storage/'.$rel;
                        $user->update(['profile_picture' => $save]);
                    }

                    // Update tutor profile fields
                    $profile->update([
                        'bio' => $data['bio'],
                        'experience_years' => $expYears,
                        'qualification' => $data['qualification'] ?? $profile->qualification,
                        'gender' => $data['gender'] ?? $profile->gender,
                        'onboarding_step' => 1,
                    ]);

                    // Sync languages
                    if (isset($data['languages'])) {
                        \DB::table('tutor_profile_language')->where('tutor_profile_id',$profile->id)->delete();
                        $rows = array_map(fn($lid)=>['tutor_profile_id'=>$profile->id,'language_id'=>$lid], $data['languages']);
                        if (!empty($rows)) { \DB::table('tutor_profile_language')->insert($rows); }
                    }
                    
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
                            'city_id' => 'required|integer',
                            'latitude' => 'nullable|numeric',
                            'longitude' => 'nullable|numeric',
                            'modes' => 'required|array|min:1',
                            'modes.*' => 'in:online,offline_my,offline_student',
                            'travel_radius_km' => 'nullable|integer|min:1|max:50',
'hourly_rate' => 'nullable|numeric|min:0',
                            'grade_levels' => 'nullable|array',
                            'grade_levels.*' => 'string',
                            'pin_code' => 'nullable|string|min:4|max:20',
                        ]);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
                    }
// Fetch selected city name
                    $city = \DB::table('cities')->where('id',$data['city_id'])->value('name');
                    // Derive overall teaching_mode for backward-compat
                    $hasOnline = in_array('online', $data['modes']);
                    $hasOffline = in_array('offline_my', $data['modes']) || in_array('offline_student', $data['modes']);
                    $teachingMode = $hasOnline && $hasOffline ? 'both' : ($hasOnline ? 'online' : 'offline');

                    $profile->update([
                        'city' => $city,
                        'latitude' => $data['latitude'] ?? $profile->latitude,
                        'longitude' => $data['longitude'] ?? $profile->longitude,
                        'teaching_mode' => $teachingMode,
                        'hourly_rate' => $data['hourly_rate'] ?? $profile->hourly_rate,
                        'travel_radius_km' => $data['travel_radius_km'] ?? $profile->travel_radius_km,
'grade_levels' => $data['grade_levels'] ?? $profile->grade_levels,
                        'pin_code' => $data['pin_code'] ?? $profile->pin_code,
                        'onboarding_step' => 4,
                    ]);
                    
                    break;

                case 'phone':
                    try {
                        $data = $request->validate([
'phone' => ['required','regex:/\d{10,}/'],
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

    public function suggestLanguages(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $items = DB::table('languages')->where('is_active',1)
            ->when($q !== '', function($qq) use ($q){ $qq->where('name','like','%'.$q.'%'); })
            ->orderBy('name')
            ->limit(10)
            ->get(['id','name']);
        return response()->json($items);
    }

    public function createLanguage(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100'
        ]);
        $name = trim($data['name']);
        // Upsert (name is unique)
        $id = DB::table('languages')->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->value('id');
        if (!$id) {
            $id = DB::table('languages')->insertGetId([
                'name' => $name,
                'code' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return response()->json(['id' => $id, 'name' => $name]);
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
        $tutorId = auth()->id();
        $summary = [
            'pending' => \App\Models\TutorEarning::where('tutor_id',$tutorId)->where('status','pending')->sum('amount'),
            'available' => \App\Models\TutorEarning::where('tutor_id',$tutorId)->where('status','available')->sum('amount'),
            // Requested and Withdrawn reflect payout requests
            'requested' => \App\Models\WithdrawalRequest::where('tutor_id',$tutorId)->where('status','pending')->sum('amount'),
            'withdrawn' => \App\Models\WithdrawalRequest::where('tutor_id',$tutorId)->where('status','approved')->sum('amount'),
        ];
        $availableNet = max(($summary['available'] ?? 0) - ($summary['requested'] ?? 0), 0);
        $earnings = \App\Models\TutorEarning::with('booking')
            ->where('tutor_id',$tutorId)
            ->orderBy('id','desc')
            ->paginate(20);
        $payouts = \App\Models\WithdrawalRequest::where('tutor_id',$tutorId)->latest()->paginate(10);
        return view('tutor.earnings', [
            'summary' => $summary,
            'availableNet' => $availableNet,
            'earnings' => $earnings,
            'payouts' => $payouts,
        ]);
    }

    public function requestWithdrawal(Request $request)
    {
        $tutorId = auth()->id();
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_account_number' => 'nullable|string|max:40',
            'bank_ifsc_code' => 'nullable|string|max:20',
            'bank_account_holder_name' => 'nullable|string|max:100',
        ]);
        $available = \App\Models\TutorEarning::where('tutor_id',$tutorId)->where('status','available')->sum('amount');
        $pendingRequested = \App\Models\WithdrawalRequest::where('tutor_id',$tutorId)->where('status','pending')->sum('amount');
        $availableNet = max($available - $pendingRequested, 0);
        if ($data['amount'] > $availableNet) {
            return back()->withErrors(['error' => 'Requested amount exceeds available balance (after pending requests).']);
        }
        // Create payout request
        \App\Models\WithdrawalRequest::create([
            'tutor_id' => $tutorId,
            'amount' => $data['amount'],
            'status' => 'pending',
            'bank_account_number' => $data['bank_account_number'] ?? null,
            'bank_ifsc_code' => $data['bank_ifsc_code'] ?? null,
            'bank_account_holder_name' => $data['bank_account_holder_name'] ?? null,
        ]);
        // Keep earnings as 'available'; payout request tracks the requested amount.
        // Precise locking of entries can be implemented later if needed.
        return back()->with('success','Withdrawal request submitted.');
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
        $profile = $tutor->tutorProfile;
        $languages = \DB::table('languages')->where('is_active',1)->orderBy('name')->get(['id','name']);
        $selectedLanguageIds = \DB::table('tutor_profile_language')
            ->where('tutor_profile_id', $profile->id)
            ->pluck('language_id')->toArray();
        $cities = \DB::table('cities')->orderBy('name')->get(['id','name']);
        $gradeBands = ['k-5'=>'K-5','6-8'=>'Middle (6-8)','9-12'=>'High (9-12)','college'=>'College','test-prep'=>'Test Prep'];
        
        return view('tutor.profile', compact('tutor', 'profile','languages','selectedLanguageIds','cities','gradeBands'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $profile = $user->tutorProfile;

        $data = $request->validate([
            'bio' => 'nullable|string|max:2000',
            'qualification' => 'nullable|string|max:120',
            'gender' => 'nullable|in:male,female,other',
            'experience_years' => 'nullable|integer|min:0|max:60',
            'languages' => 'nullable|array',
            'languages.*' => 'integer',
            'teaching_mode' => 'nullable|in:online,offline,both',
            'hourly_rate' => 'nullable|numeric|min:0',
            'travel_radius_km' => 'nullable|integer|min:0|max:50',
            'city_id' => 'nullable|integer',
            'pin_code' => 'nullable|string|max:20',
            'grade_levels' => 'nullable|array',
            'grade_levels.*' => 'string|max:40',
        ]);

        // Never update name, email, phone, or rating here
        if (isset($data['city_id'])) {
            $data['city'] = \DB::table('cities')->where('id',$data['city_id'])->value('name');
            unset($data['city_id']);
        }

        // Persist profile fields
        $profile->update([
            'bio' => $data['bio'] ?? $profile->bio,
            'qualification' => $data['qualification'] ?? $profile->qualification,
            'gender' => $data['gender'] ?? $profile->gender,
            'experience_years' => $data['experience_years'] ?? $profile->experience_years,
            'teaching_mode' => $data['teaching_mode'] ?? $profile->teaching_mode,
            'hourly_rate' => $data['hourly_rate'] ?? $profile->hourly_rate,
            'travel_radius_km' => $data['travel_radius_km'] ?? $profile->travel_radius_km,
            'city' => $data['city'] ?? $profile->city,
            'pin_code' => $data['pin_code'] ?? $profile->pin_code,
            'grade_levels' => $data['grade_levels'] ?? $profile->grade_levels,
        ]);

        // Sync languages pivot
        if (isset($data['languages'])) {
            \DB::table('tutor_profile_language')->where('tutor_profile_id', $profile->id)->delete();
            $rows = array_map(fn($lid)=>['tutor_profile_id'=>$profile->id,'language_id'=>$lid], $data['languages']);
            if (!empty($rows)) { \DB::table('tutor_profile_language')->insert($rows); }
        }

        return back()->with('success', 'Profile updated successfully!');
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

    public function notificationsJson()
    {
        $items = Notification::where('user_id', auth()->id())
            ->orderBy('created_at','desc')
            ->limit(20)
            ->get(['id','title','message','is_read','created_at']);
        return response()->json([
            'notifications' => $items,
            'unread_count' => Notification::where('user_id', auth()->id())->where('is_read', false)->count(),
        ]);
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
        
        // Make earning available for withdrawal
        \App\Models\TutorEarning::where('booking_id', $booking->id)
            ->update(['status' => 'available']);
        
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
