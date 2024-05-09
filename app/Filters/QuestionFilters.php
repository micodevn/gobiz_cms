<?php


namespace App\Filters;

use App\Models\QuestionTopic;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class UserFilters
 * @package App\Filters
 */
class QuestionFilters extends QueryFilter
{
    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [
        "keywords", "id", "name", "platforms", "is_active", "topic_id","level","class_id"
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
     * @param array $value
     * @return Builder
     */
    public function filterPlatforms(array $value): Builder
    {
        $value = array_filter($value);
        if (!$value) return  $this->builder;
        return $this->builder->whereIn("platform_id", $value);
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
     * @param array $value
     * @return Builder
     */
    public function filterTopicId($value): Builder
    {
        return $this->builder->where("topic_id", "=", $value);
    }

    /**
     * Filter user by id
     * @param string $value
     * @return Builder
     */
    public function filterLevel(string $value): Builder
    {
        return $this->builder->where("level", "=", $value);
    }

    /**
     * Filter user by id
     * @param string $value
     * @return Builder
     */
    public function filterClassId(string $value): Builder
    {
        return $this->builder->where("class_id", "=", $value);
    }

}
