<?php

namespace App\Http\Controllers\web\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\teacher\homeworks\
{
    storeHomework,
    storeHomeworkGrades,
    updateHomeworkGrades,
};
use App\Services\Teacher\HomeworkService;

class HomeworkController extends Controller
{
    public function __construct(protected HomeworkService $homework)
    {
    }

    public function showAction($TeacherId)
    {
        return view('teacher.choose_action_homework',compact('TeacherId'));
    }

    public function indexHomework($TeacherId)
    {
        $homeworks = $this->homework->indexHomework($TeacherId);
        return view('teacher.correcting_homework',compact('TeacherId','homeworks'));
    }

    public function createHomework($TeacherId)
    {
        return view('teacher.create_homework',compact('TeacherId'));
    }

    public function storeHomework(storeHomework $request, $TeacherId)
    {
        $this->homework->storeHomework($request->validated(),$TeacherId);
        return redirect()->back()->with(['success' => __('messages.success_store_homework')]);
    }

    public function indexSolution($TeacherId)
    {
        $solutions = $this->homework->indexSolution(request()->homework_id);
        return view('teacher.show_solutions_homework',compact('TeacherId','solutions'));
    }

    public function storeHomeworkGrades(storeHomeworkGrades $request, $StudentId)
    {
        $this->homework->storeHomeworkGrade($request->validated(),$StudentId);
        return redirect()->back()->with(['success' => __('messages.success_store_homework_grade')]);
    }

    public function updateHomeworkGrade(updateHomeworkGrades $request, $StudentId)
    {
        $this->homework->updateHomeworkGrade($request->validated(),$StudentId);
        return redirect()->back()->with(['success' => __('messages.success_update_homework_grade')]);
    }
}
