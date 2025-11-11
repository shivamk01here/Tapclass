<?php

namespace App\Http\Controllers;

use App\Models\ParentChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentLearnerController extends Controller
{
    public function index()
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $children = Auth::user()->children()->get();
        $activeChildId = session('active_child_id');
        return view('parent.learners.index', compact('children','activeChildId'));
    }

    public function store(Request $request)
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
        if (!session('active_child_id')) session(['active_child_id' => $child->id]);
        return back()->with('success','Learner added');
    }

    public function update(Request $request, ParentChild $child)
    {
        abort_unless(Auth::check() && Auth::user()->isParent() && $child->parent_user_id === Auth::id(), 403);
        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'age' => ['nullable','integer','min:1','max:20'],
            'class_slab' => ['required','in:1-5,6-8,9-12,graduate,postgraduate'],
            'goals' => ['nullable','string','max:2000'],
            'profile_photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);
        $child->fill([
            'first_name' => $data['first_name'],
            'age' => $data['age'] ?? null,
            'class_slab' => $data['class_slab'],
            'goals' => $data['goals'] ?? null,
        ]);
        if ($request->hasFile('profile_photo')) {
            $child->profile_photo_path = $request->file('profile_photo')->store('children/photos','public');
        }
        $child->save();
        return back()->with('success','Learner updated');
    }

    public function destroy(ParentChild $child)
    {
        abort_unless(Auth::check() && Auth::user()->isParent() && $child->parent_user_id === Auth::id(), 403);
        $child->delete();
        if (session('active_child_id') == $child->id) {
            session()->forget('active_child_id');
        }
        return back()->with('success','Learner deleted');
    }

    public function switch(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->isParent(), 403);
        $request->validate(['child_id' => ['required','exists:parent_children,id']]);
        $child = ParentChild::findOrFail($request->child_id);
        abort_unless($child->parent_user_id === Auth::id(), 403);
        session(['active_child_id' => $child->id]);
        return back()->with('success','Switched to '.$child->first_name);
    }
}
