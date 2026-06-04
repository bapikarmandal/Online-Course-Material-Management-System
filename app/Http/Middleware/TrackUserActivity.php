<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

            Auth::user()->update([
                'last_activity_at' => now()
            ]);

        }

        return $next($request);
    }
}