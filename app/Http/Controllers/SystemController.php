<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function index()  {
        return view('index');
    }
    public function show(){
        request()->validate([
            'email'=>'required|exists:users,email',
            'password'=>'required|exists:users,password',
        ]);
        $user= User::where('email',request()->email)->first();
        if($user->user_as =='teacher'){
            return view('show_teacher');
        }else{
            return view('show_student');
        }
    }

    public function create_student() {
        return view('create_student');
    }
    public function store_student(){
        request()->validate([
            'name'=>'required|unique:users,name|alpha_dash:ascii',
            'email'=> 'required|unique:users,email|email:rfc,dns',
            'password'=>'required|unique:users,password|min:5',
            'grade'=>'required'
        ]);
    }
    public function create_teacher() {
        return view('create_teacher');
    }
    public function choose()  {
        return view('choose');
    }
    public function quiz(){
        return view('quiz');
    }
}
