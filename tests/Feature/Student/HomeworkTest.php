<?php

namespace Tests\Feature\Student;

use App\Models\Homework;
use App\Models\HomeworkGrade;
use App\Models\SolutionStudentForHomework;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\UploadedFile;
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

    public function test_user_can_upload_solution_for_homework_for_one_time()
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
        $Homework = Homework::factory()->for($teacher, 'teacher')->create();

        $response = $this->post(route('student.homeworkSolution.store',
            [
                'class' => $student->class,
                'subject' => $teacher->subject,
                'homeworkId' => $Homework->id,
            ]),
            [
                'file' => UploadedFile::fake()->create('solution.pdf', 100),
            ]);

        $response->assertRedirectBack();
        $response->assertSessionHas('success', __('messages.success_store_homework_solution'));
    }

    public function test_user_cannot_upload_solution_for_homework_twice()
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
        $Homework = Homework::factory()->for($teacher, 'teacher')->create();

        $response = $this->post(route('student.homeworkSolution.store',
            [
                'class' => $student->class,
                'subject' => $teacher->subject,
                'homeworkId' => $Homework->id,
            ]),
            [
                'file' => UploadedFile::fake()->create('solution.pdf', 100),
            ]);
        $response->assertRedirectBack();
        $response->assertSessionHas('success', __('messages.success_store_homework_solution'));
        $response = $this->post(route('student.homeworkSolution.store',
            [
                'class' => $student->class,
                'subject' => $teacher->subject,
                'homeworkId' => $Homework->id,
            ]),
            [
                'file' => UploadedFile::fake()->create('solution2.pdf', 100),
            ]);

        $response->assertRedirectBack();
        $response->assertSessionHas('failed', __('messages.no_more_upload_solution'));
    }

    public function test_user_can_access_show_grade_of_his_solution_for_homework()
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
        $Homework = Homework::factory()->for($teacher, 'teacher')->create();
        $solution = SolutionStudentForHomework::factory()
            ->for($student, 'student')
            ->for($Homework, 'homework')
            ->create();

        $grade = HomeworkGrade::factory()
            ->for($student, 'student')
            ->for($Homework, 'homework')
            ->for($solution, 'studentSolution')
            ->create();
        $response = $this->get(route('student.homeworkDetails.show',
            [
                'class' => $student->class,
                'subject' => $teacher->subject,
                'homeworkId' => $Homework->id,
            ]));

        $Grade = SolutionStudentForHomework::with('homeworkGrade')
            ->where('student_id', $student->id)
            ->where('homework_id', $Homework->id)
            ->first();

        $response->assertViewIs('student.show_homework_grade');
        $response->assertSuccessful();
        $response->assertSee(__('messages.previous-page'));
        $response->assertSee(__('messages.grade'));

    }
}
