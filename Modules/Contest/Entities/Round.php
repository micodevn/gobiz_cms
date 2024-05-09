<?php

namespace Modules\Contest\Entities;


use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $table = 'rounds';

    public $fillable = [
        'title',
        'thumbnail',
        'type',
        'contest_id',
        'start_time',
        'end_time',
        'is_active',
    ];

    public function contest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function exams(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
