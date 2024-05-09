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

// Adaptive Learning
use Modules\AdaptiveLearning\Http\Controllers\ConditionalController;
use Modules\AdaptiveLearning\Http\Controllers\GoalController;
use Modules\AdaptiveLearning\Http\Controllers\LearningObjectiveController;
use Modules\AdaptiveLearning\Http\Controllers\SkillVerbController;
use Modules\AdaptiveLearning\Http\Controllers\TargetLanguageController;

Route::resource('learningObjectives', LearningObjectiveController::class);
Route::resource('skillVerbs', SkillVerbController::class);
Route::resource('targetLanguages', TargetLanguageController::class);
Route::resource('targetLanguages', TargetLanguageController::class);
Route::resource('conditionals', ConditionalController::class);
Route::resource('goals', GoalController::class);

Route::get('learning-goal', [GoalController::class, 'getListGoal'])->name('learning.goal.list');
Route::get('learning-conditional', [ConditionalController::class, 'getListConditional'])->name('learning.conditional.list');
Route::get('learning-list-option', [LearningObjectiveController::class, 'listLearningOption'])->name('learning.list.option');
Route::get('skillVerb-list-filter', [SkillVerbController::class, 'getListSkillVerb'])->name('skillVerb.list.filter');
Route::get('skillVerb-child', [SkillVerbController::class, 'optionNoParent'])->name('skillVerb.child.list');
Route::get('targetLanguages-list-option', [TargetLanguageController::class, 'getTargetLanguage'])->name('targetLanguages.list.option');
