<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\
{
    Student,
    User,
};
use Illuminate\Database\Eloquent\Builder;

class SearchStudent extends Component
{
    public $query = '';
    public function render()
    {
        $students = Student::whereHas('user', function (Builder $query) {
                    $query->whereNull('deleted_at')
                            ->where('name','LIKE','%'.$this->query.'%');})->get();

        $count_students_trashed = User::onlyTrashed()->where('user_as' , 'student')->count();
        return view('livewire.search-student',compact('students','count_students_trashed'));
    }
}
