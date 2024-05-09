<?php

namespace Modules\AdaptiveLearning\Repositories;


use App\Repositories\BaseRepository;
use Modules\AdaptiveLearning\Entities\Goal;

/**
 * Class ExerciseRepository
 * @package App\Repositories
 * @version April 5, 2022, 4:10 pm +07
 */
class GoalRepository extends BaseRepository
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
        return Goal::class;
    }

}
