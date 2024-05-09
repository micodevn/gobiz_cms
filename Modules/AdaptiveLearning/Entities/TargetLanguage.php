<?php

namespace Modules\AdaptiveLearning\Entities;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetLanguage extends Model
{
    use SoftDeletes;

    public $table = 'target_languages';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'target_language',
        'part',
        'explain'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'target_language' => 'string',
        'part' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'target_language' => 'nullable',
        'part' => 'nullable'
    ];

    const PARTS = [
        1 => 'Vocabulary',
        2 => 'Sentence',
        3 => 'Phonics'
    ];

    public function getLabel()
    {
        $part = \Arr::get(TargetLanguage::PARTS, $this->part);
        $name = $this->name;
        $explain = $this->explain ? "(" . $this->explain . ")" : "";

        return "<small>${part}</small> | <span>${name}</span> <small><i>${explain}</i></small>";
    }
}
