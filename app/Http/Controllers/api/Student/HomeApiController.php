<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Services\Student\HomeService;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    public function index(HomeService $info)
    {
        $info     = $info->index();
        $student  = $info['student'];
        $teachers = $info['teachers'];

        if($teachers->count()>0){
            return response()->json([
                'status'    =>  'Success',
                'student'   =>  $student->user->name,
                'teachers'  =>  TeacherResource::collection($teachers)
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'There is no content now !'
        ],404);
    }
}
