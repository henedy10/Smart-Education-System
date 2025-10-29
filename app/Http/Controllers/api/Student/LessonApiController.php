<?php

namespace App\Http\Controllers\api\Student;
use App\Services\Student\LessonService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use Illuminate\Http\Request;

class LessonApiController extends Controller
{
    public function index($class,$subject,LessonService $lesson)
    {
        $lessons = $lesson->index($class,$subject);

        if($lessons->isEmpty()){
            return response()->json([
                'status' => 'Failed',
                'msg'    => 'No lessons found!'
            ],404);
        }

        return response()->json([
            'status'    => 'Success',
            'lessons'   => LessonResource::collection($lessons),
        ],200);
    }
}
