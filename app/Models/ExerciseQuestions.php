<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExerciseQuestions extends Model
{
    use HasFactory;

    public $table = 'exercise_questions';

    public $fillable = [
        'exercise_id',
        'question_id',
        'position'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'exercise_id' => 'integer',
        'question_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'exercise_id' => 'nullable',
        'question_id' => 'nullable',
    ];


}
