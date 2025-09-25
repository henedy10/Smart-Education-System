<?php

use App\Http\Controllers\{
        AccountUserController,
        StudentController,
        TeacherController,
};

use Illuminate\Support\Facades\Route;

Route::controller(AccountUserController::class)->group(function (){
    // Route::middleware('checkLogin')->group(function(){
        Route::get('/','index')->name('index');
        Route::get('/passwords/edit','EditPassword')->name('Password.Edit');
    // });
    Route::post('/passwords','UpdatePassword')->middleware('throttle:updatePassword')->name('Password.Update');
    Route::post('/login','login')->middleware('throttle:login')->name('login');
    Route::get('/logout','LogOut')->name('LogOut');
});

/** Student Routes */

Route::controller(StudentController::class)->group(function (){
    Route::middleware('CheckStudent')->group(function(){
        Route::name('student.')->group(function(){
            Route::get('/student','index')->name('index');
            Route::get('/content/{class}/{subject}','showContent')->name('content.show');
            Route::get('/lessons/{class}/{subject}','showLesson')->name('lesson.show');

            Route::prefix('/homeworks/{class}/{subject}')->group(function (){
                Route::get('','showHomework')->name('homework.show');
                Route::get('/solutions/create','createHomeworkSolution')->name('homeworkSolution.create');
                Route::post('/solutions/store','storeHomeworkSolution')->name('homeworkSolution.store');
                Route::get('/details','showHomeworkDetails')->name('homeworkDetails.show');
            });

            Route::prefix('/quiz/{class}/{subject}')->group(function (){
                Route::get('/action','showAction')->name('quizAction.show');
                Route::get('','showAvailableQuiz')->name('availableQuiz.show');
                Route::get('/content','showQuizContent')->name('quizContent.show');
                Route::post('/answers','storeAnswers')->name('answers.store');
                Route::get('/results','showResults')->name('results.show');
            });
        });
    });
});

/** Teacher Routes */

Route::controller(TeacherController::class)->group(function (){
    Route::middleware('CheckTeacher')->group(function(){
        Route::name('teacher.')->group(function(){
            Route::get('/teacher','index')->name('index');

            Route::prefix('/lessons/{teacher}')->group(function(){
                Route::post('','storeLessons')->name('lessons.store');
                Route::get('','showLessons')->name('lessons.show');
            });

            Route::prefix('/homeworks/teacher/{teacher}')->group(function(){
                Route::post('','storeHomeworks')->name('homeworks.store');
                Route::get('/create','createHomeworks')->name('homeworks.create');
                Route::get('/solutions','homeworks')->name('homeworks.show');
                Route::get('/correction','correctHomeworks')->name('homeworkCorrection.show');
                Route::get('/action','showAction')->name('homeworkAction.show');
            });

            Route::prefix('/homeworks/{student}/grades')->group(function(){
                Route::post('','storeHomeworkGrades')-> name('homeworkGrades.store');
                Route::put('','updateHomeworkGrade')->name('homeworkGrades.update');
            });

            Route::prefix('/quizzes/{teacher}')->group(function(){
                Route::post('','storeQuiz')->name('quizzes.store');
                Route::get('/create','createQuiz')->name('quizzes.create');
                Route::get('','showQuizzes')-> name('quizzes.show');
                Route::get('/results','showResults')-> name('quizResults.show');
            });
        });
    });
});



