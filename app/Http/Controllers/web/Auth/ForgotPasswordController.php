<?php

namespace App\Http\Controllers\web\Auth;

use App\DTOs\Auth\ForgetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\SendPasswordResetLinkMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request)
    {
        $token = Str::random(60);
        $dto = ForgetPasswordDTO::fromRequest($request);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $dto->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($dto->email)->send(new SendPasswordResetLinkMail($token));

        return back()->with('success', 'We have sent you an email with the reset link');

    }
}
