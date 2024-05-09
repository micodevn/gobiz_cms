<?php

namespace App\Repositories;

use App\Models\ExerciseType;
use App\Repositories\BaseRepository;

/**
 * Class ExerciseTypeRepository
 * @package App\Repositories
 * @version May 9, 2022, 2:20 pm +07
*/

class ExerciseTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'code',
        'description'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExerciseType::class;
    }
}
