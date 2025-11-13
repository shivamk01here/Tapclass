<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TutorProfile;
use App\Models\Booking;
use App\Models\WithdrawalRequest;
use App\Models\Subject;
use App\Models\SiteSetting;
use App\Models\Notification;
use App\Models\ParentConsultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RegistrationIssue;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_tutors' => User::where('role', 'tutor')->count(),
            'total_revenue' => Booking::sum('platform_commission'),
            'total_bookings' => Booking::count(),
        ];
        
        $pendingTutors = TutorProfile::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->limit(5)
            ->get();
        
        $recentBookings = Booking::with(['student', 'tutor', 'subject'])
            ->latest()
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'pendingTutors', 'recentBookings'));
    }

    public function tutors(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $query = TutorProfile::with(['user', 'subjects']);
        
        if ($status !== 'all') {
            $query->where('verification_status', $status);
        }
        
        $tutors = $query->latest()->paginate(20);
        
        $stats = [
            'pending' => TutorProfile::where('verification_status', 'pending')->count(),
            'verified' => TutorProfile::where('verification_status', 'verified')->count(),
            'rejected' => TutorProfile::where('verification_status', 'rejected')->count(),
            'total' => TutorProfile::count(),
        ];
        
        return view('admin.tutors', compact('tutors', 'status', 'stats'));
    }

    public function verifyTutor($id)
    {
        $tutorProfile = TutorProfile::with(['user', 'subjects'])->where('user_id', $id)->firstOrFail();
        $tutor = $tutorProfile->user;
        $profile = $tutorProfile;
        $subjects = $tutorProfile->subjects;

        // Extra details
        $languages = \DB::table('tutor_profile_language')
            ->join('languages','tutor_profile_language.language_id','=','languages.id')
            ->where('tutor_profile_language.tutor_profile_id', $tutorProfile->id)
            ->pluck('languages.name')
            ->toArray();
        $gradeLevels = is_array($tutorProfile->grade_levels) ? $tutorProfile->grade_levels : (empty($tutorProfile->grade_levels) ? [] : (array)$tutorProfile->grade_levels);
        
        return view('admin.tutor-verify', compact('tutor', 'profile', 'subjects','languages','gradeLevels'));
    }

    public function approveTutor(Request $request, $id)
    {
        // $id is user_id, not profile id
        $tutor = TutorProfile::where('user_id', $id)->firstOrFail();
        
        $tutor->update([
            'verification_status' => 'verified',
            'is_verified_badge' => true,
        ]);
        
        Notification::createForUser(
            $tutor->user_id,
            'tutor_verified',
            'Profile Approved!',
            'Your tutor profile has been approved. You can now start accepting bookings.'
        );
        
        return redirect()->route('admin.tutors')->with('success', 'Tutor approved successfully!');
    }

    public function rejectTutor(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);
        
        // $id is user_id, not profile id
        $tutor = TutorProfile::where('user_id', $id)->firstOrFail();
        
        $tutor->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->reason,
        ]);
        
        Notification::createForUser(
            $tutor->user_id,
            'tutor_rejected',
            'Profile Rejected',
            'Your tutor profile has been rejected. Reason: ' . $request->reason
        );
        
        return redirect()->route('admin.tutors')->with('success', 'Tutor rejected.');
    }
    
    public function banTutor(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);
        
        $user = User::findOrFail($id);
        $tutorProfile = TutorProfile::where('user_id', $id)->first();
        
        // Ban the user account
        $user->update([
            'is_active' => false,
        ]);
        
        // Update tutor profile if exists
        if ($tutorProfile) {
            $tutorProfile->update([
                'verification_status' => 'rejected',
                'verification_notes' => 'BANNED: ' . $request->reason,
            ]);
        }
        
        Notification::createForUser(
            $id,
            'account_banned',
            'Account Banned',
            'Your account has been banned. Reason: ' . $request->reason
        );
        
        return redirect()->route('admin.tutors')->with('success', 'Tutor banned successfully.');
    }

    public function students()
    {
        $students = User::with(['studentProfile', 'wallet'])
            ->where('role', 'student')
            ->latest()
            ->paginate(20);
        
        return view('admin.students', compact('students'));
    }

    public function parents()
    {
        $parents = User::with(['children', 'wallet'])
            ->where('role', 'parent')
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => User::where('role','parent')->count(),
            'with_children' => User::where('role','parent')->whereHas('children')->count(),
        ];

        return view('admin.parents', compact('parents','stats'));
    }

    public function parentShow($id)
    {
        $parent = User::with(['children.bookings', 'wallet'])
            ->where('role','parent')
            ->findOrFail($id);

        $consultations = \App\Models\ParentConsultation::with(['child'])
            ->where('parent_user_id', $parent->id)
            ->latest()
            ->get();

        $childIds = $parent->children->pluck('id');
        $totalBookings = \App\Models\Booking::whereIn('child_id', $childIds)->count();

        return view('admin.parent-show', [
            'parent' => $parent,
            'consultations' => $consultations,
            'totalBookings' => $totalBookings,
        ]);
    }

    public function adjustWallet(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:credit,debit',
            'description' => 'required|string',
        ]);
        
        $student = User::findOrFail($id);
        
        if ($request->type === 'credit') {
            $student->wallet->credit($request->amount, $request->description, 'admin_adjustment');
        } else {
            $student->wallet->debit($request->amount, $request->description, 'admin_adjustment');
        }
        
        return back()->with('success', 'Wallet adjusted successfully!');
    }

    public function bookings()
    {
        $bookings = Booking::with(['student', 'tutor', 'subject'])
            ->latest()
            ->paginate(20);
        
        return view('admin.bookings', compact('bookings'));
    }

    public function payouts(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $payouts = WithdrawalRequest::with('tutor')
            ->where('status', $status)
            ->latest()
            ->paginate(20);
        
        return view('admin.payouts', compact('payouts', 'status'));
    }

    public function approvePayout(Request $request, $id)
    {
        $payout = WithdrawalRequest::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            $payout->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            
            // Mark earnings as withdrawn (honor both 'available' and 'requested')
            \App\Models\TutorEarning::where('tutor_id', $payout->tutor_id)
                ->whereIn('status', ['available','requested'])
                ->update([
                    'status' => 'withdrawn',
                    'withdrawn_at' => now(),
                ]);
            
            Notification::createForUser(
                $payout->tutor_id,
                'payout_approved',
                'Payout Approved',
                "Your withdrawal request for ₹{$payout->amount} has been approved."
            );
            
            DB::commit();
            
            return back()->with('success', 'Payout approved!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to approve payout.']);
        }
    }

    public function rejectPayout(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);
        
        $payout = WithdrawalRequest::findOrFail($id);
        
        $payout->update([
            'status' => 'rejected',
            'admin_notes' => $request->reason,
        ]);
        
        Notification::createForUser(
            $payout->tutor_id,
            'payout_rejected',
            'Payout Rejected',
            "Your withdrawal request has been rejected. Reason: {$request->reason}"
        );
        
        return back()->with('success', 'Payout rejected.');
    }

    public function settings()
    {
        $settings = SiteSetting::all()->pluck('setting_value', 'setting_key');
        $subjects = Subject::all();
        
        return view('admin.settings', compact('settings', 'subjects'));
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SiteSetting::set($key, $value);
        }
        
        return back()->with('success', 'Settings updated successfully!');
    }

    public function analytics()
    {
        // Basic analytics for now
        $data = [
            'bookings_by_month' => Booking::selectRaw('MONTH(session_date) as month, COUNT(*) as count')
                ->groupBy('month')
                ->get(),
            'top_subjects' => Booking::selectRaw('subject_id, COUNT(*) as count')
                ->groupBy('subject_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
        ];
        
        return view('admin.analytics', compact('data'));
    }

    public function consultations(Request $request)
    {
        $status = $request->get('status');
        $query = ParentConsultation::with(['parent','child'])->latest();
        if ($status) {
            $query->where('status', $status);
        }
        $consultations = $query->paginate(20);
        return view('admin.consultations', compact('consultations','status'));
    }

    public function updateConsultationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:requested,contacted,in_progress,scheduled,completed,cancelled,resolved',
        ]);
        $c = ParentConsultation::findOrFail($id);
        $c->status = $request->status;
        $c->save();
        return back()->with('success','Consultation status updated.');
    }
    public function registrationIssues(Request $request)
    {
        $status = $request->get('status');
        $query = RegistrationIssue::query()->latest();
        if ($status) { $query->where('status', $status); }
        $issues = $query->paginate(20);
        $counts = [
            'open' => RegistrationIssue::where('status','open')->count(),
            'resolved' => RegistrationIssue::where('status','resolved')->count(),
            'total' => RegistrationIssue::count(),
        ];
        return view('admin.registration-issues', compact('issues','status','counts'));
    }

    public function resolveRegistrationIssue($id)
    {
        $issue = RegistrationIssue::findOrFail($id);
        $issue->update(['status' => 'resolved']);
        return back()->with('success','Issue marked as resolved.');
    }
}
