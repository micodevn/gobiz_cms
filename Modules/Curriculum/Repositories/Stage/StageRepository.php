<?php

namespace Modules\Curriculum\Repositories\Stage;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Stage;

class StageRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'course_id',
        'is_active',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Stage::class;
    }
}
