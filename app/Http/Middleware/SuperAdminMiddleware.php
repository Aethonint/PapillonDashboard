<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next)
//     {
//         // Check if user is authenticated and has role 'admin'
//         if (Auth::check() && Auth::user()->role === 'admin') {
//             return $next($request);
//         }

//         // Redirect to login if not admin
//         return redirect()->route('login');
//     }

} 
