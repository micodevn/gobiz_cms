<?php

namespace App\Repositories;

use App\Filters\QueryFilter;
use App\Traits\Cacheable;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository as Repository;

/**
 * @method createWithCache($attr)
 * @method updateWithCache($attr, $id)
 * @method deleteWithCache($id)
 * @method findWithCache($id)
 */
abstract class BaseRepository extends Repository
{
    protected $cacheMethod = [
        'createWithCache', 'updateWithCache', 'deleteWithCache', 'findWithCache'
    ];

    protected $defaultFilters = null;
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->makeModel();
    }

    /**
     * Get a new query builder for the model's table.
     * @return Builder
     */
    public function newQuery(): Builder {
        return $this->model->newQuery()->orderBy('id', 'desc');
    }

    /**
     * List by query filters
     */
    public function listByFiltersPaginate(QueryFilter $filters): LengthAwarePaginator {
        return $filters->apply($this->newQuery())->paginate($filters->getPaginateLimit());
    }


    public function search($searches)
    {
        $query = $this->model;
        foreach($searches as $key => $value) {
            if (!in_array($key, $this->getFieldsSearchable())) {
                continue;
            }

            if (is_string($value)) {
                $query = $query->where($key, $value);
            }

            if (is_array($value)) {
                if ($value[0] === 'in') {
                    $query = $query->whereIn($key, $value[1]);
                }
                if ($value[0] === 'like') {
                    $query = $query->where($key, "like", "%$value[1]%");
                }
            }
        }

        $this->model = $query;

        return $this;
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     *
     * @return mixed
     */
    public function findArrayByField($field, $value = null)
    {
        return $this->model->where($field, '=', $value)->get();
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            $query = $this->search($search, $query);
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    public function applyDefaultFilter($model)
    {
        $filters = request('filters', []);

        $ids = \Arr::get($filters, 'ids');

        if($ids && is_array($ids)) {
            $model->whereIn('id', $ids);
        }

        return $model;
    }

    public function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;
            $this->model = $callback($this->model);
        }

        $this->applyDefaultFilter($this->model);

        return $this;
    }

    /**
     * @param $method
     * @param Cacheable $model
     * @param $metaData
     * @return void
     */
    function cacheModel($method, $model, $metaData)
    {
        $useCacheTrait = in_array(Cacheable::class, class_uses_recursive($this->model()), true);
        if (!$useCacheTrait) {
            return;
        }

        switch ($method) {
            case 'create':
            case 'update':
            case 'find':
                $model->cache();
                break;
            case 'delete':
                /** @var Cacheable|Model $instance */
                $instance = new $this->model();
                $instance->id = $metaData[0];
                $instance->removeCache();
                break;
        }
    }

    public function relicate($id)
    {
        $model = $this->find($id);
        if (!$model) return false;
        return $model->replicate();
    }

    public function findWhereCustom(array $where, $limit, $columns = ['*'], )
    {
        $this->applyCriteria();
        $this->applyScope();

        $this->applyConditions($where);
        $model = $this->model;
        if($limit) {
            $model = $this->model->select($columns)->paginate($limit);
        } else {
            $model = $this->model->get($columns);
        }
        $this->resetModel();

        return $this->parserResult($model);
    }

    function __call($method, $arguments)
    {
        if (in_array($method, $this->cacheMethod)) {
            $realMethod = str_replace('WithCache', '', $method);

            $result = $this->$realMethod(...$arguments);
            $this->cacheModel($realMethod, $result, $arguments);
            return $result;
        }

        return parent::__call($method, $arguments);
    }
}
