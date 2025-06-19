<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentOption extends Model
{
    protected $fillable=[
        'student_id',
        'quiz_id',
        'question_id',
        'select_option',
        'status_option',
    ];
    public function student(){
        return $this->belongsTo(User::class);
    }
    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
    public function option(){
        return $this->belongsTo(Question::class);
    }
}
