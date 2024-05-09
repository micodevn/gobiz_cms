<?php

namespace Modules\Contest\Entities;

use App\Models\Exercise;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contest extends Model
{
    protected $table = 'contests';

    protected $fillable = [
        'title',
        'description',
        'type',
        'grade_id',
        'is_active'
    ];

    const TYPE = [
        1 => 'Bài thi đánh giá năng lực',
        2 => 'Bài thi tháng',
    ];


    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function exercise()
    {
        return $this->hasOne(Exercise::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
