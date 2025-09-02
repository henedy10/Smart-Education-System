<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolutionStudentForHomework extends Model
{
    protected $table='student_homework_solutions';

    protected $guarded=[];

    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function homework(){
        return $this->belongsTo(Homework::class);
    }


}
