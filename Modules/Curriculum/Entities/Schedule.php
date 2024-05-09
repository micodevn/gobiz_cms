<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    public $table = 'schedules';

    public $fillable = [
        'title',
        'description',
        'is_active',
        'course_id',
        'parent_id',
        'content',
        'values',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'is_active' => 'boolean',
        'content' => 'string',
        'values' => 'string'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'is_active' => 'required|boolean',
        'course_id' => 'nullable',
        'parent_id' => 'nullable',
        'content' => 'required|string|max:255',
        'time_slot' => 'required',
        'values' => 'nullable',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\Modules\Curriculum\Entities\Level::class, 'course_id');
    }

    public function timeSlots() {
        return $this->belongsToMany(TimeSlot::class ,'schedule_slots');
    }
}
