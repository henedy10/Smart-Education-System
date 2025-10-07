<?php

namespace App\Services\Student;

use App\Traits\UserHelper;
use App\Models\
{
    Homework,
    Student,
    SolutionStudentForHomework,
};

class HomeworkService
{
    use UserHelper;

    public function index($class,$subject)
    {
        $homeworks = Homework::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })->get();

        return $homeworks;
    }

    public function createSolution($homeworkId)
    {
        $userId          = $this->getUserId();
        $studentId       = Student::where('user_id',$userId)->value('id');
        $alreadyUploaded = SolutionStudentForHomework::where('student_id',$studentId)
                                                    ->where('homework_id',$homeworkId)
                                                    ->exists();

        return [
            'alreadyUploaded' => $alreadyUploaded,
            'homework_id'     => $homeworkId,
        ];
    }

    public function storeSolution($request)
    {
        $userId      = $this->getUserId();
        $student     = Student::with('user')->firstWhere('user_id',$userId);
        $homeworkId  = $request->homework_id;
        $fileName    = $student->user->name.'.'.$request->file('file')->getClientOriginalExtension();
        $filePath    = $request->file('file')->storeAs('solutions_homework',$fileName,'public');

        $solution    = SolutionStudentForHomework::create([
            'homework_solution_file'  => $filePath,
            'student_id'              => $student->id,
            'homework_id'             => $homeworkId,
        ]);

        return $solution;
    }

    public function showGrade($homeworkId)
    {
        $userId          = $this->getUserId();
        $studentId       = Student::where('user_id',$userId)->value('id');
        $Grade           = SolutionStudentForHomework::with('homeworkGrade')
                                                    ->where('student_id',$studentId)
                                                    ->where('homework_id',$homeworkId)
                                                    ->first();

        return $Grade;
    }
}
