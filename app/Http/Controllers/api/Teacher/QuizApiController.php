<?php

namespace App\Http\Controllers\api\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Teacher\QuizService;
use App\Http\Requests\teacher\quizzes\storeQuiz;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizResultResource;
use Illuminate\Http\Request;

class QuizApiController extends Controller
{
    public function storeQuiz(storeQuiz $request, $TeacherId, QuizService $quiz)
    {
        $quiz->create($request,$TeacherId);
        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_store_quiz')
        ],201);
    }

    public function indexResults($TeacherId , QuizService $quiz)
    {
        $quizzes = $quiz->getAll($TeacherId);
        if($quizzes->count()>0){
            return response()->json([
                'status' => 'Success',
                'data'   => QuizResource::collection($quizzes)
            ],200);
        }

        return response()->json([
            'status' => 'Failed',
            'message' => __('messages.no_results')
        ],404);
    }

    public function showResult($TeacherId,$QuizID, QuizService $quiz)
    {
        $results = $quiz->getResults($QuizID);
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
