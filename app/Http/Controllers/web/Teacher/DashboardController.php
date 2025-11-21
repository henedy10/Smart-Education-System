<?php

namespace App\Http\Controllers\web\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Teacher\DashboardService;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboard)
    {
        $teacher = $dashboard->index();
        return view('teacher.show_teacher',compact('teacher'));
    }
}
