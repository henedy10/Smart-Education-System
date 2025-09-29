<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\LessonService;

class LessonController extends Controller
{
    public function index($class,$subject,LessonService $lesson)
    {
        $lessons = $lesson->index($class,$subject);
        return view('student.show_lesson',compact('class','subject','lessons'));
    }
}
