<?php

namespace App\Http\Controllers\api\Student;

use App\Services\Student\QuizService;
use App\Http\Controllers\Controller;
use App\Http\Resources\OptionResource;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizResultResource;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;

class QuizApiController extends Controller
{
    public function showAvailableQuiz($class, $subject, QuizService $quiz)
    {
        $quiz = $quiz->showAvailableQuiz($class,$subject);

        if($quiz){
            return response()->json([
                'status' => 'Success',
                'data'   => new QuizResource($quiz)
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => __('messages.no_quiz'),
        ],404);
    }

    public function showQuizContent($class, $subject, QuizService $content)
    {
        $content = $content->showContentQuiz($class,$subject);
        $quiz    = $content['quiz'];
        $options = $content['options'];

        if(!$quiz)
        {
            return response()->json([
                'status'   => 'Failed',
                'message'  => __('messages.no_quiz'),
            ],404);
        }

        return response()->json([
            'status'  => 'Success',
            'quiz'    => new QuizResource($quiz),
            'options' => OptionResource::collection($options)
        ],200);
    }

    public function storeAnswer($class, $subject, QuizService $quiz)
    {
        $info        = $quiz->storeAnswer($class,$subject);
        $student     = $info['student'];
        $quiz        = $info['quiz'];
        $studentMark = $info['studentMark'];

        if($quiz){
            return response()->json([
                'status'      => 'Success',
                'dataStudent' => new StudentResource($student),
                'quiz'        => new QuizResource($quiz),
                'studentMark' => $studentMark
            ],201);
        }

        return response()->json([
            'status'      => 'Failed',
            'message'     => __('messages.no_quiz')
        ],404);
    }

    public function indexResult($class, $subject, QuizService $result)
    {
        $results = $result->indexResult($class,$subject);
        if($results->count() > 0){
            return response()->json([
                'status'  => 'Success',
                'results' => QuizResultResource::collection($results)
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => __('messages.no_results')
        ],404);
    }
}
