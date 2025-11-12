<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudentOnboardingController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $profile = $user->studentProfile;
        $subjects = \App\Models\Subject::where('is_active', true)->orderBy('name')->get(['id','name']);
        // Cities table may not have a model; fetch via query builder
        $cities = DB::table('cities')->select('id','name')->orderBy('name')->limit(2000)->get();
        return view('onboarding.student', compact('user','profile','subjects','cities'));
    }

    public function saveStep1(Request $request)
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        $rules = [
            'date_of_birth' => 'required|date|before:today',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'integer',
            'profile_picture' => 'nullable|image|max:5120',
        ];

        $validated = $request->validate($rules);

        DB::transaction(function () use ($request, $user, $profile) {
            if ($request->hasFile('profile_picture')) {
$path = $request->file('profile_picture')->store('avatars', 'public');
                // Save web-accessible path as stored convention: /storage/avatars/...
                $user->update(['profile_picture' => '/storage/'.$path]);
            }

            $profile->update([
                'date_of_birth' => $request->date_of_birth,
                'subjects_of_interest' => $request->subjects,
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }
        return back()->with('step1_saved', true);
    }

    public function saveStep2(Request $request)
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        $rules = [
            'city_id' => 'required|integer',
            'preferred_modes' => 'required|array|min:1',
            'preferred_modes.*' => 'in:online,offline_center,offline_tutor',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'pin_code' => 'nullable|string|max:20',
        ];
        $data = $request->validate($rules);

        DB::transaction(function () use ($profile, $data) {
            $profile->update([
                'city_id' => $data['city_id'],
                'preferred_tutoring_modes' => $data['preferred_modes'],
                'latitude' => $data['latitude'] ?? $profile->latitude,
                'longitude' => $data['longitude'] ?? $profile->longitude,
                'pin_code' => $data['pin_code'] ?? $profile->pin_code,
                'onboarding_completed' => true,
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'redirect' => route('student.dashboard')]);
        }
        return redirect()->route('student.dashboard')->with('success', 'Onboarding completed.');
    }
    public function suggestSubjects(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $items = \App\Models\Subject::where('is_active', true)
            ->when($q !== '', function($qq) use ($q){ $qq->where('name','like','%'.$q.'%'); })
            ->orderBy('name')
            ->limit(10)
            ->get(['id','name']);
        return response()->json($items);
    }
}
