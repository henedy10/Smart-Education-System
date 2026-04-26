<?php

namespace App\Http\Controllers\web\Auth;

use App\DTOs\Auth\ResetPasswordDTO;
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
        $dto = ResetPasswordDTO::fromRequest($request);
        $result = DB::table('password_reset_tokens')
            ->where('email', $dto->email)
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
            ->where('email', $dto->email)
            ->delete();

        User::where('email', $dto->email)->update(['password' => Hash::make($dto->password)]);

        return redirect()->route('index')->with('success', 'Password reset successfully, you can login now');
    }
}
