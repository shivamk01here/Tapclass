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
        
        // Search by free text (name, subject, bio)
        if ($request->filled('q')) {
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
        
        // Subject filter
        $subject = null;
        if ($request->filled('subject')) {
            $subject = Subject::find($request->subject);
            if ($subject) {
                $query->whereHas('subjects', function($sq) use ($subject) {
                    $sq->where('subjects.id', $subject->id);
                });
            }
        }
        
        // Mode filter
        if ($request->filled('mode')) {
            if ($request->mode === 'online') {
                $query->whereIn('teaching_mode', ['online', 'both']);
            } elseif ($request->mode === 'offline') {
                $query->whereIn('teaching_mode', ['offline', 'both']);
            }
        }
        
        // Budget filter
        if ($request->filled('max_price')) {
            $query->where('hourly_rate', '<=', $request->max_price);
        }
        
        // Rating filter (min of selected)
        if ($request->filled('rating')) {
            $minRating = min($request->rating);
            $query->where('average_rating', '>=', $minRating);
        }
        
        // Experience filter
        if ($request->filled('experience')) {
            $query->where('experience_years', '>=', (int)$request->experience);
        }
        
        // Gender filter
        if ($request->filled('gender')) {
            $genders = (array)$request->gender;
            $query->whereIn('gender', $genders);
        }
        
        // Nearby filter (lat/lng + radius) or pin_code fallback
        if ($request->filled('nearby')) {
            $radius = (float)($request->get('radius', 10)); // km
            if ($request->filled('lat') && $request->filled('lng')) {
                $lat = (float)$request->lat; $lng = (float)$request->lng;
                $haversine = "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";
                $query->select('*')
                      ->selectRaw("{$haversine} AS distance", [$lat,$lng,$lat])
                      ->whereNotNull('latitude')->whereNotNull('longitude')
                      ->having('distance', '<=', $radius)
                      ->orderBy('distance');
            } elseif ($request->filled('pincode')) {
                $query->where('pin_code', $request->pincode);
            }
        }
        // Allow direct pincode search even without 'nearby'
        if ($request->filled('pincode')) {
            $query->where('pin_code', $request->pincode);
        }
        
        $query->orderBy('average_rating', 'desc')
              ->orderBy('total_reviews', 'desc');
        
        $tutors = $query->paginate(24)->withQueryString();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get(['id','name','icon']);
        
        return view('tutors.search', compact('tutors', 'subject', 'subjects'));
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
