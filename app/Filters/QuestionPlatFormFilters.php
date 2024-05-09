<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 * @package App\Filters
 */
class QuestionPlatFormFilters extends QueryFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
        "keywords", "id", "name", "code", "is_active", "parent_id"
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
    public function filterKeywords(string $value): Builder
    {
        return $this->builder->where("name", "like", "%$value%");
    }

    /**
     * Filter user by id
     * @param string $value
     * @return Builder
     */
    public function filterId(string $value): Builder
    {
        return $this->builder->where("id", "=", $value);
    }

    /**
     * Filter user by name
     * @param string $value
     * @return Builder
     */
    public function filterName(string $value): Builder
    {
        return $this->builder->where("name", "like", "%$value%");
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterCode(string $value): Builder
    {
        return $this->builder->where("code", "like", "%$value%");
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterIsActive(string $value): Builder
    {
        return $this->builder->where("is_active", "=", $value);
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterParentId(string $value): Builder
    {
        return $this->builder->where("parent_id", "=", $value);
    }

}
