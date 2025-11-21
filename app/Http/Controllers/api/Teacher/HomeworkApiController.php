<?php

namespace App\Http\Controllers\api\Teacher;
use App\Http\Requests\teacher\homeworks\
{
    storeHomework,
    storeHomeworkGrades,
    updateHomeworkGrades,
};
use App\Services\Teacher\HomeworkService;
use App\Http\Controllers\Controller;
use App\Http\Resources\
{
    HomeworkResource,
    SolutionStudentForHomeworkResource
};

class HomeworkApiController extends Controller
{
    public function __construct(protected HomeworkService $homework)
    {
    }

    public function indexHomework($TeacherId)
    {
        $homeworks = $this->homework->indexHomework($TeacherId);

        if($homeworks->count() > 0){
            return response()->json([
                'status' => 'Success',
                'data'   => HomeworkResource::collection($homeworks)
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => __('messages.no_homework')
        ],404);
    }

    public function storeHomework(storeHomework $request, $TeacherId)
    {
        $this->homework->storeHomework($request,$TeacherId);

        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_store_homework')
        ],201);
    }

    public function indexSolution($homeworkId)
    {
        $solutions = $this->homework->indexSolution($homeworkId);
        if($solutions->count() > 0){
            return response()->json([
                'status'    => 'Success',
                'solutions' => SolutionStudentForHomeworkResource::collection($solutions)
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => __('messages.no_homeworkSolutions')
        ],404);
    }

    public function storeHomeworkGrades(storeHomeworkGrades $request, $StudentId)
    {
        $this->homework->storeHomeworkGrade($request,$StudentId);
        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_store_homework_grade')
        ],201);
    }

    public function updateHomeworkGrade(updateHomeworkGrades $request, $StudentId)
    {
        $this->homework->updateHomeworkGrade($request,$StudentId);
        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_update_homework_grade')
        ],200);
    }
}
