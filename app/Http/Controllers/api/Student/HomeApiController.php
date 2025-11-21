<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Services\Student\HomeService;

class HomeApiController extends Controller
{
    public function index(HomeService $info)
    {
        $info = $info->index();
        if($info['teachers']->count()>0){
            return response()->json([
                'status'    =>  'Success',
                'student'   =>  $info['student']->user->name,
                'teachers'  =>  TeacherResource::collection($info['teachers'])
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'There is no content now !'
        ],404)->header('Content-Type','application/json');
    }
}
