<?php

namespace Modules\AdaptiveLearning\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends BaseModel
{
    use HasFactory;

    public $table = 'goals';

    protected $attributes = [
        'is_active' => true
    ];

    public $fillable = [
        'id',
        'name',
        'is_active'
    ];
}
