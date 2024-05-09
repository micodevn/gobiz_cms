<?php

namespace Modules\Province\Repositories;

use Modules\Province\Entities\Province;
use Prettus\Repository\Eloquent\BaseRepository;

class ProvinceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'name' => 'like',
        'code',
        'type'
    ];

    public function model(): string
    {
        return Province::class;
    }
}
