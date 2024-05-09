<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'license_code',
        'is_active',
        'grade_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Subject::class;
    }

    public function baseQuery()
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }

}
