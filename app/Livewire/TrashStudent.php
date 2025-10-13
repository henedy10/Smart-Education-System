<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class TrashStudent extends Component
{
    public $query = '';

    public function render()
    {
        $students = User::with('student')
                        ->where('user_as','student')
                        ->where('name','LIKE','%'.$this->query.'%')
                        ->onlyTrashed()
                        ->get();

        return view('livewire.trash-student',compact('students'));
    }
}
