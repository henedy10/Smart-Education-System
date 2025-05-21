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
            'name'=>'required|alpha_dash:ascii|exists:users,name',
            'password'=>'required|exists:users,password',
        ]);
        $user= User::where('name',request()->name)->first();
        if($user->user_as =='teacher'){
            return view('show_teacher',['user'=>$user]);
        }else{
            return view('show_student',['user'=>$user]);
        }
    }

    public function quiz(){
        return view('quiz');
    }
}
