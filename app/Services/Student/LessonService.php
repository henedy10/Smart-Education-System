<?php

namespace App\Services\Student;

use App\Models\Lesson;

class LessonService
{
    public function index($class,$subject)
    {
        $lessons = Lesson::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })->get();

        return $lessons;
    }
}
