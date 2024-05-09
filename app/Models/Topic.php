<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;
    public $fillable = [
        'name',
        'description',
        'slug',
        'is_active',
    ];
}
