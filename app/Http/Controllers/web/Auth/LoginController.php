<?php

namespace App\Http\Controllers\web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function __invoke(LoginRequest $request )
    {
        if(Auth::attempt($request->only('email','password'),$request->remember_me))
        {
            Auth::logoutOtherDevices($request->password);
            $request->session()->regenerate();

            return Auth::user()->user_as === "admin" ?
                redirect()->route('admin.index') : (Auth::user()->user_as === "teacher" ?
                redirect()->route('teacher.index') : redirect()->route('student.index'));
        }

        return back()->with('error','Invalid Incredientials !');
    }
}
