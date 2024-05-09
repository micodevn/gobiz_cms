<?php

namespace App\Traits;

use App\Exceptions\CacheException;
use App\Helpers\Helper;
use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

trait Cacheable
{
    /**
     * @return void
     * @throws CacheException
     */
    protected function validate()
    {
        if (!$this->cacheCollection) {
            throw new CacheException('$cacheCollection must be set');
        }

        if (!$this->cacheResource && !$this->cacheResource instanceof JsonResource) {
            throw new CacheException('$cacheResource must be set and inherit Illuminate\Http\Resources\Json\JsonResource');
        }
    }

    public function solveCacheKey()
    {
        return $this->cacheCollection . ':' . $this->id;
    }

    public function cache()
    {
        $this->validate();
        $resource = new $this->cacheResource($this);
        $data = $resource->toArray(request());

        return Redis::set($this->solveCacheKey(),json_encode($data));
    }

    public function removeCache()
    {
      return Redis::del($this->solveCacheKey());
    }

    /**
     * @param $model
     * @param $relation
     * @param $val
     * @return mixed
     */
    public function getCache($model, $relation , $val) {
        $instance = new $model();

        $useCacheTrait = in_array(Cacheable::class, class_uses_recursive($model), true);

        if (!$useCacheTrait) {
            return false;
        }
        $key_cache = $instance->cacheCollection . ':' . $val;


        $res =  $this->getAndSave($key_cache, function () use ($relation,$val) {
            return $this->$relation;
        });
        return json_decode($res,true);
    }

    public function getCacheData()
    {
        $cacheKey = $this->cacheCollection . ':' . $this->id;

        return Redis::get($cacheKey);
    }

    /**
     * @param $key
     * @param Closure $func
     * @return mixed|null
     */
    function getAndSave($key, Closure $func)
    {
        $value = Redis::get($key);
        if ($value != null) {
            return $value;
        }
        $func_res = $func();

        if ($func_res === null) {
            return null;
        }

        $r = $func_res->cache();
        if ($r) {
            return $func_res;

        }
        return null;
    }
}
