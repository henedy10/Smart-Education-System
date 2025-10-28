<?php

use App\Http\Controllers\AccountUserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
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

use App\Http\Middleware\
{
    CheckAdmin,
    PreventBackHistory,
    SetLocale,
};

use Illuminate\Support\Facades\Route;

// Localization
Route::get('/lang/{locale}',function (string $locale){
    if (!in_array($locale, ['en', 'ar'])) {
        session(['locale' => 'en']);
    }else{
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('SetLocale');

Route::middleware([PreventBackHistory::class , SetLocale::class])->group(function(){
    Route::controller(AccountUserController::class)->group(function ()
    {
        Route::middleware('checkLogin')->group(function(){
            Route::get('/','index')->name('index');
            Route::get('/passwords/edit','editPassword')->name('Password.Edit');
        });
        Route::post('/passwords','updatePassword')->middleware('throttle:updatePassword')->name('Password.Update');
        Route::post('/login','login')->middleware('throttle:login')->name('login');
        Route::get('/logout','logout')->name('LogOut');
    });

    /** Admin Routes */
    Route::middleware(CheckAdmin::class)->group(function(){
        Route::controller(AdminDashboardController::class)->group(function(){
            Route::get('/admin/dashboard' , 'index')->name('admin.index');
        });

        Route::controller(StudentController::class)->group(function(){
            Route::get('/students','index')->name('admin.student.index');
            Route::get('/students/create','create')->name('admin.student.create');
            Route::post('/students','store')->name('admin.student.store');
            Route::get('/students/{user}/edit','edit')->name('admin.student.edit');
            Route::put('/students/{user}','update')->name('admin.student.update');
            Route::delete('/students/{user}/trash','trash')->name('admin.student.trash');
            Route::get('/students/trashed','indexTrash')->name('admin.student.index.trash');
            Route::delete('/students/{user}/force-delete','forceDelete')->name('admin.student.forceDelete');
            Route::post('/students/{user}/restore','restore')->name('admin.student.restore');
        });

        Route::controller(TeacherController::class)->group(function(){
            Route::get('/teachers','index')->name('admin.teacher.index');
            Route::get('/teachers/create','create')->name('admin.teacher.create');
            Route::get('/teachers/{user}/edit','edit')->name('admin.teacher.edit');
            Route::put('/teachers/{user}','update')->name('admin.teacher.update');
            Route::post('/teachers','store')->name('admin.teacher.store');
            Route::delete('/teachers/{user}/trash','trash')->name('admin.teacher.trash');
            Route::get('/teachers/trashed','indexTrash')->name('admin.teacher.index.trash');
            Route::delete('/teachers/{user}/force-delete','forceDelete')->name('admin.teacher.forceDelete');
            Route::post('/teachers/{user}/restore','restore')->name('admin.teacher.restore');
        });
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
                        Route::post('/{homeworkId}/solutions/store','storeSolution')->name('homeworkSolution.store');
                        Route::get('/{homeworkId}/details','showGrade')->name('homeworkDetails.show');
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
                    Route::prefix('/lessons/{teacherId}')->group(function()
                    {
                        Route::post('','store')->name('lessons.store');
                        Route::get('','index')->name('lessons.show');
                    });
                });

                Route::controller(TeacherHomeworkController::class)->group(function()
                {
                    Route::prefix('/homeworks/teacher/{teacherId}')->group(function()
                    {
                        Route::post('','storeHomework')->name('homeworks.store');
                        Route::get('/create','createHomework')->name('homeworks.create');
                        Route::get('/solutions','indexSolution')->name('homeworks.show');
                        Route::get('/correction','indexHomework')->name('homeworkCorrection.show');
                        Route::get('/action','showAction')->name('homeworkAction.show');
                    });

                    Route::prefix('/homeworks/{studentId}/grades')->group(function()
                    {
                        Route::post('','storeHomeworkGrades')-> name('homeworkGrades.store');
                        Route::put('','updateHomeworkGrade')->name('homeworkGrades.update');
                    });
                });

                Route::controller(TeacherQuizController::class)->group(function()
                {
                    Route::prefix('/quizzes/{teacherId}')->group(function()
                    {
                        Route::post('','storeQuiz')->name('quizzes.store');
                        Route::get('/create','createQuiz')->name('quizzes.create');
                        Route::get('','showQuiz')-> name('quizzes.show');
                        Route::get('/results/{quizId}','showResult')-> name('quizResults.show');
                    });
                });
            });
        });

});



