<?php

namespace Tests\Feature\Student;

use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Tests\TestCase;

class QuizTest extends TestCase
{
    public function test_user_can_access_show_action_page()
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

        $response = $this->get(route('student.quizAction.show', [
            'class' => $student->class,
            'subject' => $teacher->subject,
        ]));

        $response->assertSuccessful();
        $response->assertViewIs('student.show_action_content_quiz');
    }

    public function test_user_can_access_show_available_quiz_page()
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

        $response = $this->get(route('student.availableQuiz.show', [
            'class' => $student->class,
            'subject' => $teacher->subject,
        ]));

        $response->assertSuccessful();
        $response->assertViewIs('student.show_quiz');
    }

    public function test_user_can_access_show_content_quiz_page_even_if_there_is_no_quiz()
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

        $response = $this->get(route('student.quizContent.show', [
            'class' => $teacher->class,
            'subject' => $teacher->subject,
        ]));
        $response->assertViewIs('student.show_content_quiz');
        $response->assertSeeText(__('messages.no_quiz'));
    }

    public function test_user_can_access_show_content_of_exist_quiz_page()
    {
        $studentUser = User::factory()->create(['user_as' => 'student']);
        Student::factory()
            ->for($studentUser)
            ->create();
        $teacherUser = User::factory()->create(['user_as' => 'teacher']);
        $teacher = Teacher::factory()
            ->for($teacherUser)
            ->create();

        $this->actingAs($studentUser);

        $quiz = Quiz::factory()->for($teacher, 'teacher')->create();
        $question = Question::factory()->for($quiz, 'quiz')->create();
        Option::factory()->for($question, 'question')->create();

        $response = $this->get(route('student.quizContent.show', [
            'class' => $teacher->class,
            'subject' => $teacher->subject,
        ]));
        $response->assertViewIs('student.show_content_quiz');
        $response->assertSeeText(__('messages.time_remaining'));
    }

    public function test_user_can_store_his_answers_for_the_quiz()
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

        $quiz = Quiz::factory()->for($teacher, 'teacher')->create();
        Question::factory()->for($quiz, 'quiz')->create();
        $response = $this->post(route('student.answers.store', [
            'class' => $teacher->class,
            'subject' => $teacher->subject,
        ]), ['1' => 'الإجابة 1']);
        $response->assertSuccessful();
        $response->assertViewIs('student.show_result');
        $this->assertDatabaseCount('student_options', '1');
        $response->assertSeeText(__('messages.grade'));
    }

    public function test_user_can_see_his_result()
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
        $quiz = Quiz::factory()->for($teacher, 'teacher')->create();
        QuizResult::factory()
            ->for($teacher, 'teacher')
            ->for($student, 'student')
            ->for($quiz, 'quiz')
            ->create();

        $response = $this->get(route('student.results.show', [
            'class' => $teacher->class,
            'subject' => $teacher->subject,
        ]));

        $response->assertSuccessful();
        $response->assertViewIs('student.show_quiz_results');
    }
}
