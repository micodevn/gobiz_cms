<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class QuestionTargetLanguage
 * @package App\Models
 *
 * @property integer $question_id
 * @property integer $target_languages_id
on
 */
class QuestionTargetLanguage extends BaseModel
{

    use HasFactory;

    public $table = 'question_target_languages';

    public $fillable = [
          'question_id',
          'target_language_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'question_id' => 'integer',
        'target_language_id' => 'integer',
    ];
}
