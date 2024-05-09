<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    public $table = 'subjects';

    public $fillable = [
        'title',
        'description',
        'license_code',
        'is_active',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'license_code' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'is_active' => 'required|boolean',
        'license_code' => 'nullable',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function courses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\Modules\Curriculum\Entities\Level::class, 'subject_id');
    }
}
