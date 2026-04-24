<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }
}
