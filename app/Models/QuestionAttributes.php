<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Exercise
 * @package App\Models
 *
 * @property integer $question_id
on
 */
class QuestionAttributes extends BaseModel
{
    use HasFactory;

    public const TYPE_RELATION = 'RELATION';

    public $table = 'question_attributes';
    public $timestamps = false;
    public $fillable = [
        'question_id',
        'group_parent',
        'attribute',
        'type',
        'type_option',
        'value',
    ];

//    protected $attributes = [
//        'created_at' => now(),
//        'updated_at' => now(),
//    ];
//    protected $attributes = [
//        'is_active' => true,
//        'num_repeat' => 0
//    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'question_id' => 'integer',
        'attribute' => 'string',
        'value' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'attribute' => 'nullable',
        'question_id' => 'nullable',
        'value' => 'nullable',
    ];


}
