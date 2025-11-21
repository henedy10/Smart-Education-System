<?php

namespace App\Http\Controllers\api\Student;
use App\Services\Student\LessonService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;

class LessonApiController extends Controller
{
    public function index($class,$subject,LessonService $lesson)
    {
        $lessons = $lesson->index($class,$subject);

        if($lessons->isEmpty()){
            return response()->json([
                'status' => 'failed',
                'msg'    => 'No lessons found!'
            ],404)->header('Content-Type','application/json');
        }

        $data =
        [
            'status'    => 'success',
            'lessons'   => LessonResource::collection($lessons),
        ];

        $etag = md5(json_encode($data));

        return response()->json($data,200)
                ->header('Content-Type','application/json')
                ->header('ETag',$etag)
                ->header('Last-Modified',0);
    }
}
