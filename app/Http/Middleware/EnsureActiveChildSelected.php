<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureActiveChildSelected
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && method_exists($user,'isParent') && $user->isParent()) {
            $active = session('active_child_id');
            if (!$active) {
                $first = $user->children()->first();
                if ($first) {
                    session(['active_child_id' => $first->id]);
                } else {
                    return redirect()->route('onboarding.parent.show');
                }
            }
        }
        return $next($request);
    }
}
