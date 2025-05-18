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
        $email=request()->email;
        $user= User::where('email',$email)->first();
        if($user->user_as =='teacher'){
            return view('show_teacher');
        } else{
            return view('show_student');
        }
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
    public function quiz(){
        return view('quiz');
    }
}
