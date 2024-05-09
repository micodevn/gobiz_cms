<?php

namespace Modules\Contest\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Contest\Http\Controllers\Controller;
use Modules\Contest\Http\Requests\SetPointAndPassRequest;
use Modules\Contest\Models\ContestRound;
use Modules\Contest\Repositories\RoundRepository;

class RoundController extends Controller
{
    protected RoundRepository $roundRepo;

    public function __construct(RoundRepository $roundRepo)
    {
        $this->roundRepo = $roundRepo;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $sort  = $request->get('sort', 'desc');
        $contest  = $request->get('contest_id', null);

        $query = $this->roundRepo->newQuery();

        if ($contest) {
            $roundIds = ContestRound::query()->where('contest_id',$contest)->get()->pluck('round_id');
            if ($roundIds) {
                $query = $query->whereIn('id',$roundIds);
            }
        }

        $rounds = $query->orderBy('id',$sort)->paginate($request->get('per_page', 15), [
            'id',
            'name',
        ]);
        return $this->responseSuccess($rounds);
    }


}
