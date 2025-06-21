<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=[
        'quiz_id','title','correct_option','question_mark',
    ];
    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }
}
