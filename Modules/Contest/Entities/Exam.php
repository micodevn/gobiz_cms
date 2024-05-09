<?php

namespace Modules\Contest\Entities;

use App\Models\Exercise;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Contest\Models\ContestRound;

class Exam extends Model
{
    use SoftDeletes;

    protected $table = 'exams';

    public $fillable = [
        'title',
        'round_id',
        'exercise_id',
        'subject_id',
        'start_time',
        'end_time',
        'max_turn',
        'is_active',
    ];

    public function contest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function round(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function exercise(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Exercise::class, 'id', 'exercise_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
