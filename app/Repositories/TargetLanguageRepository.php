<?php

namespace App\Repositories;

use Modules\AdaptiveLearning\Entities\TargetLanguage;
use App\Repositories\BaseRepository;

/**
 * Class TargetLanguageRepository
 * @package App\Repositories
 * @version May 20, 2022, 9:10 am +07
*/

class TargetLanguageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'target_language',
        'code',
        'part'
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
        return TargetLanguage::class;
    }
}
