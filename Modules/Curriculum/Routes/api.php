<?php

use Modules\Curriculum\Http\Controllers\Apis\CourseController;
use Modules\Curriculum\Http\Controllers\Apis\LessonController;
use Modules\Curriculum\Http\Controllers\Apis\PartsController;
use Modules\Curriculum\Http\Controllers\Apis\ScheduleController;

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

Route::name('api.')->group(function () {
    Route::get('/lessons/search', [LessonController::class, 'index'])->name('lessons.filter');
    Route::get('/parts/search', [PartsController::class, 'index'])->name('parts.filter');
    Route::get('/courses/search', [CourseController::class, 'index'])->name('courses.search');
    Route::get('/schedules/search', [ScheduleController::class, 'index'])->name('schedules.search');
    Route::get('/schedules/{id}', [ScheduleController::class, 'detail'])->name('schedules.detail');
});
