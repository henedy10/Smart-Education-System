<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\HomeworkService;
use App\Http\Requests\student\storeHomeworkSolutions;

class HomeworkController extends Controller
{
    public function index($class, $subject, HomeworkService $homework)
    {
        $homeworks = $homework->index($class,$subject);
        return view('student.show_homework',compact
        (
            'subject',
            'class',
            'homeworks',
        ));
    }

    public function createSolution($class, $subject, HomeworkService $homework)
    {
        $homework        = $homework->createSolution(request()->homework_id);
        $alreadyUploaded = $homework['alreadyUploaded'];
        $homework_id     = $homework['homework_id'];

        return view('student.show_homework_uploading',compact
        (
            'homework_id',
            'class',
            'subject',
            'alreadyUploaded',
        ));
    }

    public function storeSolution(storeHomeworkSolutions $request , HomeworkService $solution)
    {
        $solution->storeSolution($request);
        return redirect()->back()->with(['success' => __('messages.success_store_homework_solution')]);
    }

    public function showGrade($class,$subject,HomeworkService $grade)
    {
        $homeworkDetails = $grade->showGrade(request()->homework_id);
        return view('student.show_homework_grade',compact
        (
            'class',
            'subject',
            'homeworkDetails',
        ));
    }

}
