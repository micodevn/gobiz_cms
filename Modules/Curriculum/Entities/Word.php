<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Word extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    public $table = 'grammars';

    public $fillable = [
        'text',
        'description',
        'en_description',
        'form',
        'pronunciation',
        'content',
        'vn_content',
        'image',
        'video',
        'audio',
        'type',
    ];

    protected $casts = [
//        'name' => 'string',
//        'description' => 'string',
//        'thumbnail' => 'string',
//        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'text' => 'required|string',
        'description' => 'required|string|max:1000',
        'is_active' => 'required|boolean',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    const WORD_TYPEs = [
        "WORD" => 'Từ',
        "SENTENCE" => 'Câu',
    ];
}
