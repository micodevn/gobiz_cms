<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeSlot extends Model
{
    public $table = 'time_slots';

    public $fillable = [
        'day_of_week',
        'start_time',
        'end_time'
    ];
}
