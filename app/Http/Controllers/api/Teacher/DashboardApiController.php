<?php

namespace App\Http\Controllers\api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Services\Teacher\DashboardService;

class DashboardApiController extends Controller
{
    public function index(DashboardService $dashboard)
    {
        $teacher = $dashboard->index();
        return response()->json([
            'status' => 'Success',
            'data'   => new TeacherResource($teacher)
        ],200);
    }
}
