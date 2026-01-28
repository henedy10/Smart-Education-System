<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LogoutApiController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null,'Logged out successfully!',200);
    }
}
