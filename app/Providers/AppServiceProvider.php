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
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perHour(5)->by($request->ip())->response(function (Request $request, array $headers) {
                $retryAfterSeconds = $headers['Retry-After'] ?? 3600;
                $availableAt = now()->addSeconds($retryAfterSeconds)->format('Y-m-d H:i:s');
                return response()->view('errors.too-many-requests',compact('availableAt'));
            });
        });
        RateLimiter::for('loginApi', function (Request $request) {
            return Limit::perHour(5)->by($request->ip())->response(function (Request $request, array $headers) {
                $retryAfterSeconds = $headers['Retry-After'] ?? 3600;
                $availableAt = now()->addSeconds($retryAfterSeconds)->format('Y-m-d H:i:s');
                return response()->json([
                    'success'     => false,
                    'msg'         => 'too-many-requests',
                    'availableAt' => $availableAt,
                ],429)->header('X-Rate-Limiting-Remaining',0);
            });
        });

        RateLimiter::for('updatePassword', function (Request $request) {
            return Limit::perHour(5)->by($request->ip())->response(function (Request $request, array $headers) {
                $retryAfterSeconds = $headers['Retry-After'] ?? 3600;
                $availableAt = now()->addSeconds($retryAfterSeconds)->format('Y-m-d H:i:s');
                return response()->view('errors.too-many-requests',compact('availableAt'));
            });
        });
        RateLimiter::for('updatePasswordApi', function (Request $request) {
            return Limit::perHour(5)->by($request->ip())->response(function (Request $request, array $headers) {
                $retryAfterSeconds = $headers['Retry-After'] ?? 3600;
                $availableAt = now()->addSeconds($retryAfterSeconds)->format('Y-m-d H:i:s');
                return response()->json([
                    'success'     => false,
                    'msg'         => 'too-many-requests',
                    'availableAt' => $availableAt,
                ],429)->header('X-Rate-Limiting-Remaining',0);
            });
        });
    }
}
