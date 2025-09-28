<?php

namespace App\Services\Teacher;

use App\Models\Teacher;

class DashboardService
{
    public function index()
    {
        $userId    = session('id');
        $dashboard = Teacher::where('user_id',$userId)
                        ->withCount('lessons','homeworks','quizzes')
                        ->first();

        return $dashboard;
    }
}
