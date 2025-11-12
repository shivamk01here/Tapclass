<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ParentChild;
use App\Models\ParentConsultation;
use Illuminate\Support\Facades\Auth;

class ParentDashboardController extends Controller
{
    public function dashboard()
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $user = Auth::user();
        $children = $user->children()->get();
        $activeChildId = session('active_child_id') ?: optional($children->first())->id;
        $activeChild = $activeChildId ? ParentChild::find($activeChildId) : null;

        $upcoming = collect();
        $past = collect();
        if ($activeChild) {
            $upcoming = Booking::where('student_id', $user->id)
                ->where('child_id', $activeChild->id)
                ->whereIn('status', ['pending','confirmed'])
                ->latest('session_date')->take(5)->get();
            $past = Booking::where('student_id', $user->id)
                ->where('child_id', $activeChild->id)
                ->whereIn('status', ['completed','cancelled'])
                ->latest('session_date')->take(5)->get();
        }

        $consult = ParentConsultation::where('parent_user_id', $user->id)->latest()->first();

        $savedTutors = \App\Models\TutorProfile::with(['user','subjects'])
            ->whereHas('likes', function($q) use ($user){ $q->where('student_id', $user->id); })
            ->latest()
            ->take(6)
            ->get();

        return view('parent.dashboard', compact('children','activeChild','upcoming','past','consult','savedTutors'));
    }

    public function wallet()
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $wallet = Auth::user()->wallet;
        $transactions = $wallet->transactions()->orderBy('created_at','desc')->paginate(20);
        return view('parent.wallet', compact('wallet','transactions'));
    }

    public function wishlist()
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $likedTutors = \App\Models\TutorProfile::with(['user','subjects'])
            ->whereHas('likes', function($q){ $q->where('student_id', Auth::id()); })
            ->get();
        return view('parent.wishlist', compact('likedTutors'));
    }

    public function toggleLike($id)
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $tutor = \App\Models\TutorProfile::findOrFail($id);
        $userId = Auth::id();
        $like = \App\Models\TutorLike::where('student_id',$userId)->where('tutor_id',$tutor->user_id)->first();
        if ($like) { $like->delete(); $tutor->decrement('total_likes'); $liked=false; }
        else { \App\Models\TutorLike::create(['student_id'=>$userId,'tutor_id'=>$tutor->user_id]); $tutor->increment('total_likes'); $liked=true; }
        return response()->json(['success'=>true,'liked'=>$liked,'total_likes'=>$tutor->total_likes]);
    }
}
