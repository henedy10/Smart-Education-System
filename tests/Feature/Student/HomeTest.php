<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_student_can_access_home_page()
    {
        $user = User::factory()->create(['user_as' => 'student']);
        Student::factory()
            ->for($user)
            ->create();

        $this->actingAs($user);

        $response = $this->get('/student');

        $response->assertViewHas('info');
        $response->assertStatus(200);
        $response->assertViewIs('student.show_student');
    }

    public function test_teacher_cannot_access_home_page_of_student()
    {
        $user = User::factory()->create(['user_as' => 'teacher']);
        Teacher::factory()
            ->for($user)
            ->create();

        $this->actingAs($user);

        $response = $this->get('/student');

        $response->assertStatus(403);
    }

    public function test_student_can_show_his_content()
    {
        $student = User::factory()->create(['user_as' => 'student']);
        Student::factory()
            ->for($student)
            ->create();
        $teacher = User::factory()->create(['user_as' => 'teacher']);
        Teacher::factory()
            ->for($teacher)
            ->create();

        $this->actingAs($student);

        $response = $this->get(route('student.content.show',
            [
                'class' => $student->student->class,
                'subject' => $teacher->teacher->subject,
            ]
        ));

        $response->assertStatus(200);
        $response->assertViewIs('student.show_content');
    }

    public function test_teacher_cannot_show_the_content_of_student()
    {
        $student = User::factory()->create(['user_as' => 'student']);
        Student::factory()
            ->for($student)
            ->create();
        $teacher = User::factory()->create(['user_as' => 'teacher']);
        Teacher::factory()
            ->for($teacher)
            ->create();

        $this->actingAs($teacher);

        $response = $this->get(route('student.content.show',
            [
                'class' => $student->student->class,
                'subject' => $teacher->teacher->subject,
            ]
        ));

        $response->assertStatus(403);
    }
}
