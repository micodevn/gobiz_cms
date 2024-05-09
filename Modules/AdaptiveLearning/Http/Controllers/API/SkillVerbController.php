<?php

namespace Modules\AdaptiveLearning\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdaptiveLearning\Repositories\SkillVerbRepository;

class SkillVerbController extends Controller
{
    protected $repository;

    public function __construct(SkillVerbRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(Request $request)
    {
        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $keywords = $request->get('keywords',null);

        $data = $this->repository->scopeQuery(function($query) use ($keywords) {
            return $query->where("name", "like", "%$keywords%")->whereNull('parent_id');
        })->paginate($limit);


        return $this->responseSuccess($data);
    }
}
