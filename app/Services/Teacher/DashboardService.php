<?php

namespace App\Services\Teacher;

use App\Models\Teacher;
use App\Traits\UserHelper;

class DashboardService
{
    use UserHelper;

    public function index()
    {
        $dashboard = Teacher::with('user')->where('user_id', $this->getUserId())
            ->withCount('lessons', 'homeworks', 'quizzes')
            ->first();

        return $dashboard;
    }
}
