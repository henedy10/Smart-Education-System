<?php

namespace Tests\Feature\Student;

use App\Models\Lesson;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Tests\TestCase;

class LessonTest extends TestCase
{
    public function test_user_can_access_show_lesson_page()
    {
        $studentUser = User::factory()->create(['user_as' => 'student']);
        $student = Student::factory()
            ->for($studentUser)
            ->create();

        $teacherUser = User::factory()->create(['user_as' => 'teacher']);
        $teacher = Teacher::factory()
            ->for($teacherUser)
            ->create(['class' => $student->class]);

        Lesson::factory()->for($teacher, 'teacher')->create();

        $this->actingAs($studentUser);

        $response = $this->get(route('student.lesson.show', [
            'class' => $teacher->class,
            'subject' => $teacher->subject,
        ]));

        $response->assertSuccessful();
        $response->assertViewIs('student.show_lesson');
    }
}
