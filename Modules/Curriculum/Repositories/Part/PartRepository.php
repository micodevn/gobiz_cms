<?php

namespace Modules\Curriculum\Repositories\Part;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Part;

class PartRepository extends BaseRepository
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
        return Part::class;
    }
    public function baseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }
}
