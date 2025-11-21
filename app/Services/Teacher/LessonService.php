<?php

namespace App\Services\Teacher;

use App\Models\Lesson;

class LessonService
{
    public function uploadFile($title,$file)
    {
        $fileName = $title . '.' . request()->file('file_lesson')->getClientOriginalExtension();
        $filePath = $file->storeAs('lessons',$fileName,'public');

        return $filePath;
    }

    public function index($TeacherId)
    {
        $lessons = Lesson::where('teacher_id',$TeacherId)->get();
        return $lessons;
    }

    public function store($data, $TeacherId)
    {
        $filePath = $this->uploadFile($data['title_lesson'],$data['file_lesson']);
        $lesson   = Lesson::create([
                'teacher_id'   => $TeacherId,
                'file_lesson'  => $filePath,
                'title_lesson' => $data['title_lesson'],
        ]);

        return $lesson;
    }
}
