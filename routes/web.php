<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/',[SystemController::class,'index'])->name('index');
Route::get('/create/student',[SystemController::class,'create_student'])->name('create_student');
Route::get('/create/teacher',[SystemController::class,'create_teacher'])->name('create_teacher');
Route::get('/choose',[SystemController::class,'choose'])->name('choose');
Route::get('/show/student',[SystemController::class,'show_student'])->name('show_student');
Route::get('/show/teacher',[SystemController::class,'show_teacher'])->name('show_teacher');
