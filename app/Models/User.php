<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Builder;

class User extends Model
{
    use SoftDeletes,MassPrunable;

    protected $guarded=[];

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subDays(30));
    }

    public function teacher(){
        return $this->hasOne(Teacher::class);
    }

    public function student(){
        return $this->hasOne(Student::class);
    }
}
