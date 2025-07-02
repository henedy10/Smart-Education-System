<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkGrade extends Model
{
    protected $fillable=[
        'student_id',
        'homework_id',
        'student_mark',
    ];
    public function homework (){
        return $this->belongsTo(Homework::class);
    }
}
