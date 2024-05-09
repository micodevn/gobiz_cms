<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ExerciseResource;
use App\Http\Resources\API\ExerciseResourceCollection;
use App\Models\Exercise;
use App\Repositories\ExerciseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ExerciseController extends Controller
{
    protected ExerciseRepository $repository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $keywords = $request->get('keywords',null);
        $exerciseIds = $request->get('exercise_id',null);

        if ($exerciseIds && !is_array($exerciseIds)) {
            $exerciseIds = explode(',',$exerciseIds);
        }

        $data = $this->repository->scopeQuery(function($query) use ($keywords, $exerciseIds) {
            if(is_array($exerciseIds) && count($exerciseIds))
                $query = $query->whereIn('id', $exerciseIds);
            return $query->where('is_active', true)->where("name", "like", "%$keywords%");
        })->with([
            'questions',
            'learningObjectives'
        ])->paginate($limit);

        return $this->responseSuccess(new ExerciseResourceCollection($data));
    }

    public function show($id)
    {
        $data = $this->repository->with('questions','exerciseDetail')->findWithCache($id);

        if (!$data) {
            throw new NotFoundHttpException(__('Exercise not found'));
        }

        return $this->responseSuccess([
            'exercise' => ExerciseResource::make($data)
        ]);
    }

    public function options(Request $request)
    {
        $columnRequest = $request->get('select', '');
        $columnRequest = is_array($columnRequest) ? $columnRequest : explode(',', $columnRequest);
        $columns = ['id', 'name', 'duration'];
        $columns =  array_merge($columnRequest, $columns);
        $columns = array_filter($columns, function ($item) {
            return trim($item) != '' && $item != null;
        });

        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $keywords = $request->get('keywords',null);
        $exerciseIds = $request->get('exercise_id',null);

        if ($exerciseIds && !is_array($exerciseIds)) {
            $exerciseIds = explode(',',$exerciseIds);
        }

        $data = $this->repository
            ->scopeQuery(function($query) use ($keywords, $exerciseIds) {
                if(is_array($exerciseIds) && count($exerciseIds)) {
                    $query = $query->whereIn('id', $exerciseIds);
                }
                return $query->where('is_active', true)->where("name", "like", "%$keywords%");
            })
            ->paginate($limit, $columns);

        return $this->responseSuccess($data);
    }
}
