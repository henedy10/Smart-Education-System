<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Lesson;
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
            $teacher=Teacher::where('user_id',$user->id)->first();

            return view('show_teacher',['teacher'=>$teacher]);
        }else{
            return view('show_student',['user'=>$user]);
        }
    }

    public function store_teacher($TeacherId){
        if((request()->upload_lesson)=='upload_lesson'){
            request()->validate([
                'title_lesson'=>'required',
                'file_lesson'=>'required|mimes:pdf,doc,docx,zip,rar,jpg,png',
            ]);
            $path=request()->file('file_lesson')->store('lessons','public');
            Lesson::create([
                    'teacher_id'=>$TeacherId,
                    'file_lesson'=>$path,
                    'title_lesson'=> request()->title_lesson,
            ]);

            // return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        }

    }
    public function quiz(){
        return view('quiz');
    }
}

