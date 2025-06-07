<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student_Option extends Model
{
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
