<?php

namespace App\Repositories;

use Modules\Curriculum\Entities\Stage;

class StageRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'is_active',
        'course_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Stage::class;
    }

    public function baseQuery()
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }
}
