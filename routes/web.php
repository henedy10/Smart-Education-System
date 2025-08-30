<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::controller(SystemController::class)->group(function (){

    Route::get('/','Login')-> name('Login');
    Route::post('/user','checkUser')-> name('checkUser');
    Route::get('/logout','LogOut')-> name('LogOut');

    // Routes of change password

    Route::get('/passwords/edit','EditPassword')-> name('EditPassword');
    Route::post('/passwords','UpdatePassword')-> name('UpdatePassword');

    // Routes of Student

    Route::get('/student','showStudent')-> name('student.show');
    Route::get('/content/{class}/{subject}','showStudentContent')->name('show_student_content');
    Route::get('/lessons/{class}/{subject}','showStudentLesson')->name('show_student_lesson');
    Route::get('/homeworks/{class}/{subject}','showStudentHomework')->name('show_student_homework');
    Route::get('/uploadHomeworks/{class}/{subject}','showHomeworkUploadForm')-> name('to_upload_student_homework');
    Route::post('/homeworkSolutions','storeHomeworkSolution')->name('store_student_solution_homework');
    Route::get('/action/{class}/{subject}','showChooseAction')->name('show_student_quiz_action');
    Route::get('/quizzes/{class}/{subject}','showAvailableQuiz')->name('show_student_quizzes');
    Route::get('/quizContent/{class}/{subject}','showQuizContent')->name('show_content_quiz');
    Route::post('/answers/{class}/{subject}','storeQuizAnswers')->name('store_student_answers');
    Route::get('/results/{class}/{subject}','showQuizResults')->name('show_student_quiz_result');
    Route::get('/homeworkDetails/{class}/{subject}','showHomeworkDetails')->name('show_student_homework_grade');

    //Routes of Teacher

    Route::get('/teacher','showTeacher')->name('show_teacher');
    Route::post('/teacher/{teacher}','storeTeacherResource')->name('store_teacher');
    Route::get('/lessons/{teacher}','showTeacherLessons')->name('show_teacher_lessons');
    Route::get('/action/{teacher}','showActionHomework')->name('choose_action_homework');
    Route::get('/homework/create/{teacher}','createHomework')->name('create_teacher_homeworks');
    Route::get('/correctionHomeworks/{teacher}','correctHomework')->name('correct_teacher_homework');
    Route::get('/homeworkSolutions/{teacher}','solutionHomeworkOfStudent')->name('homework_solutions_of_students');
    Route::post('/homeworkGrades','storeHomeworkGrades')-> name('store_grades_homeworks');
    Route::post('/homeworkGrades/{student}/edit','updateHomeworkGrade')->name('modify_grades_homeworks');
    Route::get('/quiz/{teacher}/create','createQuiz')->name('create_teacher_quiz');
    Route::get('/quizzes/{teacher}','showQuizzes')-> name('show_results');
    Route::get('/results/{teacher}','showResults')-> name('show_content_results');

});
