<?php

namespace App\Services\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginService {

    public function login($request)
    {
        if(Auth::attempt($request->only('email','password')))
        {
            Auth::logoutOtherDevices($request->password);
            $request->session()->regenerate();
            return User::where('email',$request->email)->first();
        }
    }
}
