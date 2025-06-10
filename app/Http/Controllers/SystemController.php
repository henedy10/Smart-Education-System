<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\Teacher;
use App\Models\Lesson;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Codec\TimestampLastCombCodec;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    public function login(){
        request()->validate([
            'name'=>'required|alpha_dash:ascii|exists:users,name',
            'password'=>'required',
        ]);
        $user= User::where('name',request()->name)->first();
        if(!$user|| request()->password!= $user->password){
            return back()->withErrors(['login'=>'بيانات الدخول غير صحيحه']);
        }
        session([
            'name'=>$user->name,
            'id'=>$user->id,
        ]);

        if($user->user_as =='teacher'){
            return redirect()->route('show_teacher');
        }else{
            return redirect()->route('show_student');
        }
    }



    /* STUDENT */

    public function show_student(){
            $user= User::where('name',session('name'))->first();
            $student=Student::where('user_id',$user->id)->first();
            $teachers=Teacher::where('class',$student->class)->get();
            return view('student.show_student',['student'=>$student,'teachers'=>$teachers]);
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

    public function show_student_homework($class,$subject){
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $homeworks=Homework::where('teacher_id',$teacher->id)->get();
        return view('student.show_homework',['subject'=>$subject,'class'=>$class,'homeworks'=>$homeworks]);
    }
    public function show_student_quizzes($class,$subject){
        return view('student.show_quiz',['subject'=>$subject,'class'=>$class]);
    }

    public function log_out_student(){
        session()->flush();
        return view('index');
    }



    /*  TEACHER */
    public function show_teacher(){
        $user= User::where('name',session('name'))->first();
            $teacher=Teacher::where('user_id',$user->id)->first();
            $lessons=Lesson::where('teacher_id',$user->id)->get();
            $num_lessons=Lesson::where('teacher_id',$user->id)->count();
            $num_homeworks=Homework::where('teacher_id',$user->id)->count();
            return view('teacher.show_teacher',['teacher'=>$teacher,
                                                'lessons'=>$lessons,
                                                'num_lessons'=>$num_lessons,
                                                'num_homeworks'=>$num_homeworks,
                                                'TeacherId'=>$user->id
                                                ]);
    }

    public function store_teacher($TeacherId){
        // نشر الحصه
        if((request()->upload)=='upload_lesson'){
            request()->validate([
                'title_lesson'=>'required',
                'file_lesson'=>'required|mimes:pdf,doc,docx,zip,rar,jpg,png|max:2048',
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
                'title_homework'=>'required',
                'file_homework'=>'required|mimes:pdf,doc,docx,zip,rar,jpg,png|max:2048'
            ]);
            $path=request()->file('file_homework')->store('homeworks','public');
            $content_homework=request()->content_homework;
            $title_homework=request()->title_homework;
            Homework::create([
                'teacher_id'=>$TeacherId,
                'title_homework'=>$title_homework,
                'file_homework'=>$path,
                'content_homework'=>$content_homework,
            ]);

            return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        }

        // عمل اختبار
        else if (request()->upload=='create_quiz'){
                request()->validate([
                    'quiz_title'=>'required',
                    'quiz_date'=>'required',
                    'quiz_duration'=>'required'
                ]);
                $quiz_title=request()->quiz_title;
                $quiz_date=request()->quiz_date;
                $quiz_duration=request()->quiz_duration;
                $quiz_description=request()->quiz_description;
                $question_title=request()->question_title;
                $correct_option=request()->correct_option;
                $option_title=request()->option_title;
                $count=1;
                $Quiz=Quiz::create([
                        'teacher_id'=>$TeacherId,
                        'title'=>$quiz_title,
                        'discription'=>$quiz_description,
                        'start_time'=>$quiz_date,
                        'duration'=>$quiz_duration,
                    ]);
                    foreach($question_title as $index=>$Ques_title){
                    $question=Question::create([
                            'quiz_id'=>$Quiz->id,
                            'title'=>$Ques_title,
                            'correct_option'=>$correct_option[$index],
                        ]);
                        foreach($option_title as $index_option=>$Opt_title){
                            Option::create([
                                'question_id'=>$question->id,
                                'option_title'=>$Opt_title,
                                'option_key'=>'الإجابة '.($count),
                            ]);
                            if($count==4)
                            break;
                            else
                                $count++;
                        }
                    }

                return redirect()->back()->with('success','تم عمل اختبار جديد بنجاح ');
        }


    }

    public function show_teacher_lessons($TeacherId){
        $lessons=Lesson::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_lesson',['TeacherId'=>$TeacherId,'lessons'=>$lessons]);
    }
    public function show_teacher_homeworks($TeacherId){
        $homeworks=Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_homework',['TeacherId'=>$TeacherId,'homeworks'=>$homeworks]);
    }
public function create_teacher_quiz($TeacherId){
    return view('teacher.create_quiz',['TeacherId'=>$TeacherId]);
}

}

