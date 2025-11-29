<?php

namespace App\Http\Controllers\web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;

class LoginController extends Controller
{
    public function login(LoginService $service , LoginRequest $request )
    {
        if($user = $service->login($request))
        {
            return $user->user_as === "admin" ?
                redirect()->route('admin.index') : ($user->user_as === "teacher" ?
                redirect()->route('teacher.index') : redirect()->route('student.index'));
        }

        return back()->with('error','Invalid Incredientials !');
    }
}
