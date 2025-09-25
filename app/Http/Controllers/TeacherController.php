<?php

namespace App\Http\Controllers;
use App\Http\Requests\teacher\homeworks\{storeHomework, storeHomeworkGrades, updateHomeworkGrades};
use App\Http\Requests\teacher\lessons\{storeLesson};
use App\Http\Requests\teacher\quizzes\storeQuiz;
use App\Models\{
    Homework,
    HomeworkGrade,
    Teacher,
    Lesson,
    Question,
    Option,
    Student,
    Quiz,
    QuizResult,
    SolutionStudentForHomework,
};

class TeacherController extends Controller
{
    public function index(){
        $userId=session('id');

        $teacher=Teacher::where('user_id',$userId)
                        ->withCount('lessons','homeworks','quizzes')
                        ->first();

        return view('teacher.show_teacher',compact('teacher'));
    }

    public function storeLessons(storeLesson $request , $TeacherId){

        $fileName     = $request->title_lesson . '.' . request()->file('file_lesson')->getClientOriginalExtension();
        $filePath     = $request->file('file_lesson')->storeAs('lessons',$fileName,'public');
        $title_lesson = $request->title_lesson;

        Lesson::create([
            'teacher_id'   => $TeacherId,
            'file_lesson'  => $filePath,
            'title_lesson' => $title_lesson,
        ]);

        return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
    }

    public function storeHomeworks(storeHomework $request,$TeacherId){

        $fileName = $request->title_homework . '.' . request()->file('file_homework')->getClientOriginalExtension();
        $filePath = $request->file('file_homework')->storeAs('homeworks',$fileName,'public');

        Homework::create([
            'teacher_id'        => $TeacherId,
            'title_homework'    => $request->title_homework,
            'file_homework'     => $filePath,
            'content_homework'  => $request->content_homework,
            'deadline'          => $request->deadline_homework,
            'homework_mark'     => $request->homework_mark,
        ]);

        return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
    }

    public function storeQuiz(storeQuiz $request, $TeacherId){

        $quiz_title       =  $request->quiz_title;
        $quiz_date        =  $request->quiz_date;
        $quiz_duration    =  $request->quiz_duration;
        $quiz_description =  $request->quiz_description;
        $question_title   =  $request->question_title;
        $correct_option   =  $request->correct_option;
        $option_title     =  $request->option_title;
        $question_mark    =  $request->question_mark;
        $option_index     = 0;
        $quiz_mark        = 0;

        $Quiz=Quiz::create([
                'teacher_id'  => $TeacherId,
                'title'       => $quiz_title,
                'description' => $quiz_description,
                'start_time'  => $quiz_date,
                'duration'    => $quiz_duration,
                'quiz_mark'   => $quiz_mark,
            ]);

        for($i=0; $i<sizeof($question_title); $i++){
                $index_key=0;
            $question=Question::create([
                'quiz_id'        => $Quiz->id,
                'title'          => $question_title[$i],
                'question_mark'  => $question_mark[$i],
                'correct_option' => $correct_option[$i]
            ]);

            $quiz_mark += $question->question_mark;

                for($j = $option_index; $j <= $option_index+3; $j++){
                    Option::create([
                        'question_id'  => $question->id,
                        'option_title' => $option_title[$j],
                        'option_key'   => 'الإجابة '.($index_key+1),
                    ]);
                    $index_key++;
                }
                $option_index += 4;
        }
            $Quiz->update(["quiz_mark" => $quiz_mark]);

            $teacher  = Teacher::findOrFail($TeacherId);
            $students = Student::where('class',$teacher->class)->get();
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

    public function showLessons($TeacherId){
        $lessons = Lesson::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_lesson',compact('TeacherId','lessons'));
    }

    public function showAction($TeacherId){
        return view('teacher.choose_action_homework',compact('TeacherId'));
    }

    public function createHomeworks($TeacherId){
        $homeworks = Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.create_homework',compact('TeacherId','homeworks'));
    }

    public function correctHomeworks($TeacherId){
        $homeworks = Homework::where('teacher_id',$TeacherId)->get();
        return view('teacher.correcting_homework',compact('TeacherId','homeworks'));
    }

    public function homeworks($TeacherId){
        $solutions = SolutionStudentForHomework::where('homework_id',request()->homework_id)->get();
        return view('teacher.show_solutions_homework',compact('TeacherId','solutions'));
    }

    public function storeHomeworkGrades(storeHomeworkGrades $request , $StudentId){

        $student_mark = $request->student_mark;
        $homework_id  = $request->homework_id;
        $solution_id  = $request->solution_id;

        HomeworkGrade::create([
            'student_id'    => $StudentId,
            'solution_id'   => $solution_id,
            'student_mark'  => $student_mark,
            'homework_id'   => $homework_id,
        ]);

        $correction_status=SolutionStudentForHomework::where('student_id',$StudentId)
                                                    ->where('homework_id',$homework_id)
                                                    ->first();
        $correction_status->update(['correction_status' => true]);

        return redirect()->back()->with('success','تم تصحيح هذا الواجب بنجاح');
    }

    public function updateHomeworkGrade(updateHomeworkGrades $request , $StudentId){

        $homework_id  = $request->homework_id;
        $student_mark = $request->student_mark;

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
        $quizzes = Quiz::where('teacher_id',$TeacherId)->get();
        return view('teacher.show_results',compact('TeacherId','quizzes'));
    }

    public function showResults($TeacherId){
        $results = QuizResult::where('quiz_id',request()->quiz_id)->get();
        return view('teacher.show_content_results',compact('TeacherId','results'));
    }
}
