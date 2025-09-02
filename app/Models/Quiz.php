<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $guarded=[];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];
    public function teacher(){
        return $this->belongsTo(User::class);
    }
}
