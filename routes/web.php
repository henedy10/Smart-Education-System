<?php

use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::controller(SystemController::class)->group(function (){

    Route::get('/','Login')-> name('Login');
    Route::post('/user','checkUser')-> name('checkUser');
    Route::get('/logout','LogOut')-> name('LogOut');

    // Routes of change password

    Route::get('/passwords/edit','EditPassword')-> name('Password.Edit');
    Route::post('/passwords','UpdatePassword')-> name('Password.Update');

    // Routes of Student

    Route::get('/student','showStudent')-> name('student.show');
    Route::get('/content/{class}/{subject}','showStudentContent')->name('content.show');
    Route::get('/lessons/{class}/{subject}','showStudentLesson')->name('student.lesson.show');
    Route::get('/homeworks/{class}/{subject}','showStudentHomework')->name('student.homework.show');
    Route::get('/uploadHomeworks/{class}/{subject}','showHomeworkUploadForm')-> name('student.homeworkUpload.show');
    Route::post('/homeworkSolutions','storeHomeworkSolution')->name('student.homeworkSolution.store');
    Route::get('/action/{class}/{subject}','showChooseAction')->name('student.quizAction.show');
    Route::get('/quizzes/{class}/{subject}','showAvailableQuiz')->name('availableQuiz.show');
    Route::get('/quizContent/{class}/{subject}','showQuizContent')->name('quizContent.show');
    Route::post('/answers/{class}/{subject}','storeQuizAnswers')->name('student.answers.store');
    Route::get('/results/{class}/{subject}','showQuizResults')->name('student.quizResult.show');
    Route::get('/homeworkDetails/{class}/{subject}','showHomeworkDetails')->name('student.homeworkDetails.show');

    //Routes of Teacher

    Route::get('/teacher','showTeacher')->name('teacher.show');
    Route::post('/teacher/{teacher}','storeTeacherResource')->name('teacherResources.store');
    Route::get('/lessons/{teacher}','showTeacherLessons')->name('teacher.lesson.show');
    Route::get('/action/{teacher}','showActionHomework')->name('teacher.homeworkAction.show');
    Route::get('/homework/create/{teacher}','createHomework')->name('teacher.homework.create');
    Route::get('/correctionHomeworks/{teacher}','correctHomework')->name('teacher.homeworkCorrection.show');
    Route::get('/homeworkSolutions/{teacher}','solutionHomeworkOfStudent')->name('teacher.homeworkSolutions.show');
    Route::post('/homeworkGrades','storeHomeworkGrades')-> name('teacher.homeworkGrades.store');
    Route::post('/homeworkGrades/{student}/edit','updateHomeworkGrade')->name('teacher.homeworkGrades.update');
    Route::get('/quiz/{teacher}/create','createQuiz')->name('teacher.quiz.create');
    Route::get('/quizzes/{teacher}','showQuizzes')-> name('quizzes.show');
    Route::get('/results/{teacher}','showResults')-> name('quizResults.show');

});
