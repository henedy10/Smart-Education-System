<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\SendPasswordResetLinkMail;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function Symfony\Component\Clock\now;

class ForgotPasswordApiController extends Controller
{
    use ApiResponse;

    public function __invoke(ForgotPasswordRequest $request)
    {
        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token , 'created_at' => now()]
        );

        Mail::to($request->email)->send(new SendPasswordResetLinkMail($token));

        return $this->success(null,'We have sent you an email with the reset link',200);
    }
}
