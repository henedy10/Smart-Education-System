<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/',[SystemController::class,'index'])->name('index');
Route::get('/show',[SystemController::class,'show'])->name('show');
Route::get('/show/content/{class}/{subject}/lessons',[SystemController::class,'show_student_lesson'])->name('show_student_lesson');
Route::get('/show/content/{class}/{subject}',[SystemController::class,'show_student_content'])->name('show_student_content');
Route::get('/show/content/{class}/{subject}/homeworks',[SystemController::class,'show_student_homework'])->name('show_student_homework');



Route::get('/show/quiz',[SystemController::class,'quiz'])->name('show_quiz');
Route::post('/store/teacher/{teacher}',[SystemController::class,'store_teacher'])->name('store_teacher');
