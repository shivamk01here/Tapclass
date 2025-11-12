<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TutorProfile;
use App\Models\Subject;
use App\Models\TutorEarning;
use App\Models\SiteSetting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
public function create($tutorId, Request $request)
    {
        // Block tutors from booking
        if (auth()->check() && method_exists(auth()->user(), 'isTutor') && auth()->user()->isTutor()) {
            return back()->with('toast_error', "You're logged in as a tutor. Please switch to a student account to book.");
        }

        $tutor = TutorProfile::with(['user', 'subjects'])
            ->where('user_id', $tutorId)
            ->where('verification_status', 'verified')
            ->firstOrFail();
        
        $tutorProfile = $tutor;

        $isConsultation = $request->get('type') === 'consultation';
        if ($isConsultation) {
            // Ensure a Consultation subject exists
            $consult = Subject::firstOrCreate(
                ['slug' => 'consultation'],
                ['name' => 'Consultation', 'icon' => null, 'is_active' => true]
            );
            $subjects = collect([$consult]);
        } else {
            $subjects = $tutor->subjects;
        }
        
        return view('student.booking-create-modern', compact('tutor', 'tutorProfile', 'subjects', 'isConsultation'));
    }

public function store(Request $request)
    {
        // Block tutors from booking
        if (auth()->check() && method_exists(auth()->user(), 'isTutor') && auth()->user()->isTutor()) {
            return back()->with('toast_error', "Tutors cannot book sessions. Please use a student account.");
        }

        $isConsultation = $request->get('type') === 'consultation';

        $rules = [
            'tutor_id' => 'required|exists:users,id',
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
        if ($isConsultation) {
            // Online consultation by default
            $rules['session_mode'] = 'nullable|in:online,in-person';
        } else {
            $rules['subject_id'] = 'required|exists:subjects,id';
            $rules['session_mode'] = 'required|in:online,in-person';
            $rules['location'] = 'required_if:session_mode,in-person';
        }
        $request->validate($rules);

        $student = auth()->user();
        $tutor = TutorProfile::where('user_id', $request->tutor_id)->firstOrFail();
        
        // Resolve active child for parent-as-manager flow
        $childData = [null, null, null, null]; // id, name, age, class_slab
        if (method_exists($student,'isParent') && $student->isParent()) {
            $activeChildId = session('active_child_id');
            $child = $activeChildId ? \App\Models\ParentChild::find($activeChildId) : null;
            if (!$child) {
                return back()->withErrors(['error' => 'Please add/select a learner before booking.'])->withInput();
            }
            $childData = [$child->id, $child->first_name, $child->age, $child->class_slab];
        }
        
        // Calculate duration in hours
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        $durationHours = $startTime->diffInMinutes($endTime) / 60;
        
// Subject and rate resolution
        if ($isConsultation) {
            $consult = Subject::firstOrCreate(['slug' => 'consultation'], ['name' => 'Consultation', 'is_active' => true]);
            $request->merge(['subject_id' => $consult->id]);
            if (!$request->filled('session_mode')) {
                $request->merge(['session_mode' => 'online']);
            }
            $hourlyRate = $tutor->hourly_rate; // general consultation fee
        } else {
            $tutorSubject = $tutor->subjects()->where('subject_id', $request->subject_id)->first();
            if (!$tutorSubject) {
                return back()->withErrors(['error' => 'Tutor does not teach this subject.'])->withInput();
            }
            $hourlyRate = $request->session_mode === 'online' ? 
                $tutorSubject->pivot->online_rate : 
                $tutorSubject->pivot->offline_rate;
        }
        
        if (!$hourlyRate) {
            return back()->withErrors(['error' => 'This session mode is not available for the selected subject.'])->withInput();
        }
        
        // Calculate amount based on hourly rate and duration
        $amount = $hourlyRate * $durationHours;
        
        // Get platform commission
        $commissionSetting = SiteSetting::where('setting_key', 'commission_percentage')->first();
        $commissionRate = $commissionSetting ? $commissionSetting->setting_value : 15;
        $platformCommission = ($amount * $commissionRate) / 100;
        $tutorEarnings = $amount - $platformCommission;
        
        // Check wallet balance
        if ($student->wallet->balance < $amount) {
            return back()->withErrors(['error' => 'Insufficient wallet balance.'])->withInput();
        }
        
        // Check for conflicts
        $conflict = Booking::where('tutor_id', $tutor->user_id)
            ->where('session_date', $request->session_date)
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($startTime, $endTime) {
                $query->where(function($q) use ($startTime, $endTime) {
                    $q->where('session_start_time', '<', $endTime->format('H:i:s'))
                      ->where('session_end_time', '>', $startTime->format('H:i:s'));
                });
            })
            ->exists();
        
        if ($conflict) {
            return back()->withErrors(['error' => 'Tutor is not available at this time.'])->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            // Generate booking code
            $date = now()->format('Ymd');
            $lastBooking = Booking::where('booking_code', 'LIKE', "BK{$date}%")->latest()->first();
            $sequence = $lastBooking ? (int)substr($lastBooking->booking_code, -3) + 1 : 1;
            $bookingCode = "BK{$date}" . str_pad($sequence, 3, '0', STR_PAD_LEFT);
            
            // Create booking
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'student_id' => $student->id,
                'tutor_id' => $tutor->user_id,
                'subject_id' => $request->subject_id,
                'session_type' => $request->session_mode,
                'session_date' => $request->session_date,
                'session_start_time' => $startTime->format('H:i:s'),
                'session_end_time' => $endTime->format('H:i:s'),
                'session_duration_minutes' => $durationHours * 60,
                'amount' => $amount,
                'platform_commission' => $platformCommission,
                'tutor_earnings' => $tutorEarnings,
                'status' => 'confirmed',
                'location_address' => $request->location ?? null,
                'notes' => $request->notes ?? null,
                'meet_link' => $request->session_mode === 'online' ? 'https://meet.google.com/' . uniqid() : null,
                'child_id' => $childData[0],
                'child_name' => $childData[1],
                'child_age' => $childData[2],
                'child_class_slab' => $childData[3],
            ]);
            
            // Debit from wallet
            $student->wallet->debit($amount, "Booking {$bookingCode}", 'booking', $booking->id);
            
            // Create tutor earning
            TutorEarning::create([
                'tutor_id' => $tutor->user_id,
                'booking_id' => $booking->id,
                'amount' => $tutorEarnings,
                'status' => 'pending',
            ]);
            
            // Create notifications
            Notification::createForUser(
                $student->id,
                'booking_confirmed',
                'Booking Confirmed',
                "Your session with {$tutor->user->name} has been confirmed for {$request->session_date}.",
                ['booking_id' => $booking->id]
            );
            
            $who = $student->isParent() ? ($student->name.' (Parent) for '.($childData[1] ?? 'learner')) : $student->name;
            Notification::createForUser(
                $tutor->user_id,
                'new_booking',
                'New Booking',
                "You have a new booking from {$who} on {$request->session_date}.",
                ['booking_id' => $booking->id]
            );
            
            DB::commit();
            
            $route = auth()->user()->isParent() ? 'parent.dashboard' : 'student.bookings';
            return redirect()->route($route)->with('success', 'Booking created successfully! Booking code: ' . $bookingCode);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Booking failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->student_id !== auth()->id()) {
            abort(403);
        }
        
        $maxCancelHours = SiteSetting::get('max_cancellation_hours', 24);
        $sessionDateTime = Carbon::parse($booking->session_date)->setTimeFromTimeString($booking->session_start_time);
        $hoursDiff = now()->diffInHours($sessionDateTime, false);
        
        if ($hoursDiff < $maxCancelHours) {
            return back()->withErrors(['error' => "Cannot cancel within {$maxCancelHours} hours of the session."]);
        }
        
        DB::beginTransaction();
        
        try {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_by' => 'student',
                'cancellation_reason' => $request->reason,
            ]);
            
            // Refund to wallet
            $booking->student->wallet->credit(
                $booking->amount,
                "Refund for cancelled booking {$booking->booking_code}",
                'refund',
                $booking->id
            );
            
            // Delete tutor earnings if still pending
            TutorEarning::where('booking_id', $booking->id)
                ->where('status', 'pending')
                ->delete();
            
            // Notify tutor
            Notification::createForUser(
                $booking->tutor_id,
                'booking_cancelled',
                'Booking Cancelled',
                "Booking {$booking->booking_code} has been cancelled by the student."
            );
            
            DB::commit();
            
            return back()->with('success', 'Booking cancelled and amount refunded.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Cancellation failed.']);
        }
    }

    public function tutorCancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->tutor_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);
        
        DB::beginTransaction();
        
        try {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_by' => 'tutor',
                'cancellation_reason' => $request->reason,
            ]);
            
            // Refund to wallet
            $booking->student->wallet->credit(
                $booking->amount,
                "Refund for cancelled booking {$booking->booking_code}",
                'refund',
                $booking->id
            );
            
            // Delete tutor earnings
            TutorEarning::where('booking_id', $booking->id)->delete();
            
            // Notify student
            Notification::createForUser(
                $booking->student_id,
                'booking_cancelled',
                'Booking Cancelled',
                "Booking {$booking->booking_code} has been cancelled by the tutor. Amount refunded."
            );
            
            DB::commit();
            
            return back()->with('success', 'Booking cancelled. Student has been refunded.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Cancellation failed.']);
        }
    }

    public function reschedule(Request $request, $id)
    {
        // TODO: Implement reschedule logic
        return back()->with('info', 'Reschedule feature coming soon!');
    }
}
