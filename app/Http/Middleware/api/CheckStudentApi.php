<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return response()->json([
                'success' => false,
                'msg'     => __('messages.check_role_middleware')
            ],401);
        }

        if(Auth::user()->user_as !=='student'){
            return response()->json([
                'success' => false,
                'msg'     => __('messages.check_role_middleware')
            ],403);
        }

        return $next($request);
    }
}
