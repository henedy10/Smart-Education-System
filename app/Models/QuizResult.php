<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable=[
        'student_id',
        'teacher_id',
        'quiz_id',
        'student_mark',
        'quiz_mark',
    ];
}
