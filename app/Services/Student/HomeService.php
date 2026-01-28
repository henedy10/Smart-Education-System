<?php

namespace App\Services\Student;

use App\Traits\UserHelper;
use App\Models\
{
    Teacher,
    Student,
};

class HomeService
{
    use UserHelper;

    public function index()
    {
        $userId  = $this->getUserId();
        $student = Student::whereHas('user',function($q) use($userId){
            $q->select('name')->where('id',$userId);
        })->first();
        $teachers = Teacher::with('user')->where('class',$student->class)->cursor();

        return
        [
            'student'  => $student,
            'teachers' => $teachers,
        ];
    }
}
