<?php

namespace Modules\Province\Repositories;

use Modules\Province\Entities\Schools;
use Prettus\Repository\Eloquent\BaseRepository;

class SchoolRepository extends BaseRepository
{
    public function model(): string
    {
        return Schools::class;
    }

    public function getList($request)
    {
        $sort  = $request->get('sort', 'desc');
        $district_code  = $request->get('district_code', null);
        $search  = $request->get('search', null);
        $query = Schools::query();
        if ($district_code) {
            $query = $query->where("district_code", "like", "%$district_code%");
        }
        if ($search){
            $query = $query->where("name","like","%$search%");
        }
        return $query->orderBy('id',$sort)->paginate($request->get('per_page', 10), [
            'id',
            'name',
            'district_code'
        ]);
    }
}
