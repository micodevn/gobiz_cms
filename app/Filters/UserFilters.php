<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 * @package App\Filters
 */
class UserFilters extends QueryFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
        "keywords","email","id"
    ];

    /**
     * Sortable attributes
     * @var array $sortable
     */
    protected array $sortable = [
        "name", "email"
    ];

    /**
     * Filter user by keywords (name, email,.v.v)
     * @param string $value
     * @return Builder
     */
    public function filterKeywords(string $value): Builder {
        return $this->builder->where("name", "like", "%$value%")
            ->orWhere("email", "like", "%$value%");

    }

    public function filterEmail(string $value): Builder
    {
        return $this->builder->Where("email", "like", "%$value%");
    }
    public function filterId(string $value): Builder
    {
        return $this->builder->Where("id", "=", $value);
    }

}
