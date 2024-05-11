<?php

namespace Modules\Curriculum\Repositories\Activity;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Activity;
use Modules\Curriculum\Entities\Part;

class ActivityRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'description',
        'is_active',
        'unit_id',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Activity::class;
    }
}
