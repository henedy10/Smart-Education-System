<?php

namespace App\Services\Teacher;

use App\Models\
{
    Homework,
    SolutionStudentForHomework,
    HomeworkGrade,
};

class HomeworkService
{
    public function indexHomework($TeacherId)
    {
        $homeworks = Homework::where('teacher_id',$TeacherId)->get();
        return $homeworks;
    }

    public function indexSolution($homeworkId)
    {
        $solutions = SolutionStudentForHomework::with('student')->where('homework_id',$homeworkId)->get();
        return $solutions;
    }

    public function storeHomework($request,$TeacherId)
    {
        $fileName = $request->title_homework . '.' . request()->file('file_homework')->getClientOriginalExtension();
        $filePath = $request->file('file_homework')->storeAs('homeworks',$fileName,'public');
        $homework = Homework::create([
                                        'teacher_id'        => $TeacherId,
                                        'title_homework'    => $request->title_homework,
                                        'file_homework'     => $filePath,
                                        'content_homework'  => $request->content_homework,
                                        'deadline'          => $request->deadline_homework,
                                        'homework_mark'     => $request->homework_mark,
                                    ]);

        return $homework;
    }

    public function storeHomeworkGrade($request,$StudentId)
    {
        $student_mark = $request->student_mark;
        $homeworkId   = $request->homework_id;
        $solutionId   = $request->solution_id;
        $Grade        = HomeworkGrade::create([
                                        'student_id'    => $StudentId,
                                        'solution_id'   => $solutionId,
                                        'student_mark'  => $student_mark,
                                        'homework_id'   => $homeworkId,
                                    ]);
        $correctionStatus = SolutionStudentForHomework::where('student_id',$StudentId)
                                                    ->where('homework_id',$homeworkId)
                                                    ->first();
        $correctionStatus->update(['correction_status' => true]);

        return $Grade;
    }

    public function updateHomeworkGrade($request,$StudentId)
    {
        $homeworkId   = $request->homework_id;
        $student_mark = $request->student_mark;
        $Grade        = HomeworkGrade::where('student_id',$StudentId)
                                    ->where('homework_id',$homeworkId)
                                    ->first();
        $Grade->update(['student_mark' => $student_mark]);

        return $Grade;
    }
}
