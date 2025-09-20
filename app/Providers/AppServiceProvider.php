<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perHour(14)->by($request->ip())->response(function (Request $request, array $headers) {
                $retryAfterSeconds = $headers['Retry-After'] ?? 3600;
                $availableAt = now()->addSeconds($retryAfterSeconds)->format('Y-m-d H:i:s');
                return response()->view('errors.too-many-requests',compact('availableAt'));
            });
        });
    }
}
