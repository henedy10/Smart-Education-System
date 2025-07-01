<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeworkGrade extends Model
{
    protected $fillable=[
        'student_id',
        'homework_id',
        'student_mark',
    ];
}
