<?php

namespace App\Http\Controllers\web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;

class DashboardController extends Controller
{
    public function index(DashboardService $Service)
    {
        $info           = $Service->index();
        $dashboard      = $info['user'];
        $count_teachers = $info['count_teachers'];
        $count_students = $info['count_students'];

        return view('admin.dashboard' , compact('dashboard','count_teachers','count_students'));
    }
}
