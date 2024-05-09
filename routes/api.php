<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('list-file-options', [
    \App\Http\Controllers\FileController::class,
    'optionList'
])->name('file.options');

Route::get('file/{id}', [
    \App\Http\Controllers\FileController::class,
    'showSingle'
]);

Route::get('list-question-platform-options', [
    \App\Http\Controllers\QuestionPlatformController::class,
    'optionList'
])->name('question-platform.options');

Route::get('list-group-platform-options', [
    \App\Http\Controllers\QuestionPlatformController::class,
    'groupOptionList'
])->name('question-platform.group-options');

Route::get('question', [
    \App\Http\Controllers\API\QuestionController::class,
    'index'
]);

Route::get('question/{id}', [
    \App\Http\Controllers\API\QuestionController::class,
    'show'
]);

Route::get('question-platform', [
    \App\Http\Controllers\API\QuestionPlatformController::class,
    'index'
]);

Route::get('question-platform/{id}', [
    \App\Http\Controllers\API\QuestionPlatformController::class,
    'show'
]);

//=========file controller====================
Route::get('file', [
    \App\Http\Controllers\API\FileController::class,
    'index'
])->name('api.file.search');

Route::post('file', [
    \App\Http\Controllers\API\FileController::class,
    'createFile'
]);

//==========================================

Route::get('exercise-options', [
    \App\Http\Controllers\API\ExerciseController::class,
    'options'
]);

Route::get('exercise', [
    \App\Http\Controllers\API\ExerciseController::class,
    'index'
]);

Route::get('exercise/{id}', [
    \App\Http\Controllers\API\ExerciseController::class,
    'show'
]);

Route::post('question', [
    \App\Http\Controllers\API\QuestionController::class,
    'storeMultiple'
]);

    Route::get('list-labels', [
        \App\Http\Controllers\API\LabelController::class,
        'index'
    ])->name('list-labels');

Route::get('list-exercises', [
    \App\Http\Controllers\ExerciseController::class,
    'listExercises'
])->name('list-exercises');

Route::get('platform/detail', [
    \App\Http\Controllers\API\QuestionPlatformController::class,
    'detail'
])->name('question-platform.detail');
