<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\ApiResponse;

class LoginApiController extends Controller
{
    use ApiResponse;
    public function __invoke(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email','password'),$request->remember_me))
        {
            $user = User::where('email',$request->email)->first();
            $user->tokens()->delete();
            $authToken = $user->createToken('authToken',['*'],now()->addWeek())->plainTextToken;
            $data = [
                'user'      => new UserResource($user),
                'authToken' => $authToken
            ];

            return $this->success($data,"Success",200);
        }

        return $this->error('Invalid Incredientials !',null,404) ;
    }
}
