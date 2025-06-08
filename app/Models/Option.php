<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable=[
        'quiz_id','option_title','option_key'
    ];
    public function  question(){
return $this->belongsTo(Question::class);
    }
}
