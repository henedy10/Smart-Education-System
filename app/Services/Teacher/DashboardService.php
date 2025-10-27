<?php

namespace App\Services\Teacher;
use App\Traits\UserHelper;
use App\Models\Teacher;

class DashboardService
{
    use UserHelper;
    public function index()
    {
        $userId    = $this->getUserId();
        $dashboard = Teacher::where('user_id',$userId)
                        ->withCount('lessons','homeworks','quizzes')
                        ->first();

        return $dashboard;
    }
}
