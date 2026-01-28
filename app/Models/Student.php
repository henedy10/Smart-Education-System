<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user()  {
        return $this->belongsTo(User::class);
    }

    public function homeworkGrades(){
        return $this->hasMany(HomeworkGrade::class);
    }

    public function homeworkSolutions(){
        return $this->hasMany(SolutionStudentForHomework::class);
    }

    public function quizResults(){
        return $this->hasMany(QuizResult::class);
    }
}
