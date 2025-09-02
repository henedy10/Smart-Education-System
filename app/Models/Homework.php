<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table='homeworks';

    protected $guarded=[];

    public function teacher(){
        return $this->belongsTo(User::class);
    }
}
