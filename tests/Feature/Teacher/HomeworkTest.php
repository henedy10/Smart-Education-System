<?php

use App\Models\Homework;
use App\Models\Teacher;
use App\Models\User;

beforeEach(function () {
    $this->teacherUser = User::factory()->create(['user_as' => 'teacher']);
    $this->teacher = Teacher::factory()->for($this->teacherUser)->create();
});

test('teacher can access choose action for homework page', function () {

    $this->actingAs($this->teacherUser);
    $response = get(route('teacher.homeworkAction.show', ['teacherId' => $this->teacher->id]));

    $response->assertStatus(200);
    $response->assertViewIs('teacher.choose_action_homework');
});

test('teacher can access correction homework page', function () {

    Homework::factory(2)->for($this->teacher, 'teacher')->create();
    $this->actingAs($this->teacherUser);
    $homeworks = Homework::where('teacher_id', $this->teacher->id)->get();
    $response = get(route('teacher.homeworkCorrection.show', ['teacherId' => $this->teacher->id]));

    $response->assertStatus(200);
    $response->assertViewIs('teacher.correcting_homework');
    expect($homeworks->count())->toEqual(2);
});
