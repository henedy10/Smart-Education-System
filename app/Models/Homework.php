<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homeworks';

    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function homeworkGrades()
    {
        return $this->hasMany(HomeworkGrade::class);
    }

    public function homeworkSolutions()
    {
        return $this->hasMany(SolutionStudentForHomework::class);
    }
}
