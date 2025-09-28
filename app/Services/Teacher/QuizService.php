<?php

namespace App\Services\Teacher;

use App\Models\{Quiz,Question,Option,Teacher,Student,QuizResult};

class QuizService
{
    public function create($request,$TeacherId)
    {
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

        $Quiz = Quiz::create([
                'teacher_id'  => $TeacherId,
                'title'       => $quiz_title,
                'description' => $quiz_description,
                'start_time'  => $quiz_date,
                'duration'    => $quiz_duration,
                'quiz_mark'   => $quiz_mark,
            ]);

        for($i = 0; $i<sizeof($question_title); $i++){
            $index_key = 0;
            $question  = Question::create([
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

            return $Quiz;
    }

    public function getAll($TeacherId)
    {
        $quizzes = Quiz::where('teacher_id',$TeacherId)->get();
        return $quizzes;
    }

    public function getResults($quizId)
    {
        $results = QuizResult::where('quiz_id',$quizId)->get();
        return $results;
    }


}
