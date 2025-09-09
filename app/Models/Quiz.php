<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $guarded=[];
    protected $casts = [
        'start_time' => 'datetime',
    ];
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    public function quizResult(){
        return $this->belongsTo(QuizResult::class);
    }
    public function questions(){
        return $this->hasMany(Question::class);
    }
}
