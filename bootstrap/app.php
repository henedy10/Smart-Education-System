<?php

use App\Http\Middleware\api\CheckAdminApi;
use App\Http\Middleware\api\checkLoginApi;
use App\Http\Middleware\api\CheckStudentApi;
use App\Http\Middleware\api\CheckTeacherApi;
use App\Http\Middleware\api\PreventBackHistoryApi;
use App\Http\Middleware\api\SetLocaleApi;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\checkLogin;
use App\Http\Middleware\CheckStudent;
use App\Http\Middleware\CheckTeacher;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'CheckTeacher' => CheckTeacher::class,
            'CheckStudent' => CheckStudent::class,
            'checkLogin' => checkLogin::class,
            'PreventBackHistory' => PreventBackHistory::class,
            'SetLocale' => SetLocale::class,
            'CheckAdmin' => CheckAdmin::class,

            'CheckTeacherApi' => CheckTeacherApi::class,
            'CheckStudentApi' => CheckStudentApi::class,
            'checkLoginApi' => checkLoginApi::class,
            'PreventBackHistoryApi' => PreventBackHistoryApi::class,
            'SetLocaleApi' => SetLocaleApi::class,
            'CheckAdminApi' => CheckAdminApi::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
