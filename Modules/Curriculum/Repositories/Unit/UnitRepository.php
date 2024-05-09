<?php

namespace Modules\Curriculum\Repositories\Unit;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Unit;

class UnitRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
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
        return Unit::class;
    }

    public function baseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }
}
