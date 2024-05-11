<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    public $table = 'levels';

    public $fillable = [
        'title',
        'description',
        'code',
        'position',
        'thumbnail',
        'is_active',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'thumbnail' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'code' => 'required|string',
        'position' => 'required',
        'thumbnail' => 'nullable',
        'is_active' => 'required|boolean',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
