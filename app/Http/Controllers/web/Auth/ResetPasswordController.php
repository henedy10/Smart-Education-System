<?php

namespace App\Http\Controllers\web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\
{
    DB,
    Hash
};
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request)
    {
        $result = DB::table('password_reset_tokens')
            ->where('token',$request->token)
            ->where('email',$request->email)
            ->first();

        if(!$result){
            return back()->with('error','Invalid token or email address !');
        }

        DB::table('password_reset_tokens')
            ->where('email',$request->email)
            ->delete();

        User::where('email',$request->email)->update(['password' => Hash::make($request->password)]);

        return redirect()->route('index')->with('success' ,'Password reset successfully, you can login now');
    }
}
