<?php

namespace App\Livewire;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\{
    Quiz,
    Question,
};

class QuizAvailability extends Component
{
    public $start_time;
    public $end_time;
    public $isAvailable=false;
    public $quiz;
    public $class;
    public $subject;
    public $num_questions;

    public function mount(Quiz $quiz,$class,$subject){
        $this->quiz=$quiz;
        $this->class=$class;
        $this->subject=$subject;
        if($this->quiz){
            $this->start_time = $quiz->start_time;
            $this->end_time = $quiz->start_time->copy()->addMinutes(2);
            $this->num_questions=Question::where('quiz_id',$this->quiz->id)->count();
        }
    }

    public function checkAvailability(){

        if(now()->between($this->start_time,$this->end_time)){
            $this->isAvailable=true;
        }else{
            $this->isAvailable=false;
        }
    }

    public function render()
    {
        $this->checkAvailability();
        return view('livewire.quiz-availability');
    }
}
