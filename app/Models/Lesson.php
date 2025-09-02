<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded=[];
    public function teacher() {
        return $this->belongsTo(User::class);
    }
}

