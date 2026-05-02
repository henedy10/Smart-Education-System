<?php

namespace App\Http\Controllers\web\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Services\AI\GeminaiService;
use App\Services\Student\LessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(string $class, string $subject, LessonService $lesson)
    {
        $lessons = $lesson->index($class, $subject);

        return view('student.show_lesson', compact('class', 'subject', 'lessons'));
    }

    public function analysisByAI(Request $request, GeminaiService $geminaiService)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $lesson = Lesson::findOrFail($request->lesson_id);

        if (!$lesson->file_lesson) {
            return response()->json(['error' => 'No file associated with this lesson.'], 400);
        }

        $filePath = $lesson->file_lesson;
        // Check if file exists in public disk
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'File not found on server.'], 404);
        }

        $mimeType = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($filePath);

        $summary = $geminaiService->summarize($filePath, $mimeType);

        return response()->json(['summary' => $summary]);
    }
}
