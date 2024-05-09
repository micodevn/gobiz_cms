<?php

namespace Modules\AdaptiveLearning\Entities;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningObjective extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'learning_objectives';
//    protected $cacheCollection = 'learning_obj';
//    protected $cacheResource = LearningObjectiveResource::class;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'explain',
        'code',
        'skill_id',
        'goal_id',
        'conditional_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'code' => 'string',
        'goal_id' => 'string',
        'conditional_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'explain' => 'required',
        'code' => 'required|unique:learning_objectives',
        'skill_id' => 'required',
        'goal_id' => 'required',
        'conditional_id' => 'nullable'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);;
    }

    public function skillVerb()
    {
        return $this->belongsTo(SkillVerb::class, 'skill_id')->select(['id','name','parent_id']);
    }

    public function learningGoal()
    {
        return $this->belongsTo(Goal::class, 'goal_id')->select(['id','name']);
    }

    public function learningConditional()
    {
        return $this->belongsTo(Conditional::class, 'conditional_id')->select(['id','name']);
    }



}
