<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\TutorProfile;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured tutors (verified, top-rated)
        $featuredTutors = TutorProfile::with('user')
            ->where('verification_status', 'verified')
            ->orderBy('average_rating', 'desc')
            ->orderBy('total_reviews', 'desc')
            ->limit(6)
            ->get();

        // Get active subjects for quick search
        $subjects = Subject::where('is_active', true)->limit(8)->get();

        // Get recent reviews/testimonials
        $testimonials = Review::with(['student', 'tutor'])
            ->where('rating', '>=', 4)
            ->latest()
            ->limit(6)
            ->get();

        return view('home', compact('featuredTutors', 'subjects', 'testimonials'));
    }
    
    public function searchTutors1(Request $request)
    {
        $query = TutorProfile::with(['user', 'subjects'])
            ->where('verification_status', 'verified');
        
        // Search query
        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($uq) use ($searchTerm) {
                    $uq->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('subjects', function($sq) use ($searchTerm) {
                    $sq->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhere('bio', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Mode filter
        if ($request->has('mode')) {
            if ($request->mode === 'online') {
                $query->whereIn('teaching_mode', ['online', 'both']);
            } elseif ($request->mode === 'offline') {
                $query->whereIn('teaching_mode', ['offline', 'both']);
            }
        }
        
        // Price filter
        if ($request->has('max_price')) {
            $query->where('hourly_rate', '<=', $request->max_price);
        }
        
        // Rating filter
        if ($request->has('rating')) {
            $minRating = min($request->rating);
            $query->where('average_rating', '>=', $minRating);
        }
        
        // Sort by rating and reviews
        $query->orderBy('average_rating', 'desc')
              ->orderBy('total_reviews', 'desc');
        
        $tutors = $query->paginate(24);
        $subject = null;
        
        return view('tutors.search', compact('tutors', 'subject'));
    }
    
    public function tutorProfile1($id)
    {
        $tutor = TutorProfile::with(['user', 'subjects', 'reviews.student'])
            ->where('user_id', $id)
            ->where('verification_status', 'verified')
            ->firstOrFail();
        
        return view('tutors.profile', compact('tutor'));
    }

    public function searchTutors(Request $request)
    {
        $query = TutorProfile::with(['user', 'subjects'])
            ->where('verification_status', 'verified');

        // Subjects filter (IDs)
        $subjectIds = array_filter((array) $request->input('subjects', []));
        if (!empty($subjectIds)) {
            $query->whereHas('subjects', function ($q) use ($subjectIds) {
                $q->whereIn('subjects.id', $subjectIds);
            });
        }

        // City filter (string on tutor_profiles.city)
        if ($request->filled('city')) {
            $city = trim($request->string('city'));
            $query->where(function($q) use ($city){
                $q->where('city', 'like', '%'.$city.'%')
                  ->orWhere('location', 'like', '%'.$city.'%');
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->string('gender'));
        }

        // Mode filter (online/offline/both)
        if ($request->filled('mode')) {
            $mode = $request->string('mode');
            if ($mode === 'online') {
                $query->whereIn('teaching_mode', ['online','both']);
            } elseif ($mode === 'offline') {
                $query->whereIn('teaching_mode', ['offline','both']);
            } elseif ($mode === 'both') {
                $query->where('teaching_mode', 'both');
            }
        }

        // Min rating
        if ($request->filled('min_rating')) {
            $query->where('average_rating', '>=', (int) $request->input('min_rating'));
        }

        // Max price
        if ($request->filled('max_price')) {
            $query->where('hourly_rate', '<=', (int) $request->input('max_price'));
        }

        // Sort by rating and reviews
        $tutors = $query->orderBy('average_rating', 'desc')
            ->orderBy('total_reviews', 'desc')
            ->paginate(30)
            ->appends($request->query());

        $selectedSubjects = [];
        if (!empty($subjectIds)) {
            $selectedSubjects = Subject::whereIn('id', $subjectIds)->get(['id','name']);
        }

        return view('tutors.search', [
            'tutors' => $tutors,
            'selectedSubjects' => $selectedSubjects,
        ]);
    }
    
    public function suggestCities(Request $request)
    {
        $q = trim((string)$request->get('q', ''));
        $query = DB::table('cities')->select('id','name')->orderBy('name');
        if ($q !== '') { $query->where('name','like','%'.$q.'%'); }
        return response()->json($query->limit(50)->get());
    }

    public function tutorProfile($id)
    {
        $tutor = TutorProfile::with(['user', 'subjects', 'reviews.student'])
            ->where('user_id', $id)
            ->where('verification_status', 'verified')
            ->firstOrFail();

        // Languages via pivot
        $languages = \DB::table('tutor_profile_language')
            ->join('languages','tutor_profile_language.language_id','=','languages.id')
            ->where('tutor_profile_language.tutor_profile_id', $tutor->id)
            ->pluck('languages.name')
            ->toArray();

        // Subjects with rates and availability from tutor_subjects
        $subjects = \DB::table('tutor_subjects')
            ->join('subjects','tutor_subjects.subject_id','=','subjects.id')
            ->where('tutor_subjects.tutor_profile_id', $tutor->id)
            ->select('subjects.name as subject','tutor_subjects.online_rate','tutor_subjects.offline_rate','tutor_subjects.is_online_available','tutor_subjects.is_offline_available')
            ->orderBy('subjects.name')
            ->get();

        $gradeLevels = is_array($tutor->grade_levels) ? $tutor->grade_levels : (empty($tutor->grade_levels) ? [] : (array) $tutor->grade_levels);

        $isLiked = false;
        if (auth()->check()) {
            $isLiked = \App\Models\TutorLike::where('student_id', auth()->id())
                ->where('tutor_id', $tutor->user_id)
                ->exists();
        }

        return view('tutors.profile-modern', [
            'tutor' => $tutor,
            'languages' => $languages,
            'subjectsDetailed' => $subjects,
            'gradeLevels' => $gradeLevels,
            'isLiked' => $isLiked,
        ]);
    }
}
