<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\HomeworkService;
use App\Http\Requests\student\storeHomeworkSolutions;
use App\Http\Resources\
{
    HomeworkResource,
    SolutionStudentForHomeworkResource,
};

class HomeworkApiController extends Controller
{
    public function __construct(protected HomeworkService $homework)
    {
    }
    public function index($class, $subject)
    {
        $homeworks = $this->homework->index($class,$subject);
        if($homeworks->isEmpty()){
            return response()->json([
                'status'  => 'failed',
                'message' => 'No homeworks found!',
            ],404);
        }

        return response()->json([
            'status'      => 'success',
            'homeworks'   => HomeworkResource::collection($homeworks),
        ],200);
    }

    public function storeSolution(storeHomeworkSolutions $request,$homeworkId)
    {
        $saved = $this->homework->storeSolution($request->validated(),$homeworkId);
        if(!$saved){
            return response()->json([
                'status'  => 'failed',
                'message' => __('messages.no_more_upload_solution')
            ],400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => __('messages.success_store_homework_solution')
        ],201);
    }

    public function showGrade($homeworkId)
    {
        $homeworkDetails = $this->homework->showGrade($homeworkId);
        if(!$homeworkDetails){
            return response()->json([
                'status'  => 'failed',
                'message' => __('messages.no_assessment')
            ],404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => new SolutionStudentForHomeworkResource($homeworkDetails)
        ],200);
    }
}
