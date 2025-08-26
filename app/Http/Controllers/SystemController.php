<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\HomeworkGrade;
use App\Models\Teacher;
use App\Models\Lesson;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\SolutionStudentForHomework;
use App\Models\Student;
use App\Models\StudentOption;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Codec\TimestampLastCombCodec;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

use function PHPUnit\Framework\isEmpty;

class SystemController extends Controller
{
    public function Login(){
        $email=Cookie::get('user_email');

        if($email){
            $user=User::where('email',$email)->first();

            if(!$user){
                Cookie::queue(Cookie::forget('user_email'));
                return redirect()->view('index')->withErrors(['login' => 'هذا الحساب غير موجود']);
            }

            session([
                'email'=>$user->email,
                'id'=>$user->id
            ]);

            return $user->user_as =='teacher'
                ? redirect()->route('show_teacher')
                : redirect()->route('show_student');

        }else{
            return view('index');
        }
    }
    public function checkUser(){
            request()->validate([
                'email'=>['required','email:rfc,dns'],
                'password'=>'required',
            ]);

            $email=request()->email;
            $password=request()->password;
            $user= User::where('email',$email)
                        ->where('password',$password)
                        ->first();

            if(!$user){
                return back()->withErrors(['login'=>'بيانات الدخول غير صحيحه']);
            }else{
                session([
                    'email'=>$user->email,
                    'id'=>$user->id,
                ]);

                if(request()->remember_me){
                    Cookie::queue('user_email',$email,60*24*30,'/'); // for 1 month
                }

                return $user->user_as =='teacher'
                        ? redirect()->route('show_teacher')
                        : redirect()->route('student.show');
            }
    }

    /* STUDENT */

    public function showStudent(){
        $userId=session('id');
        if(!$userId){
            return redirect()->route('Login')->withErrors(['login'=>'يجب تسجيل الدخول أولا']);
        }

        $student=Student::with('user')->where('user_id',$userId)->first();

        if(!$student){
            return redirect()->back()->withErrors(['student'=>'هذا الحساب غير موجود']);
        }
        $teachers=Teacher::where('class',$student->class)->get();
        return view('student.show_student',compact('student','teachers'));
    }

    public function showStudentcontent($class,$subject) {
        return view('student.show_content',compact('class','subject'));
    }

    public function showStudentlesson($class,$subject){
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        if(!$teacher){
            return redirect()->back()->withErrors(['teacher'=>'هذا المدرس لم يعد موجودا']);
        }
        $lessons=Lesson::where('teacher_id',$teacher->id)->get();

        return view('student.show_lesson',compact('class','subject','lessons'));
    }

    public function show_student_homework($class,$subject){
        $time=Carbon::now('africa/cairo');
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $homeworks=Homework::where('teacher_id',$teacher->id)->get();
        return view('student.show_homework',compact('subject','class','homeworks','time'));
    }

    public function to_upload_homework($class,$subject){
        $user= User::where('email',session('email'))->first();
        $student=Student::where('user_id',$user->id)->first();
        $homework_id=request()->upload_homework;
        $check_status_student_solution=SolutionStudentForHomework::where('student_id',$student->id)->where('homework_id',$homework_id)->first();
        return view('student.show_homework_uploading',compact('homework_id','class','subject','check_status_student_solution'));
    }

    public function store_student_solution_homework(){
        $user= User::where('email',session('email'))->first();
        $student=Student::where('user_id',$user->id)->first();
        $homework_id=request()->homework_id;
        $check_status_student_solution=SolutionStudentForHomework::where('student_id',$student->id)->where('homework_id',$homework_id)->first();
        if(is_null($check_status_student_solution)){
            request()->validate([
                'file'=>'required',
            ]);
            $file_path=request()->file('file')->store('solutions_homework','public');
            SolutionStudentForHomework::create([
                    'homework_solution_file'=>$file_path,
                    'student_id'=>$student->id,
                    'homework_id'=>$homework_id,
            ]);
            return redirect()->back()->with('success','تم رفع الملف بنجاح');
        }else{
            return redirect()->back()->with('danger','لا يمكن رفع اكثر من ملف ');
        }
    }

    public function show_student_homework_grade($class,$subject){
            $user= User::where('email',session('email'))->first();
            $student=Student::where('user_id',$user->id)->first();
            $homework_id=request()->homework_id;
            $student_homework_grade=HomeworkGrade::where('homework_id',$homework_id)
                                                    ->where('student_id',$student->id)
                                                    ->first();
            $student_homework_solution=SolutionStudentForHomework::where('homework_id',$homework_id)
                                                    ->where('student_id',$student->id)
                                                    ->first();
        return view('student.show_homework_grade',compact('class','subject','student_homework_grade','student_homework_solution'));
    }

