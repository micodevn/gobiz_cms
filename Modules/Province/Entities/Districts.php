<?php

namespace Modules\Province\Entities;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $table = 'districts';
    protected $fillable = [
        'name',
        'type',
        'code',
        'province_code',
        'slug',
    ];

    const TYPE = ['Quận','Huyện'];

    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Province::class,'province_code','code');
    }
}
