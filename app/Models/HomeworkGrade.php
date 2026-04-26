<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkGrade extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentSolution()
    {
        return $this->belongsTo(SolutionStudentForHomework::class, 'solution_id');
    }

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }
}
