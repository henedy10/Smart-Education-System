<?php

namespace App\Http\Controllers\Teacher;

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
    public function showAction($TeacherId)
    {
        return view('teacher.choose_action_homework',compact('TeacherId'));
    }

    public function indexHomework($TeacherId, HomeworkService $homework)
    {
        $homeworks = $homework->indexHomework($TeacherId);
        return view('teacher.correcting_homework',compact('TeacherId','homeworks'));
    }

    public function createHomework($TeacherId)
    {
        return view('teacher.create_homework',compact('TeacherId'));
    }

    public function storeHomework(storeHomework $request, $TeacherId, HomeworkService $homework)
    {
        $homework = $homework->storeHomework($request,$TeacherId);
        return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
    }

    public function indexSolution($TeacherId,HomeworkService $solution)
    {
        $solutions = $solution->indexSolution(request()->homework_id);
        return view('teacher.show_solutions_homework',compact('TeacherId','solutions'));
    }

    public function storeHomeworkGrades(storeHomeworkGrades $request, $StudentId, HomeworkService $grade)
    {
        $grade->storeHomeworkGrade($request,$StudentId);
        return redirect()->back()->with('success','تم تصحيح هذا الواجب بنجاح');
    }

    public function updateHomeworkGrade(updateHomeworkGrades $request, $StudentId, HomeworkService $grade)
    {
        $grade->updateHomeworkGrade($request,$StudentId);
        return redirect()->back()->with('success','تم تعديل درجه هذا الواجب بنجاح');
    }
}
