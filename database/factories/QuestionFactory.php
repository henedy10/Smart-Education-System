<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'title' => fake()->text(10),
            'correct_option' => 'الإجابة 1',
            'question_mark' => fake()->randomNumber(2),
        ];
    }
}
