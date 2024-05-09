<?php

namespace Modules\Curriculum\Repositories\Lesson;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Lesson;

class LessonRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Lesson::class;
    }

    public function baseQuery()
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }
}
