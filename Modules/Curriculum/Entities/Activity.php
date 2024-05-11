<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;
    public $table = 'activities';

    public $fillable = [
        'name',
        'description',
        'thumbnail',
        'position',
        'is_active',
        'part_id',
        'code'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'thumbnail' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'thumbnail' => 'nullable',
        'is_active' => 'required|boolean',
        'part_id' => 'required',
        'code' => 'required',
        'position' => 'required',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function lesson(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
//        return $this->belongsTo(\Modules\Curriculum\Entities\Lesson::class, 'lesson_id');
    }

    public function exercises(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
//        return $this->hasMany(\App\Models\Exercise::class, 'part_id')->orderBy('position');
    }
}
