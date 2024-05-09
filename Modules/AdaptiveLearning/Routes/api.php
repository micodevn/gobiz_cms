<?php

use Illuminate\Http\Request;
use Modules\AdaptiveLearning\Http\Controllers\API\LearningObjectiveController;
use Modules\AdaptiveLearning\Http\Controllers\API\SkillVerbController;

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


//==========================================
Route::get('learning-objective', [
    LearningObjectiveController::class,
    'index'
]);

Route::get('learning-objective/{id}', [
    LearningObjectiveController::class,
    'show'
]);

Route::get('list-skill-verbs', [
    SkillVerbController::class,
    'list'
])->name('list-skill-verbs');
