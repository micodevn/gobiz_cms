<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Exercise
 * @package App\Models
 *
 * @property integer $exercise_id
 * @property integer $question_id
on
 */
class ModelLabels extends Model
{
    use HasFactory;

    public $table = 'model_labels';

    public $fillable = [
        'model_id',
        'label_id',
        'model_type',

    ];

}
