<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\{
    Quiz,
    Question,
};
class QuizAvailability extends Component
{
    public $quiz;
    public $isAvailable=false;
    public $num_questions;

    public function mount(Quiz $quiz){
        if(now()->between($this->quiz->start_time,$this->quiz->start_time->copy()->addSeconds(30))){

            $this->quiz = $quiz;
            $this->isAvailable = true;
            $this->num_questions = Question::where('quiz_id',$this->quiz->id)->count();

        }
    }

    public function render()
    {
        return view('livewire.quiz-availability');
    }
}
