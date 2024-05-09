<?php

namespace Modules\Curriculum\Repositories\Schedule;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\TimeSlot;

class TimeSlotRepository extends BaseRepository
{
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TimeSlot::class;
    }
}
