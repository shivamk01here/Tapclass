<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TutorVerificationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if ($user->role !== 'tutor') {
            return $next($request);
        }

        $profile = $user->tutorProfile;
        $routeName = $request->route() ? $request->route()->getName() : null;

        // Allow these routes regardless of verification
        $allowed = ['tutor.pending', 'logout'];
        if ($routeName && in_array($routeName, $allowed, true)) {
            return $next($request);
        }

        // If onboarding is complete but verification is pending, redirect to pending page
        if ($profile && ($profile->onboarding_completed ?? false) && ($profile->verification_status === 'pending')) {
            return redirect()->route('tutor.pending');
        }

        return $next($request);
    }
}