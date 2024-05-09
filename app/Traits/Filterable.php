<?php


namespace App\Traits;


use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Filterable
 * @author TrongNQ
 * @method static Builder filter(QueryFilter $filters)
 * @package App\Traits
 */
trait Filterable
{
    /**
     * Scope apply filter to model query builder
     * @param Builder $builder
     * @param QueryFilter $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder {
        return $filters->apply($builder);
    }
}
