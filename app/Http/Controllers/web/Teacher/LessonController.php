<?php

namespace App\Http\Controllers\web\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\teacher\lessons\storeLesson;
use App\Services\Teacher\LessonService;

class LessonController extends Controller
{
    public function index($TeacherId, LessonService $lesson)
    {
        $lessons = $lesson->index($TeacherId);
        return view('teacher.show_lesson',compact('TeacherId','lessons'));
    }

    public function store(storeLesson $request , $TeacherId, LessonService $lesson)
    {
        $lesson->store($request,$TeacherId);
        return redirect()->back()->with(['success' =>  __('messages.success_store_lesson')]);
    }
}
