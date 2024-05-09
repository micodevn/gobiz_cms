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
abstract class BaseFilter extends QueryFilter
{



    public function __call(string $method, array $arguments)
    {
        $listFilters = $this->request->get('filters',null);
        $listFilters = $listFilters ? json_decode($listFilters,true) : [];
        foreach ($listFilters as $key => $val) {

            $operation = '=';
            $value = Arr::get($val,'value',null);

            if (!empty($val['type']) && $value) {
                $value = trim($value);

                if ($val['type'] === 'relative') {
                    $operation = 'like';
                    $value = '%'.$value.'%';
                }
            }
            $value && $this->builder->where($key,$operation,$value);
        }
        $this->applyScope();
    }


}
