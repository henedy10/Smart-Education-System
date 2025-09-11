<?php

namespace App\Http\Controllers;


use App\Models\{
    Homework,
    HomeworkGrade,
    Teacher,
    Lesson,
    Option,
    Question,
    Quiz,
    QuizResult,
    SolutionStudentForHomework,
    Student,
    StudentOption,
};


class StudentController extends Controller
{

    public function showStudent(){
        $userId=session('id');
        if(!$userId){
            return redirect()->route('Login')->withErrors(['login' => 'يجب تسجيل الدخول أولا']);
        }

        $student=Student::with('user')->where('user_id',$userId)->first();

        if(!$student){
            return redirect()->back()->withErrors(['student' => 'هذا الحساب غير موجود']);
        }
        $teachers=Teacher::where('class',$student->class)->get();
        return view('student.show_student',compact('student','teachers'));
    }

    public function showStudentContent($class,$subject) {
        return view('student.show_content',compact('class','subject'));
    }

    public function showStudentLesson($class,$subject){

        $lessons=Lesson::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })->get();
        return view('student.show_lesson',compact('class','subject','lessons'));
    }

    public function showStudentHomework($class,$subject){

        $homeworks=Homework::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })->get();
        return view('student.show_homework',compact('subject','class','homeworks'));
    }

    public function showHomeworkUploadForm($class,$subject){

        $userId=session('id');
        $student=Student::with('user')->where('user_id',$userId)->first();

        $homework_id=request()->upload_homework;
        request()->validate([
            'upload_homework' => 'required|exists:homeworks,id'
        ]);

        $alreadyUploaded=SolutionStudentForHomework::where('student_id',$student->id)
        ->where('homework_id',$homework_id)
        ->exists();

        return view('student.show_homework_uploading',compact('homework_id','class','subject','alreadyUploaded'));
    }

    public function storeHomeworkSolution(){
        $userId=session('id');
        $student=Student::with('user')->where('user_id',$userId)->first();
        $homework_id=request()->homework_id;

        request()->validate([
            'file'        => 'required|file|mimes:pdf,doc,docx,jpg,png',
            'homework_id' => 'required|exists:homeworks,id'
        ]);

        $fileName=time().'_'.$student->id.'.'.request()->file('file')->getClientOriginalExtension();
        $filePath=request()->file('file')->storeAs('solutions_homework',$fileName,'public');

        SolutionStudentForHomework::create([
                'homework_solution_file'  => $filePath,
                'student_id'              => $student->id,
                'homework_id'             => $homework_id,
        ]);

        return redirect()->back()->with('success','تم رفع الملف بنجاح');
    }

    public function showHomeworkDetails($class,$subject){
        $userId=session('id');
        if(!$userId){
            return redirect()->route('Login')->withErrors(['login' => 'يجب تسجيل الدخول أولا']);
        }

        $student=Student::with('user')->where('user_id',$userId)->first();
        if(!$student){
            return redirect()->route('Login')->withErrors(['student' => 'الطالب غير موجود']);
        }

        request()->validate([
            'homework_id' => 'required|exists:homeworks,id'
        ]);
        $homework_id=request()->homework_id;

        $studentHomeworkGrade=HomeworkGrade::where('homework_id',$homework_id)
                                                ->where('student_id',$student->id)
                                                ->first();

        $studentHomeworkSolution=SolutionStudentForHomework::where('homework_id',$homework_id)
                                                ->where('student_id',$student->id)
                                                ->first();

        return view('student.show_homework_grade',compact(
            'class'
            ,'subject'
            ,'studentHomeworkGrade'
            ,'studentHomeworkSolution'
        ));
    }

    public function showAvailableQuiz($class,$subject){
        $quiz=Quiz::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })
        ->orderBy('start_time','desc')
        ->first();
        return view('student.show_quiz',['quiz'=>$quiz,'class'=>$class,'subject'=>$subject]);
    }

    public function showChooseAction($class,$subject){
        return view('student.show_action_content_quiz',compact('class','subject'));
    }

    public function showQuizResults($class,$subject){
        $userId=session('id');
        if(!$userId){
            return redirect()->route('Login')->withErrors(['login' => 'يجب تسجيل الدخول أولا']);
        }

        $student=Student::where('user_id',$userId)->first();
        if(!$student){
            return redirect()->route('Login')->withErrors(['student' => 'الطالب غير موجود']);
        }

        $teacher=Teacher::where('class',$class)
                            ->where('subject',$subject)
                            ->first();
        if(!$teacher){
            return redirect()->route('content.show')->withErrors(['teacher' => 'هذا المدرس لم يعد موجودا']);
        }
        $results=QuizResult::where('student_id',$student->id)
                                ->where('teacher_id',$teacher->id)
                                ->orderBy('created_at','desc')
                                ->get();
        return view('student.show_quiz_results',compact('class','subject','results'));
    }

    public function showQuizContent($class,$subject){

        $teacher=Teacher::where('class',$class)
                            -> where('subject',$subject)
                            ->first();
        if(!$teacher){
            return redirect()->route('content.show')->withErrors(['teacher' => 'هذا المدرس لم يعد موجودا']);
        }

        $quiz=Quiz::where('teacher_id',$teacher->id)
                            ->orderBy('start_time','desc')
                            ->first();
        if(!$quiz){
            return redirect()->back()->withErrors(['quiz' => 'لا يوجد اختبار متاح حاليا']);
        }

        $questions=Question::where('quiz_id',$quiz->id)->get();

        $duration=$quiz->duration;
        $start_time=$quiz->start_time;
        $options=[];
        foreach($questions as $q){
            $options[$q->id]=Option::where('question_id',$q->id)->get();
        }
        return view('student.show_content_quiz',compact(
            'questions',
            'options',
            'class',
            'subject',
            'duration',
            'start_time'
        ));
    }

    public function storeQuizAnswers($class,$subject){
        $studentMark=0;
        $check_selection=[];

        $userId=session('id');
        if(!$userId){
            return redirect()->route('Login')->withErrors(['login' => 'يجب تسجيل الدخول أولا']);
        }

        $student=Student::where('user_id',$userId)->first();
        if(!$student){
            return redirect()->route('Login')->withErrors(['student' => 'الطالب غير موجود']);
        }

        $teacher=Teacher::where('class',$class)
                            -> where('subject',$subject)
                            ->first();
        if(!$teacher){
            return redirect()->route('content.show')->withErrors(['teacher' => 'هذا المدرس لم يعد موجودا']);
        }

        $quiz=Quiz::where('teacher_id',$teacher->id)->orderBy('start_time','desc')->first();

        $questions=Question::where('quiz_id',$quiz->id)->get();

        foreach($questions as $Q){

            $options=request()->answer;
            $check_selection[$Q->id]= (isset($options[$Q->id]) && $Q->correct_option==$options[$Q->id]) ? true : false;

            $store_student_option=StudentOption::create([
                    'student_id'=> $student->id,
                    'quiz_id'=> $quiz->id,
                    'question_id'=>$Q->id,
                    'select_option'=>$options[$Q->id]??null,
                    'status_option'=> $check_selection[$Q->id],
            ]);

            if($check_selection[$Q->id]){
                $studentMark+=$Q->question_mark;
            }
        }

        $student_result=QuizResult::where('student_id',$student->id)
                            ->where('quiz_id',$quiz->id)
                            ->first();
        if($student_result){
            $student_result->student_mark=$studentMark;
            $student_result->test=true;
            $student_result->save();
        }

        return view('student.show_result',compact('student','quiz','studentMark','class','subject'));
    }
}

