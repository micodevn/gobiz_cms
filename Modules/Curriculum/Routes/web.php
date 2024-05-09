<?php

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

use Modules\Curriculum\Http\Controllers\LevelController;
use Modules\Curriculum\Http\Controllers\LessonController;
use Modules\Curriculum\Http\Controllers\PartController;
use Modules\Curriculum\Http\Controllers\ScheduleController;
use Modules\Curriculum\Http\Controllers\TimeSlotController;

Route::resource('levels', LevelController::class);
Route::resource('units', \Modules\Curriculum\Http\Controllers\UnitController::class);
Route::resource('parts', PartController::class);
Route::resource('lessons', LessonController::class);
Route::resource('schedules', ScheduleController::class);
Route::resource('time-slots', TimeSlotController::class);
Route::get('time-slots/day-of-week/{dayOfWeek}/edit', [TimeSlotController::class , 'editTimeOfWeek'])->name('time-slots.edit.day-of-week');
Route::post('time-slots/day-of-week/{dayOfWeek}/update', [TimeSlotController::class , 'updateTimeOfWeek'])->name('time-slots.update.day-of-week');
