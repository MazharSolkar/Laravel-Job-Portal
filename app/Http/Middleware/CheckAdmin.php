<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Checking if the user is logged in or not
        if($request->user() == null) {
            return redirect()->back();
        }
        // Checking the role of user
        if($request->user()->role != 'admin') {
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }
        return $next($request);
    }
}
