<?php

namespace App\Services\Student;

use App\Traits\UserHelper;
use App\Models\
{
    Teacher,
    Student,
    Quiz,
    Option,
    StudentOption,
    QuizResult,
};

class QuizService
{
    use UserHelper;

    public function showAvailableQuiz($class, $subject)
    {
        $quiz = Quiz::whereHas('teacher',function($q) use($class,$subject){
            $q->where('class',$class)->where('subject',$subject);
        })
        ->orderBy('start_time','desc')
        ->first();

        return $quiz;
    }

    public function showContentQuiz($class,$subject)
    {
        $teacherId = Teacher::where('class',$class)
                    ->where('subject',$subject)
                    ->value('id');

        $quiz = Quiz::with('questions')
                    ->where('teacher_id',$teacherId)
                    ->orderBy('start_time','desc')
                    ->first();
        $options = [];

        if($quiz->count() == 1)
        {
            foreach($quiz->questions as $Q)
            {
                $options[$Q->id] = Option::where('question_id',$Q->id)->get();
            }
        }

        return
        [
            'quiz'    => $quiz,
            'options' => $options,
        ];
    }

    public function storeAnswer($class,$subject)
    {
        $studentMark     = 0;
        $check_selection = [];
        $userId  = $this->getUserId();

        $student = Student::with('user')->firstWhere('user_id',$userId);

        $teacherId = Teacher::where('class',$class)
                                ->where('subject',$subject)
                                ->value('id');

        $quiz = Quiz::with('questions')
                            ->where('teacher_id',$teacherId)
                            ->orderBy('start_time','desc')
                            ->first();

        foreach($quiz->questions as $Q)
        {
            $options                 = request()->answer;
            $check_selection[$Q->id] = (isset($options[$Q->id]) && $Q -> correct_option == $options[$Q->id]) ? true : false;

            StudentOption::create([
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

        if($student_result)
        {
            $student_result->update([
                'student_mark' => $studentMark,
                'test'         => true,
            ]);
        }

        return
        [
            'student'     => $student,
            'quiz'        => $quiz,
            'studentMark' => $studentMark,
        ];
    }

    public function showResult($class, $subject)
    {
        $userId    = $this->getUserId();
        $studentId = Student::where('user_id',$userId)->value('id');
        $teacherId = Teacher::where('class',$class)
                            ->where('subject',$subject)
                            ->value('id');

        $results = QuizResult::where('student_id',$studentId)
                            ->where('teacher_id',$teacherId)
                            ->orderBy('created_at','desc')
                            ->get();

        return $results;
    }
}
