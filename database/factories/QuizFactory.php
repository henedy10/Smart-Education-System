<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'title' => fake()->text(10),
            'description' => fake()->text(),
            'start_time' => fake()->time(),
            'duration' => fake()->randomNumber(3),
            'quiz_mark' => fake()->randomNumber(3),
        ];
    }
}
