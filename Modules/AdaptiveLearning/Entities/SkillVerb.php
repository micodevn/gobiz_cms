<?php

namespace Modules\AdaptiveLearning\Entities;

use App\Models\BaseModel;
use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkillVerb extends BaseModel
{
    use SoftDeletes,Cacheable;

    use HasFactory;

    public $table = 'skill_verbs';

    protected $dates = ['deleted_at'];

    protected $attributes = [
        'is_active' => true
    ];

    public $fillable = [
        'id',
        'name',
        'parent_id',
        'is_active'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'is_active' => 'required',
    ];


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->select(['id','name','parent_id']);
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getParentNameAttribute()
    {
        return $this->parent ? $this->parent->name : "";
    }
}
