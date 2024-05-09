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

Route::get('province-info', [
    \Modules\Province\Http\Controllers\API\ProvinceController::class,
    'index'
])->name('province-info');

Route::get('provinces/load-districts', [
    \Modules\Province\Http\Controllers\API\ProvinceController::class,
    'loadDistrict'
])->name('provinces.load-districts');

// School
Route::group(['prefix' => 'school'], function () {
    Route::get('school-list', [
        \Modules\Province\Http\Controllers\API\SchoolController::class,
        'index'
    ])->name('school.api.list');

});
