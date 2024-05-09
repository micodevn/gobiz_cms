<?php

namespace Modules\AdaptiveLearning\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\LearningObjectiveResource;
use Illuminate\Http\Request;
use Modules\AdaptiveLearning\Repositories\LearningObjectiveRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LearningObjectiveController extends Controller
{
    protected LearningObjectiveRepository $repository;

    public function __construct(LearningObjectiveRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $keywords = $request->get('keywords',null);
        $data = $this->repository->scopeQuery(function($query) use ($keywords) {
            return $query->where("code", "like", "%$keywords%");
        })->with(['skillVerb','learningGoal','learningConditional'])->paginate($limit);


        return $this->responseSuccess([
            'learningObj' => $data
        ]);
    }

    public function show($id)
    {
        $data = $this->repository->with(['skillVerb','learningGoal','learningConditional'])->findWithCache($id);
        if (!$data) {
            throw new NotFoundHttpException(__('Learning Objective not found'));
        }

        return $this->responseSuccess([
            'learningObj' => LearningObjectiveResource::make($data)
        ]);
    }
}
