<?php

namespace App\Http\Controllers\web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;

class DashboardController extends Controller
{
    public function index(DashboardService $Service)
    {
        $info = $Service->index();
        return view('admin.dashboard' , compact('info'));
    }
}
