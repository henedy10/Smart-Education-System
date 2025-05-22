<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/',[SystemController::class,'index'])->name('index');
Route::get('/show',[SystemController::class,'show'])->name('show');
Route::get('/show/quiz',[SystemController::class,'quiz'])->name('show_quiz');
Route::post('/store/teacher/{teacher}',[SystemController::class,'store_teacher'])->name('store_teacher');
