<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\Teacher;
use App\Models\Lesson;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\StudentOption;
use App\Models\User;
use Illuminate\Support\Carbon;
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
        return view('student.show_lesson',['subject'=>$subject,
                                            'class'=>$class,
                                            'lessons'=>$lessons]);
    }

    public function show_student_homework($class,$subject){
        $time=Carbon::now('africa/cairo');
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $homeworks=Homework::where('teacher_id',$teacher->id)->get();
        return view('student.show_homework',['subject'=>$subject,
        'class'=>$class,
        'homeworks'=>$homeworks,
        'time'=>$time]);
    }
    public function show_student_quizzes($class,$subject){
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $quiz=Quiz::where('teacher_id',$teacher->id)
        ->orderBy('start_time','desc')
        ->first();
        $startTime = Carbon::parse($quiz->start_time,'africa/cairo');
        $currentTime = Carbon::now('africa/cairo');
        if(!is_null($quiz)){
            $num_questions=Question::where('quiz_id',$quiz->id)->count();
            return view('student.show_quiz',['subject'=>$subject,
                                            'class'=>$class,
                                            'quiz'=>$quiz,
                                            'num_questions'=>$num_questions,
                                            'currentTime'=>$currentTime,
                                            'startTime'=>$startTime,
                                        ]);
        }else{
            return view('student.show_quiz',['subject'=>$subject,
                                            'class'=>$class,
                                            'quiz'=>$quiz,
                                        ]);
        }
    }

        public function show_content_quiz($class,$subject){

        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $quiz=Quiz::where('teacher_id',$teacher->id)->first();
        $question=Question::where('quiz_id',$quiz->id)->get();
        $options=[];

        foreach($question as $q){
            $options[$q->id]=Option::where('question_id',$q->id)->get();
        }
        return view('student.show_content_quiz',['question'=>$question,
                                                'options'=>$options,
                                                'class'=>$class,
                                                'subject'=>$subject]);
    }

    //store of selection of student

    public function store_student_answers($class,$subject){
        $check_selection=[];
        $user= User::where('name',session('name'))->first();
        $student=Student::where('user_id',$user->id)->first();
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $quiz=Quiz::where('teacher_id',$teacher->id)->first();
        $question=Question::where('quiz_id',$quiz->id)->get();
        foreach($question as $Q){
            $options=request()->answer;
            if($Q->correct_option==$options[$Q->id]){
                $check_selection[$Q->id]=true;
            }else{
                $check_selection[$Q->id]=false;
            }
            $store_student_option=StudentOption::create([
                    'student_id'=> $student->id,
                    'quiz_id'=> $quiz->id,
                    'question_id'=>$Q->id,
                    'select_option'=>$options[$Q->id],
                    'status_option'=> $check_selection[$Q->id],
            ]);
        }

        return view('student.show_content',['class'=>$class,'subject'=>$subject]);
    }


    /*  TEACHER */
    public function show_teacher(){
        $user= User::where('name',session('name'))->first();
            $teacher=Teacher::where('user_id',$user->id)->first();
            $lessons=Lesson::where('teacher_id',$user->id)->get();
            $num_lessons=Lesson::where('teacher_id',$teacher->id)->count();
            $num_homeworks=Homework::where('teacher_id',$teacher->id)->count();
            $num_quizzes=Quiz::where('teacher_id',$teacher->id)->count();
            return view('teacher.show_teacher',['teacher'=>$teacher,
                                                'lessons'=>$lessons,
                                                'num_lessons'=>$num_lessons,
                                                'num_homeworks'=>$num_homeworks,
                                                'num_quizzes'=>$num_quizzes,
                                                'TeacherId'=>$teacher->id,
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
                'file_homework'=>'required|mimes:pdf,doc,docx,zip,rar,jpg,png|max:2048',
                'deadline_homework'=>'required',
            ]);
            $path=request()->file('file_homework')->store('homeworks','public');
            $content_homework=request()->content_homework;
            $title_homework=request()->title_homework;
            $deadline_homework=request()->deadline_homework;
            Homework::create([
                'teacher_id'=>$TeacherId,
                'title_homework'=>$title_homework,
                'file_homework'=>$path,
                'content_homework'=>$content_homework,
                'deadline'=>$deadline_homework,
            ]);

            return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        }

        // عمل اختبار
        else if (request()->upload=='create_quiz'){
                request()->validate([
                    'quiz_title'=>'required',
                    'quiz_date'=>'required',
                    'quiz_duration'=>'required',
                    'question_title'=>'required|array',
                    'question_title.*'=>'required|string',
                    'option_title'=>'required|array',
                    'option_title.*'=>'required|string',
                    'correct_option'=>'required|array',
                    'correct_option.*'=>'required'
                ]);
                $quiz_title=request()->quiz_title;
                $quiz_date=request()->quiz_date;
                $quiz_duration=request()->quiz_duration;
                $quiz_description=request()->quiz_description;
                $question_title=request()->question_title;
                $correct_option=request()->correct_option;
                $option_title=request()->option_title;

                $option_index=0;

                $Quiz=Quiz::create([
                        'teacher_id'=>$TeacherId,
                        'title'=>$quiz_title,
                        'description'=>$quiz_description,
                        'start_time'=>$quiz_date,
                        'duration'=>$quiz_duration,
                    ]);
                    for($i=0;$i<sizeof($question_title);$i++){
                        $index_key=0;
                    $question=Question::create([
                            'quiz_id'=>$Quiz->id,
                            'title'=>$question_title[$i],
                            'correct_option'=>$correct_option[$i],
                        ]);
                        for($j=$option_index;$j<=$option_index+3;$j++){

                            Option::create([
                                'question_id'=>$question->id,
                                'option_title'=>$option_title[$j],
                                'option_key'=>'الإجابة '.($index_key+1),
                            ]);
                            $index_key++;
                        }
                        $option_index+=4;
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

    // تسجيل الخروج لكل من الطالب و المدرس

    public function log_out_student(){
        session()->flush();
        return view('index');
    }

}

