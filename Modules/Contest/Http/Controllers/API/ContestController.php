<?php

namespace Modules\Contest\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use Modules\Contest\Repositories\ContestRepository;
use Illuminate\Http\Request;

class ContestController extends AppBaseController
{
    protected ContestRepository $contestRepo;

    public function __construct(ContestRepository $contestRepo)
    {
        $this->contestRepo = $contestRepo;
    }

    public function getList(Request $request)
    {
        $contest = $this->contestRepo->newQuery();
        $search = $request->get('search', null);
        $type = $request->get('type', null);
        if ($search) {
            $contest = $contest->where('title', 'like', "%$search%");
        }

        if ($type) {
            $contest = $contest->where('type', $type);
        }
        $contest = $contest->orderBy('id', 'desc')
            ->paginate($request->get('per_page', config('repository.pagination.limit')), [
                'id', 'title'
            ]);
        return $this->responseSuccess($contest);
    }

    public function getRoundByContest(Request $request, $id)
    {
        $contestRounds = $this->contestRepo->getContestRounds($id)
            ->paginate($request->get('per_page', config('repository.pagination.limit')));

        return $this->responseSuccess($contestRounds);
    }
}
