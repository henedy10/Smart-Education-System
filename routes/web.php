<?php

use App\Http\Controllers\web\Admin\
{
    DashboardController as AdminDashboardController,
    StudentController,
    TeacherController
};

use App\Http\Controllers\web\Auth\
{
    ForgotPasswordController,
    LoginController,
    LogoutController,
    ResetPasswordController
};

use App\Http\Controllers\web\Student\
{
    HomeController,
    HomeworkController,
    LessonController,
    QuizController,
};

use App\Http\Controllers\web\Teacher\
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

Route::view('/','auth.login');
/********************* Localization Route *******************/
Route::get('/lang/{locale}',function (string $locale){
    if (!array_key_exists($locale,config('lang.supported'))) {
        session(['locale' => config('lang.default')]);
    }else{
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('SetLocale');

Route::middleware([PreventBackHistory::class , SetLocale::class])->group(function(){

    /********************** Auth Routes **********************/
    Route::get('/login',[LoginController::class,'index'])->name('index');
    Route::post('/login',[LoginController::class,'login'])->name('login');
    Route::post('/logout',LogoutController::class)->name('logout');
    Route::post('/forgot-password',ForgotPasswordController::class)->name('password.email');
    Route::view('/forgot-password','auth.passwords.forgot-password')->name('password.request');
    Route::view('/reset-password/{token}','auth.passwords.reset-password')->name('password.reset');
    Route::post('/reset-password',ResetPasswordController::class)->name('password.update');

    /**************************** Student Routes ****************************/
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
                        Route::get('/{homeworkId}/grade','showGrade')->name('homeworkDetails.show');
                    });
                });

                Route::controller(QuizController::class)->group(function()
                {
                    Route::prefix('/quiz/{class}/{subject}')->group(function ()
                    {
                        Route::get('/action','showAction')->name('quizAction.show');
                        Route::get('','showAvailableQuiz')->name('availableQuiz.show');
                        Route::get('/content','showQuizContent')->name('quizContent.show');
                        Route::post('/answers','storeAnswer')->name('answers.store');
                        Route::get('/results','indexResult')->name('results.show');
                    });
                });
            });
        });

    /****************************** Teacher Routes ************************************/

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



