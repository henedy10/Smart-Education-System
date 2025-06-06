<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/',[SystemController::class,'index'])->name('index');

Route::get('/show',[SystemController::class,'login'])->name('login');
Route::get('/show/student',[SystemController::class,'show_student'])->name('show_student');
Route::get('/show/content/{class}/{subject}/lessons',[SystemController::class,'show_student_lesson'])->name('show_student_lesson');
Route::get('/show/content/{class}/{subject}',[SystemController::class,'show_student_content'])->name('show_student_content');
Route::get('/show/content/{class}/{subject}/homeworks',[SystemController::class,'show_student_homework'])->name('show_student_homework');
Route::get('/show/quiz/{class}/{subject}',[SystemController::class,'show_student_quizzes'])->name('show_student_quizzes');
Route::get('/log_out',[SystemController::class,'log_out_student'])->name('log_out_student');

Route::get('/show/teacher',[SystemController::class,'show_teacher'])->name('show_teacher');
Route::post('/store/teacher/{teacher}',[SystemController::class,'store_teacher'])->name('store_teacher');
Route::get('/show/teacher/{teacher}/lessons',[SystemController::class,'show_teacher_lessons'])->name('show_teacher_lessons');
Route::get('/show/teacher/{teacher}/homeworks',[SystemController::class,'show_teacher_homeworks'])->name('show_teacher_homeworks');
