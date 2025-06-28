<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable=[
        'teacher_id',
        'title',
        'description',
        'start_time',
        'duration',
        'quiz_mark',
    ];
    public function teacher(){
        return $this->belongsTo(User::class);
    }
}
