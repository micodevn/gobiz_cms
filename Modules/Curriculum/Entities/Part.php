<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use SoftDeletes;
    public $table = 'parts';

    public $fillable = [
        'title',
        'description',
        'thumbnail',
        'is_active',
        'lesson_id',
        'level',
        'type'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'thumbnail' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'thumbnail' => 'nullable',
        'lesson_id' => 'nullable',
        'type' => 'nullable',
        'level' => 'nullable',
        'is_active' => 'required|boolean',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    const PART_TYPES = [
        1 => 'Quesion hiểu bài',
        2 => 'Part Quiz',
        3 => 'Bài tập về nhà',
        4 => 'Tập luyện',
        5 => 'Câu hỏi tương tác',
    ];

    const PART_LEVEL = [
        1 => 'Cơ bản',
        2 => 'Trung bình',
        3 => 'Nâng cao',
    ];

    public function lesson(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\Modules\Curriculum\Entities\Lesson::class, 'lesson_id');
    }

    public function exercises(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Exercise::class, 'part_id')->orderBy('position');
    }
}
