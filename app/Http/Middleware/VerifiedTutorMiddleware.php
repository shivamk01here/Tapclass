<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedTutorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->role !== 'tutor') {
            abort(403, 'Only tutors can access this page.');
        }

        if (!$user->tutorProfile || $user->tutorProfile->verification_status !== 'verified') {
            return redirect()->route('tutor.onboarding')->with('warning', 'Please complete your profile and wait for verification.');
        }

        return $next($request);
    }
}
