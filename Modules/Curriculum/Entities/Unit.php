<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    public $table = 'units';

    public $fillable = [
        'name',
        'description',
        'code',
        'thumbnail',
        'is_active',
        'position',
        'level_id',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'thumbnail' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'code' => 'required|string',
        'level_id' => 'required',
        'thumbnail' => 'nullable',
        'is_active' => 'required|boolean',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
