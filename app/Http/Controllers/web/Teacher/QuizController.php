<?php

namespace App\Http\Controllers\web\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Teacher\QuizService;
use App\Http\Requests\teacher\quizzes\storeQuiz;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quiz)
    {
    }

    public function createQuiz($TeacherId){
        return view('teacher.create_quiz',compact('TeacherId'));
    }

    public function storeQuiz(storeQuiz $request, $TeacherId)
    {
        $this->quiz->store($request->validated(),$TeacherId);
        return redirect()->back()->with(['success' => __('messages.success_store_quiz')]);
    }

    public function showQuiz($TeacherId)
    {
        $quizzes = $this->quiz->getAll($TeacherId);
        return view('teacher.show_results',compact('TeacherId','quizzes'));
    }

    public function showResult($TeacherId,$QuizID)
    {
        $results = $this->quiz->getResults($QuizID);
        return view('teacher.show_content_results',compact('TeacherId','results'));
    }
}
