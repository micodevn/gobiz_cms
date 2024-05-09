<?php

namespace Modules\Curriculum\Repositories\Part;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Part;

class PartRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'is_active',
        'lesson_id',
        'type'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Part::class;
    }
}
