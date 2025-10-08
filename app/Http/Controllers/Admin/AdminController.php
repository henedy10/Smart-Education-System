<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\
{
    Student,
    Teacher,
    User,
};

class AdminController extends Controller
{
    public function index()
    {
        $userId    = session('id');
        $dashboard = User::where('id',$userId)
                        ->withCount('teacher','student')
                        ->first();
        return view('admin.dashboard' , compact('dashboard'));
    }

    public function studentIndex()
    {
        $students = Student::with('user')->get();
        return view('admin.student',compact('students'));
    }

    public function teacherIndex()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.teacher',compact('teachers'));
    }
}
