<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/contest', function (Request $request) {
    return $request->user();
});
Route::get('contest-list', [
    Modules\Contest\Http\Controllers\API\ContestController::class,
    'getList'
])->name('contest-list');

Route::get('contest-round-list/{id}', [
    Modules\Contest\Http\Controllers\API\ContestController::class,
    'getRoundByContest'
])->name('contest-round-list');

Route::get('get-rounds', [
    Modules\Contest\Http\Controllers\API\RoundController::class,
    'index'
])->name('round-option');
