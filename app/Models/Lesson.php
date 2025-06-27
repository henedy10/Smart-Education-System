<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable=[
        'teacher_id','file_lesson','title_lesson',
    ];
    public function teacher() {
        return $this->belongsTo(User::class);
    }
}

