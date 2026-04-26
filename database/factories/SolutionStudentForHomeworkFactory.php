<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class SolutionStudentForHomeworkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'homework_id' => Homework::factory(),
            'homework_solution_file' => UploadedFile::fake()->create('solution.pdf'),
            'correction_status' => $this->faker->boolean,
        ];
    }
}
