<?php

namespace App\Livewire;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class SearchTeacher extends Component
{
    public $query = '';

    public function render()
    {
        $teachers = Teacher::whereHas('user', function (Builder $query) {
            $query->whereNull('deleted_at')
                ->where('name', 'LIKE', '%'.$this->query.'%');
        })->get();

        $count_teachers_trashed = User::onlyTrashed()->where('user_as', 'teacher')->count();

        return view('livewire.search-teacher', compact('teachers', 'count_teachers_trashed'));
    }
}
