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
        $user           = User::firstWhere('id',$this->getUserId());
        $count_teachers = Teacher::count();
        $count_students = Student::count();
        $lastModified   =  max($user->updated_at , Teacher::pluck('updated_at')->max(),Student::pluck('updated_at')->max());

        return
        [
            'userId'         =>  $this->getUserId(),
            'user'           =>  $user,
            'count_teachers' =>  $count_teachers,
            'count_students' =>  $count_students,
            'last_modified'  =>  $lastModified,
        ];
    }
}
