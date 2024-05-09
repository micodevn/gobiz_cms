<?php

namespace Modules\Province\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table = 'provinces';

    protected $fillable = [
        'name',
        'type',
        'code',
        'slug'
    ];

    const TYPE = ['Tỉnh','Thành Phố'];

    public function districts(): HasMany
    {
        return $this->hasMany(Districts::class,'code');
    }
}
