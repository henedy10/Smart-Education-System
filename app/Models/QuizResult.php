<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    protected $fillable=[
        'student_id',
        'teacher_id',
        'quiz_id',
        'student_mark',
        'quiz_mark',
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
}
