<?php

use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\User;

test('guest or student can not access the dashboard of teacher', function () {
    $teacherUser = User::factory()->create(['user_as' => 'student']);
    $this->actingAs($teacherUser);

    $response = get('/teacher');

    $response->assertStatus(403);
});

test('teacher can access the dashboard of teacher', function () {
    $teacherUser = User::factory()->create(['user_as' => 'teacher']);
    $teacher = Teacher::factory()->for($teacherUser)->create();
    Lesson::factory()->for($teacher)->create();

    $this->actingAs($teacherUser);

    $response = get('/teacher');
    $response->assertStatus(200);
    $response->assertViewIs('teacher.show_teacher');
    expect($teacher->lessons->count())->toBe(1);
    expect($teacher->homeworks->count())->toBe(0);
    expect($teacher->quizzes->count())->toBe(0);

});
