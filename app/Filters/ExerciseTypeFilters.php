<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 * @package App\Filters
 */
class ExerciseTypeFilters extends BaseFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
        "keywords","id","name","code","description"
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
    public function filterKeywords(string $value): Builder {
        return $this->builder->where("name", "like", "%$value%");
    }

    /**
     * Filter user by id
     * @param string $value
     * @return Builder
     */
    public function filterId(string $value): Builder {
        return $this->builder->where("id", "=", $value);
    }

}
