<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AccountUserApiController;
use App\Http\Controllers\api\Admin\DashboardApiController as AdminDashboardApiController;
use App\Http\Controllers\api\Admin\StudentApiController;
use App\Http\Controllers\api\Admin\TeacherApiController;
use App\Http\Controllers\api\Student\
{
    HomeApiController,
    HomeworkApiController,
    LessonApiController,
    QuizApiController,
};

use App\Http\Controllers\api\Teacher\
{
    HomeworkApiController as TeacherHomeworkApiController,
    LessonApiController as TeacherLessonApiController,
    QuizApiController as TeacherQuizApiController,
    DashboardApiController,
};

// use App\Http\Middleware\api\
// {
//     CheckAdminApi,
//     PreventBackHistoryApi,
//     SetLocaleApi,
// };

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['SetLocaleApi'])->group(function(){
    Route::controller(AccountUserApiController::class)->group(function ()
    {
        Route::post('/passwords','updatePassword')->middleware('throttle:updatePasswordApi');
        Route::post('/login','login')->middleware('throttle:loginApi');
        Route::get('/logout','logout')->middleware('auth:sanctum');
    });

    /** Admin Routes */
    Route::middleware(['auth:sanctum','CheckAdminApi'])->group(function(){
        Route::controller(AdminDashboardApiController::class)->group(function(){
            Route::get('/admin/dashboard' , 'index');
        });

        Route::controller(StudentApiController::class)->group(function(){
            Route::get('/students','index');
            Route::post('/students','store');
            Route::put('/students/{user}','update');
            Route::delete('/students/{user}/trash','trash');
            Route::get('/students/trashed','indexTrash');
            Route::delete('/students/{user}/force-delete','forceDelete');
            Route::post('/students/{user}/restore','restore');
        });

        Route::controller(TeacherApiController::class)->group(function(){
            Route::get('/teachers','index');
            Route::put('/teachers/{user}','update');
            Route::post('/teachers','store');
            Route::delete('/teachers/{user}/trash','trash');
            Route::get('/teachers/trashed','indexTrash');
            Route::delete('/teachers/{user}/force-delete','forceDelete');
            Route::post('/teachers/{user}/restore','restore');
        });
    });

    /** Student Routes */
        Route::middleware(['auth:sanctum','CheckStudentApi'])->group(function()
        {
            Route::controller(HomeApiController::class)->group(function()
            {
                Route::get('/student','index');
            });

            Route::controller(LessonApiController::class)->group(function()
            {
                Route::get('/lessons/{class}/{subject}','index');
            });

            Route::controller(HomeworkApiController::class)->group(function()
            {
                Route::prefix('/homeworks/{class}/{subject}')->group(function ()
                {
                    Route::get('','index');
                    Route::post('/{homeworkId}/solutions/store','storeSolution');
                    Route::get('/{homeworkId}/grade','showGrade');
                });
            });

            Route::controller(QuizApiController::class)->group(function()
            {
                Route::prefix('/quiz/{class}/{subject}')->group(function ()
                {
                    Route::get('','showAvailableQuiz');
                    Route::get('/content','showQuizContent');
                    Route::post('/answers','storeAnswer');
                    Route::get('/results','indexResult');
                });
            });
        });

    /** Teacher Routes */

        Route::middleware(['auth:sanctum','CheckTeacherApi'])->group(function()
        {
            Route::name('teacher.')->group(function()
            {
                Route::controller(DashboardApiController::class)->group(function()
                {
                    Route::get('/teacher','index');
                });

                Route::controller(TeacherLessonApiController::class)->group(function()
                {
                    Route::prefix('/lessons/{teacherId}')->group(function()
                    {
                        Route::post('','store');
                        Route::get('','index');
                    });
                });

                Route::controller(TeacherHomeworkApiController::class)->group(function()
                {
                    Route::prefix('/homeworks/teacher/{teacherId}')->group(function()
                    {
                        Route::post('','storeHomework');
                        Route::get('/correction','indexHomework');
                    });
                    Route::get('/homeworks/{homeworkId}/teacher/{teacherId}/solutions','indexSolution');

                    Route::prefix('/homeworks/{studentId}/grades')->group(function()
                    {
                        Route::post('','storeHomeworkGrades');
                        Route::put('','updateHomeworkGrade');
                    });
                });

                Route::controller(TeacherQuizApiController::class)->group(function()
                {
                    Route::prefix('/quizzes/{quizId}/teachers/{teacherId}')->group(function()
                    {
                        Route::post('','storeQuiz');
                        Route::get('','indexResults');
                        Route::get('/results','showResult');
                    });
                });
            });
        });
});
