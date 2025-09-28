<?php

namespace App\Services\Teacher;

use App\Models\Lesson;

class LessonService
{
    public function index($TeacherId)
    {
        $lessons = Lesson::where('teacher_id',$TeacherId)->get();
        return $lessons;
    }

    public function store($request, $TeacherId)
    {
        $fileName     = $request->title_lesson . '.' . request()->file('file_lesson')->getClientOriginalExtension();
        $filePath     = $request->file('file_lesson')->storeAs('lessons',$fileName,'public');
        $title_lesson = $request->title_lesson;

        $lesson = Lesson::create([
            'teacher_id'   => $TeacherId,
            'file_lesson'  => $filePath,
            'title_lesson' => $title_lesson,
        ]);

        return $lesson;
    }
}
