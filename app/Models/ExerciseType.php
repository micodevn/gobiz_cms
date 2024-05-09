<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use phpDocumentor\Reflection\Types\This;

/**
 * Class ExerciseType
 * @package App\Models
 * @version May 9, 2022, 2:20 pm +07
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $description
 */
class ExerciseType extends BaseModel
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'exercise_types';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'name',
        'code',
        'description',
//        'game_name',
        'doc_link',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'code' => 'required',
//        'game_name' => 'nullable',
        'how_to_play' => 'nullable',
        'doc_link' => 'required',
        'description' => 'nullable',
        'how_to_play_web' => 'nullable'
    ];


    public static function filters() {
        return [
            'name' => [
                'type' => 'text',
                'placeholder' => 'Nhập tên ...',
                'filter_type' => self::RELATIVE

            ],
            'description' => [
                'type' => 'text',
                'placeholder' => 'Nhập description ...',
                'filter_type' => self::RELATIVE
            ],
            'code' => [
                'type' => 'text',
                'placeholder' => 'Nhập code ...',
                'filter_type' => self::ABSOLUTE
            ],
//            'test' => [
//                'type' => 'component',
//                'componentName' => 'api-select',
//                'options' => [
//                    'options' => [
//                        1 => 'abcasdas',
//                        2 => 'asdqqfsdf'
//                    ],
//                    // options for select2
//                    'url' => route('products.list-option'),
//                    'selected' => null,
//                    'class' => 'api-select',
//                    'labelField' => 'name',
//                    'valueField' => 'id'
//                ]
//            ]
        ];
    }

    public function code(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtoupper($value),
        );
    }


}
