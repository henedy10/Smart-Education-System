<?php

namespace Tests\Feature\Student;

use App\Models\Homework;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Tests\TestCase;

class HomeworkTest extends TestCase
{
    public function test_user_can_access_homeworks_list_page()
    {
        $studentUser = User::factory()->create(['user_as' => 'student']);
        $student = Student::factory()
            ->for($studentUser)
            ->create();

        $teacherUser = User::factory()->create(['user_as' => 'teacher']);
        $teacher = Teacher::factory()
            ->for($teacherUser)
            ->create();

        $this->actingAs($studentUser);

        $homeworks = Homework::factory(5)->for($teacher, 'teacher')->create();
        $response = $this->get(route('student.homework.show',
            [
                'class' => $student->class,
                'subject' => $teacher->subject,
            ]));

        $response->assertViewIs('student.show_homework');
        $response->assertSuccessful();
        $response->assertSee(__('messages.homeworks'));
        foreach ($homeworks as $homework) {
            $response->assertSeeText($homework->title);
        }
    }

    public function test_user_can_access_homeworks_list_page_if_empty()
    {
        $studentUser = User::factory()->create(['user_as' => 'student']);
        $student = Student::factory()
            ->for($studentUser)
            ->create();

        $teacherUser = User::factory()->create(['user_as' => 'teacher']);
        $teacher = Teacher::factory()
            ->for($teacherUser)
            ->create();

        $this->actingAs($studentUser);
        $response = $this->get(route('student.homework.show',
            [
                'class' => $student->class,
                'subject' => $teacher->subject,
            ]));

        $response->assertViewIs('student.show_homework');
        $response->assertSuccessful();
        $response->assertSee(__('messages.no_homework'));

    }

    public function test_user_can_access_specific_homework_page()
    {
        $student = User::factory()->create(['user_as' => 'student']);
        Student::factory()
            ->for($student)
            ->create(['class' => 'A1']);

        $teacher = User::factory()->create(['user_as' => 'teacher']);
        Teacher::factory()
            ->for($teacher)
            ->create(['subject' => 'math']);

        $Homework = Homework::factory()->create();
        $this->actingAs($student);
        $response = $this->get(route('student.homeworkSolution.create',
            [
                'class' => $student->student->class,
                'subject' => $teacher->teacher->subject,
                'homeworkId' => $Homework->id,
            ]));
        $response->assertViewIs('student.show_homework_uploading');
        $response->assertSuccessful();
        $response->assertSeeText(__('messages.upload_homework_solution'));
    }
}
