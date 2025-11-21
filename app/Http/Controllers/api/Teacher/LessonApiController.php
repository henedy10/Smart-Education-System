<?php

namespace App\Http\Controllers\api\Teacher;

use App\Services\Teacher\LessonService;
use App\Http\Controllers\Controller;
use App\Http\Requests\teacher\lessons\storeLesson;
use App\Http\Resources\LessonResource;

class LessonApiController extends Controller
{
    public function __construct(protected LessonService $lesson)
    {
    }

    public function index($TeacherId)
    {
        $lessons = $this->lesson->index($TeacherId);

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

    public function store(storeLesson $request,$TeacherId)
    {
        $this->lesson->store($request->validated(),$TeacherId);

        return response()->json([
            'status'  => 'Success',
            'message' =>  __('messages.success_store_lesson')
        ],201);
    }
}
