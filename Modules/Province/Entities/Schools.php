<?php

namespace Modules\Province\Entities;

use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    protected $table = 'schools';

    protected $fillable = [
        'name',
        'district_id',
        'district_code',
    ];

    protected $with = [
        'district'
    ];

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Districts::class);
    }
}
