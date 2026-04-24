<?php

namespace App\Http\Controllers\web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request)
    {
        $result = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $result) {
            return back()->with('error', 'Invalid token or email address !');
        }

        $tokenExpire = 60;
        $tokenCreatedAt = Carbon::parse($result->created_at);
        $diffInMinutes = $tokenCreatedAt->diffInMinutes(Carbon::now());
        if ($diffInMinutes > $tokenExpire) {
            return back()->with('error', 'Token expired !');
        }

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        return redirect()->route('index')->with('success', 'Password reset successfully, you can login now');
    }
}
