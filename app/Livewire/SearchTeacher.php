<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\
{
    Teacher,
    User,
};
use Illuminate\Database\Eloquent\Builder;

class SearchTeacher extends Component
{
    public $query = '';
    public function render()
    {
        $teachers = Teacher::whereHas('user', function (Builder $query) {
                    $query->whereNull('deleted_at')
                        ->where('name','LIKE','%'.$this->query.'%')
                    ;})->get();

        $count_teachers_trashed = User::onlyTrashed()->where('user_as' , 'teacher')->count();
        return view('livewire.search-teacher',compact('teachers','count_teachers_trashed'));
    }
}
