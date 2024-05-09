<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    public $table = 'grades';

    public $fillable = [
        'title',
        'description',
        'level',
        'is_active'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'level' => 'required',
        'is_active' => 'required|boolean',
        'subjects' => 'nullable',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    const GRADE = [
        0 => 'Lớp tiền tiểu học',
        1 => 'Lớp 1',
        2 => 'Lớp 2',
        3 => 'Lớp 3',
        4 => 'Lớp 4',
        5 => 'Lớp 5',
        6 => 'Lớp 6',
        7 => 'Lớp 7',
        8 => 'Lớp 8',
        9 => 'Lớp 9',
        10 => 'Lớp 10',
        11 => 'Lớp 11',
        12 => 'Lớp 12',
    ];

    public function subjects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Subject::class, 'grade_id');
    }
}
