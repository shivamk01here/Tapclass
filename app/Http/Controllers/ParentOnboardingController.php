<?php

namespace App\Http\Controllers;

use App\Models\ParentChild;
use App\Models\ParentConsultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentOnboardingController extends Controller
{
    public function show()
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        return view('onboarding.parent');
    }

    public function storeChild(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'age' => ['nullable','integer','min:1','max:20'],
            'class_slab' => ['required','in:1-5,6-8,9-12,graduate,postgraduate'],
            'goals' => ['nullable','string','max:2000'],
            'profile_photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);
        $child = new ParentChild([
            'parent_user_id' => Auth::id(),
            'first_name' => $data['first_name'],
            'age' => $data['age'] ?? null,
            'class_slab' => $data['class_slab'],
            'goals' => $data['goals'] ?? null,
        ]);
        if ($request->hasFile('profile_photo')) {
            $child->profile_photo_path = $request->file('profile_photo')->store('children/photos','public');
        }
        $child->save();

        // If no active child, set it now
        if (!session('active_child_id')) session(['active_child_id' => $child->id]);

        if ($request->has('add_another')) {
            return back()->with('success','Child added. You can add another.');
        }
        return redirect()->route('onboarding.parent.consultation');
    }

    public function consultationPrompt()
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $supportNumber = config('app.support_number', '+91-90000-00000');
        $existing = ParentConsultation::where('parent_user_id', Auth::id())->latest()->first();
        return view('onboarding.parent-consultation', compact('supportNumber','existing'));
    }

    public function storeConsultation(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $data = $request->validate([
            'contact_phone' => ['required','string','max:20'],
            'questions' => ['nullable','string','max:2000'],
        ]);
        $childId = session('active_child_id');
        ParentConsultation::create([
            'parent_user_id' => Auth::id(),
            'child_id' => $childId,
            'contact_phone' => $data['contact_phone'],
            'questions' => $data['questions'] ?? null,
            'status' => 'requested',
        ]);
        return redirect()->route('parent.dashboard')->with('success','Consultation request sent. Our advisor will contact you.');
    }
}
