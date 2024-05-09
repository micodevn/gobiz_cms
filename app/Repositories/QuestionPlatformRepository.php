<?php

namespace App\Repositories;

use App\Models\QuestionPlatform;
use App\Repositories\BaseRepository;

/**
 * Class QuestionPlatformRepository
 * @package App\Repositories
 * @version March 29, 2022, 2:03 pm +07
*/

class QuestionPlatformRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'code',
        'description',
        'parent_id',
        'image_id',
        'is_active'
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
     *
     * @return  QuestionPlatform
     **/
    public function model()
    {
        return QuestionPlatform::class;
    }

    public function create(array $attributes)
    {
        $attributes['created_by'] = \Auth::id();
        !empty($attributes['media_types']) &&  $attributes['media_types'] = implode(',',$attributes['media_types']);
        return parent::create($attributes); // TODO: Change the autogenerated stub
    }

    public function getGroupedPlatform($searchTerm = '')
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

    public function update(array $attributes, $id)
    {
        !empty($attributes['media_types']) &&  $attributes['media_types'] = implode(',',$attributes['media_types']);
        return parent::update($attributes, $id); // TODO: Change the autogenerated stub
    }

    /**
     * @param $id
     * @return  bool
     */
    public function checkLevel($id): bool
    {
        return $this->model()::query()->where('parent_id','=',$id)->count('id') > 0;
    }
}