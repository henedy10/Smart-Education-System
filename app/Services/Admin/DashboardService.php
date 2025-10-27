<?php

namespace App\Services\Admin;
use App\Models\
{
    Student,
    Teacher,
    User,
};
use App\Traits\UserHelper;

class DashboardService
{
    use UserHelper;

    public function index()
    {
        $userId         = $this->getUserId();
        $dashboard      = User::firstWhere('id',$userId);
        $count_teachers = Teacher::count();
        $count_students = Student::count();

        return
        [
            'userId'         =>  $userId,
            'dashboard'      =>  $dashboard,
            'count_teachers' =>  $count_teachers,
            'count_students' =>  $count_students,
        ];
    }
}
