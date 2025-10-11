<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\
{
    Student,
    Teacher,
    User,
};

class DashboardController extends Controller
{
    public function index()
    {
        $userId         = session('id');
        $dashboard      = User::firstWhere('id',$userId);
        $count_teachers = Teacher::count();
        $count_students = Student::count();

        return view('admin.dashboard' , compact('dashboard','count_teachers','count_students'));
    }
}
