<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Homework>
 */
class HomeworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_homework' => 'fake.pdf',
            'content_homework' => fake()->text(),
            'deadline' => now(),
            'title_homework' => fake()->text(),
            'homework_mark' => 5,
            'teacher_id' => Teacher::factory(),
        ];
    }
}
