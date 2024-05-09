<?php

namespace App\Models;

use App\Http\Resources\API\ExerciseResource;
use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdaptiveLearning\Entities\LearningObjective;
use Modules\Curriculum\Entities\Part;

class Exercise extends BaseModel
{
    use SoftDeletes, Cacheable;

    protected $cacheCollection = 'k12:product:exercise';
    protected $cacheResource = ExerciseResource::class;

    public $table = 'exercises';

    protected $attributes = [
        'is_active' => true
    ];

    protected $dates = ['deleted_at'];

    protected bool $isFilterProduct = true;

    const LEVEL= [
        1 => 'Cơ bản',
        2 => 'Nâng cao',
    ];

    public $fillable = [
        'name',
        'description',
        'position',
        'platform_id',
        'level',
        'is_active',
        'duration',
        'duration_show',
//        'app_image',
        'type_id',
//        'audio',
        'video'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'part_id' => 'integer',
//        'position' => 'integer',
        'is_active' => 'integer',
        'duration' => 'integer',
        'duration_show' => 'integer',
        'image' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'duration_show' => 'nullable',
        'part_id' => 'nullable',
        'position' => 'nullable',
        'is_active' => 'nullable',
        'duration' => 'nullable',
        'image' => 'nullable',
    ];


    public function questions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        $table = (new ExerciseQuestions())->getTable();

        return $this->belongsToMany(Question::class, $table)->select(['id', 'name'])->withPivot('position')->withTimestamps();
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExerciseType::class, 'type_id');
    }

    public function learningObjectives(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        $table = (new ExerciseLearningObjective())->getTable();
        return $this->belongsToMany(LearningObjective::class, $table)->select(['id', 'code as name', 'explain', 'goal_id', 'skill_id'])->withTimestamps();
    }

    public function part(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Part::class, 'id', 'part_id');
    }

    public function platform(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QuestionPlatform::class, 'platform_id');
    }

    public function getPlatformNameAttribute()
    {
        if (!$this->platform) {
            return "";
        }

        return $this->platform->name;
    }
}
