<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureParentOnboarded
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && method_exists($user,'isParent') && $user->isParent()) {
            if ($user->children()->count() === 0) {
                return redirect()->route('onboarding.parent.show');
            }
        }
        return $next($request);
    }
}
