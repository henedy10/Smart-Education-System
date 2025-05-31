<?php

namespace App\Http\Controllers;


use App\Models\Homework;
use App\Models\Teacher;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Codec\TimestampLastCombCodec;

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
            $lessons=Lesson::where('teacher_id',$user->id)->get();

            return view('show_teacher',['teacher'=>$teacher,'lessons'=>$lessons]);
        }else{
            $student=Student::where('user_id',$user->id)->first();
            $teachers=Teacher::where('class',$student->class)->get();
            return view('student.show_student',['student'=>$student,'teachers'=>$teachers]);
        }
    }

    public function show_student_content($class,$subject) {
        return view('student.show_content',['subject'=>$subject,'class'=>$class]);
    }
    public function show_student_lesson($class,$subject){
        $teacher=Teacher::where('class',$class)
                        -> where('subject',$subject)->first();
        $lessons=Lesson::where('teacher_id',$teacher->id)->get();
        return view('student.show_lesson',['subject'=>$subject,'class'=>$class,'lessons'=>$lessons]);
    }
    public function store_teacher($TeacherId){
        // نشر الحصه
        if((request()->upload)=='upload_lesson'){
            request()->validate([
                'title_lesson'=>'required',
                'file_lesson'=>'required|mimes:pdf,doc,docx,zip,rar,jpg,png',
            ]);
            $path=request()->file('file_lesson')->store('lessons','public');
            $title_lesson=request()->title_lesson;
            Lesson::create([
                'teacher_id'=>$TeacherId,
                'file_lesson'=>$path,
                'title_lesson'=> $title_lesson,
            ]);

            return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        }
        // نشر الواجب
        else if(request()->upload=='upload_homework'){
            request()->validate([
                'content_homework'=>'required',
                'file_homework'=>'required|mimes:pdf,doc,docx,zip,rar,jpg,png'
            ]);
            $path=request()->file('file_homework')->store('homeworks','public');
            $content_homework=request()->content_homework;
            Homework::create([
                'teacher_id'=>$TeacherId,
                'file_homework'=>$path,
                'content_homework'=>$content_homework,
            ]);

            return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        }

    }


    public function quiz(){
        return view('quiz');
    }
}

