<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/',[SystemController::class,'index']);
Route::get('/student',[SystemController::class,'create_student']);
Route::get('/teacher',[SystemController::class,'create_teacher']);
Route::get('/choose',[SystemController::class,'choose']);
