<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::controller(SystemController::class)->group(function (){

    Route::view('/','index');

    // Routes of Student

    Route::get('/show','login')->name('login');
    Route::get('/show/student','show_student')->name('show_student');
    Route::get('/show/content/{class}/{subject}','show_student_content')->name('show_student_content');
    Route::get('/show/content/{class}/{subject}/lessons','show_student_lesson')->name('show_student_lesson');
    Route::get('/show/content/{class}/{subject}/homeworks','show_student_homework')->name('show_student_homework');
    Route::get('/show/content/{class}/{subject}/homeworks/upload','upload_homework')->name('upload_student_homework');
    Route::get('/show/quiz/{class}/{subject}','show_student_quizzes')->name('show_student_quizzes');
    Route::get('/show/{class}/{subject}/content/quiz','show_content_quiz')->name('show_content_quiz');
    Route::post('/store/{class}/{subject}/student/answers','store_student_answers')->name('store_student_answers');
    Route::get('/log_out','log_out_student')->name('log_out_student');

    //Routes of Teacher

    Route::get('/show/teacher','show_teacher')->name('show_teacher');
    Route::post('/store/teacher/{teacher}','store_teacher')->name('store_teacher');
    Route::get('/show/teacher/{teacher}/lessons','show_teacher_lessons')->name('show_teacher_lessons');
    Route::get('/show/teacher/{teacher}/homeworks/create','create_teacher_homeworks')->name('create_teacher_homeworks');
    Route::get('/show/teacher/{teacher}/homeworks','choose_action_homework')->name('choose_action_homework');

    Route::get('/create/teacher/{teacher}/quiz','create_teacher_quiz')->name('create_teacher_quiz');
    Route::get('/show/teacher/{teacher}/quiz/results','show_results')->name('show_results');

});
