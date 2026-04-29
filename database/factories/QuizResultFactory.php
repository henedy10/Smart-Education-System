<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuizResult>
 */
class QuizResultFactory extends Factory
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
            'quiz_id' => Quiz::factory(),
            'teacher_id' => Teacher::factory(),
            'student_mark' => $this->faker->numberBetween(0, 100),
            'quiz_mark' => $this->faker->numberBetween(0, 100),
            'test' => $this->faker->boolean(),
        ];
    }
}
