<?php

namespace Modules\Curriculum\Entities;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    public $table = 'lessons';

    public $fillable = [
        'title',
        'description',
        'thumbnail',
        'stage_id',
        'position',
        'type',
        'is_active'
    ];

    const LESSON_TYPES = [
        1 => 'Buổi học chính',
        2 => 'Buổi học phụ đạo',
        3 => 'Tiền tiểu học',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'thumbnail' => 'nullable|string|max:255',
        'stage_id' => 'nullable',
        'type' => 'required',
        'is_active' => 'required|boolean',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function parts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\Modules\Curriculum\Entities\Part::class, 'lesson_id');
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(File::class,'lesson_documents', 'lesson_id', 'file_id', 'id');
    }
}
