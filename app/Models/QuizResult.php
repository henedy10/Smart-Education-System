<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    protected $guarded=[];

    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
    public function teacher(){
        return $this->hasMany(Teacher::class);
    }
}
