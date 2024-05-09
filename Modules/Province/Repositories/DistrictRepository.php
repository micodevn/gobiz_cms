<?php

namespace Modules\Province\Repositories;

use Modules\Province\Entities\Districts;
use Prettus\Repository\Eloquent\BaseRepository;

class DistrictRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'name' => 'like',
        'code',
        'type'
    ];

    public function model(): string
    {
        return Districts::class;
    }
}
