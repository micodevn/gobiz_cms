<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 * @package App\Filters
 */
class LearningObjectiveFilters extends QueryFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
        "keywords","id","code","explain"
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
        return $this->builder->where("explain", "like", "%$value%");
    }

    /**
     * Filter user by id
     * @param string $value
     * @return Builder
     */
    public function filterId(string $value): Builder {
        return $this->builder->where("id", "=", $value);
    }



    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterCode(string $value): Builder {
        return $this->builder->where("code", "=", $value);
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterExplain(string $value): Builder {
        return $this->builder->where("explain", "like", "%$value%");
    }


}
