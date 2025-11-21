<?php

namespace App\Http\Controllers\api\Student;

use App\Services\Student\QuizService;
use App\Http\Controllers\Controller;
use App\Http\Resources\
{
    QuizResource,
    QuizResultResource,
    StudentResource
};

class QuizApiController extends Controller
{
    public function __construct(protected QuizService $quiz)
    {
    }

    public function showAvailableQuiz($class, $subject)
    {
        $quiz = $this->quiz->showAvailableQuiz($class,$subject);

        if($quiz){
            return response()->json([
                'status' => 'success',
                'data'   => new QuizResource($quiz)
            ],200);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => __('messages.no_quiz'),
        ],404);
    }

    public function showQuizContent($class, $subject)
    {
        $content = $this->quiz->showContentQuiz($class,$subject);

        if(!$content['quiz'])
        {
            return response()->json([
                'status'   => 'failed',
                'message'  => __('messages.no_quiz'),
            ],404);
        }

        return response()->json([
            'status'  => 'success',
            'quiz'    => new QuizResource($content['quiz']),
        ],200);
    }

    public function storeAnswer($class, $subject)
    {
        $info = $this->quiz->storeAnswer($class,$subject);

        if($info['quiz']){
            return response()->json([
                'status'      => 'success',
                'student'     => new StudentResource($info['student']),
                'quiz'        => new QuizResource($info['quiz']),
                'studentMark' => $info['studentMark']
            ],201);
        }

        return response()->json([
            'status'      => 'failed',
            'message'     => __('messages.no_quiz')
        ],404);
    }

    public function indexResult($class, $subject)
    {
        $results = $this->quiz->indexResult($class,$subject);

        if($results->count() > 0){
            return response()->json([
                'status'  => 'success',
                'results' => QuizResultResource::collection($results)
            ],200);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => __('messages.no_results')
        ],404);
    }
}
