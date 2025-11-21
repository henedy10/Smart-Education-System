<?php

namespace App\Http\Controllers\api\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Teacher\QuizService;
use App\Http\Requests\teacher\quizzes\storeQuiz;
use App\Http\Resources\
{
    QuizResource,
    QuizResultResource
};

class QuizApiController extends Controller
{
    public function __construct(protected QuizService $quiz)
    {
    }

    public function storeQuiz(storeQuiz $request,$TeacherId)
    {
        $this->quiz->store($request->validated(),$TeacherId);

        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_store_quiz')
        ],201);
    }

    public function indexResults($TeacherId)
    {
        $quizzes = $this->quiz->getAll($TeacherId);

        if($quizzes->count()>0){
            return response()->json([
                'status' => 'Success',
                'data'   => QuizResource::collection($quizzes)
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => __('messages.no_results')
        ],404);
    }

    public function showResult($QuizID)
    {
        $results = $this->quiz->getResults($QuizID);
        
        if($results->count()>0){
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
