<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use SoftDeletes;
    public $table = 'stages';

    public $fillable = [
        'title',
        'description',
        'course_id',
        'is_active',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'course_id' => 'nullable',
        'is_active' => 'required|boolean',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\Modules\Curriculum\Entities\Level::class, 'course_id');
    }

    public function lessons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }
}
