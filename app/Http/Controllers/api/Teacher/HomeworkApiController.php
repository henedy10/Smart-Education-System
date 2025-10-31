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
use App\Http\Resources\HomeworkResource;
use App\Http\Resources\SolutionStudentForHomeworkResource;
use Illuminate\Http\Request;

class HomeworkApiController extends Controller
{
    public function indexHomework($TeacherId, HomeworkService $homework)
    {
        $homeworks = $homework->indexHomework($TeacherId);

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

    public function storeHomework(storeHomework $request, $TeacherId, HomeworkService $homework)
    {
        $homework = $homework->storeHomework($request,$TeacherId);

        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_store_homework')
        ],201);
    }

    public function indexSolution($homeworkId , $TeacherId, HomeworkService $solution)
    {
        $solutions = $solution->indexSolution($homeworkId);
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

    public function storeHomeworkGrades(storeHomeworkGrades $request, $StudentId, HomeworkService $grade)
    {
        $grade->storeHomeworkGrade($request,$StudentId);
        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_store_homework_grade')
        ],201);
    }

    public function updateHomeworkGrade(updateHomeworkGrades $request, $StudentId, HomeworkService $grade)
    {
        $grade->updateHomeworkGrade($request,$StudentId);
        return response()->json([
            'status'  => 'Success',
            'message' => __('messages.success_update_homework_grade')
        ],200);
    }
}