    public function show_student_quizzes($class,$subject){
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $quiz=Quiz::where('teacher_id',$teacher->id)
        ->orderBy('start_time','desc')
        ->first();

        if(!is_null($quiz)){
            $startTime = Carbon::parse($quiz->start_time,'africa/cairo');
            $currentTime = Carbon::now('africa/cairo');
            $num_questions=Question::where('quiz_id',$quiz->id)->count();
            return view('student.show_quiz',compact('subject','class','quiz','num_questions','currentTime','startTime'));
        }else{
            return view('student.show_quiz',compact('subject','class','quiz'));
        }
    }

    public function show_student_quiz_action($class,$subject){
        return view('student.show_action_content_quiz',compact('class','subject'));
    }

    public function show_student_quiz_result($class,$subject){
        $user=User::where('id',session('id'))->first();
        $teacher=Teacher::where('class',$class)
                            ->where('subject',$subject)
                            ->first();
        $student=Student::where('user_id',$user->id)->first();
        $results=QuizResult::where('student_id',$student->id)
                                ->where('teacher_id',$teacher->id)
                                ->get();
        return view('student.show_quiz_results',compact('class','subject','results'));
    }

        public function show_content_quiz($class,$subject){
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $quiz=Quiz::where('teacher_id',$teacher->id)->orderBy('start_time','desc')->first();
        $question=Question::where('quiz_id',$quiz->id)->get();
        $duration=$quiz->duration;
        $start_time=$quiz->start_time;
        $options=[];
        foreach($question as $q){
            $options[$q->id]=Option::where('question_id',$q->id)->get();
        }
        return view('student.show_content_quiz',compact('question','options','class','subject','duration','start_time'));
    }

    //store of selection of student
    public function store_student_answers($class,$subject){
        $student_mark=0;
        $check_selection=[];

        $user= User::where('email',session('email'))->first();

        $student=Student::where('user_id',$user->id)->first();

        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();

        $quiz=Quiz::where('teacher_id',$teacher->id)->orderBy('start_time','desc')->first();

        $question=Question::where('quiz_id',$quiz->id)->get();

        foreach($question as $Q){
            $options=request()->answer;
            if(isset($options[$Q->id])&&$Q->correct_option==$options[$Q->id]){
                $check_selection[$Q->id]=true;
            }else{
                $check_selection[$Q->id]=false;
            }
            $store_student_option=StudentOption::create([
                    'student_id'=> $student->id,
                    'quiz_id'=> $quiz->id,
                    'question_id'=>$Q->id,
                    'select_option'=>$options[$Q->id]??null,
                    'status_option'=> $check_selection[$Q->id],
            ]);
            if($check_selection[$Q->id]){
                $student_mark+=$Q->question_mark;
            }
        }
        $student_result=QuizResult::where('student_id',$student->id)->where('quiz_id',$quiz->id)->first();
        $student_result->student_mark=$student_mark;
        $student_result->save();
        return view('student.show_result',compact('student','quiz','student_mark','class','subject'));
    }

    /*  TEACHER */
    public function show_teacher(){
            $user= User::where('email',session('email'))->first();
            $teacher=Teacher::where('user_id',$user->id)->first();
            $lessons=Lesson::where('teacher_id',$user->id)->get();
            $num_lessons=Lesson::where('teacher_id',$teacher->id)->count();
            $num_homeworks=Homework::where('teacher_id',$teacher->id)->count();
            $num_quizzes=Quiz::where('teacher_id',$teacher->id)->count();
            return view('teacher.show_teacher',compact('teacher','lessons','num_lessons','num_homeworks','num_quizzes'));
    }

