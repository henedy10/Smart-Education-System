<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Teacher\QuizService;
use App\Http\Requests\teacher\quizzes\storeQuiz;

class QuizController extends Controller
{
    public function createQuiz($TeacherId){
        return view('teacher.create_quiz',compact('TeacherId'));
    }

    public function storeQuiz(storeQuiz $request, $TeacherId, QuizService $quiz)
    {
        $quiz->create($request,$TeacherId);
        return redirect()->back()->with('success','تم عمل اختبار جديد بنجاح ');
    }

    public function showQuiz($TeacherId , QuizService $quiz)
    {
        $quizzes = $quiz->getAll($TeacherId);
        return view('teacher.show_results',compact('TeacherId','quizzes'));
    }

    public function showResult($TeacherId, QuizService $quiz)
    {
        $results = $quiz->getResults(request()->quiz_id);
        return view('teacher.show_content_results',compact('TeacherId','results'));
    }
}
