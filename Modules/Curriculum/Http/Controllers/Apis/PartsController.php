<?php

namespace Modules\Curriculum\Http\Controllers\Apis;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Modules\Curriculum\Repositories\Part\PartRepository;

class PartsController extends AppBaseController
{
    private PartRepository $partRepository;

    public function __construct(PartRepository $partRepository)
    {
        $this->partRepository = $partRepository;
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->get('per_page', config('repository.pagination.limit'));
            $filters = ['type' => $request->get('type', 1)];
            $keywords = $request->get('search',null);

            $query = $this->partRepository->newQuery();

            if ($keywords) {
                $query = $query->where("title", "like", "%$keywords%")->orWhere('id' , $keywords);
            }

            $parts = $query->where($filters)->paginate($limit);

            return $this->responseSuccess($parts);
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }
}
