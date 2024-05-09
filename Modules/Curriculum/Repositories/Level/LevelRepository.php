<?php

namespace Modules\Curriculum\Repositories\Level;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Level;

class LevelRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'level',
        'is_active',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Level::class;
    }

    public function baseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }
}
