<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_lesson' => fake()->text(10),
            'file_lesson' => UploadedFile::fake()->create('solution.pdf'),
            'teacher_id' => Teacher::factory(),
        ];
    }
}
