<?php

namespace App\Http\Controllers;

use App\Http\Requests\student\{storeHomeworkSolutions};
use App\Models\{
    Homework,
    Teacher,
    Lesson,
    Option,
    Quiz,
    QuizResult,
    SolutionStudentForHomework,
    Student,
    StudentOption,
};

class StudentController extends Controller
{

    public function showStudent() {
        $userId  = session('id');
        $student = Student::whereHas('user',function($q) use($userId){
            $q->select('name')->where('id',$userId);
        })->first();
        $teachers = Teacher::where('class',$student->class)->get();

        return view('student.show_student',compact('student','teachers'));
    }

    public function showStudentContent($class,$subject) {
        return view('student.show_content',compact('class','subject'));
    }

    public function showStudentLesson($class,$subject){
        $lessons = Lesson::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })->get();

        return view('student.show_lesson',compact('class','subject','lessons'));
    }

    public function showStudentHomework($class,$subject){
        $homeworks = Homework::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })->get();

        return view('student.show_homework',compact('subject','class','homeworks'));
    }

    public function showHomeworkUploadForm($class,$subject){
        $userId          = session('id');
        $studentId       = Student::where('user_id',$userId)->value('id');
        $homework_id     = request()->upload_homework;
        $alreadyUploaded = SolutionStudentForHomework::where('student_id',$studentId)
                                                    ->where('homework_id',$homework_id)
                                                    ->exists();

        return view('student.show_homework_uploading',compact('homework_id','class','subject','alreadyUploaded'));
    }

    public function storeHomeworkSolution(storeHomeworkSolutions $request){
        $userId      = session('id');
        $student     = Student::with('user')->where('user_id',$userId)->first();
        $homework_id = $request->homework_id;
        $fileName    = $student->user->name.'.'.$request->file('file')->getClientOriginalExtension();
        $filePath    = $request->file('file')->storeAs('solutions_homework',$fileName,'public');

        SolutionStudentForHomework::create([
            'homework_solution_file'  => $filePath,
            'student_id'              => $student->id,
            'homework_id'             => $homework_id,
        ]);

        return redirect()->back()->with('success','تم رفع الملف بنجاح');
    }

    public function showHomeworkDetails($class,$subject){
        $userId          = session('id');
        $studentId       = Student::where('user_id',$userId)->value('id');
        $homework_id     = request()->homework_id;
        $homeworkDetails = SolutionStudentForHomework::with('homeworkGrade')
                                                    ->where('student_id',$studentId)
                                                    ->where('homework_id',$homework_id)
                                                    ->first();

        return view('student.show_homework_grade',compact(
            'class',
            'subject',
            'homeworkDetails',
        ));
    }

    public function showAvailableQuiz($class,$subject){

        $quiz=Quiz::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })
        ->orderBy('start_time','desc')
        ->first();

        return view('student.show_quiz',[
            'quiz'      =>  $quiz,
            'class'     =>  $class,
            'subject'   =>  $subject
    ]);
    }

    public function showChooseAction($class,$subject){
        return view('student.show_action_content_quiz',compact('class','subject'));
    }

    public function showQuizResults($class,$subject){
        $userId    = session('id');
        $studentId = Student::where('user_id',$userId)->value('id');
        $teacherId = Teacher::where('class',$class)
                            ->where('subject',$subject)
                            ->value('id');

        $results = QuizResult::where('student_id',$studentId)
                            ->where('teacher_id',$teacherId)
                            ->orderBy('created_at','desc')
                            ->get();

        return view('student.show_quiz_results',compact('class','subject','results'));
    }

    public function showQuizContent($class,$subject){

        $teacherId = Teacher::where('class',$class)
                            ->where('subject',$subject)
                            ->value('id');

        $quiz = Quiz::with('questions')
                    ->where('teacher_id',$teacherId)
                    ->orderBy('start_time','desc')
                    ->first();

        if($quiz->count() == 0){
            return redirect()->back()->withErrors(['quiz' => 'لا يوجد اختبار متاح حاليا']);
        }

        $options = [];
        foreach($quiz->questions as $Q){
            $options[$Q->id] = Option::where('question_id',$Q->id)->get();
        }
        return view('student.show_content_quiz',compact(
            'quiz',
            'options',
            'class',
            'subject',
        ));
    }

    public function storeQuizAnswers($class,$subject){
        $studentMark     = 0;
        $check_selection = [];
        $userId  = session('id');

        $student = Student::with('user')
                                ->where('user_id',$userId)
                                ->first();

        $teacherId = Teacher::where('class',$class)
                                ->where('subject',$subject)
                                ->value('id');

        $quiz = Quiz::with('questions')
                            ->where('teacher_id',$teacherId)
                            ->orderBy('start_time','desc')
                            ->first();

        foreach($quiz->questions as $Q){
            $options                 = request()->answer;
            $check_selection[$Q->id] = (isset($options[$Q->id]) && $Q -> correct_option == $options[$Q->id]) ? true : false;
            $store_student_option    = StudentOption::create([
                'student_id'     =>  $student->id,
                'quiz_id'        =>  $quiz->id,
                'question_id'    =>  $Q->id,
                'select_option'  =>  $options[$Q->id] ?? null,
                'status_option'  =>  $check_selection[$Q->id],
            ]);

            if($check_selection[$Q->id]){
                $studentMark += $Q->question_mark;
            }
        }

        $student_result = QuizResult::where('student_id',$student->id)
                                    ->where('quiz_id',$quiz->id)
                                    ->first();

        if($student_result){
            $student_result->update([
                'student_mark' => $studentMark,
                'test'         => true,
            ]);
        }

        return view('student.show_result',compact('student','quiz','studentMark','class','subject'));
    }
}

