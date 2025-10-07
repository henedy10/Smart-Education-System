<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\QuizService;

class QuizController extends Controller
{
    public function showAction($class,$subject)
    {
        return view('student.show_action_content_quiz',compact('class','subject'));
    }

    public function showAvailableQuiz($class, $subject, QuizService $quiz)
    {
        $quiz = $quiz->showAvailableQuiz($class,$subject);

        return view('student.show_quiz',[
            'quiz'      =>  $quiz,
            'class'     =>  $class,
            'subject'   =>  $subject
        ]);
    }

    public function showQuizContent($class, $subject, QuizService $content)
    {
        $content = $content->showContentQuiz($class,$subject);
        $quiz    = $content['quiz'];
        $options = $content['options'];

        if($quiz->count() == 0)
        {
            return redirect()->back()->withErrors(['quiz' => __('messages.no_quiz')]);
        }

        return view('student.show_content_quiz',compact(
            'quiz',
            'options',
            'class',
            'subject',
        ));
    }

    public function storeAnswer($class, $subject, QuizService $quiz)
    {
        $info        = $quiz->storeAnswer($class,$subject);
        $student     = $info['student'];
        $quiz        = $info['quiz'];
        $studentMark = $info['studentMark'];

        return view('student.show_result',compact('student','quiz','studentMark','class','subject'));
    }

    public function showResults($class, $subject, QuizService $result)
    {
        $results = $result->showResult($class,$subject);
        return view('student.show_quiz_results',compact('class','subject','results'));
    }
}
