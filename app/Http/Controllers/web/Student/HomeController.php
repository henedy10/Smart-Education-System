<?php

namespace App\Http\Controllers\web\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\HomeService;

class HomeController extends Controller
{
    public function index(HomeService $info)
    {
        $info = $info->index();
        return view('student.show_student',compact('info'));
    }

    public function showContent($class,$subject)
    {
        return view('student.show_content',compact('class','subject'));
    }
}
