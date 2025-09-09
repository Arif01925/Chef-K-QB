<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckLoginSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('loggedIn')) {
            return redirect('/login')->with('error', 'Please log in first.');
        }

        return $next($request);
    }
}
