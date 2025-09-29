<?php

use App\Http\Controllers\AccountUserController;
use App\Http\Controllers\Student\
{
    HomeController,
    HomeworkController,
    LessonController,
    QuizController,
};

use App\Http\Controllers\Teacher\
{
    HomeworkController as TeacherHomeworkController,
    LessonController as TeacherLessonController,
    QuizController as TeacherQuizController,
    DashboardController,
};
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;

Route::middleware(PreventBackHistory::class)->group(function(){
    Route::controller(AccountUserController::class)->group(function ()
    {
        // Route::middleware('checkLogin')->group(function(){
            Route::get('/','index')->name('index');
            Route::get('/passwords/edit','editPassword')->name('Password.Edit');
        // });
        Route::post('/passwords','updatePassword')->middleware('throttle:updatePassword')->name('Password.Update');
        Route::post('/login','login')->middleware('throttle:login')->name('login');
        Route::get('/logout','logout')->name('LogOut');
    });

    /** Student Routes */
        Route::middleware('CheckStudent')->group(function()
        {
            Route::name('student.')->group(function()
            {
                Route::controller(HomeController::class)->group(function()
                {
                    Route::get('/student','index')->name('index');
                    Route::get('/content/{class}/{subject}','showContent')->name('content.show');
                });

                Route::controller(LessonController::class)->group(function()
                {
                    Route::get('/lessons/{class}/{subject}','index')->name('lesson.show');
                });

                Route::controller(HomeworkController::class)->group(function()
                {
                    Route::prefix('/homeworks/{class}/{subject}')->group(function ()
                    {
                        Route::get('','index')->name('homework.show');
                        Route::get('/solutions/create','createSolution')->name('homeworkSolution.create');
                        Route::post('/solutions/store','storeSolution')->name('homeworkSolution.store');
                        Route::get('/details','showGrade')->name('homeworkDetails.show');
                    });
                });

                Route::controller(QuizController::class)->group(function()
                {
                    Route::prefix('/quiz/{class}/{subject}')->group(function ()
                    {
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

        Route::middleware('CheckTeacher')->group(function()
        {
            Route::name('teacher.')->group(function()
            {
                Route::controller(DashboardController::class)->group(function()
                {
                    Route::get('/teacher','index')->name('index');
                });

                Route::controller(TeacherLessonController::class)->group(function()
                {
                    Route::prefix('/lessons/{teacher}')->group(function()
                    {
                        Route::post('','store')->name('lessons.store');
                        Route::get('','index')->name('lessons.show');
                    });
                });

                Route::controller(TeacherHomeworkController::class)->group(function()
                {
                    Route::prefix('/homeworks/teacher/{teacher}')->group(function()
                    {
                        Route::post('','storeHomework')->name('homeworks.store');
                        Route::get('/create','createHomework')->name('homeworks.create');
                        Route::get('/solutions','indexSolution')->name('homeworks.show');
                        Route::get('/correction','indexHomework')->name('homeworkCorrection.show');
                        Route::get('/action','showAction')->name('homeworkAction.show');
                    });

                    Route::prefix('/homeworks/{student}/grades')->group(function()
                    {
                        Route::post('','storeHomeworkGrades')-> name('homeworkGrades.store');
                        Route::put('','updateHomeworkGrade')->name('homeworkGrades.update');
                    });
                });

                Route::controller(TeacherQuizController::class)->group(function()
                {
                    Route::prefix('/quizzes/{teacher}')->group(function()
                    {
                        Route::post('','storeQuiz')->name('quizzes.store');
                        Route::get('/create','createQuiz')->name('quizzes.create');
                        Route::get('','showQuiz')-> name('quizzes.show');
                        Route::get('/results','showResult')-> name('quizResults.show');
                    });
                });
            });
        });

});



