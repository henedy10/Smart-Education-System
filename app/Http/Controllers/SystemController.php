<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function index()  {
        return view('index');
    }
    public function create_student() {
        return view('create_student');
    }
    public function create_teacher() {
        return view('create_teacher');
    }
    public function choose()  {
        return view('choose');
    }
    public function show_student(){
        return view('show_student');
    }
    public function show_teacher(){
        return view('show_teacher');
    }
}
