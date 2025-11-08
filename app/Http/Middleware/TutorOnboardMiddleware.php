<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TutorOnboardMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only applies to tutors
        if ($user->role !== 'tutor') {
            return $next($request);
        }

        $profile = $user->tutorProfile;

        // Allow access to onboarding and logout routes without completion
        $currentRoute = $request->route() ? $request->route()->getName() : null;
        $allowedRoutes = [
            'tutor.onboarding',
            'tutor.onboarding.save-step',
            'tutor.onboarding.verify-otp',
            'logout',
        ];

        if ($currentRoute && in_array($currentRoute, $allowedRoutes, true)) {
            return $next($request);
        }

        if (!$profile || !$profile->onboarding_completed) {
            return redirect()->route('tutor.onboarding')->with('warning', 'Please complete onboarding to continue.');
        }

        return $next($request);
    }
}