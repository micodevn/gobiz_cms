<?php

namespace Modules\AdaptiveLearning\Repositories;


use App\Repositories\BaseRepository;
use Modules\AdaptiveLearning\Entities\Conditional;


/**
 * Class ExerciseRepository
 * @package App\Repositories
 * @version April 5, 2022, 4:10 pm +07
 */
class ConditionalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
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
     * @return  string
     * Configure the Model
     **/
    public function model()
    {
        return Conditional::class;
    }

}
