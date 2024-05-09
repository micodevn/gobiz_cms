<?php

namespace Modules\AdaptiveLearning\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conditional extends BaseModel
{
//    use Cacheable;

//    use SoftDeletes;

    public $table = 'conditionals';

    protected $attributes = [
        'is_active' => true
    ];

    public $fillable = [
        'id',
        'name',
        'is_active'
    ];
}
