<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(HomeService $info)
    {
        $info     = $info->index();
        $student  = $info['student'];
        $teachers = $info['teachers'];

        return view('student.show_student',compact('student','teachers'));
    }

    public function showContent($class,$subject)
    {
        return view('student.show_content',compact('class','subject'));
    }
}
