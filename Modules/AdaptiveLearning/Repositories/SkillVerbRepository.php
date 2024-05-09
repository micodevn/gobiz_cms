<?php

namespace Modules\AdaptiveLearning\Repositories;


use Modules\AdaptiveLearning\Entities\SkillVerb;
use App\Repositories\BaseRepository;

/**
 * Class ExerciseRepository
 * @package App\Repositories
 * @version April 5, 2022, 4:10 pm +07
 */
class SkillVerbRepository extends BaseRepository
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
     * @return  SkillVerb
     * Configure the Model
     **/
    public function model()
    {
        return SkillVerb::class;
    }


    public function groupLearningObj($searchTerm = '')
    {
        $q = $this->model()::query()->where('is_active', 1);

        if (trim($searchTerm) != '') {
            $q = $q->where(function ($q) use ($searchTerm) {
                return $q
                    ->where('name', 'like', "%${searchTerm}%")
                    ->orWhereNull('parent_id');
            });
        }

        return $q->get();
    }
}
