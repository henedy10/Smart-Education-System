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
    public function uploadFile($title,$file)
    {
        $fileName = $title . '.' . request()->file('file_homework')->getClientOriginalExtension();
        $filePath = $file->storeAs('homeworks',$fileName,'public');

        return $filePath;
    }

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

    public function storeHomework($data,$TeacherId)
    {
        $filePath = $this->uploadFile($data['title_homework'] , $data['file_homework']);
        $homework = Homework::create([
                                        'teacher_id'        => $TeacherId,
                                        'title_homework'    => $data['title_homework'],
                                        'file_homework'     => $filePath,
                                        'content_homework'  => $data['content_homework'],
                                        'deadline'          => $data['deadline_homework'],
                                        'homework_mark'     => $data['homework_mark'],
                                    ]);

        return $homework;
    }

    public function storeHomeworkGrade($data,$StudentId)
    {
        $Grade = HomeworkGrade::create([
                                        'student_id'    => $StudentId,
                                        'solution_id'   => $data['solution_id'],
                                        'student_mark'  => $data['student_mark'],
                                        'homework_id'   => $data['homework_id'],
                                    ]);
                                    
        SolutionStudentForHomework::where('student_id',$StudentId)
                                    ->where('homework_id',$data['homework_id'])
                                    ->update(['correction_status' => true]);

        return $Grade;
    }

    public function updateHomeworkGrade($data,$StudentId)
    {
        $Grade = HomeworkGrade::where('student_id',$StudentId)
                                    ->where('homework_id',$data['homework_id'])
                                    ->update(['student_mark' => $data['student_mark']]);

        return $Grade;
    }
}
