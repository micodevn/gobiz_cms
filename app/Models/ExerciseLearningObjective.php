<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ExerciseLearningObjective
 * @package App\Models
 *
 * @property integer $exercise_id
 * @property integer $learning_obj_id
on
 */
class ExerciseLearningObjective extends Model
{
    use HasFactory;

    public $table = 'exercise_leaning_objective';

    public $fillable = [
        'exercise_id',
        'learning_objective_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'exercise_id' => 'integer',
        'learning_objective_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'exercise_id' => 'nullable',
        'learning_objective_id' => 'nullable',
    ];


}
