<?php

namespace App\Http\Controllers\api\Teacher;

use App\Services\Teacher\LessonService;
use App\Http\Controllers\Controller;
use App\Http\Requests\teacher\lessons\storeLesson;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonApiController extends Controller
{
    public function index($TeacherId, LessonService $lesson)
    {
        $lessons = $lesson->index($TeacherId);
        if($lessons->count() > 0){
            return response()->json([
                'status' => 'Success',
                'data'   => LessonResource::collection($lessons),
            ],200);
        }

        return response()->json([
            'status'   => 'Failed',
            'messages' => __('messages.no_lesson'),
        ],404);
    }

    public function store(storeLesson $request , $TeacherId, LessonService $lesson)
    {
        $lesson->store($request,$TeacherId);
        return response()->json([
            'status'  => 'Success',
            'message' =>  __('messages.success_store_lesson')
        ],201);
    }
}
