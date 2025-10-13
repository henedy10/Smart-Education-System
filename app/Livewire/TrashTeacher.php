<?php

namespace App\Livewire;
use App\Models\User;

use Livewire\Component;

class TrashTeacher extends Component
{
    public $query = '';

    public function render()
    {
        $teachers = User::with('teacher')
                        ->where('user_as','teacher')
                        ->where('name','LIKE','%'.$this->query.'%')
                        ->onlyTrashed()
                        ->get();

        return view('livewire.trash-teacher',compact('teachers'));
    }
}
