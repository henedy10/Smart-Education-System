<?php

namespace App\Http\Controllers\api\lang;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class LanguageApiController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->success(config('lang'));
    }
}
