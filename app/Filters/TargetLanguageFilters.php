<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 * @package App\Filters
 */
class TargetLanguageFilters extends QueryFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
        "keywords","id","target_language","part"
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
    public function filterTargetLanguage(string $value): Builder {
        return $this->builder->where("target_language", "like", "%$value%");
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
     * Filter user by id
     * @param string $value
     * @return Builder
     */
    public function filterPart(string $value): Builder {
        return $this->builder->where("part", "=", $value);
    }



}
