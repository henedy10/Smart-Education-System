<?php

namespace App\Http\Controllers;

use App\Models\Homework;
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

use function PHPUnit\Framework\isEmpty;

class SystemController extends Controller
{
    public function login(){
        request()->validate([
            'name'=>['required','regex:/^[a-zA-Z0-9\s_]+$/'],
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
    public function show_student_homework_grade($class,$subject){
        return view('student.show_homework_grade',['class'=>$class,'subject'=>$subject]);
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
        $duration=$quiz->duration;
        $start_time=$quiz->start_time;
        $options=[];

        foreach($question as $q){
            $options[$q->id]=Option::where('question_id',$q->id)->get();
        }
        return view('student.show_content_quiz',['question'=>$question,
                                                'options'=>$options,
                                                'class'=>$class,
                                                'subject'=>$subject,
                                                'duration'=>$duration,
                                                'start_time'=>$start_time]);
    }

    //store of selection of student

    public function store_student_answers($class,$subject){
        $student_mark=0;
        $check_selection=[];
        $user= User::where('name',session('name'))->first();
        $student=Student::where('user_id',$user->id)->first();
        $teacher=Teacher::where('class',$class)
        -> where('subject',$subject)->first();
        $quiz=Quiz::where('teacher_id',$teacher->id)->first();
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
        $student_result=QuizResult::create([
            'student_id'=>$student->id,
            'teacher_id'=>$teacher->id,
            'quiz_id'=>$quiz->id,
            'student_mark'=>$student_mark,
            'quiz_mark'=>$quiz->quiz_mark,
        ]);
        return view('student.show_result',['student'=>$student,
                                            'quiz'=>$quiz,
                                            'student_mark'=>$student_mark,
                                            'class'=>$class,
                                            'subject'=>$subject]);
    }

    public function to_upload_homework($class,$subject){
        $homework_id=request()->upload_homework;
        return view('student.show_homework_uploading',['homework_id'=>$homework_id,
                                                        'class'=>$class,
                                                        'subject'=>$subject]);
    }
    public function store_student_solution_homework(){
        $user= User::where('name',session('name'))->first();
        $student=Student::where('user_id',$user->id)->first();
        request()->validate([
            'file'=>'required',
        ]);
        $file_path=request()->file('file')->store('solutions_homework','public');
        $homework_id=request()->homework_id;
        SolutionStudentForHomework::create([
                'homework_solution_file'=>$file_path,
                'student_id'=>$student->id,
                'homework_id'=>$homework_id,
        ]);
        return redirect()->back()->with('تم رفع الملف بنجاح');
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
                return redirect()->back()->with('success','تم عمل اختبار جديد بنجاح ');
        }
    }

    public function show_teacher_lessons($TeacherId){
        $lessons=Lesson::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_lesson',['TeacherId'=>$TeacherId,'lessons'=>$lessons]);
    }
    public function choose_action_homework($TeacherId){
        return view('teacher.choose_action_homework',['TeacherId'=>$TeacherId]);
    }
    public function create_teacher_homeworks($TeacherId){
        $homeworks=Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.create_homework',['TeacherId'=>$TeacherId,'homeworks'=>$homeworks]);
    }
    public function correct_teacher_homework($TeacherId){
        $time=Carbon::now('africa/cairo');
        $homeworks=Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.correcting_homework',['TeacherId'=>$TeacherId,
                                                    'homeworks'=>$homeworks,
                                                    'time'=>$time]);
    }
    public function homework_solutions_of_students($TeacherId){
        $homework_id=request()->homework_id;
        $solutions=SolutionStudentForHomework::where('homework_id',$homework_id)->get();
        return view('teacher.show_solutions_homework',['TeacherId'=>$TeacherId,
                                                        'solutions'=>$solutions]);
    }
    public function create_teacher_quiz($TeacherId){
        return view('teacher.create_quiz',['TeacherId'=>$TeacherId]);
    }
    public function show_results($TeacherId){
        $time=Carbon::now('africa/cairo');
        $quizzes=Quiz::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_results',['TeacherId'=>$TeacherId,'quizzes'=>$quizzes,'time'=>$time]);
    }
    public function show_content_results($TeacherId){
        $quiz_id=request()->quiz_id;
        $results=QuizResult::where('quiz_id',$quiz_id)->get();
        return view('teacher.show_content_results',['TeacherId'=>$TeacherId,'results'=>$results]);
    }

    // تسجيل الخروج لكل من الطالب و المدرس

    public function log_out_student(){
        session()->flush();
        return view('index');
    }

}

