<?php


namespace App\Filters;

use App\Models\ExerciseTopic;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 * @package App\Filters
 */
class ExerciseFilters extends QueryFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
        "keywords","name","platform","unit_id","status","id","topic_id","exercise_types"
    ];

    /**
     * Sortable attributes
     * @var array $sortable
     */
    protected array $sortable = [
        "id"
    ];

    /**
     * Filter user by keywords (name, email,.v.v)
     * @param string $value
     * @return Builder
     */
    public function filterName(string $value): Builder {
        return $this->builder->where("name", "like", "%$value%");
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterPlatform(string $value): Builder {
        return $this->builder->where("platform_id", "=", $value);
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterStatus(string $value): Builder {
        return $this->builder->where("is_active", "=", $value);
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterId(string $value): Builder {
        return $this->builder->where("id", "=", $value);
    }

    /**
     * Filter user by
     * @param array $values
     * @return Builder
     */
    public function filterTopicId($values): Builder
    {
        $values = !is_array($values) ? (array)$values : $values;

        $exerciseIds = ExerciseTopic::query()->selectRaw('exercise_id, count(*) as exercise_count')
            ->groupBy('exercise_id')
            ->whereIn('topic_id', $values)
            ->havingRaw('count(*) >= ' . count($values))->pluck('exercise_id');

        return $this->builder->whereIn('id',$exerciseIds);
    }

    /**
     * Filter user by
     * @param array $value
     * @return Builder
     */
    public function filterExerciseTypes(array $value): Builder {
        $value = array_filter($value);
        if (!$value) return $this->builder;
        return $this->builder->whereIn("type_id", $value);
    }

}
