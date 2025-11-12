<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentOnboarded
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only applies to students
        if ($user->role !== 'student') {
            return $next($request);
        }

        $profile = $user->studentProfile;

        // Allow access to onboarding and logout routes without completion
        $currentRoute = $request->route() ? $request->route()->getName() : null;
        $allowedRoutes = [
            'student.onboarding',
            'student.onboarding.step1',
            'student.onboarding.step2',
            'logout',
        ];

        if ($currentRoute && in_array($currentRoute, $allowedRoutes, true)) {
            return $next($request);
        }

        if (!$profile || !($profile->onboarding_completed ?? false)) {
            return redirect()->route('student.onboarding')->with('warning', 'Please complete onboarding to continue.');
        }

        return $next($request);
    }
}