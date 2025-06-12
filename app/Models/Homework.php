<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table='homeworks';
    protected $fillable=[
    'teacher_id',
    'file_homework',
    'content_homework',
    'title_homework',
    'deadline',
    ];

    public function teacher(){
        return $this->belongsTo(User::class);
    }
}
