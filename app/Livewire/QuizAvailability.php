<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\
{
    Quiz,
    Question,
    QuizResult,
    Student,
};

class QuizAvailability extends Component
{
    public $start_time;
    public $end_time;
    public $isAvailable = false;
    public $quiz;
    public $class;
    public $subject;
    public $num_questions;
    public $check_student_quiz;

    public function mount($quiz,$class,$subject){
        $this->quiz    = $quiz;
        $this->class   = $class;
        $this->subject = $subject;

        if($this->quiz){
            $this->start_time = $quiz->start_time;
            $this->end_time   = $quiz->start_time->copy()->addMinutes(2);
            $this->num_questions=Question::where('quiz_id',$this->quiz->id)->count();
        }
    }

    public function checkAvailability(){
        if($this->quiz){
            $student = Student::where('user_id',session('id'))->first();
            $this->check_student_quiz = QuizResult::where('quiz_id',$this->quiz->id)
            ->where('student_id',$student->id)
            ->where('test',1)
            ->first();

            if(now()->between($this->start_time,$this->end_time)){
                $this->isAvailable = true;
            }

            if((!now()->between($this->start_time,$this->end_time))||isset($this->check_student_quiz)){
                $this->isAvailable = false;
            }
        }
    }

    public function render()
    {
        $this->checkAvailability();
        return view('livewire.quiz-availability');
    }
}
