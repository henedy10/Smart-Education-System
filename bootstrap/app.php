<?php

use App\Http\Middleware\{CheckTeacher,CheckStudent, checkLogin, PreventBackHistory, SetLocale};
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'CheckTeacher'       => CheckTeacher::class,
            'CheckStudent'       => CheckStudent::class,
            'checkLogin'         => checkLogin::class,
            'PreventBackHistory' => PreventBackHistory::class,
            'SetLocale'          => SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
