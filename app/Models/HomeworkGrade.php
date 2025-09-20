<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkGrade extends Model
{
    protected $guarded=[];

    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function studentSolution(){
        return $this->belongsTo(SolutionStudentForHomework::class,'solution_id');
    }
    public function homework (){
        return $this->belongsTo(Homework::class);
    }
}
