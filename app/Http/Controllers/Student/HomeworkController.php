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

    public function createSolution($class, $subject)
    {
        $homework_id = request()->upload_homework;
        return view('student.show_homework_uploading',compact
        (
            'homework_id',
            'class',
            'subject',
        ));
    }

    public function storeSolution(storeHomeworkSolutions $request , HomeworkService $solution , $homeworkId)
    {
        $saved = $solution->storeSolution($request,$homeworkId);
        if($saved){
            return redirect()->back()->with(['success' => __('messages.success_store_homework_solution')]);
        }

        return redirect()->back()->with(['failed' => __('messages.no_more_upload_solution')]);
    }

    public function showGrade($class,$subject,HomeworkService $grade,$homeworkId)
    {
        $homeworkDetails = $grade->showGrade($homeworkId);
        return view('student.show_homework_grade',compact
        (
            'class',
            'subject',
            'homeworkDetails',
        ));
    }

}