    public function store_teacher($TeacherId){
        // نشر الحصه
        if((request()->upload)=='upload_lesson'){
            request()->validate([
                'title_lesson'=>'required',
                'file_lesson'=>'required|mimes:pdf,doc,docx,zip,rar,jpg,png|max:10240',
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
                'homework_mark'=>'required',
            ]);
            $path=request()->file('file_homework')->store('homeworks','public');
            $content_homework=request()->content_homework;
            $title_homework=request()->title_homework;
            $deadline_homework=request()->deadline_homework;
            $homework_mark=request()->homework_mark;
            Homework::create([
                'teacher_id'=>$TeacherId,
                'title_homework'=>$title_homework,
                'file_homework'=>$path,
                'content_homework'=>$content_homework,
                'deadline'=>$deadline_homework,
                'homework_mark'=>$homework_mark,
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
                    'correct_option.*'=>'required',
                    'question_mark'=>'required|array',
                    'question_mark.*'=>'required|integer',
                ]);
                $quiz_title=request()->quiz_title;
                $quiz_date=request()->quiz_date;
                $quiz_duration=request()->quiz_duration;
                $quiz_description=request()->quiz_description;
                $question_title=request()->question_title;
                $correct_option=request()->correct_option;
                $option_title=request()->option_title;
                $question_mark=request()->question_mark;
                $option_index=0;

                $quiz_mark=0;
                $Quiz=Quiz::create([
                        'teacher_id'=>$TeacherId,
                        'title'=>$quiz_title,
                        'description'=>$quiz_description,
                        'start_time'=>$quiz_date,
                        'duration'=>$quiz_duration,
                        'quiz_mark'=>$quiz_mark,
                    ]);

                    for($i=0;$i<sizeof($question_title);$i++){
                        $index_key=0;
                    $question=Question::create([
                            'quiz_id'=>$Quiz->id,
                            'title'=>$question_title[$i],
                            'question_mark'=>$question_mark[$i],
                            'correct_option'=>$correct_option[$i]]);
                    $quiz_mark+=$question->question_mark;
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

                    $quiz=Quiz::find($Quiz->id);
                    $quiz->quiz_mark=$quiz_mark;
                    $quiz->save();

                    $teacher=Teacher::find($TeacherId);
                    $students=Student::where('class',$teacher->class)->get();
                    foreach($students as $student){
                        QuizResult::create([
                            'student_id'=>$student->id,
                            'teacher_id'=>$teacher->id,
                            'quiz_id'=>$quiz->id,
                            'quiz_mark'=>$quiz->quiz_mark,
                        ]);
                    }
                return redirect()->back()->with('success','تم عمل اختبار جديد بنجاح ');
        }
    }

    public function show_teacher_lessons($TeacherId){
        $lessons=Lesson::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_lesson',compact('TeacherId','lessons'));
    }

    public function choose_action_homework($TeacherId){
        return view('teacher.choose_action_homework',compact('TeacherId'));
    }

    public function create_teacher_homeworks($TeacherId){
        $homeworks=Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.create_homework',compact('TeacherId','homeworks'));
    }

    public function correct_teacher_homework($TeacherId){
        $time=Carbon::now('africa/cairo');
        $homeworks=Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.correcting_homework',compact('TeacherId','homeworks','time'));
    }

    public function homework_solutions_of_students($TeacherId){
        $homework_id=request()->homework_id;
        $solutions=SolutionStudentForHomework::where('homework_id',$homework_id)->get();
        return view('teacher.show_solutions_homework',compact('TeacherId','solutions'));
    }

    public function store_grades_homeworks($StudentId){
        request()->validate([
            'student_mark'=>'required',
        ]);
        $student_mark=request()->student_mark;
        $homework_id=request()->homework_id;
        $homework_grade=HomeworkGrade::create([
            'student_mark'=>$student_mark,
            'homework_id'=>$homework_id,
            'student_id'=>$StudentId,
        ]);
        $correction_status=SolutionStudentForHomework::where('student_id',$StudentId)->where('homework_id',$homework_id)->first();
            $correction_status->correction_status=1;
            $correction_status->save();
            return redirect()->back()->with('success','تم تصحيح هذا الواجب بنجاح');
        }

        public function modify_grades_homeworks($StudentId){
            request()->validate([
                'student_mark'=>'required',
            ]);
            $homework_id=request()->homework_id;
            $student_mark=request()->student_mark;
            $modify_homework_grade=HomeworkGrade::where('student_id',$StudentId)->where('homework_id',$homework_id)->first();
            $modify_homework_grade->student_mark=$student_mark;
            $modify_homework_grade->save();
            return redirect()->back()->with('success','تم تعديل درجه هذا الواجب بنجاح');
    }

    public function create_teacher_quiz($TeacherId){
        return view('teacher.create_quiz',compact('TeacherId'));
    }

    public function show_results($TeacherId){
        $time=Carbon::now('africa/cairo');
        $quizzes=Quiz::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_results',compact('TeacherId','quizzes','time'));
    }

    public function show_content_results($TeacherId){
        $quiz_id=request()->quiz_id;
        $results=QuizResult::where('quiz_id',$quiz_id)->get();
        return view('teacher.show_content_results',compact('TeacherId','results'));
    }

    // تسجيل الخروج لكل من الطالب و المدرس

    public function LogOut(){

        session()->forget(['email','id']);
        session()->invalidate();
        session()->regenerateToken();

        Cookie::queue(Cookie::forget('user_email'));

        return redirect()->route('Login');

    }

    // تغيير كلمه المرور للمستخدم
    public function EditPassword(){
        return view('change_password');
    }

    public function UpdatePassword(){
        request()->validate([
            'email'=>'required|email',
            'NewPassword'=>'required|min:8',
            'ConfirmPassword'=>'required|same:NewPassword',
        ]);

        $email=request()->email;
        $NewPassword=request()->NewPassword;
        $user= User::where('email',$email)->first();

        if(is_null($user)){
            return redirect()->back()->withErrors(['email'=>'هذا الحساب غير موجود']);
        }else{
                $user->password=$NewPassword;
                $user->save();
                return redirect()->route('Login')->with('success','تم تغيير كلمة المرور بنجاح');
        }
    }

}

