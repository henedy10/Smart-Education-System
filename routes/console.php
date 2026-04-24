<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('model:prune')->everySixHours();
Schedule::command('sanctum:prune-expired --hours=24')->daily();
Schedule::call(function () {
    DB::table('password_reset_tokens')->where('created_at', '<', now()->subMinute())->delete();
})->everyMinute();
