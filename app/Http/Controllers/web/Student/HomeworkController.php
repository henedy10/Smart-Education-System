<?php

namespace App\Http\Controllers\web\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\student\storeHomeworkSolutions;
use App\Services\Student\HomeworkService;

class HomeworkController extends Controller
{
    public function __construct(protected HomeworkService $homework) {}

    public function index($class, $subject)
    {
        $homeworks = $this->homework->index($class, $subject);

        return view('student.show_homework', compact(
            'subject',
            'class',
            'homeworks',
        ));
    }

    public function createSolution($class, $subject, $homeworkId)
    {
        return view('student.show_homework_uploading', compact(
            'homeworkId',
            'class',
            'subject',
        ));
    }

    public function storeSolution(storeHomeworkSolutions $request)
    {
        $saved = $this->homework->storeSolution($request);
        if ($saved) {
            return redirect()->back()->with(['success' => __('messages.success_store_homework_solution')]);
        }

        return redirect()->back()->with(['failed' => __('messages.no_more_upload_solution')]);
    }

    public function showGrade($class, $subject, $homeworkId)
    {
        $homeworkDetails = $this->homework->showGrade($homeworkId);

        return view('student.show_homework_grade', compact(
            'class',
            'subject',
            'homeworkDetails',
        ));
    }
}
