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
};

class TeacherController extends Controller
{


    public function showTeacher(){
        $userId=session('id');
        if(!$userId){
            return redirect()->route('Login')->withErrors(['login'=>'يجب تسجيل الدخول أولا']);
        }

        $teacher=Teacher::where('user_id',$userId)
        ->withCount('lessons','homeworks','quizzes')
        ->first();

        if(!$teacher){
            return redirect()->route('Login')->withErrors(['teacher'=>'المدرس غير موجود']);
        }

            return view('teacher.show_teacher',compact('teacher'));
    }

    public function storeTeacherResource($TeacherId){
        // نشر الحصه
        if((request()->upload)=='upload_lesson'){
            request()->validate([
                'title_lesson'  => 'required|max:255',
                'file_lesson'   => 'required|mimes:pdf,doc,docx,zip,rar,jpg,png|max:10240',
            ]);

            $fileName=time() . '.' . request()->title_lesson . '.' . request()->file('file_lesson')->getClientOriginalExtension();
            $filePath=request()->file('file_lesson')->storeAs('lessons',$fileName,'public');
            $title_lesson=request()->title_lesson;

            Lesson::create([
                'teacher_id'   => $TeacherId,
                'file_lesson'  => $filePath,
                'title_lesson' => $title_lesson,
            ]);

            return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        }

        // نشر الواجب
        else if(request()->upload == 'upload_homework'){
            request()->validate([
                'content_homework'   => 'required',
                'title_homework'     => 'required|max:255',
                'file_homework'      => 'required|mimes:pdf,doc,docx,zip,rar,jpg,png|max:2048',
                'deadline_homework'  => 'required',
                'homework_mark'      => 'required|integer',
            ]);

            $fileName=request()->title_homework . '.' . request()->file('file_homework')->getClientOriginalExtension();
            $filePath=request()->file('file_homework')->storeAs('homeworks',$fileName,'public');

            Homework::create([
                'teacher_id'        => $TeacherId,
                'title_homework'    => request()->title_homework,
                'file_homework'     => $filePath,
                'content_homework'  => request()->content_homework,
                'deadline'          => request()->deadline_homework,
                'homework_mark'     => request()->homework_mark,
            ]);

            return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        }

        // عمل اختبار
        else if (request()->upload == 'create_quiz'){

            request()->validate([
                'quiz_title'        => 'required|max:255',
                'quiz_date'         => 'required',
                'quiz_duration'     => 'required|integer|min:1',
                'question_title'    => 'required|array|max:255',
                'question_title.*'  => 'required|string',
                'option_title'      => 'required|array|max:255',
                'option_title.*'    => 'required|string',
                'correct_option'    => 'required|array',
                'correct_option.*'  => 'required',
                'question_mark'     => 'required|array',
                'question_mark.*'   => 'required|integer',
            ]);

            $quiz_title       =  request()->quiz_title;
            $quiz_date        =  request()->quiz_date;
            $quiz_duration    =  request()->quiz_duration;
            $quiz_description =  request()->quiz_description;
            $question_title   =  request()->question_title;
            $correct_option   =  request()->correct_option;
            $option_title     =  request()->option_title;
            $question_mark    =  request()->question_mark;
            $option_index=0;

            $quiz_mark=0;

            $Quiz=Quiz::create([
                    'teacher_id'  => $TeacherId,
                    'title'       => $quiz_title,
                    'description' => $quiz_description,
                    'start_time'  => $quiz_date,
                    'duration'    => $quiz_duration,
                    'quiz_mark'   => $quiz_mark,
                ]);

            for($i=0 ; $i<sizeof($question_title) ; $i++){
                    $index_key=0;
                $question=Question::create([
                    'quiz_id'        => $Quiz->id,
                    'title'          => $question_title[$i],
                    'question_mark'  => $question_mark[$i],
                    'correct_option' => $correct_option[$i]
                ]);

                $quiz_mark+=$question->question_mark;

                    for($j=$option_index ; $j <= $option_index+3 ; $j++){
                        Option::create([
                            'question_id'  => $question->id,
                            'option_title' => $option_title[$j],
                            'option_key'   => 'الإجابة '.($index_key+1),
                        ]);
                        $index_key++;
                    }
                    $option_index+=4;
            }
                $Quiz->update(["quiz_mark"=>$quiz_mark]);

                $teacher=Teacher::findOrFail($TeacherId);
                $students=Student::where('class',$teacher->class)->get();
                foreach($students as $student){
                    QuizResult::create([
                        'student_id'  => $student->id,
                        'teacher_id'  => $teacher->id,
                        'quiz_id'     => $Quiz->id,
                        'quiz_mark'   => $Quiz->quiz_mark,
                    ]);
                }
            return redirect()->back()->with('success','تم عمل اختبار جديد بنجاح ');
        }
    }

    public function showTeacherLessons($TeacherId){
        $lessons=Lesson::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_lesson',compact('TeacherId','lessons'));
    }

    public function showActionHomework($TeacherId){
        return view('teacher.choose_action_homework',compact('TeacherId'));
    }

    public function createHomework($TeacherId){
        $homeworks=Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.create_homework',compact('TeacherId','homeworks'));
    }

    public function correctHomework($TeacherId){
        $time=now('africa/cairo');
        $homeworks=Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.correcting_homework',compact('TeacherId','homeworks','time'));
    }

    public function solutionHomeworkOfStudent($TeacherId){
        $solutions=SolutionStudentForHomework::where('homework_id',request()->homework_id)->get();
        return view('teacher.show_solutions_homework',compact('TeacherId','solutions'));
    }

    public function storeHomeworkGrades($StudentId){
        request()->validate([
            'student_mark' => 'required|integer|min:0',
        ]);

        $student_mark=request()->student_mark;
        $homework_id=request()->homework_id;

        HomeworkGrade::create([
            'student_mark' => $student_mark,
            'homework_id'  => $homework_id,
            'student_id'   => $StudentId,
        ]);

        $correction_status=SolutionStudentForHomework::where('student_id',$StudentId)
        ->where('homework_id',$homework_id)
        ->first();
        $correction_status->update(['correction_status' => true]);

        return redirect()->back()->with('success','تم تصحيح هذا الواجب بنجاح');
    }

    public function updateHomeworkGrade($StudentId){
        request()->validate([
            'student_mark' => 'required|integer',
        ]);

        $homework_id=request()->homework_id;
        $student_mark=request()->student_mark;

        $modify_homework_grade=HomeworkGrade::where('student_id',$StudentId)
        ->where('homework_id',$homework_id)
        ->first();

        $modify_homework_grade->update(['student_mark' => $student_mark]);

        return redirect()->back()->with('success','تم تعديل درجه هذا الواجب بنجاح');
    }

    public function createQuiz($TeacherId){
        return view('teacher.create_quiz',compact('TeacherId'));
    }

    public function showQuizzes($TeacherId){
        $time=now('africa/cairo');
        $quizzes=Quiz::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_results',compact('TeacherId','quizzes','time'));
    }

    public function showResults($TeacherId){
        $results=QuizResult::where('quiz_id',request()->quiz_id)->get();
        return view('teacher.show_content_results',compact('TeacherId','results'));
    }
}
