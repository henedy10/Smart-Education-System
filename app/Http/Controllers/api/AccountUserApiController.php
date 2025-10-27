<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Cookie;
use App\Models\{User};
use App\Http\Requests\account\{login, updatePassword};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountUserApiController extends Controller
{
    public function login(login $request)
    {
        $data = $request->validated();
        $user = User::where('email',$request->email)
                    ->where('password',$request->password)
                    ->first();

        if(is_null($user)){
            return response()->json([
                'status'      => 'failed',
                'data'        => $data,
                'message'     => __('messages.fail_password'),
            ],401)->header('X-Auth-Status' , 'Failed');

        }else{
            $user->tokens()->delete();
            $authToken = $user->createToken('authToken',['*'])->plainTextToken;

            return response()->json([
                'status'          => "Success",
                'message'         => "Login Successfully",
                'data'            =>
                [
                    'username' => $user->name,
                    'email'    => $user->email,
                ],
                'remember_me'     => $request->remember_me ? true : false,
                'authToken'       => $authToken,
            ],200)
            ->header('X-Auth-Status','Success')
            ->header('X-User-Role' , $user->user_as)
            ->header('X-Remember-Me',$request->remember_me ? 'true' : 'false');
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'status'  => "Success" ,
            'message' => "Logged out successfully!",
        ],200)
        ->header('X-Auth-Status' , 'logged_out')
        ->header('X-Logout','true');
    }

    public function updatePassword(updatePassword $request)
    {
        $user = User::firstWhere('email', $request->email);

        $user->update(['password' => $request->NewPassword]);
        return response()->json([
            'success' => true,
            'msg'     => __('messages.success_update_password'),
        ],200)
        ->header('X-Auth-Status','update_password')
        ->header('X-Update-Password' ,'true');
    }
}
