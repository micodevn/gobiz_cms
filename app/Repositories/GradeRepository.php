<?php

namespace App\Repositories;

use App\Models\Grade;

class GradeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'level',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Grade::class;
    }

    public function baseQuery()
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }
}
