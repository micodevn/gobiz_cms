<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseTypeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\QuestionPlatformController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//use Modules\Curriculum\Http\Controllers\CourseController;
//use Modules\Curriculum\Http\Controllers\PartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
//
//    Route::resource('courses', CourseController::class);
//    Route::resource('parts', PartController::class);
//    Route::resource('lessons', LessonController::class);
    Route::resource('questionPlatforms', QuestionPlatformController::class);
    Route::resource('topics', TopicController::class);
    Route::resource('files', FileController::class);
    Route::resource('exercises', ExerciseController::class);
    Route::resource('subjects', App\Http\Controllers\SubjectController::class);
    Route::resource('grades', App\Http\Controllers\GradeController::class);
    Route::resource('stages', App\Http\Controllers\StageController::class);
    Route::resource('labels', LabelController::class);
    Route::resource('configs', ConfigController::class);
    Route::resource('banners', BannerController::class);

    // ===== Files =====
    Route::get('file-replicate', [App\Http\Controllers\FileController::class, 'replicateFile'])->name('files.replicate');
    // ===== End files =====


    // ===== Questions =====
    Route::resource('questions', App\Http\Controllers\QuestionController::class);
    Route::get('question-replicate', [App\Http\Controllers\QuestionController::class, 'replicateQuestion'])->name('questions.replicate');
    Route::get('questions-list-active', [App\Http\Controllers\QuestionController::class, 'getQuestionActive'])->name('questions.list-active');
    Route::get('questions-type-sync', [App\Http\Controllers\QuestionController::class, 'getQuestionTypeSync'])->name('questions.type-sync');
    // ===== End questions =====




    // ===== Exercises =====
    Route::resource('exercises', App\Http\Controllers\ExerciseController::class);
    Route::resource('exercise-types', ExerciseTypeController::class);
    Route::get('exercises-replicate', [App\Http\Controllers\ExerciseController::class, 'replicateExercise'])->name('exercises.replicate');
    // ===== End exercises =====

    Route::get('list-exercise-type', [App\Http\Controllers\ExerciseController::class, 'listExerciseType'])->name('exerciseType.list');
    Route::post('get-example-question-attribute', [App\Http\Controllers\QuestionController::class, 'getResponseExampleDataAttr'])->name('question.response.attribute.example');


});

Auth::routes([
    'register' => false,
    'forgot' => false,
    'reset' => false
]);

