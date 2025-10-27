<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\TutorProfile;
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
    
    public function tutorProfile($id)
    {
        $tutor = TutorProfile::with(['user', 'subjects', 'reviews.student'])
            ->where('user_id', $id)
            ->where('verification_status', 'verified')
            ->firstOrFail();

            // dd($tutor);
        
        return view('tutors.profile', compact('tutor'));
    }
}
