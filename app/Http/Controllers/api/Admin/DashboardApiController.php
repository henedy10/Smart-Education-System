<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index(DashboardService $Service)
    {
        $info           = $Service->index();
        $dashboard      = $info['dashboard'];
        $count_teachers = $info['count_teachers'];
        $count_students = $info['count_students'];

        return response()->json([
            'status'         => 'Success',
            'data'           => $dashboard,
            'count_teachers' => $count_teachers,
            'count_students' => $count_students
        ],200);
    }
}
