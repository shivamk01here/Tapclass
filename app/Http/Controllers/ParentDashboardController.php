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
        return view('parent.dashboard', compact('children','activeChild','upcoming','past','consult'));
    }
}
