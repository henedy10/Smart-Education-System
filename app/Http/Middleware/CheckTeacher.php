<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('user_as') && session('user_as') === 'teacher' ){
            return $next($request);
        }

        return redirect()->route('index')->withErrors(['login' => __('messages.check_role_middleware')]);
    }
}
