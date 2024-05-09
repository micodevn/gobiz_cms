<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;

class ScheduleSlot extends Model
{
    public $table = 'schedule_slots';

    public $fillable = [
        'schedule_id',
        'time_slot_id',
    ];
}
