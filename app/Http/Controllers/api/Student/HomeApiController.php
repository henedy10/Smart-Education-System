<?php

namespace App\Http\Controllers\api\Student;

use App\Http\Controllers\Controller;
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
                'teachers'  =>  $teachers
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'There is no content now !'
        ],404);
    }


    public function showContent($class,$subject)
    {
        return response()->json([
            __('messages.lessons')    =>  __('messages.lesson_msg'),
            __('messages.homeworks')  =>  __('messages.homework_msg'),
            __('messages.quizzes')    =>  __('messages.quiz_msg')
        ],200);
    }
}
