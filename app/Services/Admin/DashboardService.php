<?php

namespace App\Services\Admin;
use App\Models\
{
    Student,
    Teacher,
    User,
};

class DashboardService
{
    public function index()
    {
        $userId         = session('id');
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
