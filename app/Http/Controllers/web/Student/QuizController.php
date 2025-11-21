<?php

namespace App\Http\Controllers\web\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\QuizService;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quiz)
    {
    }

    public function showAction($class,$subject)
    {
        return view('student.show_action_content_quiz',compact('class','subject'));
    }

    public function showAvailableQuiz($class,$subject)
    {
        $quiz = $this->quiz->showAvailableQuiz($class,$subject);

        return view('student.show_quiz',compact('quiz','class','subject'));
    }

    public function showQuizContent($class,$subject)
    {
        $quiz = $this->quiz->showContentQuiz($class,$subject);
        if($quiz->count() === 0)
        {
            return redirect()->back()->withErrors(['quiz' => __('messages.no_quiz')]);
        }

        return view('student.show_content_quiz',compact('quiz','class','subject'));
    }

    public function storeAnswer($class,$subject)
    {
        $info = $this->quiz->storeAnswer($class,$subject);
        return view('student.show_result',compact('info','class','subject'));
    }

    public function indexResult($class,$subject)
    {
        $results = $this->quiz->indexResult($class,$subject);
        return view('student.show_quiz_results',compact('class','subject','results'));
    }
}
