<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('lang','en');

        if(!in_array($locale,['en','ar'])){
            $locale = 'en';
        }

        app()->setLocale($locale);
        return $next($request);
    }
}
