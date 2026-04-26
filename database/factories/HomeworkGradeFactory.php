<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\HomeworkGrade;
use App\Models\SolutionStudentForHomework;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HomeworkGrade>
 */
class HomeworkGradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'homework_id' => Homework::factory(),
            'solution_id' => SolutionStudentForHomework::factory(),
            'student_mark' => $this->faker->numberBetween(0, 100),
        ];
    }
}
