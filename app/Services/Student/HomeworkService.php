<?php

namespace App\Services\Student;

use App\Models\Homework;
use App\Models\SolutionStudentForHomework;
use App\Models\Student;
use App\Traits\UploadFile;
use App\Traits\UserHelper;

class HomeworkService
{
    use UploadFile,UserHelper;

    public function index($class, $subject)
    {
        $homeworks = Homework::whereHas('teacher', function ($q) use ($class, $subject) {
            $q->where('class', $class)->where('subject', $subject);
        })->get();

        return $homeworks;
    }

    public function storeSolution($request, $homeworkId)
    {
        $student = Student::with('user')->firstWhere('user_id', $this->getUserId());
        $alreadyUploaded = SolutionStudentForHomework::where('student_id', $student->id)
            ->where('homework_id', $homeworkId)
            ->exists();

        if ($alreadyUploaded || is_null($alreadyUploaded)) {
            return false;
        }

        $filePath = $this->uploadFile($student->user->name, $request->file);
        $solution = SolutionStudentForHomework::create([
            'homework_solution_file' => $filePath,
            'student_id' => $student->id,
            'homework_id' => $homeworkId,
        ]);

        return $solution;
    }

    public function showGrade($homeworkId)
    {
        $studentId = Student::where('user_id', $this->getUserId())->value('id');
        $Grade = SolutionStudentForHomework::with('homeworkGrade')
            ->where('student_id', $studentId)
            ->where('homework_id', $homeworkId)
            ->first();

        return $Grade;
    }
}
