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

use Modules\Contest\Http\Controllers\ContestController;
use Modules\Contest\Http\Controllers\ExamController;

Route::middleware(['auth'])->group(function () {
    Route::resource('contests', ContestController::class);
    Route::resource('rounds', ContestController::class);
    Route::resource('exams', ExamController::class);
});
