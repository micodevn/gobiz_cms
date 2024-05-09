<?php


namespace App\Filters;


use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Class Query Filter
 * @author TrongNQ
 * @package App\Filters
 */
abstract class QueryFilter
{
    /**
     * @var Request $request
     */
    protected Request $request;

    /**
     * Model query builder
     * @var Builder $builder
     */
    protected Builder $builder;

    /**
     * Filterable attributes
     * @var array
     */
    protected array $filterable = [];

    /**
     * Sortable attributes
     * @var array $sortable
     */
    protected array $sortable = [];

    /**
     * Define all the filter methods mapping with param name
     * @var array $methodsMapping
     */
    protected array $methodsMapping = [];

    /**
     * Define all the model columns mapping that apply to filter params name
     * @var array $mapColumns
     */
    protected array $mapColumns = [];

    /**
     * Define all relations wants to get
     * @var array $relations
     */
    protected array $relations = [];

    /**
     * Define scope query to inject to builder while build
     * the query base on request params
     * @var ?Closure
     */
    protected ?Closure $scopeQuery = null;

    /**
     * Determine current query builder is already sorting applied
     * @var bool $isSortingApplied
     */
    public bool $isSortingApplied = false;

    /**
     * Available sorting directions
     * @var array|string[] $sortingDirections
     */
    private array $sortingDirections = ["asc", "desc"];

    /**
     * Query Filter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Setup query builder before apply
     */
    protected function setUp() {
        $this->builder->select($this->request->get("columns", ["*"]));
    }

    /**
     * Apply all filterable attributes to query builder
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder {
        $this->builder = $builder;
        $this->setUp();

        if($this->request->has("relations")) {
            $requestRelations = $this->request->get("relations");
            if(is_array($requestRelations)) {
                $this->relations = array_merge($this->request->get("relations"), $this->relations);
            }else{
                $this->relations = [$requestRelations];
            }
        }

        if(count($this->relations) > 0) $this->builder->with($this->relations);

        foreach ($this->filters() as $name => $value) {
            if ($value === null || $value === '') continue;
            $method = $this->mapParamWithMethod($name);
            if($value == 'false' || $value == 'true') $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $mappedColumnName = key_exists($name, $this->mapColumns) ? $this->mapColumns[$name] : null;
            call_user_func_array([$this, $method], [$value, $mappedColumnName]);
        }

        $this->builder = $this->handleRelationAggregate($builder);
        $this->builder = $this->applySorting($builder);
        $this->applyScope();
        return $this->builder;
    }

    /**
     * Apply all sorting attributes to query builder
     * @param Builder $builder
     * @return Builder
     */
    private function applySorting(Builder $builder): Builder {
        $sortingQuery = $this->request->get("sort");

        $values = explode("|", $sortingQuery);
        if(!is_array($values) || count($values) < 2 || !in_array($values[1], $this->sortingDirections)) return $builder;

        $column = $values[0];
        $direction = $values[1];
        if(!in_array($column, $this->sortable)) return $builder;

        $column = key_exists($column, $this->mapColumns) ? $this->mapColumns[$column] : $values[0];
        $this->isSortingApplied = true;
        return $builder->orderBy($column, $direction);
    }

    /**
     * Get all filterable params data from request
     * @return array
     */
    public function filters(): array {
        return $this->request->all($this->filterable);
    }

    /**
     * Map request params name with method to use for filtering
     * @param string $name
     * @return string
     */
    public function mapParamWithMethod(string $name): string {
        if(!array_key_exists($name, $this->methodsMapping)) {
            return 'filter' . Str::studly($name);
        } else return $this->methodsMapping[$name];
    }

    /**
     * Filter by keyword
     * @param string $keyword
     * @param string $columnName
     * @return Builder
     */
    public function filterKeyword(string $keyword, string $columnName): Builder {
        return $this->builder->where($columnName, "like", '%' . $keyword . '%');
    }

    /**
     * Get filter request data
     * @return Request
     */
    public function getRequest(): Request {
        return $this->request;
    }

    /**
     * Get paginate limit number
     * @return int
     */
    public function getPaginateLimit(): int {
        return $this->getRequest()->has("limit")
            ? intval($this->getRequest()->get("limit")) : intval(config("pagination.limit"));
    }

    /**
     * Function to set query scope for this query filter
     * @param Closure $closure
     * @return $this
     */
    public function addScope(Closure $closure): static {
        $this->scopeQuery = $closure;
        return $this;
    }

    /**
     * Apply scope in current QueryFilter
     * @return $this
     */
    protected function applyScope(): static {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;
            $this->builder = $callback($this->builder);
        }

        return $this;
    }

    /**
     * Filter resource by created_at start date
     * @param $value
     * @return Builder
     */
    public function filterStartDate($value): Builder {
        return $this->builder->where("created_at", ">=", Carbon::createFromFormat("d/m/Y", $value));
    }

    /**
     * Filter resource by created_at end date
     * @param $value
     * @return Builder
     */
    public function filterEndDate($value): Builder {
        return $this->builder->where("created_at", "<=", Carbon::createFromFormat("d/m/Y", $value));
    }

    /**
     * Resolve context model relations aggregation
     * @param Builder $builder
     * @return Builder
     */
    public function handleRelationAggregate(Builder $builder): Builder {
        $relationAggregations = Arr::where($this->getRequest()->all(), function ($param, $key) {
            return Str::startsWith($key,"with");
        });

        foreach ($relationAggregations as $aggregation => $value) {
            switch ($aggregation) {
                case "withCount":
                    $builder->withCount($value);
                    break;
                case "withSum":
                    $value = json_encode($value);
                    $builder->withSum(data_get($value, "relation"), data_get($value, "column"));
                    break;
            }
        }
        return $builder;
    }
}
