<?php

namespace App\Models;

use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ExerciseAttribute
 * @package App\Models
 * @version April 5, 2022, 4:10 pm +07
 *
 */
class ExerciseAttribute extends BaseModel
{
    use Cacheable;

    use HasFactory;

    public $table = 'exercise_attribute';


    public $fillable = [
        'id',
        'exercise_id',
        'level',
        'platform_id',
        'question_number',
    ];


    const OTHER_PLATFORM = [
        'id' => -1,
        'text' => 'Other Platform',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'level' => 'required',
        'question_number' => 'required',
        'platform_id' => 'nullable',
    ];

    public function platform()
    {
        return $this->belongsTo(QuestionPlatform::class, 'platform_id')->select('id', 'name');
    }


}
