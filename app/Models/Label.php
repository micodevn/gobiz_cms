<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Label
 * @package App\Models
 * @version August 1, 2022, 9:44 am +07
 *
 */
class Label extends Model
{
    public $table = 'labels';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'status',
        'attribute',
        'slug',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
