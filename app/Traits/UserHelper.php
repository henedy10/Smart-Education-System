<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;

trait UserHelper
{
    public function getUserId()
    {
        if (Auth::guard('sanctum')->check()) {
            return Auth::guard('sanctum')->id();
        }

        if (session()->has('id')) {
            return session('id');
        }
    }
}
