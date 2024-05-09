<?php

namespace Modules\Curriculum\Repositories\Schedule;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Schedule;

class ScheduleRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'is_active',
        'course_id',
        'content'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Schedule::class;
    }
}
