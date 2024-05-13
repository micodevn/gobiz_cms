<?php


namespace App\Filters;

use App\Models\File;
use App\Models\ModelLabels;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 * @package App\Filters
 */
class FileFilters extends QueryFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
         "name", "type", "is_active", "id"
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
    public function filterIsActive(string $value): Builder
    {
        return $this->builder->where("is_active", "=", $value);
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterType(string $value): Builder
    {
        return $this->builder->where("type", "=", $value);
    }

    /**
     * Filter user by
     * @param string $value
     * @return Builder
     */
    public function filterId(string $value): Builder
    {
        return $this->builder->where("id", "=", $value);
    }

    /**
     * Filter user by
     * @param array $value
     * @return Builder
     */
//    public function filterLabels(array $value): Builder
//    {
//        $value = array_filter($value);
//
//        $fileID = ModelLabels::query()->whereIn('label_id', $value)->where('model_type', File::MODEL_TYPE)->pluck('model_id')->toArray();
//        if ($fileID) {
//            return $this->builder->whereIn('id', $fileID);
//        }
//        return $this->builder;
//    }

}
